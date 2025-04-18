<?php
session_start();
session_unset();
session_destroy();
setcookie("user", "", time() - 3600, "/"); // delete cookie

// Redirect to custom logged out page
header("Location:http://localhost/projectKT/loggedout.html");
exit;
?>

