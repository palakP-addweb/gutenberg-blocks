<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

?>

<div class='wrap options-media-php'>
    <h2><?php _e( 'Theme Typography', 'addweb-blocks' ); ?></h2>
    <form method='post' action='options.php'>
        <?php

// $block_types = WP_Block_Type_Registry::get_instance()->get_all_registered();
// echo '<pre>';
// print_r($block_types);
// echo '</pre>';

submit_button();


        settings_fields( 'awagb-block-typo-group' );
        do_settings_sections( 'awagb-block-typo-group' );

        $block_typo_options = get_option('block_typo_options');
        $color = $block_typo_options['color'];

        $tag_typo = $block_typo_options['tag_typo'];
        //print_r($tag_typo);
        //echo count($tag_typo); ?>

        <h2 class="title">Theme Color</h2>
        <table class="form-table">
            <tr valign="top">
                <th scope="row" valign="top">Primary Color</th>
                <td valign="top" style="vertical-align: top;" >
                    <input name="block_typo_options[color][primary]" type="text" value="<?php echo $color['primary'];?>" class="awagb-primary-color" data-default-color="#effeff" />
                </td>

                <th scope="row" valign="top">Secondary Color</th>
                <td valign="top" style="vertical-align: top;" >
                    <input name="block_typo_options[color][secondary]" type="text" value="<?php echo $color['secondary'];?>" class="awagb-secondary-color" data-default-color="#effe00" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row" valign="top">Link Color</th>
                <td valign="top" style="vertical-align: top;">
                    <input name="block_typo_options[color][link]" type="text" value="<?php echo $color['link'];?>" class="awagb-link-color" data-default-color="#effeff" />
                </td>

                <th scope="row" valign="top">Link Hover Color</th>
                <td valign="top" style="vertical-align: top;">
                <input name="block_typo_options[color][link_hover]" type="text" value="<?php echo $color['link_hover'];?>" class="awagb-link-hover-color" data-default-color="#effe00" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row" valign="top">Primary Button Color</th>
                <td valign="top" style="vertical-align: top;" >
                    <input name="block_typo_options[color][primary_button]" type="text" value="<?php echo $color['primary_button'];?>" class="awagb-primary-button-color" data-default-color="#effeff" />
                </td>

                <th scope="row" valign="top">Primary Button Hover Color</th>
                <td valign="top"style="vertical-align: top;" >
                    <input name="block_typo_options[color][primary_button_hover]" type="text" value="<?php echo $color['primary_button_hover'];?>" class="awagb-primary-button-hover-color" data-default-color="#effeff" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row" valign="top">Secondary Button Color</th>
                <td valign="top" style="vertical-align: top;" >
                    <input name="block_typo_options[color][secondary_button]" type="text" value="<?php echo $color['secondary_button'];?>" class="awagb-secondary-button-color" data-default-color="#effeff" />
                </td>

                <th scope="row" valign="top">Secondary Button Hover Color</th>
                <td valign="top"style="vertical-align: top;" >
                    <input name="block_typo_options[color][secondary_button_hover]" type="text" value="<?php echo $color['secondary_button_hover'];?>" class="awagb-secondary-button-hover-color" data-default-color="#effeff" />
                </td>
            </tr>
        </table>

        <h2 class="title">Theam Color</h2>


        <table id="repeatable-fieldset-one" class="form-table">
            <tbody>
                <?php
                if ( $tag_typo['tag'] ) :
                    $i = 0;
                    foreach ( $tag_typo['tag'] as $field ) { if($field == '') { $i++; continue;}?>

                    <tr valign="top">
                        <td valign="top" style="vertical-align: top;" >
                            <fieldset>
                                <legend class="screen-reader-text"><span>Thumbnail size</span></legend>
                                <label for="thumbnail_size_w">Select Tag</label>
                                <select name="block_typo_options[tag_typo][tag][]" id="default_role">
                                    <option value="">Select Tag</option>
                                    <option <?=$tag_typo['tag'][$i] == 'h1' ? ' selected="selected"' : '';?> value="h1">H1</option>
                                    <option <?=$tag_typo['tag'][$i] == 'h2' ? ' selected="selected"' : '';?> value="h2">H2</option>
                                    <option <?=$tag_typo['tag'][$i] == 'h3' ? ' selected="selected"' : '';?> value="h3">H3</option>
                                    <option <?=$tag_typo['tag'][$i] == 'h4' ? ' selected="selected"' : '';?> value="h4">H4</option>
                                    <option <?=$tag_typo['tag'][$i] == 'h5' ? ' selected="selected"' : '';?> value="h5">H5</option>
                                    <option <?=$tag_typo['tag'][$i] == 'h6' ? ' selected="selected"' : '';?> value="h6">H6</option>
                                    <option <?=$tag_typo['tag'][$i] == 'p' ? ' selected="selected"' : '';?> value="p">P</option>
                                </select>
                            </fieldset>
                        </td>
                        <td valign="top" style="vertical-align: top;" >
                            <fieldset>
                                <legend class="screen-reader-text"><span>Font size</span></legend>
                                <label for="thumbnail_size_w">Font size</label>
                                <input name="block_typo_options[tag_typo][size][]" type="number" step="1" min="0" value="<?=$tag_typo['size'][$i];?>" class="small-text" />
                            </fieldset>
                        </td>
                        <td valign="top" style="vertical-align: top;" >
                            <fieldset>
                                <legend class="screen-reader-text"><span>Font Weight</span></legend>
                                <label for="thumbnail_size_w">Font Weight</label>
                                <select name="block_typo_options[tag_typo][weight][]" id="default_role">
                                    <option <?=$tag_typo['tag'][$i] == 'normal' ? ' selected="selected"' : '';?> value="normal">normal</option>
                                    <option <?=$tag_typo['tag'][$i] == 'bold' ? ' selected="selected"' : '';?> value="bold">bold</option>
                                    <option <?=$tag_typo['tag'][$i] == 'lighter' ? ' selected="selected"' : '';?> value="lighter">lighter</option>
                                    <option <?=$tag_typo['tag'][$i] == 'bolder' ? ' selected="selected"' : '';?> value="bolder">bolder</option>
                                    <option <?=$tag_typo['tag'][$i] == '100' ? ' selected="selected"' : '';?> value="100">100</option>
                                    <option <?=$tag_typo['tag'][$i] == '200' ? ' selected="selected"' : '';?> value="200">200</option>
                                    <option <?=$tag_typo['tag'][$i] == '300' ? ' selected="selected"' : '';?> value="300">300</option>
                                    <option <?=$tag_typo['tag'][$i] == '400' ? ' selected="selected"' : '';?> value="400">400 - normal</option>
                                    <option <?=$tag_typo['tag'][$i] == '500' ? ' selected="selected"' : '';?> value="500">500</option>
                                    <option <?=$tag_typo['tag'][$i] == '600' ? ' selected="selected"' : '';?> value="600">600</option>
                                    <option <?=$tag_typo['tag'][$i] == '700' ? ' selected="selected"' : '';?> value="700">700 - Bold</option>
                                    <option <?=$tag_typo['tag'][$i] == '800' ? ' selected="selected"' : '';?> value="800">800</option>
                                    <option <?=$tag_typo['tag'][$i] == '900' ? ' selected="selected"' : '';?> value="900">900</option>
                                    <option <?=$tag_typo['tag'][$i] == 'inherit' ? ' selected="selected"' : '';?> value="inherit">inherit</option>
                                    <option <?=$tag_typo['tag'][$i] == 'initial' ? ' selected="selected"' : '';?> value="initial">initial</option>
                                    <option <?=$tag_typo['tag'][$i] == 'revert' ? ' selected="selected"' : '';?> value="revert">revert</option>
                                    <option <?=$tag_typo['tag'][$i] == 'revert-layer' ? ' selected="selected"' : '';?> value="revert-layer">revert-layer</option>
                                    <option <?=$tag_typo['tag'][$i] == 'unset' ? ' selected="selected"' : '';?> value="unset">unset</option>
                                </select>
                            </fieldset>
                        </td>
                        <td valign="top" style="vertical-align: top;" >
                            <fieldset>
                                <legend class="screen-reader-text"><span>Font Color</span></legend>
                                <label for="thumbnail_size_w">Font Color</label>
                                <input name="block_typo_options[tag_typo][color][]" type="text" value="<?=$tag_typo['color'][$i];?>" class="awagb-secondary-color" data-default-color="#effe00" />
                            </fieldset>
                        </td>
                        <td valign="top" style="vertical-align: top;" ><a class="button remove-row" href="#">Remove</a></td>
                    </tr>

                    <?php $i++; }
                else :
                // show a blank one
                ?>
                    <tr valign="top">
                        <td valign="top" style="vertical-align: top;" >
                            <fieldset>
                                <legend class="screen-reader-text"><span>Thumbnail size</span></legend>
                                <label for="thumbnail_size_w">Select Tag</label>
                                <select name="block_typo_options[tag_typo][tag][]" id="default_role">
                                    <option selected="selected" value="">Select Tag</option>
                                    <option value="h1">H1</option>
                                    <option value="h2">H2</option>
                                    <option value="h3">H3</option>
                                    <option value="h4">H4</option>
                                    <option value="h5">H5</option>
                                    <option value="h6">H6</option>
                                    <option value="p">P</option>
                                </select>
                            </fieldset>
                        </td>
                        <td valign="top" style="vertical-align: top;" >
                            <fieldset>
                                <legend class="screen-reader-text"><span>Font size</span></legend>
                                <label for="thumbnail_size_w">Font size</label>
                                <input name="block_typo_options[tag_typo][size][]" type="number" step="1" min="0" value="18" class="small-text" />
                            </fieldset>
                        </td>
                        <td valign="top" style="vertical-align: top;" >
                            <fieldset>
                                <legend class="screen-reader-text"><span>Font Weight</span></legend>
                                <label for="thumbnail_size_w">Font Weight</label>
                                <select name="block_typo_options[tag_typo][weight][]" id="default_role">
                                    <option selected="selected" value="normal">normal</option>
                                    <option value="bold">bold</option>
                                    <option value="lighter">lighter</option>
                                    <option value="bolder">bolder</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="300">300</option>
                                    <option value="400">400 - normal</option>
                                    <option value="500">500</option>
                                    <option value="600">600</option>
                                    <option value="700">700 - Bold</option>
                                    <option value="800">800</option>
                                    <option value="900">900</option>
                                    <option value="inherit">inherit</option>
                                    <option value="initial">initial</option>
                                    <option value="revert">revert</option>
                                    <option value="revert-layer">revert-layer</option>
                                    <option value="unset">unset</option>
                                </select>
                            </fieldset>
                        </td>
                        <td valign="top" style="vertical-align: top;" >
                            <fieldset>
                                <legend class="screen-reader-text"><span>Font Color</span></legend>
                                <label for="thumbnail_size_w">Font Color</label>
                                <input name="block_typo_options[tag_typo][color][]" type="text" value="<?php echo $color['secondary'];?>" class="awagb-secondary-color" data-default-color="#effe00" />
                            </fieldset>
                        </td>
                        <td valign="top" style="vertical-align: top;" ><a class="button  cmb-remove-row-button button-disabled" href="#">Remove</a></td>
                    </tr>

                <?php endif; ?>

                    <!-- empty hidden one for jQuery -->
                    <tr class="empty-row screen-reader-text" valign="top">
                        <td valign="top" style="vertical-align: top;" >
                            <fieldset>
                                <legend class="screen-reader-text"><span>Thumbnail size</span></legend>
                                <label for="thumbnail_size_w">Select Tag</label>
                                <select name="block_typo_options[tag_typo][tag][]" id="default_role">
                                    <option selected="selected" value="">Select Tag</option>
                                    <option value="h1">H1</option>
                                    <option value="h2">H2</option>
                                    <option value="h3">H3</option>
                                    <option value="h4">H4</option>
                                    <option value="h5">H5</option>
                                    <option value="h6">H6</option>
                                    <option value="p">P</option>
                                </select>
                            </fieldset>
                        </td>
                        <td valign="top" style="vertical-align: top;" >
                            <fieldset>
                                <legend class="screen-reader-text"><span>Font size</span></legend>
                                <label for="thumbnail_size_w">Font size</label>
                                <input name="block_typo_options[tag_typo][size][]" type="number" step="1" min="0" value="18" class="small-text" />
                            </fieldset>
                        </td>
                        <td valign="top" style="vertical-align: top;" >
                            <fieldset>
                                <legend class="screen-reader-text"><span>Font Weight</span></legend>
                                <label for="thumbnail_size_w">Font Weight</label>
                                <select name="block_typo_options[tag_typo][weight][]" id="default_role">
                                    <option selected="selected" value="normal">normal</option>
                                    <option value="bold">bold</option>
                                    <option value="lighter">lighter</option>
                                    <option value="bolder">bolder</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="300">300</option>
                                    <option value="400">400 - normal</option>
                                    <option value="500">500</option>
                                    <option value="600">600</option>
                                    <option value="700">700 - Bold</option>
                                    <option value="800">800</option>
                                    <option value="900">900</option>
                                    <option value="inherit">inherit</option>
                                    <option value="initial">initial</option>
                                    <option value="revert">revert</option>
                                    <option value="revert-layer">revert-layer</option>
                                    <option value="unset">unset</option>
                                </select>
                            </fieldset>
                        </td>
                        <td valign="top" style="vertical-align: top;" >
                            <fieldset>
                                <legend class="screen-reader-text"><span>Font Color</span></legend>
                                <label for="thumbnail_size_w">Font Color</label>
                                <input name="block_typo_options[tag_typo][color][]" type="text" value="<?php echo $color['secondary'];?>" class="awagb-secondary-color" data-default-color="#effe00" />
                            </fieldset>
                        </td>
                        <td valign="top" style="vertical-align: top;" ><a class="button remove-row" href="#">Remove</a></td>
                    </tr>
                </tbody>
            </table>
<p><a id="add-row" class="button" href="#1">Add Tag</a></p>





<script type="text/javascript">
    jQuery(document).ready(function( $ ){
        $( '#add-row' ).on('click', function() {
            var row = $( '.empty-row.screen-reader-text' ).clone(true);
            row.removeClass( 'empty-row screen-reader-text' );
            row.insertBefore( '#repeatable-fieldset-one tbody>tr:last' );
            return false;
        });

        $( '.remove-row' ).on('click', function() {
            $(this).parents('tr').remove();
            return false;
        });
    });
  </script>

        <?php submit_button(); ?>

    </form>
</div>
