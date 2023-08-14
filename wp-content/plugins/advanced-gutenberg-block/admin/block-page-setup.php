<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) exit; 

?>

<div class='wrap'>
    <h2>Block Show/Hide</h2>
    <form method='post' action='options.php'>
        <?php  

// $block_types = WP_Block_Type_Registry::get_instance()->get_all_registered();
// echo '<pre>';
// print_r($block_types);
// echo '</pre>';

submit_button();
        
        $all_blocks = awagb_get_block_names();
        ksort($all_blocks);
        
        settings_fields( 'awagb-block-settings-group' ); 
        do_settings_sections( 'awagb-block-settings-group' ); 

        $block_options = get_option('block_options');

        //print_r($block_options);
        
        foreach($all_blocks as $type => $blocks){ ?>

            <h2 class="title"><?php echo ucwords(str_replace("-"," ", $type)); ?></h2>
            <table class="form-table">
                <tr valign="top">
                <?php 
                $i = 0;
                foreach($blocks as $slug => $block){ 
                    $option = str_replace("/","_", $slug);
                    $checked = (isset($block_options[$option]) && $block_options[$option] == 'show' ) ? "checked='checked'" : '';

                    echo $i%4 == 0 ? '</tr><tr valign="top">': '' ; $i++;
                    ?>                    
                    <th scope="row"><?php echo ucwords($block['title']); ?></th>
                    <td>
                    <label class="switch">
                    <input type="checkbox" class="awagb-swiper" name="block_options[<?php echo $option;?>]" value="show" <?php echo $checked; ?>>
  <span class="slider round"></span>
</label>    
                    </td>
                    
                <?php } ?>    
                    </tr>
            </table>
            </hr>

        <?php } ?>

        <?php submit_button(); ?>

    </form>
</div>