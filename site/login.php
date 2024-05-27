<?php
/*
 * Login.
 * Displays and Processes the form.
 */

require_once 'helper.php';
$posting = $_SERVER['REQUEST_METHOD'] == 'POST';

function try_again($msg)
{
    status_msg($msg . ' <br> Try again -> <a href="login.php">Login</a>');
}

if (isLoggedIn()) { /* We are already logged in! */
    status_msg("You are already logged in as a manager!");
}

$timed_out = isTimedOut();
if ($timed_out) {
    status_msg("You are timed out for $timed_out more seconds");
}

// Handle post request here
if ($posting)
{
    $error = "";
    $all_set = isset($_POST["username"]) && isset($_POST["password"]);
    if (!$all_set) $error = 'Something went really wrong here!';

    $username = $_POST["username"];
    if ($username == "") $error .= "Please enter a username<br>";
    if (!preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', $username)) $error .= "Invalid username format.<br>";

    $password = $_POST["password"];
    if ($password == "") $error .= "Please enter a password<br>";

    if ($error != "") try_again($error);

    $username = sanitize_input($username);
    $password = sanitize_input($password);

    require_once "settings.php";
    $conn = @mysqli_connect(
        $db_host,
        $db_user,
        $db_password,
        $db_name
    );

    if (!$conn) {
        try_again("Database connection failed: " . mysqli_connect_error());
    }

    $stmt = $conn->prepare("SELECT password FROM manager WHERE username = ?");
    if ($stmt === false) {
        try_again("Statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows == 0) {
        fail_login();
        $login_attempts = getSession("login_attempts");
        $login_attempts = 3 - $login_attempts;
        try_again("Invalid username or password.<br>you have $login_attempts more attempts<br>");
    } else {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        if (!password_verify($password, $hashed_password)) {
            fail_login();
            $login_attempts = getSession("login_attempts");
            $login_attempts = 3 - $login_attempts;
            try_again("Invalid username or password.<br>you have $login_attempts more attempts<br>");
        } else {
            login($username);
            redirect("manage.php");
        }
    }

    $stmt->close();
    $conn->close();
}

// Otherwise generate the form.
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
        <p>Don't have an account?</p>
        <a href="register.php">Register!</a>
    </div>
</body>
<?php include 'footer.inc'; ?>
