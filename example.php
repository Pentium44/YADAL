<?php
include_once("pentdb.php");

$db = "db.php";
$var = "var";

// Write content to new variable in the database
echo "Writing content... ";
echo pentdb_write($var, "Content...", $db);
echo "<br>\r\n";

// Write more content to an existing variable in the database
echo "Writing more content to variable... ";
echo pentdb_extend($var, " More content!", $db);
echo "<br>\r\n";

// Retrieve the contents of the specified variable in the database
echo "Getting content: ";
echo pentdb_get($var, $db) . "<br>\r\n";
echo "<br>\r\n";
?>
