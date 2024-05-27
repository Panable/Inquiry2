<?php include 'header.inc';
require_once 'settings.php';

$conn = @mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submissions (if any)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'filter') {
        $field = $_POST['field'];
        $value = $_POST['value'];

        // Build query based on selected field
        $sql = "SELECT EOInumber AS `EOI Number`, job_ref_number AS `Job Reference Number`, first_name AS `First Name`, last_name AS `Last Name`, status AS `Status` FROM eoi";
        switch ($field) {
            case 'job_ref_number':
                $sql .= " WHERE job_ref_number = '$value'";
                break;
            case 'name': // Search by full name
                $sql .= " WHERE CONCAT(first_name, ' ', last_name) LIKE '%$value%'";
                break;
            case 'first_name':
                $sql .= " WHERE first_name LIKE '%$value%'";
                break;
            case 'last_name':
                $sql .= " WHERE last_name LIKE '%$value%'";
                break;
            case 'status':
                $sql .= " WHERE status = '$value'";
                break;
            // Add more cases for other filter options (e.g., skills)
        }
        $result = @mysqli_query($conn, $sql);
    } else if ($action === 'delete_all') {
        // Warning: Deleting all EOIs is permanent! Add confirmation
        die("Are you sure you want to delete all EOIs? This action cannot be undone.");
    } else if ($action === 'change_status') {
        $eoi_id = $_POST['eoi_id'];
        $new_status = $_POST['new_status'];

        // Update the status for the specific EOI
        $sql = "UPDATE eoi SET status = '$new_status' WHERE EOInumber = $eoi_id";
        $result = @mysqli_query($conn, $sql);

        // Handle update success/failure
        if ($result) {
            echo '<p>EOI status updated successfully.</p>';
        } else {
            echo '<p>Error updating EOI status: ' . mysqli_error($conn) . '</p>';
        }
    }
} else {
    // Default: Display all EOIs
    $sql = "SELECT EOInumber AS `EOI Number`, job_ref_number AS `Job Reference Number`, first_name AS `First Name`, last_name AS `Last Name`, status AS `Status` FROM eoi";
    $result = @mysqli_query($conn, $sql);
}

?>


<main class="manage-eoi-page">
    <section class="container">
        <h1>Manage EOI</h1>

        <form method="post" action="manage.php">
            <label for="field">Choose a field to filter by:</label>
            <select name="field" id="field">
                <option value="all"> All </option>
                <option value="job_ref_number">Job Reference Number</option>
                <option value="name">Applicant's Full Name</option>
                <option value="first_name">First Name</option>
                <option value="last_name">Last Name</option>
                <option value="status">Status</option>
            </select>
            <input type="text" name="value" placeholder="Enter value to filter by">
            <button type="submit" name="action" value="filter">Search</button>
            <button type="submit" name="action" value="delete_all" onclick="return confirm('Are you sure you want to delete all EOIs? This action cannot be undone.');">Delete All EOIs</button>
        </form>

        <?php
        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<thead>';
            echo '<tr>
                <th scope="col">EOI Number</th>
                <th scope="col">Job Reference Number</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>';
            echo '</thead>';
            echo '<tbody>';

            // Displaying query results
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                foreach ($row as $key => $value) {
                    echo '<td>' . $value . '</td>';
                }
                // Add form to change status
                echo '<td>';
                echo '<form method="post" action="manage.php">';
                echo '<input type="hidden" name="eoi_id" value="' . $row['EOI Number'] . '">';
                echo '<select name="new_status">';
                echo '<option value="Pending">Pending</option>';
                echo '<option value="Approved">Approved</option>';
                echo '<option value="Rejected">Rejected</option>';
                echo '</select>';
                echo '<button type="submit" name="action" value="change_status">Change Status</button>';
                echo '</form>';
                echo '</td>';

                // Add action buttons here as form elements
                echo '<td>';
                echo '<form method="post" action="view.php"><input type="hidden" name="eoi_id" value="' . $row['EOI Number'] . '"><button type="submit" name="action" value="view">&#128065; View </button></form>';
                echo '<form method="post" action="delete.php"><input type="hidden" name="eoi_id" value="' . $row['EOI Number'] . '"><button type="submit" name="action" value="delete">&#128465; Delete </button></form>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        }
        ?>

    </section>
</main>

<?php include 'footer.inc'; ?>
