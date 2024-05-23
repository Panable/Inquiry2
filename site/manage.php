<?php include 'header.inc'; ?>
<?php include 'settings.php'; ?>

    <main>
        <section class="container">
            <h1> Manage EOI </h1>
            <?php
            echo "<select name='Field' id='cars'>
                <option value='Reference Number'> Reference Num </option>
                <option value='First Name'> First Name</option>
                <option value='Last Name'> Last Name</option>
                <option value='Full Name'> Full Name</option>
                <option value='Status'> Status </option>
                <option value='Status'> Skills </option>
                </select>
                "
            ?>
            <button> Delete All EOI's</button>
            <table>
                <thead>
                <tr>
                    <th> #</th>
                    <th> Name</th>
                    <th> DOB</th>
                    <th> Status</th>
                    <th> Edit</th>
                </tr>
                </thead>
            </table>
        </section>
    </main>


<?php include 'footer.inc'; ?>