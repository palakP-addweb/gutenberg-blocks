<?php
/**
 * Plugin Name:       Advanced Gutenberg Block
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            AddWeb Solution
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       addweb-blocks
 *
 * @package           addweb-blocks
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */



// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

define( 'AWAGB_VERSION', '0.1.0' );
define( 'AWAGB_PLUGIN_FILE', __FILE__ );
define( 'AWAGB_PLUGIN_DIR', plugin_dir_path(__FILE__) );
define( 'AWAGB_PLUGIN_URL', plugin_dir_url(__FILE__) );

/**
 * Set default option value
 */
register_activation_hook( AWAGB_PLUGIN_FILE, 'awagb_set_up_options' );
register_deactivation_hook( AWAGB_PLUGIN_FILE, 'awagb_delete_options' );

//add_action( 'plugins_loaded', 'awagb_set_up_options' );

function awagb_set_up_options(){

	$block_types = WP_Block_Type_Registry::get_instance()->get_all_registered();
	$all_blocks = array();
	foreach($block_types as $block) {
		if($block->title == '' )  continue;
		$all_blocks[str_replace("/","_", $block->name)] = 'show';
	}
	$all_blocks['awagb_dynamic-block'] = $all_blocks['awagb_basic-block'] = 'show';

  	add_option('block_options', $all_blocks);
	$block_typo_options = array();
	$block_typo_options['color'] = array(
							'primary' => '#effeff',
							'secondary' => '#effeff',
							'link' => '#effeff',
							'link_hover' => '#effeff',
							'primary_button' => '#effeff',
							'primary_button_hover' => '#effeff',
							'secondary_button' => '#effeff',
							'secondary_button_hover' => '#effeff',

						);

	add_option('block_typo_options', $block_typo_options);
}

function awagb_delete_options(){

	delete_option('block_options');
	delete_option('block_typo_options');

}


/**
 * Register option setting
 */
function awagb_admin_init() {

	register_setting( 'awagb-block-settings-group', 'block_options' );

	register_setting( 'awagb-block-typo-group', 'block_typo_options' );

	//include(AWAGB_PLUGIN_DIR . 'admin/block-show-hide.php');

}
add_action( 'admin_init', 'awagb_admin_init' );

/**
 * Register menu page
 */

 function awagb_add_menu_page()
 {
   add_menu_page('Blocks', 'Blocks', 'manage_options', 'advanced_blocks', 'awagb_show_hide_page', 'dashicons-layout', 2);
   $block_admin_block_script = add_submenu_page("advanced_blocks", "Block Show/Hide", "Block Show/Hide", 'manage_options', "advanced_blocks", "awagb_show_hide_page");
   $block_admin_script =  add_submenu_page("advanced_blocks", "Addweb Blocks", "Addweb Blocks", 'manage_options', "addweb_blocks", "awagb_addweb_blocks_page");
   $block_admin_settings_script = add_submenu_page("advanced_blocks", "Settings", "Settings", 'manage_options', "awagb_settings_page", "awagb_settings_page");

   add_action( 'load-' . $block_admin_block_script, 'awagb_admin_enqueue_scripts' );
   //add_action( 'load-' . $block_admin_script, 'awagb_admin_enqueue_scripts' );
   add_action( 'load-' . $block_admin_settings_script, 'awagb_admin_enqueue_scripts' );


}
add_action( 'admin_menu', 'awagb_add_menu_page' );

/**
 * Add admin script
 */
function awagb_admin_enqueue_scripts()
{


	// wp_enqueue_style( 'awagb-bootstrap-style', AWAGB_PLUGIN_URL  . 'blocks/src/bootstrap/css/bootstrap.min.css', AWAGB_VERSION );
    // wp_enqueue_style( 'awagb-bootstrap-themestyle', AWAGB_PLUGIN_URL  . 'blocks/src/bootstrap/css/bootstrap-theme.min.css' , AWAGB_VERSION);
    // wp_enqueue_script( 'awagb-bootstrap-script', AWAGB_PLUGIN_URL  . 'blocks/src/bootstrap/js/bootstrap.min.js', array(), true, AWAGB_VERSION );

	wp_enqueue_style( 'awagb-admin-styles', AWAGB_PLUGIN_URL . 'blocks/src/bootstrap/css/admin/admin-style.css', array(), AWAGB_VERSION );


	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'awagb-admin-script', AWAGB_PLUGIN_URL . 'blocks/src/bootstrap/js/admin/admin-script.js', array( 'wp-color-picker' ), false, true );

}


/**
 * Menu advanced blocks page callback
 */
function awagb_show_hide_page()
{
	include( AWAGB_PLUGIN_DIR . 'admin/block-page-setup.php' );
}

/**
 * Menu advanced blocks page callback
 */
function awagb_addweb_blocks_page()
{
	//include( AWAGB_PLUGIN_DIR . 'admin/block-page-setup.php' );
}

/**
 * Menu advanced blocks page callback
 */
function awagb_settings_page()
{
	include( AWAGB_PLUGIN_DIR . 'admin/block-settings.php' );
}
/**
 * Get block list
 */
function awagb_get_block_names() {

	$block_types = WP_Block_Type_Registry::get_instance()->get_all_registered();
	$all_blocks = array();
	foreach($block_types as $block) {
		if($block->title == '' )  continue;

		$all_blocks[$block->category][$block->name] = array('title' => $block->title, 'icon' => $block->icon);
	}

	return $all_blocks;

}

/**
 * Get block list
 */
add_action( 'wp_enqueue_scripts', 'awagb_enqueue_script' );

function awagb_enqueue_script() {

	if( ! is_admin() ) {
		wp_enqueue_style( 'dashicons' );
	}
	// enqueue JS
	wp_enqueue_script( 'awagb-separate-accordion', AWAGB_PLUGIN_URL . 'blocks/src/accordion/separate-accordion.js', array('jquery'), AWAGB_VERSION, true );
	wp_enqueue_script( 'awagb-accordion-group', AWAGB_PLUGIN_URL . 'blocks/src/accordion-group/group-accordion.js', array('jquery'), AWAGB_VERSION, true );

}







function awagb_allowed_block_types( $allowed_blocks, $editor_context ) {

	$block_options = get_option('block_options');
	$result = array();

	foreach($block_options as $key => $value){
		$result[] = str_replace("_","/", $key);
 	}
	return $result;

}

function create_advanced_gutenberg_block_init() {

	// Register blocks in the format $dir => $render_callback.
	// Register blocks in the format $dir => $render_callback.
	$blocks = array(
		'dynamic' => array( 'render_callback' => 'wz_tutorial_dynamic_block_recent_posts'),
		'static'  => array(),
		'call-to-action'  => array(),
		'hero-banner' => array(),
		'accordion' => array( 'script' => 'awagb-separate-accordion'),
		'accordion-item' => array( ),
		'accordion-group' => array( 'script' => 'awagb-accordion-group'),
	);


	foreach ( $blocks as $dir => $args ) {

		register_block_type( __DIR__ . '/blocks/build/' . $dir, $args );

	}

	add_filter( 'allowed_block_types_all', 'awagb_allowed_block_types', 25, 2 );


}
add_action( 'init', 'create_advanced_gutenberg_block_init' );

function awagb_categories( $categories, $post  ) {

	array_unshift( $categories, array(
		'slug'	=> 'addweb-blocks',
		'title' => 'Addweb Blocks'
	) );

    return $categories;
}
add_action( 'block_categories_all', 'awagb_categories', 10, 2 );


/**
 * Renders the dynamic block on server.
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
function wz_tutorial_dynamic_block_recent_posts( $attributes ) {

	$args = array(
		'posts_per_page'      => $attributes['postsToShow'],
		'post_status'         => 'publish',
		'order'               => $attributes['order'],
		'orderby'             => $attributes['orderBy'],
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);

	$query        = new WP_Query();
	$latest_posts = $query->query( $args );

	$li_html = '';

	foreach ( $latest_posts as $post ) {
		$post_link = esc_url( get_permalink( $post ) );
		$title     = get_the_title( $post );

		if ( ! $title ) {
			$title = __( '(no title)', 'multiple-blocks' );
		}

		$li_html .= '<li>';

		$li_html .= sprintf(
			'<a class="multiple-blocks-recent-posts__post-title" href="%1$s">%2$s</a>',
			esc_url( $post_link ),
			$title
		);

		$li_html .= '</li>';

	}

	$classes = array( 'multiple-blocks-recent-posts' );

	$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) );

	$heading = $attributes['showHeading'] ? '<h3>' . $attributes['heading'] . '</h3>' : '';

	return sprintf(
		'<div %2$s>%1$s<ul>%3$s</ul></div>',
		$heading,
		$wrapper_attributes,
		$li_html
	);
}




function awagb_gutenberg_default_colors()
{

	$block_typo_options = get_option('block_typo_options');
    $colors = $block_typo_options['color'];
	$theme_colors = array();
	foreach($colors as $name => $color){
		$theme_colors[] = array(
			'name' => esc_html__( ucwords(str_replace('_',' ', $name)), 'addweb-blocks' ),
			'slug' => esc_html__(strtolower($name), 'addweb-blocks' ),
			'color' => $color
		);
	}

    add_theme_support(
        'editor-color-palette', $theme_colors
    );

    add_theme_support(
        'editor-font-sizes',
        array(
            array(
				'name'      => esc_html__( 'Extra small', 'addweb-blocks' ),
				'shortName' => esc_html_x( 'XS', 'Font size', 'addweb-blocks' ),
				'size'      => 16,
				'slug'      => 'extra-small',
			),
			array(
				'name'      => esc_html__( 'Small', 'addweb-blocks' ),
				'shortName' => esc_html_x( 'S', 'Font size', 'addweb-blocks' ),
				'size'      => 18,
				'slug'      => 'small',
			),
			array(
				'name'      => esc_html__( 'Normal', 'addweb-blocks' ),
				'shortName' => esc_html_x( 'M', 'Font size', 'addweb-blocks' ),
				'size'      => 20,
				'slug'      => 'normal',
			),
			array(
				'name'      => esc_html__( 'Large', 'addweb-blocks' ),
				'shortName' => esc_html_x( 'L', 'Font size', 'addweb-blocks' ),
				'size'      => 24,
				'slug'      => 'large',
			),
			array(
				'name'      => esc_html__( 'Extra large', 'addweb-blocks' ),
				'shortName' => esc_html_x( 'XL', 'Font size', 'addweb-blocks' ),
				'size'      => 40,
				'slug'      => 'extra-large',
			),
			array(
				'name'      => esc_html__( 'Huge', 'addweb-blocks' ),
				'shortName' => esc_html_x( 'XXL', 'Font size', 'addweb-blocks' ),
				'size'      => 96,
				'slug'      => 'huge',
			),
			array(
				'name'      => esc_html__( 'Gigantic', 'addweb-blocks' ),
				'shortName' => esc_html_x( 'XXXL', 'Font size', 'addweb-blocks' ),
				'size'      => 144,
				'slug'      => 'gigantic',
			),
        )
    );

}
add_action( 'init', 'awagb_gutenberg_default_colors',10,2 );

