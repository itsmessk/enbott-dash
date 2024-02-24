<!DOCTYPE html>
<html lang="en">

<head>
	<title>Datatable Example PHP MySQLi</title>

	<link href="bootstrap.min.css" rel="stylesheet">
	<link href="dataTables.bootstrap.css" rel="stylesheet">
	<link href="dataTables.responsive.css" rel="stylesheet">

	<style>
		.mytablee {
			margin-left: 50px;
			margin-top: 30px;
			width: 1000px;
		}
	</style>
</head>

<body>
	
	<br>
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
				include('conn.php');
				$query = mysqli_query($conn, "SELECT sa.*, s.Section_Name, s.classroom 
            FROM sessionhoursaptitude sa
            INNER JOIN sections s ON sa.Section_id = s.section_id");
$counter = 1;
while ($row = mysqli_fetch_array($query)) {
    ?>
    <tr>
        <td><?php echo $counter++; ?></td>
        <td><?php echo $row['Section_Name']; ?></td>
        <td><?php echo $row['classroom']; ?></td>
        <td><?php echo $row['TrainerName']; ?></td>
        <td><?php echo $row['TopicName']; ?></td>
        <td><?php echo $row['Date']; ?></td>
        <td><?php echo $row['StartTime']; ?></td>
        <td><?php echo $row['EndTime']; ?></td>
        <td><?php echo $row['hour_id']; ?></td>
        <td><?php echo $row['hours_pending']; ?></td>
        <td><?php echo $row['hours_tot']; ?></td>
    </tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div>
	<script src="jquery.min.js"></script>
	<script src="jquery.dataTables.min.js"></script>
	<script src="dataTables.bootstrap.min.js"></script>
	<script src="dataTables.responsive.js"></script>
	<script src="bootstrap.min.js"></script>
	<script>
		$(document).ready(function () {
			$('#dataTables-example').DataTable({
				responsive: true
			});
		});
	</script>
</body>

</html>