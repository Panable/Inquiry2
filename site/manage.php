<?php
include 'header.inc';
require_once 'settings.php';

$conn = @mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Default: Display all EOIs
$sql = "SELECT EOInumber AS `EOI Number`, job_ref_number AS `Job Reference Number`, first_name AS `First Name`, last_name AS `Last Name`, status AS `Status` FROM eoi";
$result = mysqli_query($conn, $sql);

// Handle form submissions (if any)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'filter') {
        // Handle search/filtering form submissions
        $field = $_POST['field'];
        $value = $_POST['value'];

        // Build query based on selected field
        switch ($field) {
            case 'job_ref_number':
                $sql .= " WHERE job_ref_number LIKE '%$value%'";
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
        $result = mysqli_query($conn, $sql);
    } elseif ($action === 'delete_eois') {
        // Handle deletion of all EOIs with specified job reference number
        $delete_job_ref = $_POST['delete_job_ref'];

        // Delete all EOIs with the specified job reference number
        $sql_delete = "DELETE FROM eoi WHERE job_ref_number = '$delete_job_ref'";
        $result_delete = mysqli_query($conn, $sql_delete);

        if ($result_delete) {
            echo '<p>All EOIs with job reference number ' . $delete_job_ref . ' have been deleted.</p>';
        } else {
            echo '<p>Error deleting EOIs: ' . mysqli_error($conn) . '</p>';
        }
    } elseif ($action === 'update_status') {
        // Update EOI status
        $eoi_id = $_POST['eoi_id'];
        $new_status = $_POST['new_status'];

        // Update the status for the specific EOI
        $sql_update = "UPDATE eoi SET status = '$new_status' WHERE EOInumber = $eoi_id";
        $result_update = mysqli_query($conn, $sql_update);

        // Handle update success/failure
        if ($result_update) {
            echo '<p>EOI status updated successfully.</p>';
        } else {
            echo '<p>Error updating EOI status: ' . mysqli_error($conn) . '</p>';
        }
    }
}
?>

<main class="manage-eoi-page">
    <section class="container">
        <h1>Manage EOI</h1>

        <form method="post" action="manage.php">
            <label for="field">Choose a field to filter by:</label>
            <select name="field" id="field">
                <option value="all"> All</option>
                <option value="job_ref_number">Job Reference Number</option>
                <option value="name">Applicant's Full Name</option>
                <option value="first_name">First Name</option>
                <option value="last_name">Last Name</option>
                <option value="status">Status</option>
            </select>
            <input type="text" name="value" placeholder="Enter value to filter by">
            <button type="submit" name="action" value="filter">Search</button>
        </form>

        <form method="post" action="manage.php">
            <label for="delete_job_ref">Select Job Reference Number to Delete:</label>
            <select name="delete_job_ref" id="delete_job_ref">
                <?php
                // Query the database to get distinct job reference numbers
                $sql_job_ref = "SELECT DISTINCT job_ref_number FROM eoi";
                $result_job_ref = mysqli_query($conn, $sql_job_ref);
                if ($result_job_ref) {
                    while ($row_job_ref = mysqli_fetch_assoc($result_job_ref)) {
                        echo '<option value="' . $row_job_ref['job_ref_number'] . '">' . $row_job_ref['job_ref_number'] . '</option>';
                    }
                }
                ?>
            </select>
            <button type="submit" name="action" value="delete_eois">Delete EOIs</button>
        </form>

        <form method="post" action="manage.php">
            <?php
            if ($result && $result->num_rows > 0) {
                echo '<table>';
                echo '<thead>';
                echo '<tr>
                    <th scope="col">EOI Num</th>
                    <th scope="col">Job Reference Number</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>';
                echo '</thead>';
                echo '<tbody>';

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    // Display EOI details
                    foreach ($row as $key => $value) {
                        // Skip the status column
                        if ($key === 'Status') {
                            continue;
                        }
                        // Output each value in a table cell
                        echo '<td>' . $value . '</td>';
                    }

                    // Add form to change status
                    echo '<td>';
                    echo '<form method="post" action="manage.php">';
                    echo '<input type="hidden" name="eoi_id" value="' . $row['EOI Number'] . '">';
                    echo '<select name="new_status">';
                    // Dynamically generate options based on current status
                    $current_status = $row['Status'];
                    $status_options = ['New', 'Current', 'Final'];
                    foreach ($status_options as $option) {
                        echo '<option value="' . $option . '"';
                        if ($option === $current_status) {
                            echo ' selected'; // Set the current status as selected
                        }
                        echo '>' . $option . '</option>';
                    }
                    echo '</select>';
                    echo '</td>';

                    // Action buttons in a separate cell
                    echo '<td>';
                    echo '<button type="submit" name="action" value="update_status">&#9998; Update Status</button>';
                    echo '<button type="submit" name="action" value="delete">&#128465; Delete </button>';
                    echo '</td>';
                    echo '</tr>';
                    echo '</form>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p>No EOIs found.</p>';
            }
            ?>
        </form>
    </section>
</main>

<?php include 'footer.inc'; ?>
