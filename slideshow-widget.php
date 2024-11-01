<?php 

/*  Copyright 2010 Dietrich Koch based on Brad Williams  (email : brad@webdevstudios.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// use widgets_init Action hook to execute custom function
add_action( 'widgets_init', 'ssl_register_widgets' );

 //register our widget
function ssl_register_widgets() {
    register_widget( 'ssl_widget' );
}

//ssl_widget class
class ssl_widget extends WP_Widget {

    //process our new widget
    function ssl_widget() {
        $widget_ops = array('classname' => 'ssl_widget', 'description' => __('widget that display a slideshow from all attachments','ssl-plugin') ); 
        $this->WP_Widget('ssl_widget', __('Siteshow Widget','ssl-plugin'), $widget_ops);
    }
 
     //build our widget settings form
    function form($instance) {
        $defaults = array( 'title' => __('Siteshow','ssl-plugin') ); 
        $instance = wp_parse_args( (array) $instance, $defaults );
        $title = strip_tags($instance['title']);
        $bio = strip_tags($instance['bio']);
        ?>
            <p><?php _e('Title','ssl-plugin') ?>: <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>"  type="text" value="<?php echo esc_attr($title); ?>" /></p>
            <p><?php _e('Description','ssl-plugin') ?>: <textarea class="widefat" name="<?php echo $this->get_field_name('bio'); ?>" / > <?php echo esc_attr($bio); ?></textarea></p>
        <?php
    }
 
    //save our widget settings
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['bio'] = strip_tags($new_instance['bio']);
        return $instance;
    }
 
    //display our widget
    function widget($args, $instance) {
        extract($args);
        echo $before_widget;
        $title = apply_filters('widget_title', $instance['title'] );
        $bio = empty($instance['bio']) ? '&nbsp;' :  $instance['bio']; 
        if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		 if (class_exists('Galerie')) { $Gallery = new Galerie(); $Gallery -> siteshow($output = true, $post_id = null); };
        echo '<p>'. $bio . '</p>';
        echo $after_widget;
    }
}
?>