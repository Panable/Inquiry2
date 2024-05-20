<?php
include 'settings.php';

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table if not exists
$createTableSQL = "CREATE TABLE IF NOT EXISTS eoi (
    EOInumber INT AUTO_INCREMENT PRIMARY KEY,
    JobRefNumber CHAR(5) NOT NULL,
    FirstName VARCHAR(20) NOT NULL,
    LastName VARCHAR(20) NOT NULL,
    StreetAddress VARCHAR(40) NOT NULL,
    SuburbTown VARCHAR(40) NOT NULL,
    State CHAR(3) NOT NULL,
    Postcode CHAR(4) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    PhoneNumber VARCHAR(12) NOT NULL,
    Skill1 VARCHAR(50),
    Skill2 VARCHAR(50),
    Skill3 VARCHAR(50),
    OtherSkills TEXT,
    Status ENUM('New', 'Current', 'Final') DEFAULT 'New'
)";
$conn->query($createTableSQL);

// Sanitize and validate inputs
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$jobRefNumber = sanitize_input($_POST['JobRefNumber']);
$firstName = sanitize_input($_POST['FirstName']);
$lastName = sanitize_input($_POST['LastName']);
$streetAddress = sanitize_input($_POST['StreetAddress']);
$suburbTown = sanitize_input($_POST['SuburbTown']);
$state = sanitize_input($_POST['State']);
$postcode = sanitize_input($_POST['Postcode']);
$email = sanitize_input($_POST['Email']);
$phoneNumber = sanitize_input($_POST['PhoneNumber']);
$skill1 = sanitize_input($_POST['Skill1']);
$skill2 = sanitize_input($_POST['Skill2']);
$skill3 = sanitize_input($_POST['Skill3']);
$otherSkills = sanitize_input($_POST['OtherSkills']);

// Validate inputs
$errors = [];
if (!preg_match('/^[A-Za-z0-9]{5}$/', $jobRefNumber)) {
    $errors[] = "Invalid Job Reference Number.";
}
if (!preg_match('/^[A-Za-z]{1,20}$/', $firstName)) {
    $errors[] = "Invalid First Name.";
}
if (!preg_match('/^[A-Za-z]{1,20}$/', $lastName)) {
    $errors[] = "Invalid Last Name.";
}
// Add other validations

if (empty($errors)) {
    $stmt = $conn->prepare("INSERT INTO eoi (JobRefNumber, FirstName, LastName, StreetAddress, SuburbTown, State, Postcode, Email, PhoneNumber, Skill1, Skill2, Skill3, OtherSkills, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'New')");
    $stmt->bind_param("sssssssssssss", $jobRefNumber, $firstName, $lastName, $streetAddress, $suburbTown, $state, $postcode, $email, $phoneNumber, $skill1, $skill2, $skill3, $otherSkills);
    $stmt->execute();
    $eoiNumber = $stmt->insert_id;
    $stmt->close();

    echo "EOI submitted successfully. Your EOI number is $eoiNumber.";
} else {
    echo "Errors: " . implode(", ", $errors);
}

$conn->close();
?>

