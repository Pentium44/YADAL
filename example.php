<?php
include_once("yadal.php");

$db = "db.php";
$var = "var";

// Tell the people why there's no more content being written to database on first try
echo "You will notice that 'Writing more content to variable' returned 2 on first load. This is because the database locks after every edit for 1 second to keep spam from corrupting the database. This is called YADAL database auto lock or YADALDAL!<br><br>\r\n";

// Write content to new variable in the database
echo "Writing content... ";
echo yadal_write($var, "Content...", $db);
echo "<br>\r\n";

// Write more content to an existing variable in the database
echo "Writing more content to variable... ";
echo yadal_extend($var, " More content!", $db);
echo "<br>\r\n";

// Retrieve the contents of the specified variable in the database
echo "Getting content: ";
$variable = yadal_get($var, $db);
echo $variable . "<br>\r\n";
echo "<br>\r\n";
?>
