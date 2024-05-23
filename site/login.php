<?php
/*
 * Login.
 * Displays and Processes the form.
 */

require_once 'helper.php';
$posting = $_SERVER['REQUEST_METHOD'] == 'POST';

if (isLoggedIn()) /* We are already logged in! */
    status_msg("You are already logged in as a manager!");

// Handle post request here
if ($posting)
{   
    print_r($_POST);
    require_once "settings.php";
    $conn = @mysqli_connect(
        $db_host,
        $db_user,
        $db_password,
        $db_name
    );
    status_msg("Successfully logged in");
}

// Otherwise continue as normal
?>

<?php include 'header.inc';?>
<link rel="stylesheet" href="styles/login.css">
<body>
    <div class="grid-item center">
        <h2>Login</h2>
        <br>
        <form action="login.php" method="post" novalidate="novalidate">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <br>
        <p>Dont have an account?</p>
        <a href="register.php">Register!</a>
    </div>
</body>
<?php include 'footer.inc'; ?>
