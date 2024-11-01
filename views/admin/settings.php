<?php

global $post, $post_ID;
$post_ID = 1;
wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);

?>
<style>
#footer{position:relative;}
</style>

<div class="wrap" style="padding:5px;background:yellow;width:550px;margin-top:10px;>
	<h2><?php _e('Configuration Settings', $this -> plugin_name); ?></h2>
	<div class="infos">
	<?php _e('Contact me if you have trouble with this plugin:  ', $this -> plugin_name) ?>
	<a href="http://internetdienste-berlin.de/site-slideshow/">http://internetdienste-berlin.de/site-slideshow</a><br />
	<?php _e('Please give me your vote:  ', $this -> plugin_name) ?>
	<a href="http://wordpress.org/extend/plugins/site-slideshow/">http://wordpress.org/extend/plugins/site-slideshow</a>
	<br /><span class="danke"><?php _e('A small thankyou?', $this -> plugin_name); ?></span>
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="paypal"> 
		
		<input name="cmd" type="hidden" value="_s-xclick" /> 
		<input name="hosted_button_id" type="hidden" value="GEAVFBEECG85G" /> 
		<input alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal." name="submit" src="http://www.internetdienste-berlin.de/files/2011/01/Zahlbutton.png" type="image" /> 
		<img src="https://www.paypal.com/de_DE/i/scr/pixel.gif" border="0" alt="" width="1" height="1" /> 
	</form> 
		<span class="backlink"style="font-weight:bold;font-size:1.2em;"><?php _e("or better: put this link", $this -> plugin_name) ?> <a href='http://internetdienste-berlin.de'>http://internetdienste-berlin.de</a><?php _e(' anywhere on your site', $this -> plugin_name) ?></span>


	</div>
	<form action="<?php echo $this -> url; ?>" name="post" id="post" method="post">
		<div id="poststuff" class="metabox-holder has-right-sidebar">			
			<div id="side-info-column" class="inner-sidebar">
<?php 
$this -> plugin_name='site-slideshow';/*warum ich das hier setzen muss weiß ich, hätte eigentlich im globalen $this vorhanden sein müssen*/
?>

	<div id="minor-publishing">
		<div id="misc-publishing-actions">
			<div class="misc-pub-section misc-pub-section-last">
				<a href="<?php echo $this -> url; ?>&amp;method=reset" title="<?php _e('Reset all configuration settings to their default values', $this -> plugin_name); ?>" onclick="if (!confirm('<?php _e('Are you sure you wish to reset all configuration settings?', $this -> plugin_name); ?>')) { return false; }"><?php _e('Reset to Defaults', $this -> plugin_name); ?></a>
			</div>
		</div>
	</div>
	<div id="major-publishing-actions">
		<div id="publishing-action">
			<input class="button-primary" type="submit" name="save" value="<?php _e('Save Configuration', $this -> plugin_name); ?>" />
		</div>
		<br class="clear" />
	</div>
	
</div>

			
				<?php do_action('submitpage_box'); ?>	
				<?php do_meta_boxes($this -> menus['galerie-settings'], 'side', $post); ?>

	
			</div>
			<div id="post-body">
				<div id="post-body-content">
					<?php do_meta_boxes($this -> menus['galerie-settings'], 'normal', $post); ?>
					
				</div>
			<div id="normal-sortables" class="meta-box-sortables">
			<?php $styles = $this -> get_option('styles');

$this -> plugin_name='site-slideshow';/*warum ich das hier setzen muss weiß ich, hätte eigentlich im globalen $this vorhanden sein müssen*/
?>
<div id="autoslide_div" style="display:block;">
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="autospeed"><?php _e('Auto Speed', $this -> plugin_name); ?></label></th>
				<td>
					<input type="text" style="width:45px;" name="autospeed" value="<?php  if ($autospeed = $this -> get_option('autospeed'))echo $autospeed;else echo 2000 ; ?>" id="autospeed" /> <?php _e('speed', $this -> plugin_name); ?>
					<span class="howto"><?php _e('default:2000 (in ms)', $this -> plugin_name); ?><br/><?php _e('lower number for shorter interval between images', $this -> plugin_name); ?></span>
				</td>
			</tr>
		</tbody>
	</table>

</div>
<table class="form-table">
	<tbody>
		<tr>
			<th><label for="fadespeed"><?php _e('Image Fading Speed', $this -> plugin_name); ?></label></th>
			<td>
				<input style="width:45px;" type="text" name="fadespeed" value="<?php if ($fadespeed = $this -> get_option('fadespeed'))echo $fadespeed;else echo 2000 ; ?>" id="fadespeed" />
				<span class="howto"><?php _e('default:2000 recommended:1000-20000 (in ms)', $this -> plugin_name); ?><br/><?php _e('lower number for quicker fading of images', $this -> plugin_name); ?></span>
			</td>
		</tr>

		<tr>
			<th><label for="informationY"><?php _e('Show title of post', $this -> plugin_name); ?></label></th>
			<td>
				<label><input onclick="jQuery('#information_div').show();" <?php echo ($this -> get_option('information') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="information" value="Y" id="informationY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input onclick="jQuery('#information_div').hide();" <?php echo ($this -> get_option('information') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="information" value="N" id="informationN" /> <?php _e('No', $this -> plugin_name); ?></label>
			</td>
		</tr>
	</tbody>
</table>

<table class="form-table">
	<tbody>
		<tr>
			<th><label for="sliding"><?php _e('Choose random modus', $this -> plugin_name); ?></label></th>
			<td>
				<label><input  <?php echo ($this -> get_option('sliding') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="sliding" value="Y" id="slidingY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('sliding') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="sliding" value="N" id="slidingN" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('If you choose NO you see the images always in the same reverse time order ', $this -> plugin_name); ?></span>
		
		</tr>
<tr>
			<th><label for="limit"><?php _e('Number of slides', $this -> plugin_name); ?></label></th>
			<td>
				<input style="width:55px;" type="text" name="limit" value="<?php if ($limit = $this -> get_option('limit'))echo $limit;else echo 1000 ; ?>" id="limit" />
				<span class="howto"><?php _e('default:1000 ', $this -> plugin_name); ?><br/><?php _e('higher number can remind you on forgotten articles. Also you can n,m put in where n is the starting point and m the number of slides shown after starting point', $this -> plugin_name);
										
				?></span>
			</td>
		</tr>

		</tbody>
</table>
<div class="inside">
<?php $styles = $this -> get_option('styles');

$this -> plugin_name='site-slideshow';/*warum ich das hier setzen muss weiß ich, hätte eigentlich im globalen $this vorhanden sein müssen*/
?>

<table class="form-table">
	<tbody>
		<tr>
			<th><label for="styles.resizeimages"><?php _e('Resize Images', $this -> plugin_name); ?></label></th>
			<td>
				<span class="howto"><?php _e('Images are resized proportionally to fit the width of the slideshow area', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="styles.width"><?php _e('Gallery width', $this -> plugin_name); ?></label></th>
			<td>
				<input style="width:65px;" id="styles.width" type="text" name="styles[width]" 
				value="<?php  echo $styles['width']; ?>" /> <?php _e('put in number with px or %', $this -> plugin_name); ?>
				<span class="howto"><?php _e('width of the slideshow gallery, supply here measure of unit px or %', $this -> plugin_name); ?></span>
			</td>
			</tr>
		<tr>		
		<tr>
			<th><label for="styles.height"><?php _e('Gallery Height', $this -> plugin_name); ?></label></th>
			<td>
				<input style="width:45px;" id="styles.height" type="text" name="styles[height]" value="<?php  echo $styles['height']; ?>" /> <?php _e('px', $this -> plugin_name); ?>
				<span class="howto"><?php _e('height of the slideshow gallery', $this -> plugin_name); ?></span>
			</td>
			</tr>
		<tr>
			<th><label for="styles.border"><?php _e('Slideshow Border', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="styles[border]" value="<?php echo $styles['border']; ?>" id="styles.border" style="width:145px;" />
				<span class="howto"><?php _e('perhaps you have to adapt with for seeing the right border, the bottom border cannot be seen if the height of the image is larger than the height of the gallery', $this -> plugin_name); ?></span>

			</td>
		</tr>
		<tr>
			<th><label for="styles.background"><?php _e('Slideshow Background', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="styles[background]" value="<?php echo $styles['background']; ?>" id="styles.background" style="width:85px;" />
				<span class="howto"><?php _e('the best choicer in my opinion is <strong>transparent</strong>', $this -> plugin_name); ?></span>

			</td>
		</tr>
		<tr>
			<th><label for="styles.infobackground"><?php _e('Information Background', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="styles[infobackground]" value="<?php echo $styles['infobackground']; ?>" id="styles.infobackground" style="width:85px;" />
				<span class="howto"><?php _e('the best choicer in my opinion is <strong>transparent</strong><br />
				see also text color', $this -> plugin_name); ?></span>
		
			</td>
		</tr>
		<tr>
			<th><label for="styles.infocolor"><?php _e('Information Text Color', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="styles[infocolor]" value="<?php echo $styles['infocolor']; ?>" id="styles.infocolor" style="width:65px;" />
				<span class="howto"><?php _e('give sufficient contrast to Information Background', $this -> plugin_name); ?></span>
			
			</td>
		</tr>
		<tr>
			<th><label for="styles.infosize"><?php _e('Information Text Size', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="styles[infosize]" value="<?php echo $styles['infosize']; ?>" id="styles.infosize" style="width:65px;" />
				<span class="howto"><?php _e('recommended: 1em <br/ > give number with unit of measurement px,em or %', $this -> plugin_name); ?></span>
		
		</td>
		</tr>
	</tbody>
</table></div>

			</div>
			</div>
			<br class="clear" />
		</div>
	</form>
</div>
