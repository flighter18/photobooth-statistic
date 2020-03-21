<?php
# SESSION START
###############
if (session_status() == PHP_SESSION_NONE) {
        session_start();
}

session_destroy(); //destroy the session
header("location:index.php"); //to redirect back to "index.php" after logging out
exit();
?>
