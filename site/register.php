<?php
/*
 * Register.
 * Displays and Processes the form.
 */

require_once 'helper.php';
$posting = $_SERVER['REQUEST_METHOD'] == 'POST';

function try_again($msg)
{
    status_msg($msg . ' <br> Try again -> <a href="register.php">Register</a>');
}

if (isLoggedIn()) { /* We are already logged in! */
    status_msg("Please logout before registering.");
}

// Handle post request here
if ($posting)
{
    $error = "";
    $all_set = isset($_POST["first_name"]) 
            && isset($_POST["last_name"])
            && isset($_POST["username"])
            && isset($_POST["password"]);
    if (!$all_set) $error = 'Something went really wrong here!';

    $first_name = $_POST["first_name"];
    if ($first_name == "") $error .= "Please enter a first name<br>";
    if (!preg_match("/^[a-zA-Z]{1,20}$/", $first_name)) $error .= "Only alpha letters allowed in your first name, and it must be between 1 and 20 characters long.<br>";

    $last_name  = $_POST["last_name"];
    if ($last_name == "") $error .= "Please enter a last name<br>";
    if (!preg_match("/^[a-zA-Z]{1,20}$/", $last_name)) $error .= "Only alpha letters allowed in your last name, and it must be between 1 and 20 characters long.<br>";

    $username   = $_POST["username"];
    if ($username == "") $error .= "Please enter a username<br>";
    if (!preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', $username)) $error .= "Username must start with a letter and be between 5 and 31 characters long.<br>";

    $password   = $_POST["password"];
    if ($password == "") $error .= "Please enter a password<br>";
    if (strlen($password) < 8) $error .= "Password must be at least 8 characters long.<br>";
    if (!preg_match('/[A-Z]/', $password)) $error .= "Password must contain at least one uppercase letter.<br>";
    if (!preg_match('/[a-z]/', $password)) $error .= "Password must contain at least one lowercase letter.<br>";
    if (!preg_match('/[0-9]/', $password)) $error .= "Password must contain at least one number.<br>";
    if (!preg_match('/[\W]/', $password)) $error  .= "Password must contain at least one special character.<br>";

    if ($error != "") try_again($error);

    $first_name = sanitize_input($first_name);
    $last_name  = sanitize_input($last_name);
    $username   = sanitize_input($username);
    $password   = n_password_hash($password);

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

    // Check if username already exists
    $stmt = $conn->prepare("SELECT username FROM manager WHERE username = ?");
    if ($stmt === false) {
        try_again("Statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        try_again("Username already exists. Please choose a different username.");
    }

    $stmt->close();

    // Proceed to insert new user
    $stmt = $conn->prepare("INSERT INTO manager (first_name, last_name, username, password) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        try_again("Statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param("ssss", $first_name, $last_name, $username, $password);

    if ($stmt->execute()) {
        status_msg('Successfully created a new account <br> login here -> <a href="login.php">Login</a>');
    } else {
        try_again("Error: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
}

// Otherwise generate the form.
?>

<?php include 'header.inc';?>
<div class="content-block">
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
