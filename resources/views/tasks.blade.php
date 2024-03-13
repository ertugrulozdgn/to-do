<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <style>
        .table tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }
        .table th, .table td {
            width: 25%;
        }
        .nav-tabs .nav-link {
            color: #495057;
        }

        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <strong>Toplam İhtiyaç Duyulan Hafta: {{ $totalWeek }}</strong>
        <h1>İş Listesi</h1>
        <ul class="nav nav-tabs">
            @foreach ($developers as $developer)
                <li class="nav-item">
                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $developer['name'] }}-tab" data-toggle="tab" href="#{{ $developer['name'] }}" role="tab" aria-selected="true">{{ $developer['name'] }}</a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach ($developers as $developer)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $developer['name'] }}" role="tabpanel">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Görev Adı</th>
                                <th>Süre</th>
                                <th>Zorluk</th>
                                <th>Gereken İş Süresi (Saat)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($weeklyPlan[$developer['name']] as $task)
                                <tr>
                                    <td>{{ $task->name }}</td>
                                    <td>{{ $task->duration }}</td>
                                    <td>{{ $task->difficulty }}</td>
                                    <td>{{ $task->work_units_needed }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p>Developer İş Bitiş Süresi (Hafta): <strong>{{ $totalWeekNeededForDeveloper[$developer['name']] }}</strong></p>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>
