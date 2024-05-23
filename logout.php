<?php
session_start();
    
    $_SESSION['auth'] = null;
    $_SESSION['user_id'] = null;
    $_SESSION['status'] = null;
    header("Location: index.php");

