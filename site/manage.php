<?php include 'header.inc';
require_once 'settings.php';

$conn = @mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//Query all EOIs (Display All)
$sql = "SELECT EOInumber AS `EOI Number`, job_ref_number AS `Job Reference Number`, first_name AS `First Name`, last_name AS `Last Name`, status AS `Status` FROM eoi";
$result = @mysqli_query($conn, $sql);
?>


<main class="manage-eoi-page">
    <section>
        <h1>Manage EOI</h1>

        <form method="post" action="manage.php">
            <label for="field">Choose a field to filter by:</label>
            <select name="field" id="field">
                <option value="job_ref_number">Job Reference Number</option>
                <option value="first_name">First Name</option>
                <option value="last_name">Last Name</option>
                <option value="full_name">Full Name</option>
                <option value="status">Status</option>
                <option value="skills">Skills</option>
            </select>
            <input type="text" name="value" placeholder="Enter value to filter by">
            <button type="submit" name="action" value="filter">Filter</button>
            <button type="submit" name="action" value="delete_all">Delete All EOIs</button>
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
                foreach ($row as $value) {
                    echo '<td>' . $value . '</td>';
                }
                // Add action buttons here if needed

                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        }
        ?>

    </section>
</main>

<?php include 'footer.inc'; ?>
