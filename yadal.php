<?php
// YADAL - Yet another database abstraction layer!
// (C) Chris Dorman, 2014-2015 - GPLv3
// Version 0.2

function check_file_lock($file){
	$filemod = filemtime($file);
	$getTime = time(); 
	return ((time() - filemtime($file)) > 1 ) ? false : true;
}

function yadal_write($varname, $input, $db) {
	// check if database exists, if so include
	if(file_exists($db) && is_readable($db) && include($db)) { 
		// check if file has been modified within an unreasonable time frame
		if(check_file_lock($db)) return 1;

		// check if variable exists
		if(isset(${'yadalvar_' . $varname})) {
			return 2;
		} else {
			// remove end of database
			$db_contents = file_get_contents($db);
			$remove_end_of_database = str_replace('?>', "", $db_contents);
			file_put_contents($db, $remove_end_of_database);
			
			// start writing new variable
			$db_contents_new = file_get_contents($db);
			file_put_contents($db, $db_contents_new."\$yadalvar_".$varname." = \"".addslashes($input)."\";\n?>");
			return 0;
		}
	} else {
		// create database
		
		file_put_contents($db, "<?php\n");
		
		$db_contents_new = file_get_contents($db);
		file_put_contents($db, $db_contents_new."\$yadalvar_".$varname." = \"".addslashes($input)."\";\n?>");
		return 0;
	}
}

function yadal_extend($varname, $input, $db) {
	// check if database exists, if so include
	if(file_exists($db) && is_readable($db) && include($db)) { 
		// check if file has been modified within an unreasonable time frame
		if(check_file_lock($db)) return 2;

		// check if variable is in database
		if(isset(${'yadalvar_' . $varname})) {
		
			$fopen_db = fopen($db, "r");
			$file_db = file($db, FILE_IGNORE_NEW_LINES);
			$line_count = 0;
			$var_contents = ${'yadalvar_' . $varname};
			while(!feof($fopen_db)) {
				$line_data = fgets($fopen_db);
				if(strpos($line_data, "\$yadalvar_".$varname) !== false) {
					$file_db[$line_count] = "\$yadalvar_".$varname." = \"".$var_contents.addslashes($input) . "\";";
					file_put_contents($db, implode( "\n", $file_db ));
				}
	
				$line_count = $line_count + 1;
			}
			fclose($fopen_db);
			return 0;
		} else {
			return 3;
		}	
	} else {
		return 1;
	}
}

function yadal_get($varname, $db) {
	// check if database exists, if so include
	if(file_exists($db) && is_readable($db) && include($db)) { 
		if(isset(${'yadalvar_' . $varname})) {
			return ${'yadalvar_' . $varname};
		} else {
			return 2;
		}
	} else {
		return 1;
	}
}

?>
