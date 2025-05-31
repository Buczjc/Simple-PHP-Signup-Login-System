<?php
//Destroys the session and redirect useres back to signup page
session_destroy();
header("Location: signup.php");
exit();