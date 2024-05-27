<?php
require_once 'helper.php';

if (!isLoggedIn()) { /* We are already logged in! */
    status_msg("You are already logged out!");
} else {
    logout();
    status_msg("Successfully logged out!");
}
