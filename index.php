<?php
/*
Plugin Name: LoL Free Champion Rotation
Plugin URI: https://alurosu.com/lol-free-champion-rotation-example/
Description: This plugin offers a widget and a shortcode which will show you the weekly free-to-play champions from League of Legends.
Version: 4.0
Author: alurosu
Text Domain: lol-free-champion-rotation
Author URI: https://alurosu.com/
License: GPLv2
*/

class lol_free_champion_rotation extends WP_Widget {

	// constructor
	function lol_free_champion_rotation() {
		parent::WP_Widget(false, $name = __('LoL Free Champion Rotation', 'lol-free-champion-rotation') );
	}
	// widget form creation
	function form($instance) {
		if( $instance) {
			$title = esc_attr($instance['title']);
			$description = esc_attr($instance['description']);
			$width = esc_attr($instance['width']);
			$checkbox = esc_attr($instance['checkbox']);
		} else {
			$title = '';
			$description = '';
			$width = 'auto';
			$checkbox = '1';
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'lol-free-champion-rotation'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description:', 'lol-free-champion-rotation'); ?></label>
		<textarea class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" type="text"><?php echo $description; ?></textarea>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width:', 'lol-free-champion-rotation'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" placeholder="ex. 200, 90% or auto" />
		</p>
		<p>
		<input id="<?php echo esc_attr( $this->get_field_id( 'checkbox' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'checkbox' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $checkbox ); ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'checkbox' ) ); ?>"><?php _e( 'Give credit to Author', 'lol-free-champion-rotation' ); ?></label>
		</p>
	 	<?PHP
	}

	// widget update
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		// Fields
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['description'] = strip_tags($new_instance['description']);
		$instance['width'] = strip_tags($new_instance['width']);
		$instance['checkbox'] = strip_tags($new_instance['checkbox']);
		return $instance;
	}
	// widget display
	function widget($args, $instance) {
		extract( $args );
		// these are the widget options
		$title = apply_filters('widget_title', $instance['title']);
		$description = $instance['description'];
		$width = $instance['width'];
		if (is_numeric($width)) {
			$width .='px';
		}
		if (!$width)
			$width = "auto";
		$checkbox = $instance['checkbox'];
		echo $before_widget;
		// Display the widget
		echo '<div class="widget-text sf-lol-free-champion-rotation" id="sf-lol-box" style="max-width:'.$width.'">';
		// Check if title is set
		if ($title) {
			echo $before_title . $title . $after_title;
		}
		?>
		<?PHP if ($description) { ?>
			<p><?PHP echo $description;?></p>
		<?PHP } ?>
		<div class="sf-lol-champions">Loading..</div>
		<?PHP
		if ($checkbox == '1')
			echo '<div class="sf-author">by <a href="https://alurosu.com/lol-free-champion-rotation-example/" target="_blank" rel="nofollow">alurosu</a></div>';
		echo '</div>';
		echo $after_widget;
	}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("lol_free_champion_rotation");'));

// add stylesheets
function lol_free_champion_rotation_add_stylesheet() {
	wp_enqueue_style( 'prefix-style', plugins_url('data/style.css', __FILE__) );
}
add_action( 'wp_enqueue_scripts', 'lol_free_champion_rotation_add_stylesheet' );

// add scripts
function lol_free_champion_rotation_add_script() {
	wp_enqueue_script( 'prefix-style', plugins_url('data/lol-free-champion-rotation.js', __FILE__), array( 'jquery' ));
}
add_action( 'wp_enqueue_scripts', 'lol_free_champion_rotation_add_script' );

// register the shortcode
function lol_free_champion_rotation_shortcode( $atts = [], $content = null, $tag = '' ) {
    $atts = array_change_key_case( (array) $atts, CASE_LOWER );
    $lol_atts = shortcode_atts(
        array(
            'width' => 'auto',
			'creditauthor' => 1,
        ), $atts, $tag
    );

	if (is_numeric($lol_atts['width']))
		$lol_atts['width'] .= 'px';

	$o = '<div class="widget-text sf-lol-free-champion-rotation" id="sf-lol-box" style="max-width:'.$lol_atts['width'].'">';
	$o .= '<div class="sf-lol-champions">Loading..</div>';
	if ($lol_atts['creditauthor'] == '1')
		$o .= '<div class="sf-author">by <a href="https://alurosu.com/lol-free-champion-rotation-example/" target="_blank" rel="nofollow">alurosu</a></div>';
	$o .= '</div>';

    return $o;
}
function lol_free_champion_rotation_shortcodes_init() {
    add_shortcode( 'lolrotation', 'lol_free_champion_rotation_shortcode' );
}

add_action( 'init', 'lol_free_champion_rotation_shortcodes_init' );
?>
