<?php include 'header.inc'; ?>

<main>
    <form method="post" action="" class="content-block">
        <h1>Apply to The Hive</h1>
        <label for="job_reference_number">Job Reference Number</label>
        <input type="text" name="job_reference_number" id="job_reference_number" minlength="5" maxlength="5" size="10" required>
        <fieldset>
            <legend>Details</legend>
            <input type="hidden" name="botchecker" value="notabot">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" minlength="2" maxlength="20" size="10" required pattern="[a-zA-Z]*">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" minlength="2" maxlength="20" size="10" required pattern="[a-zA-Z]*">
            <p><label for="dob">Date Of Birth</label>
                <input type="date" name="dob" id="dob" size="10">
            </p>
            <fieldset>
                <legend>Gender</legend>
                <span class="custom-radio">
                    <input type="radio" id="male" name="gender" value="male">
                    <label for="male">Male</label>
                    <input type="radio" id="female" name="gender" value="female" required="required">
                    <label for="female">Female</label>
                </span>
            </fieldset>
        </fieldset>
        <fieldset>
            <legend>Location</legend>
            <label for="street_address">Street Address</label>
            <input type="text" name="street_address" id="street_address" minlength="2" maxlength="40" size="30" required="required">
            <label for="suburb">Suburb/Town</label>
            <input type="text" name="suburb" id="suburb" minlength="2" maxlength="40" size="30" required pattern="[a-zA-Z]*">
            <p><label for="state">State</label>
                <select name="state" id="state">
                    <option selected="selected" disabled value="">Please Select</option>
                    <option value="VIC">Victoria</option>
                    <option value="NSW">New South Wales</option>
                    <option value="WA">Western Australia</option>
                    <option value="SA">South Australia</option>
                    <option value="TAS">Tasmania</option>
                    <option value="QLD">Queensland</option>
                </select>
            </p>
            <label for="postcode">Your Postcode</label>
            <input type="text" name="postcode" id="postcode" pattern="[0-9]{4}" title="Postcode" required minlength="4" maxlength="4">
        </fieldset>
        <fieldset>
            <legend>Contact Details</legend>
            <label for="email">Email</label>
            <input type="email" id="email" pattern="^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$" size="30" required>
            <label for="phone">Phone Number</label>
            <input type="text" name="phone" id="phone" pattern="[0-9]*" size="30" required minlength="8" maxlength="12">
        </fieldset>
        <fieldset>
            <legend>Skillset</legend>
            <span>
                <label for="html">HTML</label>
                <input type="checkbox" id="html" name="language[]" value="html">
                <label for="css">CSS</label>
                <input type="checkbox" id="css" name="language[]" value="css">
                <label for="javascript">JavaScript</label>
                <input type="checkbox" id="javascript" name="language[]" value="javascript">
                <label for="php">PHP</label>
                <input type="checkbox" id="php" name="language[]" value="php">
                <label for="mysql">MySQL</label>
                <input type="checkbox" id="mysql" name="language[]" value="mysql">
            </span>
            <p>
                <label for="other_skills">Other skills:</label>
            </p>
            <textarea id="other_skills" name="other_skills" rows="4" cols="50"></textarea>
        </fieldset>
        <input type="submit" value="Apply">
        <input type="reset" value="Reset Form">
    </form>
</main>

<?php include 'footer.inc'; ?>
