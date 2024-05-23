<?php
/*
 * Login.
 * Displays and Processes the form.
 */

require_once 'helper.php';
$posting = $_SERVER['REQUEST_METHOD'] == 'POST';

function try_again($msg)
{
    status_msg($msg . ' <br> try again -> <a href="register.php">Register</a>');
}

if (isLoggedIn()) /* We are already logged in! */
    status_msg("Please logout before registering.");
// Handle post request here
if ($posting)
{
    $error = "";
    $all_set = isset($_POST["first_name"]) 
            || isset($_POST["last_name"])
            || isset($_POST["username"])
            || isset($_POST["password"]);
    if (!$all_set) $error = 'Something went really wrong here!';

    $first_name = $_POST["first_name"];
    if ($first_name == "") $error .= "Please enter a first name<br>";

    $last_name  = $_POST["last_name"];
    if ($last_name == "") $error .= "Please enter a last name<br>";

    $username   = $_POST["username"];
    if ($username == "") $error .= "Please enter a username<br>";

    $password   = $_POST["password"];
    if ($password == "") $error .= "Please enter a password<br>";

    if ($error != "") try_again($error);

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
