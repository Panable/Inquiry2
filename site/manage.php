<?php
require_once 'helper.php';
if (!isLoggedIn())
    status_msg("Please login to access this page...");

include 'header.inc';
require_once 'settings.php';

$conn = @mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

    <main class="manage-eoi-page">
        <section class="container">
            <h1>Manage EOI</h1>

            <?php


            // Default: Display all EOIs
            $sql = "SELECT EOInumber AS `EOI Number`, job_ref_number AS `Job Reference Number`, first_name AS `First Name`, last_name AS `Last Name`, status AS `Status` FROM eoi";
            $result = mysqli_query($conn, $sql);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $action = $_POST['action'];

                // Handle different actions
                switch ($action) {
                    case 'filter':
                        $result = handleFiltering($_POST, $conn);
                        break;
                    case 'delete_eois':
                        handleDeleteEOIs($_POST, $conn);
                        // Fetch the query result again after deleting EOIs
                        $result = mysqli_query($conn, $sql);
                        break;
                    case 'update_status':
                        handleUpdateStatus($_POST, $conn);
                        // Fetch the query result again after updating status
                        $result = mysqli_query($conn, $sql);
                        break;
                    default:
                        // Handle invalid action
                        echo '<p class="output-message error">Invalid action.</p>';
                        break;
                }
            }
            // Function to handle filtering
            function handleFiltering($postData, $conn) {
                $field = $postData['field'];
                $value = $postData['value'];

                $sql = "SELECT EOInumber AS `EOI Number`, job_ref_number AS `Job Reference Number`, first_name AS `First Name`, last_name AS `Last Name`, status AS `Status` FROM eoi";

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

                return mysqli_query($conn, $sql);
            }

            // Function to handle deleting EOIs
            function handleDeleteEOIs($postData, $conn) {
                $delete_job_ref = $postData['delete_job_ref'];

                // Delete all EOIs with the specified job reference number
                $sql_delete = "DELETE FROM eoi WHERE job_ref_number = '$delete_job_ref'";
                $result_delete = mysqli_query($conn, $sql_delete);

                if ($result_delete) {
                    echo '<p class="output-message success"> All EOIs with job reference number ' . $delete_job_ref . ' have been deleted.</p>';
                } else {
                    echo '<p class="output-message error"> Error deleting EOIs: ' . mysqli_error($conn) . '</p>';
                }
            }

            // Function to handle updating EOI status
            function handleUpdateStatus($postData, $conn) {
                $eoi_id = $postData['eoi_id'];
                $new_status = $postData['new_status'];

                // Update the status for the specific EOI
                $sql_update = "UPDATE eoi SET status = '$new_status' WHERE EOInumber = $eoi_id";
                $result_update = mysqli_query($conn, $sql_update);

                // Handle update success/failure
                if ($result_update) {
                    echo '<p class="output-message success">EOI status updated successfully.</p>';
                } else {
                    echo '<p class="output-message error">Error updating EOI status: ' . mysqli_error($conn) . '</p>';
                }
            }
            ?>


            <div class="form-wrapper">
                <h3 class="filter-heading">Choose a field to filter by:</h3>
                <!-- Filter form -->
                <form class="filter-form" method="post" action="manage.php">
                    <select name="field" id="field" class="medium-width">
                        <option value="all"> All</option>
                        <option value="job_ref_number">Job Reference Number</option>
                        <option value="name">Applicant's Full Name</option>
                        <option value="first_name">First Name</option>
                        <option value="last_name">Last Name</option>
                        <option value="status">Status</option>
                    </select>
                    <input type="text" name="value" placeholder="Enter value to filter by" class="medium-width">
                    <button type="submit" name="action" value="filter">Search</button>
                </form>
            </div>

            <div class="form-wrapper">
                <h3 class="delete-heading">Select Job Reference Number to Delete:</h3>
                <form class="delete-form" method="post" action="manage.php">
                    <select name="delete_job_ref" id="delete_job_ref" class="medium-width">
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
            </div>


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
                        //echo '<button type="submit" name="action" value="delete">&#128465; Delete </button>';
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