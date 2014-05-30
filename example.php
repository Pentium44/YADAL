<?php
include_once("pentdb.php");

$db = "db.php";
$var = "var";

// Write content to new variable in the database
echo "Writing content... <br>\r\n";
pentdb_write($var, "Content...", $db);

// Write more content to an existing variable in the database
echo "Writing more content to variable... <br>\r\n";
pentdb_extend($var, " More content!", $db);

// Retrieve the contents of the specified variable in the database
echo "Getting content: ";
echo pentdb_get($var, $db) . "<br>\r\n";

?>
