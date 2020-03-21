<?php // Aufbau der Datenbankverbindung  

$conn = mysqli_connect ("localhost", "<User>", "<Password>", "<DB-Name>") or die("ERROR keine Verbindung zur Datenbank " . mysqli_error($conn));

mysqli_query($conn, "SET NAMES 'utf8'");
mysqli_query($conn, "SET CHARACTER SET 'utf8'");

?>

