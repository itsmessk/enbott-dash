<?php
# Initialize the session
session_start();

# If user is not logged in then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
    echo "<script>" . "window.location.href='login/login.php';" . "</script>";
    exit;
}
?>
<?php
// Assuming 'conn.php' is your connection file
include 'conn.php';

$sql = "SELECT COUNT(*) AS total_students FROM student_detail"; // Make sure the table name matches your database
$result = $conn->query($sql);
$total_students = 0;

if ($result->num_rows > 0) {
    // Fetch the result row
    $row = $result->fetch_assoc();
    $total_students = $row['total_students'];
}

// Initialize variables
$total_trainers = $total_hours = $total_sections = 0;

// SQL query to count the number of trainers
$sql_trainers = "SELECT COUNT(*) AS total_trainers FROM trainer_details";
$result_trainers = $conn->query($sql_trainers);
if ($result_trainers->num_rows > 0) {
    $row = $result_trainers->fetch_assoc();
    $total_trainers = $row['total_trainers'];
}

// SQL query to sum the durations
$sql_hours = "SELECT SUM(duration) AS total_hours FROM course_details";
$result_hours = $conn->query($sql_hours);
if ($result_hours->num_rows > 0) {
    $row = $result_hours->fetch_assoc();
    $total_hours = $row['total_hours'];
}

// SQL query to count the number of sections
$sql_sections = "SELECT COUNT(*) AS total_sections FROM sections   ";
$result_sections = $conn->query($sql_sections);
if ($result_sections->num_rows > 0) {
    $row = $result_sections->fetch_assoc();
    $total_sections = $row['total_sections'];
}

// Always close the connection
$conn->close();
?>
<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Enbott Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="img/logo.png">
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="css/normalize.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="css/main.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="css/all.min.css">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="fonts/flaticon.css">
    <!-- Full Calender CSS -->
    <link rel="stylesheet" href="css/fullcalendar.min.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Modernize js -->
    <script src="js/modernizr-3.6.0.min.js"></script>
    <style>
        .footer-wrap-layout1 {
    background-color: white; /* Set background color to black */
    color: white; /* Change text color to white for contrast */
    width: 120%; /* Ensure it covers the full width */
    padding: 10px 0; /* Add some padding for spacing */
    margin: 0; /* Remove any default margin */
    position: fixed; /* Fix position to the bottom */
    left: 0; /* Align to the left edge */
    bottom: 0; /* Align to the bottom edge */
    text-align: center; /* Center the text */
}

.footer-wrap-layout1 a {
    color: black; /* Ensure links are also white */
    text-decoration: none; /* Optional: removes underline from links */
}

.footer-wrap-layout1 a:hover {
    text-decoration: underline; /* Optional: adds underline on hover for links */
}

.sidebar-menu-content {
    min-height: 100vh; /* Minimum height to take full viewport height */
    overflow-y: auto; /* Allows scrolling within the sidebar if content overflows */
    position: fixed; /* Keeps the sidebar in place while scrolling the main content */
    width: 250px; /* Adjust the width as necessary */
    left: 0; /* Align to the left side of the viewport */
    top: 0; /* Align to the top of the viewport */
    bottom: 0; /* Extends to the bottom of the viewport */
    background-color: #yourSidebarBackgroundColor; /* Your sidebar background color */
    z-index: 1000; /* Ensures sidebar stays above other content (adjust as necessary) */
}

/* Additional styles to ensure the rest of the content doesn't overlap with the fixed sidebar */


    </style>
</head>

<body>
    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->
    <div id="wrapper" class="wrapper bg">
        <!-- Header Menu Area Start Here -->
        <div class="navbar navbar-expand-md header-menu-one bg-light">
            <div class="nav-bar-header-one"
                style="background: linear-gradient(to right, #ffffff, #ffffff); border-right: 2px solid black; text-align: center;">
                <div class="header-logo">
                    <a href="index.php">
                        <img src="img/logo.png" alt="logo">
                    </a>
                </div>
                <div class="toggle-button sidebar-toggle">
                    <button type="button" class="item-link">
                        <span class="btn-icon-wrap">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="d-md-none mobile-nav-bar">
                <button class="navbar-toggler pulse-animation" type="button" data-toggle="collapse"
                    data-target="#mobile-navbar" aria-expanded="false">
                    <i class="far fa-arrow-alt-circle-down"></i>
                </button>
                <button type="button" class="navbar-toggler sidebar-toggle-mobile">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div class="header-main-menu collapse navbar-collapse" id="mobile-navbar">
                <ul class="navbar-nav">
                    <li class="navbar-item header-search-bar">
                        <div class="input-group stylish-input-group">
                            <span class="input-group-addon">
                                <button type="submit">
                                    <span class="flaticon-search" aria-hidden="true"></span>
                                </button>
                            </span>
                            <input type="text" class="form-control" placeholder="Find Something . . .">
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="navbar-item dropdown header-admin">
                        <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-expanded="false">
                            <div class="admin-title">

                                <span>
                                    <?= strtoupper(htmlspecialchars($_SESSION["username"])); ?>
                                </span>

                            </div>
                            <div>
                                <img src="img/klu.png" alt="Admin" style="width: 150px; height: auto;">
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">

                            <div class="item-content">
                                <ul class="settings-list">


                                    <li><a href="login/logout.php"><i class="flaticon-turn-off"></i>Log Out</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <!-- <li class="navbar-item dropdown header-message">
                        <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-expanded="false">
                            <i class="far fa-envelope"></i>
                            <div class="item-title d-md-none text-16 mg-l-10">Message</div>
                            <span>5</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="item-header">
                                <h6 class="item-title">05 Message</h6>
                            </div>
                            <div class="item-content">
                                <div class="media">
                                    <div class="item-img bg-skyblue author-online">
                                        <img src="img/figure/student11.png" alt="img">
                                    </div>
                                    <div class="media-body space-sm">
                                        <div class="item-title">
                                            <a href="#">
                                                <span class="item-name">Maria Zaman</span>
                                                <span class="item-time">18:30</span>
                                            </a>
                                        </div>
                                        <p>What is the reason of buy this item.
                                            Is it usefull for me.....</p>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="item-img bg-yellow author-online">
                                        <img src="img/figure/student12.png" alt="img">
                                    </div>
                                    <div class="media-body space-sm">
                                        <div class="item-title">
                                            <a href="#">
                                                <span class="item-name">Benny Roy</span>
                                                <span class="item-time">10:35</span>
                                            </a>
                                        </div>
                                        <p>What is the reason of buy this item.
                                            Is it usefull for me.....</p>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="item-img bg-pink">
                                        <img src="img/figure/student13.png" alt="img">
                                    </div>
                                    <div class="media-body space-sm">
                                        <div class="item-title">
                                            <a href="#">
                                                <span class="item-name">Steven</span>
                                                <span class="item-time">02:35</span>
                                            </a>
                                        </div>
                                        <p>What is the reason of buy this item.
                                            Is it usefull for me.....</p>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="item-img bg-violet-blue">
                                        <img src="img/figure/student11.png" alt="img">
                                    </div>
                                    <div class="media-body space-sm">
                                        <div class="item-title">
                                            <a href="#">
                                                <span class="item-name">Joshep Joe</span>
                                                <span class="item-time">12:35</span>
                                            </a>
                                        </div>
                                        <p>What is the reason of buy this item.
                                            Is it usefull for me.....</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="navbar-item dropdown header-notification">
                        <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-expanded="false">
                            <i class="far fa-bell"></i>
                            <div class="item-title d-md-none text-16 mg-l-10">Notification</div>
                            <span>8</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="item-header">
                                <h6 class="item-title">03 Notifications</h6>
                            </div>
                            <div class="item-content">
                                <div class="media">
                                    <div class="item-icon bg-skyblue">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="media-body space-sm">
                                        <div class="post-title">Complete Today Task</div>
                                        <span>1 Mins ago</span>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="item-icon bg-orange">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div class="media-body space-sm">
                                        <div class="post-title">Director Metting</div>
                                        <span>20 Mins ago</span>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="item-icon bg-violet-blue">
                                        <i class="fas fa-cogs"></i>
                                    </div>
                                    <div class="media-body space-sm">
                                        <div class="post-title">Update Password</div>
                                        <span>45 Mins ago</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li> -->
                    <!-- <li class="navbar-item dropdown header-language">
                        <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-expanded="false"><i class="fas fa-globe-americas"></i>EN</a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">English</a>
                            <a class="dropdown-item" href="#">Spanish</a>
                            <a class="dropdown-item" href="#">French</a>
                            <a class="dropdown-item" href="#">Chinese</a>
                        </div>
                    </li> -->
                </ul>
            </div>
        </div>
        <!-- Header Menu Area End Here -->
        <!-- Page Area Start Here -->
        <div class="dashboard-page-one">
            <!-- Sidebar Area Start Here -->
            <div class="sidebar-main sidebar-menu-one sidebar-expand-md sidebar-color">
                <div class="mobile-sidebar-header d-md-none">
                    <div class="header-logo">
                        <a href="index.php"><img src="img/logo.png" alt="logo"></a>
                    </div>
                </div>
                <div class="sidebar-menu-content">
                    <ul class="nav nav-sidebar-menu sidebar-toggle-view">
                        <li class="nav-item sidebar-nav-item">
                            <a href="index.php" class="nav-link"><i class="flaticon-dashboard"></i><span>Progress
                                    Dashboard</span></a>
                            <ul class="nav sub-group-menu">
                                <!-- <li class="nav-item">
                                    <a href="index.php" class="nav-link"><i class="fas fa-angle-right"></i>Admin</a>
                                </li> -->
                                <li class="nav-item">
                                    <a href="student.php" class="nav-link"><i class="fas fa-angle-right"></i>Student
                                        details</a>
                                </li>
                                <li class="nav-item">
                                    <a href="trainer.php" class="nav-link"><i class="fas fa-angle-right"></i>Trainer
                                        Details</a>
                                </li>
                                <li class="nav-item">
                                    <a href="coverage.php" class="nav-link"><i class="fas fa-angle-right"></i>Coverage
                                        Status</a>
                                </li>
                                <li class="nav-item">
                                    <a href="section.php" class="nav-link"><i class="fas fa-angle-right"></i>Section
                                        Details</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                    <ul class="nav nav-sidebar-menu sidebar-toggle-view">
                        <li class="nav-item sidebar-nav-item">
                            <a href="index.php" class="nav-link"><i class="flaticon-dashboard"></i><span>Performance
                                    Dashboard</span></a>
                            <ul class="nav sub-group-menu">
                                <!-- <li class="nav-item">
                                    <a href="index.php" class="nav-link"><i class="fas fa-angle-right"></i>Admin</a>
                                </li> -->
                                <li class="nav-item">
                                    <a href="aptitude.php" class="nav-link"><i class="fas fa-angle-right"></i>Aptitude
                                        Details</a>
                                </li>
                                <li class="nav-item">
                                    <a href="communication.php" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Communication Details</a>
                                </li>


                            </ul>
                        </li>

                    </ul>
                    
                </div>
            </div>
            <!-- Sidebar Area End Here -->
            <div class="dashboard-content-one">
                <!-- Breadcubs Area Start Here -->
                <div class="breadcrumbs-area">
                    <h3>Enbott Admin dashboard</h3>
                    <ul>
                        <li>
                            <a href="index.php">Home</a>
                        </li>
                        <li>Admin</li>
                    </ul>
                </div>
                <!-- Breadcubs Area End Here -->
                <!-- Dashboard summery Start Here -->
                <div class="row gutters-20">
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="dashboard-summery-one mg-b-20">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <div class="item-icon bg-light-green ">
                                        <i class="flaticon-classmates text-green"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="item-content">
                                        <a href="">
                                            <div class="item-title">Students enrolled</div>
                                        </a>
                                        <div class="item-number"><span class="counter"
                                                data-num="<?= $total_students; ?>">
                                                <?= number_format($total_students); ?>
                                            </span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="dashboard-summery-one mg-b-20">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <div class="item-icon bg-light-blue">
                                        <i class="flaticon-multiple-users-silhouette text-blue"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="item-content">
                                        <a href="">
                                            <div class="item-title">Training Resources</div>
                                        </a>
                                        <div class="item-number"><span class="counter"
                                                data-num="<?= $total_trainers; ?>">
                                                <?= number_format($total_trainers); ?>
                                            </span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="dashboard-summery-one mg-b-20">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <div class="item-icon bg-light-yellow">
                                        <i class="flaticon-couple text-orange"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="item-content">
                                        <a href="">
                                            <div class="item-title">No.Of.hours Trained</div>
                                        </a>
                                        <div class="item-number"><span class="counter" data-num="<?= $total_hours; ?>">
                                                <?= number_format($total_hours); ?>
                                            </span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="dashboard-summery-one mg-b-20">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <div class="item-icon bg-light-red">
                                        <i class="flaticon-classmates text-red"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="item-content">

                                        <a href="">
                                            <div class="item-title">No. of sections</div>
                                        </a>
                                        <div class="item-number"><span class="counter"
                                                data-num="<?= $total_sections; ?>">
                                                <?= number_format($total_sections); ?>
                                            </span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Dashboard summery End Here -->
                <!-- Dashboard Content Start Here -->
                <div class="row gutters-20">
                    <div class="col-12 col-xl-8 col-6-xxxl">
                        <div class="card dashboard-card-one pd-b-20">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>Department-wise Break-Down</h3>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                            aria-expanded="false">...</a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"><i
                                                    class="fas fa-times text-orange-red"></i>Close</a>
                                            <a class="dropdown-item" href="#"><i
                                                    class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                            <a class="dropdown-item" href="#"><i
                                                    class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                        </div>
                                    </div>
                                </div>

                                <div style="width:100%;">
                                    <canvas id="departmentLineChart"></canvas>
                                </div>

                            </div>

                        </div>
                    </div>
                    <?php
                    // Include your database connection file
                    include 'conn.php';

                    // Initialize variables
                    $total_hours_aptitude = $total_hours_communication = 0;

                    // Query to get the total hours for Aptitude (topic = 0)
                    $sql_aptitude = "SELECT SUM(duration) AS total_hours FROM course_details WHERE topic = 0";
                    $result_aptitude = $conn->query($sql_aptitude);
                    if ($result_aptitude->num_rows > 0) {
                        $row = $result_aptitude->fetch_assoc();
                        $total_hours_aptitude = $row['total_hours'];
                    }

                    // Query to get the total hours for Communication (topic = 1)
                    $sql_communication = "SELECT SUM(duration) AS total_hours FROM course_details WHERE topic = 1";
                    $result_communication = $conn->query($sql_communication);
                    if ($result_communication->num_rows > 0) {
                        $row = $result_communication->fetch_assoc();
                        $total_hours_communication = $row['total_hours'];
                    }

                    // Close the database connection
                    $conn->close();
                    ?>

                    <div class="col-12 col-xl-8 col-6-xxxl">
                        <div class="card dashboard-card-one pd-b-20">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>Training Coverage Progress</h3>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                            aria-expanded="false">...</a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#"><i
                                                    class="fas fa-times text-orange-red"></i>Close</a>
                                            <a class="dropdown-item" href="#"><i
                                                    class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                            <a class="dropdown-item" href="#"><i
                                                    class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="doughnut-chart-wrap">
                                    <canvas id="student-doughnut-chart" width="100" height="300"></canvas>
                                </div>
                                
                            </div>

                        </div>
                    </div>

                    <!-- Dashboard Content End Here -->
                    <footer class="footer-wrap-layout1">
                        <div class="copyright">
                            © Copyrights <a href="#">Enbott.com</a> 2024. All rights reserved.</a>
                        </div>
                    </footer>

                </div>
            </div>
            <!-- Page Area End Here -->
        </div>
        <!-- jquery-->
        <script src="js/jquery-3.3.1.min.js"></script>
        <!-- Plugins js -->
        <script src="js/plugins.js"></script>
        <!-- Popper js -->
        <script src="js/popper.min.js"></script>
        <!-- Bootstrap js -->
        <script src="js/bootstrap.min.js"></script>
        <!-- Counterup Js -->
        <script src="js/jquery.counterup.min.js"></script>
        <!-- Moment Js -->
        <script src="js/moment.min.js"></script>
        <!-- Waypoints Js -->
        <script src="js/jquery.waypoints.min.js"></script>
        <!-- Scroll Up Js -->
        <script src="js/jquery.scrollUp.min.js"></script>
        <!-- Full Calender Js -->
        <script src="js/fullcalendar.min.js"></script>
        <!-- Chart Js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Custom Js -->
        <script src="js/main.js"></script>
        <script>
document.addEventListener("DOMContentLoaded", function () {
    var ctx = document.getElementById('departmentLineChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar', // Keep as 'bar' for a horizontal bar chart
        data: {
            labels: ["CSE", "ECE", "IT", "BIO TECH", "FOOD TECH", "MECH", "AGRI", "BIOMEDICAL", "EEE", "AERO", "CIVIL", "Auto", "CHEMICAL"],
            datasets: [{
                label: 'Student Count',
                backgroundColor: [
                    'rgba(267, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(199, 199, 199, 0.2)',
                    'rgba(83, 102, 255, 0.2)',
                    'rgba(40, 159, 64, 0.2)',
                    'rgba(215, 99, 132, 0.2)',
                    'rgba(20, 162, 235, 0.2)',
                    'rgba(40, 206, 86, 0.2)',
                    'rgba(75, 192, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(111,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(199, 199, 199, 1)',
                    'rgba(83, 102, 255, 1)',
                    'rgba(40, 159, 64, 1)',
                    'rgba(215, 99, 132, 1)',
                    'rgba(20, 162, 235, 1)',
                    'rgba(40, 206, 86, 1)',
                    'rgba(75, 192, 132, 1)'
                ],
                borderWidth: 1,
                data: [2022, 315, 152, 69, 54, 49, 30, 22, 21, 15, 13, 6, 6]
            }]
        },
        options: {
            indexAxis: 'y', // Add this line to change the index axis to y for a horizontal bar chart
            responsive: true,
            legend: {
                display: true,
            },
            title: {
                display: true,
                text: 'Department-wise Student Count'
            },
            scales: {
                yAxes: [{ // This now becomes the vertical axis and should be configured for the departments
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Department'
                    }
                }],
                xAxes: [{ // This now becomes the horizontal axis and should be configured for the counts
                    display: true,
                    ticks: {
                        beginAtZero: true
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Student Count'
                    }
                }]
            }
        }
    });
});
</script>


        <script>
if ($("#student-doughnut-chart").length) {
    var doughnutChartData = {
        labels: ["Aptitude", "Communication"],
        datasets: [{
            backgroundColor: ["#304ffe", "#ffa601"],
            // Use PHP variables to pass the total hours data
            data: [<?= $total_hours_aptitude; ?>, <?= $total_hours_communication; ?>],
            label: "Total Hours"
        }]
    };
    var doughnutChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        cutoutPercentage: 65,
        rotation: -9.4,
        animation: {
            duration: 2000
        },
        legend: {
            display: false
        },
        tooltips: {
            enabled: true
        },
    };
    var studentCanvas = $("#student-doughnut-chart").get(0).getContext("2d");
    var studentChart = new Chart(studentCanvas, {
        type: 'doughnut',
        data: doughnutChartData,
        options: doughnutChartOptions
    });
}
</script>

</body>

</html>