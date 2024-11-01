<?php header("Content-Type: text/css"); ?>

<?php $styles = array(); ?>
<?php foreach ($_GET as $skey => $sval) : ?>
	<?php $styles[$skey] = urldecode($sval); ?>
<?php endforeach; ?>

#siteshow {position:relative;overflow:hidden; margin-left: 0 !important;
 list-style:none !important; color:#fff; width:100%; height:<?php echo ((int) $styles['height'] ); ?>px;background:<?php echo $styles['background']; ?>; padding:2px;  }
#siteshow img{width:<?php echo ( $styles['width'] ); ?>; height:auto;
border-left:<?php echo $styles['border'] ?> !important;
border-bottom:<?php echo $styles['border'] ?> !important;
border-right:<?php echo $styles['border'] ?> !important;}
#siteshow span { display:block; }
.fullsize { position:relative; z-index:1; overflow:hidden; 
	width:<?php echo ((int) $styles['height']); ?>; 
	height:<?php echo ((int) $styles['height']); ?>px;
	}
.fullsize p.info { color:<?php echo $styles['infocolor']; ?>; padding:0; margin:0 !important; 
	width:<?php echo ( $styles['width'] ); ?>;
	font-size:<?php echo $styles['infosize']; ?>; font-weight:bold; 
	border-top:<?php echo $styles['border'] ?> !important;
	border-left:<?php echo $styles['border'] ?> !important;
	border-right:<?php echo $styles['border'] ?> !important;
	}
.linkhover { background:transparent url('../images/link.gif') center center no-repeat !important; text-indent:-9999px; opacity:.4 !important; filter:alpha(opacity=40) !important; }
#spinner { position:relative; top:50%; left:45%; }	
#spinner img {border:none;}
text-decoration:none;
}
