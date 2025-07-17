<?php
$dsn = "localhost";
$dbusername = "root";
$dbpassword = "";
$db = "session_library";

try {
    $conn = new mysqli ($dsn, $dbusername, $dbpassword, $db);
}
catch (mysqli_sql_exception $ex) {
    // Something went wrong...
    echo "<p>Error: Unable to connect to database.</p>";
    echo "<p>Debugging errno: " . $ex->getCode() . "</p>";
    echo "<p>Debugging error: " . $ex->getMessage() . "</p>";
    exit;
}