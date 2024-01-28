<?php   // logout of a session
session_start();

session_unset();
session_destroy();

header("location: Atlas.html");
exit;
?>