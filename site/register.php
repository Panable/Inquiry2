<?php
/*
 * Login.
 * Displays and Processes the form.
 */

require_once 'helper.php';
$posting = $_SERVER['REQUEST_METHOD'] == 'POST';

if (isLoggedIn()) /* We are already logged in! */
    status_msg("Please logout before registering.");

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



    status_msg('Successfully created a new account <br> login here -> <a href="login.php">Login</a>');
}

// Otherwise continue as normal
?>

<?php include 'header.inc';?>
<div class="form-container">
    <h2>Register</h2>
    <form action="register.php" method="post" novalidate="novalidate">
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
</div>
<?php include 'footer.inc'; ?>
