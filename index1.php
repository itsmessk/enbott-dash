<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Performance Charts</title>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div style="width: 800px; margin: auto;">
        
        <canvas id="barChart" width="80" height="40"></canvas>
        <canvas id="lineChart" width="80" height="40"></canvas>
        <canvas id="pieChart" width="80" height="40"></canvas>
    </div>

    <?php
    
    include('conn.php');

    
    $query = "SELECT * FROM sessionhoursaptitude";
    $result = mysqli_query($conn, $query);

    
    $sectionNames = [];
    $completedHours = [];
    $trainerNames = [];
    $trainerHours = [];
    $dates = [];
    $completedHoursByDate = [];

    
    while ($row = mysqli_fetch_assoc($result)) {
        $sectionNames[] = $row['Section_id'];
        $completedHours[] = $row['hour_id'];
        $trainerNames[] = $row['TrainerName'];
        $dates[] = $row['Date'];
    }

    
    $uniqueDates = array_unique($dates);
    foreach ($uniqueDates as $date) {
        $completedHoursByDate[$date] = array_sum(array_intersect_key($completedHours, array_intersect($dates, [$date])));
    }

    
    $uniqueTrainers = array_unique($trainerNames);
    foreach ($uniqueTrainers as $trainer) {
        $trainerHours[$trainer] = array_sum(array_intersect_key($completedHours, array_intersect($trainerNames, [$trainer])));
    }
    ?>

    <script>
        // JavaScript code to create charts using Chart.js
        var ctxBar = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($sectionNames); ?>,
                datasets: [{
                    label: 'Completed Hours',
                    data: <?php echo json_encode($completedHours); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)'
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        var ctxLine = document.getElementById('lineChart').getContext('2d');
        var lineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_keys($completedHoursByDate)); ?>,
                datasets: [{
                    label: 'Completed Hours',
                    data: <?php echo json_encode(array_values($completedHoursByDate)); ?>,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        var ctxPie = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_keys($trainerHours)); ?>,
                datasets: [{
                    label: 'Completed Hours',
                    data: <?php echo json_encode(array_values($trainerHours)); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                    ]
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>
