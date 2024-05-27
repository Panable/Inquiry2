<?php
// Set default title
$title = "Homepage";

// Check current page and set title accordingly
$current_page = basename($_SERVER['PHP_SELF']);
switch ($current_page) {
    case 'jobs.php':
        $title = "Jobs";
        break;
    case 'apply.php':
        $title = "Apply";
        break;
    case 'about.php':
        $title = "About Us";
        break;
    case 'phpenhancements.php':
        $title = "Enhancements";
        break;
    case 'manage.php':
        $title = "Manage";
        break;
    case 'login.php':
        $title = "Login";
        break;
    case 'enhancements2.php':
        $title = "Logout";
        break;
    // Add more cases if needed for other pages
}

// Include helper.php
require_once 'helper.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title; ?></title>
    <!-- Logo Icon (Tab) -->
    <link rel="icon" href="images/TheHiveLogo.svg">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
<header>
    <nav>
        <a href="index.php"><img src="images/TheHiveLogo.svg" alt="The Hive Logo"></a>
        <ul>
            <li><a href="jobs.php">Jobs</a></li>
            <li><a href="apply.php">Apply</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="phpenhancements.php">Enhancements</a></li>
            <?php
            if (isLoggedIn())
            {
                echo '<li><a href="manage.php">Manage</a></li>';
                echo '<li><a href="enhancements2.php">Logout</a></li>';
            }
            else
            {
                echo '<li><a href="login.php">Login</a></li>';
            }
            ?>
        </ul>
        <hr>
    </nav>
</header>
