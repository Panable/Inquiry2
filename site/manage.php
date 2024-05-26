<?php include 'header.inc'; ?>
<?php require_once 'settings.php'; ?>

<main class="manage-eoi-page">
    <section >
        <h1> Manage EOI </h1>
        <?php
        echo "<select name='Field' id='eoi'>
                <option value='Reference Number'> Reference Num </option>
                <option value='First Name'> First Name</option>
                <option value='Last Name'> Last Name</option>
                <option value='Full Name'> Full Name</option>
                <option value='Status'> Status </option>
                <option value='Skills'> Skills </option>
                </select>
                "
        ?>
        <button> Delete All EOI's</button>
        <table>
            <thead>
            <tr>
                <th scope="col"> # </th>
                <th scope="col"> EOI Number </th>
                <th scope="col"> Job Reference Number </th>
                <th scope="col"> Name </th>
                <th scope="col"> Contact </th>
                <th scope="col"> Status </th>
                <th scope="col"> Action </th>
            </tr>
            </thead>
            <tbody>
            <?php
            // PHP code to fetch and display EOIs
            // Assume $eois is an array of EOI records from the database
            foreach ($eois as $eoi) {
                echo "<tr>
                        <td>{$eoi['EOInumber']}</td>
                        <td>{$eoi['job_ref_number']}</td>
                        <td>{$eoi['first_name']}</td>
                        <td>{$eoi['last_name']}</td>
                        <td>{$eoi['status']}</td>
                        <td>
                            <a href='view.php?EOInumber={$eoi['EOInumber']}'>View</a> |
                            <a href='delete.php?job_ref_number={$eoi['job_ref_number']}'>Delete</a> |
                            <a href='edit_status.php?EOInumber={$eoi['EOInumber']}'>Change Status</a>
                        </td>
                      </tr>";
            }
            ?>
            </tbody>
        </table>
    </section>
</main>

<?php include 'footer.inc'; ?>
