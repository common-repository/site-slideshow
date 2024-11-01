=== Site Slideshow ===
Contributors: Dietrich Koch
Donate link: http://www.internetdienste-berlin.de/2011/03/site-slideshow-version-2/
Tags: wordpress plugins, wordpress slideshow gallery, slides, slideshow, image gallery, images, gallery, featured content, site gallery, slideshow gallery, standard gallery
Requires at least: 2.9
Tested up to: 3.1
Stable tag: 2.1.1

Slideshow gallery widget presenting one picture for every post containing images with link to the post owning this picture

== Description ==
Site Slideshow looks for pictures in all articles and pages, fetches one of them as representative of the post and gathered it into a slideshow widget. Site Slideshow is highly customizible. Klicking on the slide leads you to the post it stems from.
Site Slideshow version 2 is much more general than version 1. It finds not only images from the standard gallery but also from any image-Tag and from the New Generation Gallery if it is represented by the shortcode [nggallery id=...]. Now you can also use Slideshow Gallery plugin concurrently.
== Installation ==
Installing the WordPress Site Slideshow plugin simply follow the steps below.
<ol>
<li>Load the plugin from wordpress plugin repository </li>
<li>Extract the package to obtain the `site-slideshow` folder</li>
<li>Upload the `site-slideshow` folder to the `/wp-content/plugins/` directory</li>
<li>Activate the plugin through the 'Plugins' menu in WordPress</li>
<li>Configure the settings according to your needs through the 'Slideshow'  menu</li>
<li>Put the Site Slideshow widget into a sidebar of your choice.</li>
</ol>
Or instead of 1 until 3 use wordpress' automatic plugin installation
== Suggestions & Problems ==
If you have suggestions or problems don't hesitate to contact me over my blog http://internetdienste-berlin.de or the plugin forum.
== Frequently Asked Questions ==

= Can I display/embed multiple instances of the slideshow gallery? =

No, it doesn't make any sense.

= How do I force some picture to be repesented in the slideshow =

Sort the picture in your post such that the picture you want to be represented get the number 1

= Can I exclude certain images from a post in the slideshow? =

Yes, you can. Sort the picture and change the number one to any other number

= Which picture will be represented if I don't sort the post gallery. =

The one which is loaded firstly.


== Demo ==
<p>http://internetdienste-berlin.de</p>
<p>http://nord-deutsche-treppen.de</p>
<p>http://hus-halligblick.de</p>
== Screenshots ==

1. Options page

== Changelog ==
<ul><li>
0.9 Stable version but with some minor technical drawbacks  which will be overcome in version 1.</li>
<li>0.9.5 Heavily improved and simplified version. You can much more control, e.g. random sliding, restrict number of slides and some more.</li>
<li>0.9.6 There are now the poossibilities to control width of the slideshow in 2 measures of unit</li>
<li>0.9.7 Bug with width-controlling fixed</li>
<li>0.9.9 Efficiency improved by using medium-sized pictures</li>
<li>1.0.0 German localization with a small gap</li>
<li>1.0.1 Fixing a hole in the arrangement of the slides</li>
<li>1.0.2 Localization bug fixed, donate button placed on the option page, please use it, some small improvements</li>
<li>2.0.0 A big jump to include pictures which are repesented in posts by image-Tags or by the New Generation Gallery shortcode [nggallery id=..]</li>
<li>2.0.1 Fixing a small bug in initialization the slideshow the first time</li>
<li>2.1.0 Improving of code: total capsulation, now you can use the plugins Slideshow Gallery and such which are deviating from it.
A bug with resp to the number of slides are fixed.</li>
</ul>