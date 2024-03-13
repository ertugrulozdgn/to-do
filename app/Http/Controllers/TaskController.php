<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('work_units_needed')->get();

        $developers = [
            ['name' => 'DEV1', 'difficulty' => 1],
            ['name' => 'DEV2', 'difficulty' => 2],
            ['name' => 'DEV3', 'difficulty' => 3],
            ['name' => 'DEV4', 'difficulty' => 4],
            ['name' => 'DEV5', 'difficulty' => 5],
        ];

        // Haftalık iş planlaması
        $weeklyPlan = $this->makeWeeklyPlan($developers, $tasks);

        // Her bir geliştiricinin tüm işleri bitirme süresi
        $totalWeekNeededForDeveloper = [];
        foreach ($developers as $developer) {
            $totalWeekNeededForDeveloper[$developer['name']] = $this->totalWeekNeededForDeveloper($developer['name'], $weeklyPlan);
        }

        // Tüm geliştiricilerin iş bitirme süresi
        $totalWeek = max($totalWeekNeededForDeveloper);

        return view('tasks', compact('developers', 'weeklyPlan', 'totalWeek', 'totalWeekNeededForDeveloper'));
    }

    private function makeWeeklyPlan($developers, $tasks)
    {
        $weekly_hours = 45;
        $weeklyPlan = [];
        $totalWorkUnits = $tasks->sum('work_units_needed');

        // Geliştirici kapasitelerini ve tamamlanan iş sayısını izlemek için dizi
        $developerCapacities = collect($developers)->map(function ($developer) use ($weekly_hours) {
            return [
                'name' => $developer['name'],
                'capacity' => $developer['difficulty'] * $weekly_hours,
                'tasks_completed' => 0,
                'weeks' => 0,
            ];
        });

        // Geliştiricilere iş atama
        while ($totalWorkUnits > 0) {
            foreach ($developerCapacities as $developer) {
                // Geliştirici kapasitesi tamamlanan işlerin toplam kapasitesinden küçükse iş ata
                if ($developer['capacity'] > 0 && $totalWorkUnits > 0) {
                    $task = $tasks->shift(); // İlk işi al
                    $developer['tasks_completed']++; // Geliştiricinin tamamladığı iş sayısını arttır
                    $developer['capacity'] -= $task->work_units_needed; // Geliştiricinin kalan kapasitesini güncelle
                    $totalWorkUnits -= $task->work_units_needed; // Toplam iş birimlerini güncelle

                    // Geliştiriciye atanan işleri haftalık plana ekle
                    if (!isset($weeklyPlan[$developer['name']])) {
                        $weeklyPlan[$developer['name']] = collect();
                    }
                    $weeklyPlan[$developer['name']]->push($task);
                }
            }
        }

        return $weeklyPlan;
    }

    private function totalWeekNeededForDeveloper($developerName, $weeklyPlan)
    {
        $totalHoursNeeded = 0;

        foreach ($weeklyPlan[$developerName] as $task) {
            // Her bir işin bitiş süresini toplam saatlere ekle
            $totalHoursNeeded += $task->work_units_needed;
        }

        // Toplam saatleri haftalık saat sayısına (45) bölerek hafta sayısını bul
        $totalWeeksNeeded = ceil($totalHoursNeeded / 45);

        return $totalWeeksNeeded;
    }
}
