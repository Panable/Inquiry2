
<?php
require 'settings.php'; // Include your database connection settings

function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = @mysqli_connect($db_host, $db_user, $db_password, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

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

    if (!empty($errors)) {
        echo "Errors: <br>" . implode("<br>", $errors);
        exit;
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("INSERT INTO eoi (job_ref_number, first_name, last_name, dob, gender, street_address, suburb, state, postcode, email, phone, skill1, skill2, skill3, other_skills) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssssss", $job_ref_number, $first_name, $last_name, $dob, $gender, $street_address, $suburb, $state, $postcode, $email, $phone, $skill1, $skill2, $skill3, $other_skills);

        if ($stmt->execute()) {
            // Commit transaction
            $conn->commit();
            echo "New record created successfully. Your EOI number is: " . $stmt->insert_id;
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
    echo "Invalid request method.";
}
?>

