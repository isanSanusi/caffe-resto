<?php
    // fungsi destroy session agar bisa logout
    session_start();
    session_unset();
    session_destroy();
    header("location: login.php");