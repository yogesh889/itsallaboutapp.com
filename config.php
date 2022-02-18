<?php
	$config =array(
		"base_url" => "https://itsallaboutapp.com/", 
		"providers" => array ( 

			"Google" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "1069503353192-rfioff04t3jhofdbbdpbpn4hntjibs9g.apps.googleusercontent.com", "secret" => "nGaPeXIgjKq8IXz6ZaOjZf5v" ), 
			),

			"Facebook" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "2f90d5b2ecf4ba7ec3404141880a1631", "secret" => "569525460710076" ), 
			),

			"Twitter" => array ( 
				"enabled" => true,
				"keys"    => array ( "key" => "XXXXXXXX", "secret" => "XXXXXXX" ) 
			),
		),
		// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
		"debug_mode" => false,
		"debug_file" => "",
	);
?>