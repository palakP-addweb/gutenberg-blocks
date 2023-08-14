<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;


add_filter( 'allowed_block_types_all', 'awagb_allowed_block_types2', 25, 2 );
 
function awagb_allowed_block_types2( $allowed_blocks, $editor_context ) {


    $block_types = WP_Block_Type_Registry::get_instance()->get_all_registered();
	$all_blocks = array();
	foreach($block_types as $block) {
		if($block->title == '' )  continue;
		$all_blocks[str_replace("/","_", $block->name)] = $block->name;
	}

    $block_options = get_option('block_options');
 
	return (sort(array_diff_key($all_blocks,$block_options)));

 
}