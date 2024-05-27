<?php include 'header.inc'; ?>

<body>
<h1 class="enhancement">Website Enhancements</h1>
<section class="content-block">
    <h2>Login and Register Enhancements</h2>
    <br>
    <p>Our website has been enhanced with improved login and register functionalities:</p>
    <ul>
        <li><strong>Failed Login Attempts:</strong> Implemented a mechanism to track failed login attempts using sessions. After three consecutive failed attempts, the user is timed out for 60 seconds.</li>
    </ul>
    <p>Below is the code snippet illustrating how failed login attempts are tracked:</p>
    <h3>Failed Login Attempts Tracking</h3>
    <div class="code">
        <pre><code>// Code snippet from helper.php
    echo htmlspecialchars('
    function fail_login()
    {
        if (getSession("timed_out")) return;

        if (!getSession("login_attempts"))
        {
            setSession("login_attempts", 1);
            return;
        }

        $login_attempts = getSession("login_attempts");
        setSession("login_attempts", ++$login_attempts);
        if ($login_attempts >= 3)
        {
            setSession("timed_out", time());
        }
    }
    ');
        </code></pre>
    </div>
    <p>This snippet from <code>helper.php</code> shows the <code>fail_login()</code> function responsible for tracking failed login attempts. It checks if the user is already timed out, and if not, increments the <code>login_attempts</code> session variable. If the number of login attempts reaches three, it sets the <code>timed_out</code> session variable with the current time, indicating that the user is timed out for 60 seconds.</p>
</section>

    <section class="content-block">
        <h2>Logout Enhancement</h2>
        <br>
        <p>The website now includes a logout feature:</p>
        <p>Below is the code snippet for the logout functionality:</p>
        <h3>Logout Functionality</h3>
    <div class="code">
        <pre><code>// Code snippet from logout.php
    require_once \'helper.php\';

    if (!isLoggedIn()) { /* We are already logged in! */
        status_msg("You are already logged out!");
    } else {
        logout();
        status_msg("Successfully logged out!");
    }
    ');
        </code></pre>
        </div>
        <p>This snippet from <code>logout.php</code> demonstrates the logout functionality. It checks if the user is already logged in using the <code>isLoggedIn()</code> function from <code>helper.php</code>. If the user is not logged in, it displays a message indicating that the user is already logged out.</p>
        <p>If the user is logged in, it calls the <code>logout()</code> function from <code>helper.php</code>. The <code>logout()</code> function unsets the session data associated with the user's login status, effectively logging them out. After logging out, a success message is displayed using the <code>status_msg()</code> function.</p>
        <p>It's important to unset the session data upon logout to ensure that the user's authentication state is properly cleared. This prevents unauthorized access to restricted areas of the website and helps maintain security.</p>
    </section>


        <footer>
            <p>&copy; 2024 Your Website Name. All rights reserved.</p>
        </footer>

<?php include 'footer.inc'; ?>
