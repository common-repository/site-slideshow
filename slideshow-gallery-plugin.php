<?php

class GaleriePlugin {

	var $version = '1.1.1';
	var $plugin_name;
	var $plugin_base;
	var $pre = 'Galerie';
	
	var $menus = array();
	var $sections = array(
		'galerie'			=>	'galerie',
		'settings'			=>	'galerie-settings',
	);
	
	var $helpers = array('Db', 'Html', 'Form', 'Metabox');
	var $models = array('Slide');
	
	var $debugging = false;		//set to "true" to turn on debugging
	var $debug_level = 1;		//set to 2 for PHP and DB errors or 1 for just DB errors

	function register_plugin($name, $base) {
		$this -> plugin_name = $name;
		$this -> plugin_base = rtrim(dirname($base), DS);
		$this -> sections = (object) $this -> sections;
		
		$this -> enqueue_scripts();
		$this -> enqueue_styles();
		
		$this -> initialize_classes();
		$this -> initialize_options();
		
		if (function_exists('load_plugin_textdomain')) {
			$currentlocale = get_locale();
			if(!empty($currentlocale)) {
				$moFile = dirname(__FILE__) . DS . "languages" . DS . $this -> plugin_name . "-" . $currentlocale . ".mo";				
				if(@file_exists($moFile) && is_readable($moFile)) {
					load_textdomain($this -> plugin_name, $moFile);
				}
			}
		}
		
		global $wpdb;
		if ($this -> debugging == true) {
			$wpdb -> show_errors();
			error_reporting(E_ALL ^ E_NOTICE);
			@ini_set('display_errors', 1);
		} else {
			$wpdb -> hide_errors();
			error_reporting(0);
			@ini_set('display_errors', 0);
		}
		
		return true;
	}
	
	function init_class($name = null, $params = array()) {
		if (!empty($name)) {
			$name = $this -> pre . $name;
				
			if (class_exists($name)) {
				if ($class = new $name($params)) {							
					return $class;
				}
			}
		}
		
		$this -> init_class('Country');
		
		return false;
	}
	
	function initialize_classes() {
		if (!empty($this -> helpers)) {
			foreach ($this -> helpers as $helper) {
				$hfile = dirname(__FILE__) . DS . 'helpers' . DS . strtolower($helper) . '.php';
				
				if (file_exists($hfile)) {
					require_once($hfile);
					
					if (empty($this -> {$helper}) || !is_object($this -> {$helper})) {
						$classname = $this -> pre . $helper . 'Helper';
						
						if (class_exists($classname)) {
							$this -> {$helper} = new $classname;
						}
					}
				} 
			}
		}
	
		if (!empty($this -> models)) {
			foreach ($this -> models as $model) {
				$mfile = dirname(__FILE__) . DS . 'models' . DS . strtolower($model) . '.php';
			// echo $mfile;
				if (file_exists($mfile)) {
					require_once($mfile);
					
					if (empty($this -> {$model}) || !is_object($this -> {$model})) {
						$classname = $this -> pre . $model;
					
						if (class_exists($classname)) {
							$this -> {$model} = new $classname;
						}
					}
				} 
			}
		}
	}
	
	function initialize_options() {
		$styles = array(
			'width'				=>	"100%",
			'height'			=>	"250",
			'border'			=>	"1px solid #ffffff",
			'background'		=>	"transparent",
			'infobackground'	=>	"transparent",
			'infocolor'			=>	"#000000",
			'limit'				=> 1000,
			'sliding'			=> "Y",
			'infosize'			=> '1em'
		);
		
		$this -> add_option('styles', $styles);
		
		//General Settings
		$this -> add_option('fadespeed', 2000);
		$this -> add_option('information', "Y");
		$this -> add_option('autoslide', "Y");
		$this -> add_option('autospeed', 2000);
		$this -> add_option('limit',1000);
		$this -> add_option('sliding',"Y");
		
	}
	
	function render_msg($message = '') {
		$this -> render('msg-top', array('message' => $message), true, 'admin');
	}
	
	function render_err($message = '') {
		$this -> render('err-top', array('message' => $message), true, 'admin');
	}
	
	function redirect($location = '', $msgtype = '', $message = '') {
		$url = $location;
		
		if ($msgtype == "message") {
			$url .= '&' . $this -> pre . 'updated=true';
		} elseif ($msgtype == "error") {
			$url .= '&' . $this -> pre . 'error=true';
		}
		
		if (!empty($message)) {
			$url .= '&' . $this -> pre . 'message=' . urlencode($message);
		}
		
		?>
		
		<script type="text/javascript">
		window.location = '<?php echo (empty($url)) ? get_option('home') : $url; ?>';
		</script>
		
		<?php
		
		flush();
	}
	
	//		
	function check_uploaddir() {
		$uploaddir = ABSPATH . 'wp-content' . DS . 'uploads' . DS . $this -> plugin_name . DS;
		
		if (!file_exists($uploaddir)) {
			if (@mkdir($uploaddir, 0777)) {
				@chmod($uploaddir, 0777);
				return true;
			} else {
				$message = __('Uploads folder named "' . $this -> plugin_name . '" cannot be created inside "wp-content/uploads"', $this -> plugin_name);
				$this -> render_msg($message);
			}
		}
		
		return false;
	}
	
	function add_action($action, $function = null, $priority = 10, $params = 1) {
		if (add_action($action, array($this, (empty($function)) ? $action : $function), $priority, $params)) {
			return true;
		}
		
		return false;
	}
	
	function add_filter($filter, $function = null, $priority = 10, $params = 1) {
		if (add_filter($filter, array($this, (empty($function)) ? $filter : $function), $priority, $params)) {
			return true;
		}
		
		return false;
	}
	
	function enqueue_scripts() {	
		wp_enqueue_script('jquery');
		wp_enqueue_script('cycle','/' . PLUGINDIR . '/' . $this -> plugin_name .'/'.'js/jquery.cycle.all.min.js');
		if (is_admin()) {
			if (!empty($_GET['page']) && in_array($_GET['page'], (array) $this -> sections)) {
				wp_enqueue_script('autosave');
			
				if ($_GET['page'] == 'galerie-settings') {
					wp_enqueue_script('common');
					wp_enqueue_script('wp-lists');
					wp_enqueue_script('postbox');
					
					wp_enqueue_script('settings-editor', '/' . PLUGINDIR . '/' . $this -> plugin_name . '/js/settings-editor.js', array('jquery'), '1.0');
				}
				
				if ($_GET['page'] == "galerie" && $_GET['method'] == "order") {
					wp_enqueue_script('jquery-ui-sortable');
				}
				
				add_thickbox();
			}
			
			wp_enqueue_script($this -> plugin_name . 'admin', '/' . PLUGINDIR . '/' . $this -> plugin_name . '/js/admin.js', null, '1.0');
		} else {			
//			if ($this -> get_option('imagesthickbox') == "Y") {
//			add_thickbox();
//			}
		}
		
		return true;
	}
	
	function enqueue_styles() {
		if (!is_admin()) {
			$src = '/' . PLUGINDIR . '/' . $this -> plugin_name . '/css/gallery-css.php?1=1';
			
			if ($styles = $this -> get_option('styles')) {
				foreach ($styles as $skey => $sval) {
					$src .= "&amp;" . $skey . "=" . urlencode($sval);
				}
			}
			
			wp_enqueue_style($this -> plugin_name, $src, null, '1.0', 'screen');
		}
	
		return true;
	}
	
	function plugin_base() {
		return rtrim(dirname(__FILE__), '/');
	}
	
	function url() {
		return rtrim(get_bloginfo('wpurl'), '/') . '/' . substr(preg_replace("/\\" . DS . "/si", "/", $this -> plugin_base()), strlen(ABSPATH));
	}
	
	function add_option($name = '', $value = '') {
		if (add_option($this -> pre . $name, $value)) {
			return true;
		}
		
		return false;
	}
	
	function update_option($name = '', $value = '') {
		if (update_option($this -> pre . $name, $value)) {
			return true;
		}
		
		return false;
	}
	
	function get_option($name = '', $stripslashes = true) {
		if ($option = get_option($this -> pre . $name)) {
			if (@unserialize($option) !== false) {
				return unserialize($option);
			}
			
			if ($stripslashes == true) {
				$option = stripslashes_deep($option);
			}
			
			return $option;
		}
		
		return false;
	}
	
	function debug($var = array()) {
		if ($this -> debugging) {
			echo '<pre>' . print_r($var, true) . '</pre>';
			return true;
		}
		
		return false;
	}
	
	
	function get_fields($table = null) {	
		global $wpdb;
	
		if (!empty($table)) {
			$fullname = $table;
		
			if (($tablefields = mysql_list_fields(DB_NAME, $fullname, $wpdb -> dbh)) !== false) { 
				$columns = mysql_num_fields($tablefields);
				
				$field_array = array();
				for ($i = 0; $i < $columns; $i++) {
					$fieldname = mysql_field_name($tablefields, $i);
					$field_array[] = $fieldname;
				}
				
				return $field_array;
			}
		}
		
		return false;
	}
		
	function render($file = '', $params = array(), $output = true, $folder = 'admin') {	
		if (!empty($file)) {
			$filename = $file . '.php';
			$filepath = $this -> plugin_base() . DS . 'views' . DS . $folder . DS;
			$filefull = $filepath . $filename;
		
			if (file_exists($filefull)) {
				if (!empty($params)) {
					foreach ($params as $pkey => $pval) {
						${$pkey} = $pval;
					}
				}
			
				if ($output == false) {
					ob_start();
				}
				
				include($filefull);
				
				if ($output == false) {					
					$data = ob_get_clean();					
					return $data;
				} else {
					flush();
					return true;
				}
			}
		}
		
		return false;
	}
}

?>