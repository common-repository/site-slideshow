<?php $styles = array(); ?>
<?php foreach ($_GET as $skey => $sval) : ?>
	<?php $styles[$skey] = urldecode($sval); ?>
<?php endforeach; ?>
<?php if (!empty($slides_S)) : ?>
	<ul id="siteshow" style="display:block;">
		
			<?php foreach ($slides_S as $slide) : ?>		
				<li><div class="fullsize" >
						<p class="info"><?php if ($this -> get_option('information') == "Y") { echo $slide -> title; } else ''; ?></p>
						<a href="<?php echo $slide -> link; ?>" title="<?php echo $slide -> title; ?>"><img src="<?php echo $slide -> image_url; ?>" alt="<?php echo $slide -> title; ?>" /></a>							
					</div>
				</li>
			<?php endforeach; ?>
			
	</ul>
	<script type="text/javascript">
	jQuery.noConflict();
	jQuery(document).ready(function($) {$('#siteshow').cycle({ 
	timeout:<?php if ($timeout =  $this -> get_option('autospeed')){ echo $timeout;} else echo 2000; ?>, 
	fx:'fade', 
	random:<?php if ($this -> get_option('sliding')=="Y"){echo 1;}  else echo 0; ?>,
	speed:<?php if ($speed =  $this -> get_option('fadespeed')){ echo $speed;} else echo 2000; ?>,
	
	});

	});

	</script>


<?php endif; ?>