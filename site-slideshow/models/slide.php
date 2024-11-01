<?php

class GalerieSlide extends GalerieDbHelper {

	var $table;
	var $model = 'Slide';
	// var $controller = "slides";
	var $plugin_name = 'site-slideshow';
	
	var $data = array();
	var $errors = array();
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'title'				=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'description'		=>	"TEXT NOT NULL",
		'image'				=>	"VARCHAR(50) NOT NULL DEFAULT ''",
		'type'				=>	"ENUM('file','url') NOT NULL DEFAULT 'file'",
		'image_url'			=>	"VARCHAR(200) NOT NULL DEFAULT ''",
		'uselink'			=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'link'				=>	"VARCHAR(200) NOT NULL DEFAULT ''",
		'order'				=>	"INT(11) NOT NULL DEFAULT '0'",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);

	function GalerieSlide($data = array()) {
		global $wpdb;
				$this -> table = $wpdb -> prefix . 'site_slides';
		if (!empty($data)) {shuffle($data);
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = $dval;
			
			}
		}
		
		return true;
	}

	
}

?>