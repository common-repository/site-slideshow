<?php
global $wpdb;
/*Man hätte auch statt save_post die hooks add_attachment, edit_attachment, delete_attachment nehmen können, aber letzteres scheint nicht
einwandfrei zu arbeiten, deshalb habe ich mich für save_post entschieden.*/

global $runflag;
/*$runflag=0;*/

/*Ganz gewiss ist diese brutale Umsetzung eines sql-Programms in ein php-Programms nicht vom feinsten und mit vielen
unnötigen Aktionen belastet, aber wenn ich mal schlauer sein sollte, mach ich es auch schlauer, hoff ich*/
add_action ('save_post','dk_slideshow_update');
/*add_action ('plugins_loaded','dk_slideshow_update');*/
function dk_slideshow_update(){
global $wpdb;
$prefix = $wpdb -> prefix;
global $runflag; /*der Hook 'save_post' verursacht einen zweimaligen Durchlauf, durch diesen Flag wird das verhindert*/
/*if ($runflag==1)return;*/

$limit =get_option('Galerielimit') ;
$wpdb->query($wpdb->prepare("DROP TABLE if EXISTS $prefix" . "site_slides"));
$wpdb->query($wpdb->prepare("CREATE TABLE IF NOT EXISTS $prefix" . "site_slides (
  `uselink` varchar(10) character set utf8 default 'Y',
	 `description` varchar(500) character set utf8 default NULL,
	 `image_url` varchar(300) character set utf8 default '',	
	 `order` int(1)
) 
SELECT DISTINCT `ID`, `post_title` ,`post_name`, `guid`  ,`post_date`  ,`post_modified`  ,
`post_status`  ,`post_type`
FROM $prefix" . "posts   WHERE (post_type='post' or post_type ='page')AND
			'publish'=  post_status "));

$wpdb->query($wpdb->prepare("ALTER TABLE  $prefix" . "site_slides 
 CHANGE `post_title` `title` VARCHAR( 149 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
CHANGE `post_name` `image` VARCHAR( 53 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
CHANGE `guid` `link` VARCHAR( 300 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
CHANGE `post_date` `created` VARCHAR( 300 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
CHANGE `post_modified` `modified` VARCHAR( 300 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
")); 

$wpdb->query($wpdb->prepare("ALTER TABLE $prefix" . "site_slides 
DROP `post_status` ,
DROP `post_type`"));

$wpdb->query($wpdb->prepare("ALTER TABLE $prefix" . "site_slides ADD  PRIMARY KEY (`ID`)")); 
global $wpdb;
$query ="SELECT * FROM $prefix" . "site_slides";
$result = mysql_query ($query);
echo mysql_error();
$rows = mysql_num_rows($result);
for($j = 0; $j< $rows; ++$j){
$ngg=-1;
$src=-1;
$id =mysql_result($result,$j,'ID');
$images = get_children($id,'ARRAY_A');
$row=get_post($id,'ARRAY_A');
$content=$row['post_content'];
$src=stripos($content,'src=',stripos($content,'<img'));
if (class_exists('nggLoader'))$ngg=stripos($content,'[nggallery');
if (!empty($images)) {
	foreach ( $images as $attachment_id => $attachment ) {$order=$attachment['menu_order'];
	if(	wp_get_attachment_url( $attachment_id ) && $order<=1){ 
	$imgarray=wp_get_attachment_image_src( $attachment_id ,'medium');
	$image_url=$imgarray[0]; 
	break;
	}
	}
	$query ="UPDATE $prefix" . "site_slides SET image_url='" . $image_url ."' WHERE ID=$id";
	$wpdb->query($wpdb->prepare($query));
		$image_url='';
	}
elseif ($src>-1) {
	if (stripos ($content,'.jpg',$src +5)){$ende=stripos($content,'.jpg',$src+5);
	$leng=$ende+1 - $src;
	$image_url=substr($content,$src+4,$leng);
	$query ="UPDATE $prefix" . "site_slides SET image_url=$image_url WHERE ID=$id";
	$wpdb->query($wpdb->prepare($query));
		$image_url='';}
}
elseif ($ngg>-1){
	$ende = stripos($content,']',$ngg); if (($ende-$ngg <18)){
	$galida=stripos($content,'=',$ngg)+1;
	$galide=stripos($content,']',$galida);
	$galid = substr($content,$galida, $galide-$galida);
	$query ="SELECT filename,path FROM `$prefix" . "ngg_pictures`,$prefix" . "ngg_gallery  WHERE galleryid=$galid AND gid=$galid LIMIT 1";
	$filename = mysql_query($query);
	$filename=mysql_fetch_row($filename);
	$path=$filename[1];
	if(!empty($path)){$image_url = get_bloginfo('url') ."/$path/$filename[0]";
	$query ="UPDATE $prefix" . "site_slides SET image_url='" .$image_url ."' WHERE ID=$id";
					}
	$wpdb->query($wpdb->prepare($query));
		$image_url='';	
																}
				}
		}

$wpdb->query($wpdb->prepare("DELETE FROM $prefix" . "site_slides WHERE image_url=''"));
$wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS hilfstabellexyz"));
$wpdb->query($wpdb->prepare("CREATE TABLE  hilfstabellexyz SELECT * FROM $prefix" . "site_slides LIMIT $limit"));
$wpdb->query($wpdb->prepare("DROP TABLE $prefix" . "site_slides"));
$wpdb->query($wpdb->prepare("RENAME TABLE hilfstabellexyz TO $prefix" . "site_slides"));

	}



?>