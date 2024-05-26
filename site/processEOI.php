<?php
require 'settings.php'; // Include your database connection settings

function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Establish a connection to the database
$conn = @mysqli_connect($db_host, $db_user, $db_password, $db_name);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL statement to create EOI table if it does not exist
$createTableSQL = "CREATE TABLE IF NOT EXISTS eoi (
    EOInumber INT AUTO_INCREMENT PRIMARY KEY,
    job_ref_number VARCHAR(5) NOT NULL,
    first_name VARCHAR(20) NOT NULL,
    last_name VARCHAR(20) NOT NULL,
    dob DATE NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    street_address VARCHAR(40) NOT NULL,
    suburb VARCHAR(40) NOT NULL,
    state ENUM('VIC','NSW','QLD','NT','WA','SA','TAS','ACT') NOT NULL,
    postcode VARCHAR(4) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(12) NOT NULL,
    skill1 VARCHAR(100),
    skill2 VARCHAR(100),
    skill3 VARCHAR(100),
    other_skills TEXT,
    status ENUM('New', 'Current', 'Final') DEFAULT 'New'
)";

// Execute the SQL query to create the table if it does not exist
if ($conn->query($createTableSQL) !== TRUE) {
    die("Error creating table: " . $conn->error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $job_ref_number = sanitize_input($_POST["job_ref_number"]);
    $first_name = sanitize_input($_POST["first_name"]);
    $last_name = sanitize_input($_POST["last_name"]);
    $dob = sanitize_input($_POST["dob"]);
    $gender = sanitize_input($_POST["gender"]);
    $street_address = sanitize_input($_POST["street_address"]);
    $suburb = sanitize_input($_POST["suburb"]);
    $state = sanitize_input($_POST["state"]);
    $postcode = sanitize_input($_POST["postcode"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $phone = sanitize_input($_POST["phone"]);
    $skill1 = sanitize_input($_POST["skill1"]);
    $skill2 = sanitize_input($_POST["skill2"]);
    $skill3 = sanitize_input($_POST["skill3"]);
    $other_skills = sanitize_input($_POST["other_skills"]);
    $status = "New";

    // Server-side validation
    $errors = [];
    if (!preg_match("/^[A-Za-z0-9]{5}$/", $job_ref_number)) $errors[] = "Invalid Job Reference Number.";
    if (!preg_match("/^[a-zA-Z]{1,20}$/", $first_name)) $errors[] = "Invalid First Name.";
    if (!preg_match("/^[a-zA-Z]{1,20}$/", $last_name)) $errors[] = "Invalid Last Name.";
    $age = (new DateTime())->diff(new DateTime($dob))->y;
    if ($age < 15 || $age > 80) $errors[] = "Invalid Age.";
    if (!preg_match("/^[0-9]{4}$/", $postcode)) $errors[] = "Invalid Postcode.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid Email.";
    if (!preg_match("/^[0-9 ]{8,12}$/", $phone)) $errors[] = "Invalid Phone Number.";
    if (empty($skill1) && empty($skill2) && empty($skill3) && empty($other_skills)) $errors[] = "At least one skill must be provided.";
    if (isset($_POST["other_skills_checkbox"]) && empty($other_skills)) $errors[] = "Other skills field is checked but no skills are provided.";

    // Postcode range validation
    $postcode = intval($postcode);
    $postcode_ranges = [
        'NSW' => [[2000, 2599], [2619, 2898], [2921, 2999]],
        'ACT' => [[2600, 2618], [2900, 2920]],
        'VIC' => [[3000, 3999]],
        'QLD' => [[4000, 4999]],
        'SA' => [[5000, 5799]],
        'WA' => [[6000, 6797]],
        'TAS' => [[7000, 7799]],
        'NT' => [[800, 899]],
    ];

    $valid_postcode = false;
    foreach ($postcode_ranges[$state] as $range) {
        if ($postcode >= $range[0] && $postcode <= $range[1]) {
            $valid_postcode = true;
            break;
        }
    }
    if (!$valid_postcode) {
        $errors[] = "Invalid Postcode for the selected State.";
    }
    if (!empty($errors)) {
        header( "refresh:7;url=apply.php");
        echo '<link rel="stylesheet" href="styles/style.css">';
        echo '<main>';
        echo '<section class="content-block">';
        echo "Errors: <br>" . implode("<br>", $errors);
        echo '</main>';
        include 'footer.inc';
        exit;
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("INSERT INTO eoi (job_ref_number, first_name, last_name, dob, gender, street_address, suburb, state, postcode, email, phone, skill1, skill2, skill3, other_skills, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssssssss", $job_ref_number, $first_name, $last_name, $dob, $gender, $street_address, $suburb, $state, $postcode, $email, $phone, $skill1, $skill2, $skill3, $other_skills, $status);

        if ($stmt->execute()) {
            // Commit transaction
            $conn->commit();
            header( "refresh:5;url=apply.php");
            echo '<link rel="stylesheet" href="styles/style.css">';
            echo '<main>';
            echo '<section class="content-block">';
            echo "New record created successfully. Your EOI number is: " . $stmt->insert_id;
            echo '</main>';
            include 'footer.inc';

        } else {
            throw new Exception("Error: " . $stmt->error);
        }

        $stmt->close();
    } catch (Exception $e) {
        // Rollback transaction
        $conn->rollback();
        echo $e->getMessage();
    }

    $conn->close();
} else {
    // Redirect if accessed directly
    header( "refresh:5;url=apply.php" );
    echo '<link rel="stylesheet" href="styles/style.css">';
    echo '<main>';
    echo '<section class="content-block">';
    echo 'You\'ll be redirected in about 5 secs. If not, click <a href="apply.php"> here</a>';
    echo '</main>';
    include 'footer.inc';
}
?>
