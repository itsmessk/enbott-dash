<!DOCTYPE html>
<html lang="en">
<head>
    <title>Session Hourly Register - Comm</title>
    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="dataTables.bootstrap.css" rel="stylesheet">
    <link href="dataTables.responsive.css" rel="stylesheet">
    <style>
        .mytable {
            margin-left: 50px;
            margin-top: 30px;
            width: 1000px;
        }
    </style>
</head>
<body>
    <br>
    <!-- Dropdown for Sections -->
    <select id="sectionDropdown" class="form-control" style="width: 200px; margin-left: 50px; margin-top: 20px;">
        <option value="">Select a Section</option>
        <?php
        include('conn.php');
        $sectionsQuery = mysqli_query($conn, "SELECT DISTINCT Section_Name FROM sections");
        while ($section = mysqli_fetch_assoc($sectionsQuery)) {
            echo '<option value="'.$section['Section_Name'].'">'.$section['Section_Name'].'</option>';
        }
        ?>
    </select>
    
    <!-- Table -->
    <div class="mytable">
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Section Name</th>
                    <th>Class Room</th>
                    <th>Trainer Name</th>
                    <th>Topic Name</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Hours Completed</th>
                    <th>Hours Pending</th>
                    <th>Total Hours</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysqli_query($conn, "SELECT sa.*, s.Section_Name, s.classroom FROM sessionhourscommunication sa INNER JOIN sections s ON sa.Section_id = s.section_id");
                $counter = 1;
                while ($row = mysqli_fetch_array($query)) {
                    echo '<tr data-section-name="'.$row['Section_Name'].'">';
                    echo '<td>'.$counter++.'</td>';
                    echo '<td>'.$row['Section_Name'].'</td>';
                    echo '<td>'.$row['classroom'].'</td>';
                    echo '<td>'.$row['TrainerName'].'</td>';
                    echo '<td>'.$row['TopicName'].'</td>';
                    echo '<td>'.$row['Date'].'</td>';
                    echo '<td>'.$row['StartTime'].'</td>';
                    echo '<td>'.$row['EndTime'].'</td>';
                    echo '<td>'.$row['hour_id'].'</td>';
                    echo '<td>'.$row['hours_pending'].'</td>';
                    echo '<td>'.$row['hours_tot'].'</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Scripts -->
    <script src="jquery.min.js"></script>
    <script src="jquery.dataTables.min.js"></script>
    <script src="dataTables.bootstrap.min.js"></script>
    <script src="dataTables.responsive.js"></script>
    <script src="bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            var table = $('#dataTables-example').DataTable({
                responsive: true
            });

            $('#sectionDropdown').on('change', function () {
                var selectedSection = this.value;
                table.columns(1).search(selectedSection).draw();
            });
        });
    </script>
</body>
</html>
