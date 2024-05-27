<?php

/* This php file contains some common functions that
other parts of the website may need access to. 

Namely, contains session functions and a redirect function. */

session_start();

function timing_safe_compare($a, $b) {
    $length = strlen($a);

    if ($length !== strlen($b)) {
        return false;
    }

    $result = 0;
    for ($i = 0; $i < $length; $i++) {
        $result |= (ord($a[$i]) ^ ord($b[$i]));
    }

    return $result === 0;
}

function n_password_hash($password, $cost = 10) {
    // Generate a secure random salt using openssl_random_pseudo_bytes
    $salt = bin2hex(openssl_random_pseudo_bytes(16));
    $salt = substr(base64_encode($salt), 0, 22);
    $salt = strtr($salt, '+', '.'); // Ensure compatibility with bcrypt salt

    // Format the salt to match bcrypt requirements
    $salt = sprintf('$2y$%02d$%s', $cost, $salt);

    // Hash the password with the generated salt using crypt
    $hash = crypt($password, $salt);

    return $hash;
}

function n_password_verify($password, $hash) {
    // Hash the input password with the same salt
    $input_hash = crypt($password, $hash);

    // Compare the hashes using a timing attack safe comparison
    return timing_safe_compare($hash, $input_hash);
}

function redirect($page)
{
    header('location: ' . $page);
    exit;
}

/*
 * Function to unset a session variable
 */
function unsetSession($key)
{
    unset($_SESSION[$key]);
}

/*
 * Function to set a session variable
 */
function setSession($key, $value)
{
    $_SESSION[$key] = $value;
}

/*
 * Function to get the value of a session variable
 */
function getSession($key)
{
    if (!isset($_SESSION[$key])) {
        return false;
    }

    return $_SESSION[$key];
}

function status_msg($msg)
{
    setSession('statusMsg', $msg);    
    redirect('status.php');
}

function isLoggedIn()
{
    return getSession("login");
}

function login($name)
{
    setSession("login", $name);
}

function logout()
{
    unsetSession("login");
}

function fail_login()
{
    if (getSession("timed_out")) return;
    /* Create a new failed attempts */
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

function isTimedOut()
{
    if (!getSession("login_attempts"))
        return false;
    
    if (!getSession("timed_out"))
        return false;

    $timed_out = getSession("timed_out");
    $elapsed_time = time() - $timed_out;

    if ($elapsed_time >= 60)
    {
        unsetSession("login_attempts");
        unsetSession("timed_out");
        return false;
    }
    else
    {
        return 60 - $elapsed_time;
    }

    return true;
}

function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

