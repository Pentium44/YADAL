<?php
// PentDB - Simple database engine written in PHP
// (C) Chris Dorman, 2014 - GPLv3

function pentdb_get($varname, $db) {
	// check if database exists, if so include
	if(file_exists($db) && is_readable($db) && include_once($db)) { 
		return ${'pentdbvar_' . $varname};
	} else {
		return 1;
	}
}

function pentdb_write($varname, $input, $db) {
	// check if database exists, if so include
	if(file_exists($db) && is_readable($db) && include_once($db)) { 
		// check if variable exists
		if(isset(${'pentdbvar_' . $varname})) {
			return 2;
		} else {
			// remove end of database
			$db_contents = file_get_contents($db);
			$remove_end_of_database = str_replace('?>', "", $db_contents);
			file_put_contents($db, $remove_end_of_database);
			
			// start writing new variable
			$db_contents_new = file_get_contents($db);
			file_put_contents($db, $db_contents_new."\$pentdbvar_".$varname." = \"".$input."\";\n?>");
			return 0;
		}
	} else {
		// create database
		file_put_contents($db, "<?php\n");
		
		$db_contents_new = file_get_contents($db);
		file_put_contents($db, $db_contents_new."\$pentdbvar_".$varname." = \"".$input."\";\n?>");
		return 0;
	}
}

function pentdb_extend($varname, $input, $db) {
	// check if database exists, if so include
	if(file_exists($db) && is_readable($db) && include_once($db)) { 
		$fopen_db = @fopen($db, "r");
		$file_db = file($db, FILE_IGNORE_NEW_LINES);
		$line_count = 0;
		$var_contents = ${'pentdbvar_' . $varname};
		while(!feof($fopen_db)) {
			$line_data = fgets($fopen_db);
			if(strpos($line_data, "\$pentdbvar_".$varname) !== false) {
				$file_db[$line_count] = "\$pentdbvar_".$varname." = \"".$var_contents.$input . "\";\n";
				file_put_contents($db, implode( "\n", $file_db ));
				return 0;
			}
	
			$line_count = $line_count + 1;
		}
	} else {
		return 1;
	}
}

?>
