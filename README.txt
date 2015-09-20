YADAL - Yet another database abstraction layer. YADAL is lightweight and stores 
information in PHP documents as variables so information is kept away from 
people who view the website.

Version: 0.2 - release
(C) Chris Dorman, 2014-2015 - GPLv3

View example.php for info on how to use YADAL.

Changelog:
	* 0.2
		Fixed bug: YADAL will not return get data if yadal_extend is ran before yadal_get
		Added database lock to prevent spammed inquiries from corrupting the database
		Renamed project! :D
	
	* 0.1c
		Fixed major exploits (added addslashes)

	* 0.1b
		Little tweaks, closes fopen in extend
		
	* 0.1a
		Initial release
