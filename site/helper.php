<?php

/* This php file contains some common functions that
other parts of the website may need access to. 

Namely, contains session functions and a redirect function. */

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

function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

unsetSession("login");
session_start();
