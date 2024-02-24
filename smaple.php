<?php
// Include your database connection script
include 'conn.php';

// SQL to count students by department
$sql = "SELECT s_dept, COUNT(*) as student_count FROM student_detail GROUP BY s_dept ORDER BY student_count DESC";
$result = mysqli_query($conn, $sql);

// Prepare data for the chart
$departments = [];
$studentCounts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $departments[] = $row['s_dept'];
    $studentCounts[] = $row['student_count'];
}

// Close database connection
mysqli_close($conn);

// Encode data as JSON to be used by the JavaScript chart
echo json_encode(['departments' => $departments, 'studentCounts' => $studentCounts]);
?>
