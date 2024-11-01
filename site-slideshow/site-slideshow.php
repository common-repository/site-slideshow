<?php

/*
Plugin Name: Site Slideshow 
Plugin URI: http://www.internetdienste-berlin.de/2011/03/site-slideshow-version-2/
Author: Dietrich Koch 
Author URI: http://internetdienste-berlin.de
Description: Site Slideshow as a sidebar widget represents for any article or page one image of the standard gallery, but it is not repeated any image when it is used by different posts and we show only the first image of every post. Klicking on the slide leads to the article/page the image stems from. There are some options for adapting the slideshow for your purposes. Further information look at http://www.internetdienste-berlin.de/2011/01/artikel-und-seiten-ubergreifende-slideshow-gallery-als-plugin/
Version: 2.1.1
*/

define('DS', DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__) . DS . 'slideshow-gallery-plugin.php');
require_once(dirname(__FILE__) . DS . 'slideshow-gallery-generate.php');
require_once(dirname(__FILE__) . DS . 'slideshow-widget.php');

class Galerie extends GaleriePlugin {
	function Galerie() {
		$url = explode("&", $_SERVER['REQUEST_URI']);
		$this -> url = $url[0];
		$this -> referer = (empty($_SERVER['HTTP_REFERER'])) ? $this -> url : $_SERVER['HTTP_REFERER'];
		
		$this -> register_plugin('site-slideshow', __FILE__);
		
		//WordPress action hooks
		$this -> add_action('admin_menu');
		$this -> add_action('admin_head');

	}

	function admin_menu() {
/*		add_menu_page(__('Siteshow', $this -> plugin_name), __('Siteshow', $this -> plugin_name), 10, "galerie-settings", array($this, 'admin_settings'), $this -> url() . '/images/icon.png');
		$this -> menus['galerie-settings'] = add_submenu_page("galerie", __('Sitehow', $this -> plugin_name), __('Siteshow', $this -> plugin_name), 10, "galerie-settings", array($this, 'admin_settings'));
		*/
		add_options_page('Site Slideshow Options','Site Slideshow','manage_options','',array($this, 'admin_settings'));

		// add_action('admin_head-' . $this -> menus['galerie-settings'], array($this, 'admin_head_galerie_settings'));

	}
	
	function admin_head() {
		$this -> render('head', false, true, 'admin');
	}
	
	function admin_head_galerie_settings() {		
		add_meta_box('submitdiv', __('Save Settings', $this -> plugin_name), array($this -> Metabox, "settings_submit"), $this -> menus['galerie-settings'], 'side', 'core');
		add_meta_box('generaldiv', __('General Settings', $this -> plugin_name), array($this -> Metabox, "settings_general"), $this -> menus['galerie-settings'], 'normal', 'core');
//		add_meta_box('linksimagesdiv', __('Links &amp; Images Overlay', $this -> plugin_name), array($this -> Metabox, "settings_linksimages"), $this -> menus['galerie-settings'], 'normal', 'core');
		add_meta_box('stylesdiv', __('Appearance &amp; Styles', $this -> plugin_name), array($this -> Metabox, "settings_styles"), $this -> menus['galerie-settings'], 'normal', 'core');
		
		do_action('do_meta_boxes', $this -> menus['galerie-settings'], 'normal');
		do_action('do_meta_boxes', $this -> menus['galerie-settings'], 'side');
	}
	
		
	function siteshow($output = true, $post_id = null, $exclude = null) {		
		global $wpdb;	
			$slides_S = $this -> Slide -> find_all(null, null, array('created', "DESC"));
			$content_S = $this -> render('galerie', array('slides_S' => $slides_S, 'frompost' => false), false, 'default');		
		if ($output) { echo $content_S; } else { return $content_S; }
	}
	
	
		
	function admin_settings() {

		switch ($_GET['method']) {
			case 'reset'			:
				global $wpdb;
				$query = "DELETE FROM `" . $wpdb -> prefix . "options` WHERE `option_name` LIKE '" . $this -> pre . "%';";
				
				if ($wpdb -> query($query)) {
					$message = __('All configuration settings have been reset to their defaults', $this -> plugin_name);
					$msg_type = 'message';
					$this -> render_msg($message);	
				} else {
					$message = __('Configuration settings could not be reset', $this -> plugin_name);
					$msg_type = 'error';
					$this -> render_err($message);
				}
				
				$this -> redirect($this -> url, $msg_type, $message);
				break;
			default					:
				if (!empty($_POST)) {
					foreach ($_POST as $pkey => $pval) {					
						$this -> update_option($pkey, $pval);
					}
					
					$message = __('Configuration has been saved', $this -> plugin_name);
					$this -> render_msg($message);
				}	
				break;
		}
			 // admin_head_galerie_settings();		
		$this -> render('settings', false, true, 'admin');
	}
}

//initialize a Galerie object
$Gallery = new Galerie();

?>