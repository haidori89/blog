<?php
require_once "app/functions.php";
session_start();
session_destroy();
session_start();
$_SESSION['redicet'] = true;
msg_alert("warning","you logged out");
header("location: login.php?redicet=logout");