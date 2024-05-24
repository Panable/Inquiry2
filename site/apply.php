<?php include 'header.inc'; ?>
<?php require_once 'settings.php'; ?>

<?php
$conn = @mysqli_connect($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


@mysqli_close($conn);
?>

<main>
    <section class="content-block">
        <form action="processEOI.php" method="post" novalidate>
            <label for="job_ref_number">Job Reference Number:</label>
            <select id="job_ref_number" name="job_ref_number" required>
                <?php foreach ($job_descriptions as $job) : ?>
                    <option value="<?= htmlspecialchars($job['job_ref_number']) ?>"><?= htmlspecialchars($job['job_ref_number']) ?> - <?= htmlspecialchars($job['job_title']) ?></option>
                <?php endforeach; ?>
            </select><br>

            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required maxlength="20"><br>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required maxlength="20"><br>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required><br>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select><br>

            <label for="street_address">Street Address:</label>
            <input type="text" id="street_address" name="street_address" required maxlength="40"><br>

            <label for="suburb">Suburb/Town:</label>
            <input type="text" id="suburb" name="suburb" required maxlength="40"><br>

            <label for="state">State:</label>
            <select id="state" name="state" required>
                <option value="VIC">VIC</option>
                <option value="NSW">NSW</option>
                <option value="QLD">QLD</option>
                <option value="NT">NT</option>
                <option value="WA">WA</option>
                <option value="SA">SA</option>
                <option value="TAS">TAS</option>
                <option value="ACT">ACT</option>
            </select><br>

            <label for="postcode">Postcode:</label>
            <input type="text" id="postcode" name="postcode" required pattern="\d{4}"><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" required pattern="\d{8,12}"><br>

            <label for="skill1">Skill 1:</label>
            <input type="text" id="skill1" name="skill1"><br>

            <label for="skill2">Skill 2:</label>
            <input type="text" id="skill2" name="skill2"><br>

            <label for="skill3">Skill 3:</label>
            <input type="text" id="skill3" name="skill3"><br>

            <label for="other_skills">Other Skills:</label>
            <textarea id="other_skills" name="other_skills"></textarea><br>

            <input type="submit" value="Submit">
        </form>
    </section>
</main>

<?php include 'footer.inc'; ?>