<?php
/**
* Restricting user to access this file directly (Security Purpose).
**/
  if( ! defined( 'ABSPATH' ) ) {
    die( "Sorry You Don't Have Permission To Access This Page"  );
    exit;
  }
  
/********* Plugin Setting Template ********/

if( isset($_GET['settings-updated']) ) { ?>
<div class="updated settings-error notice is-dismissible" id="setting-error-settings_updated"> 
  <p><strong>Settings saved.</strong></p>
  <button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button>
</div><?php } ?>
<div class="pt-wrap" style="max-width: 1000px; width:100%;">
  <div class="fa-plugin-setting">
    <ul>
      <li><a href = "#pt-setting"><?php _e('Settings', ADDWEBPT_TEXT_DOMAIN); ?></a></li>
      <li><a href = "#pt-about">About Us</a></li>
    </ul>
    <div id="pt-setting">
      <h2><?php _e( 'Timer Popup Settings', 'addweb-pt-timer-popup' );?></h2>
      <form method="post" action="options.php">
      <!-- form method="post" action="<?php //echo esc_url( admin_url( 'options-general.php?page='.$_GET['page'].'&header=true' ) ); ?>" enctype="multipart/form-data"> --><?php 
        settings_fields( ADDWEBPT_TEXT_DOMAIN );
        ?><div class="timer_popup_form">
          <table class="form-table" width="100%">
            <tr>
              <th scope="row"></th>
              <td>
                <input type="checkbox" name="<?php echo ADDWEBPT_TEXT_DOMAIN; ?>[addweb_pt_popup_active]" <?php echo ($addweb_pt_option['addweb_pt_popup_active']) ? 'checked="checked"' : ''; ?> id="addweb_pt_popup_active" value="1">&nbsp;<label for="addweb_pt_popup_active"><strong><?php _e( 'Enable', 'addweb-pt-timer-popup' );?></strong></label>
                </td>
            </tr>
            <tr>
              <th scope="row"><label for="addweb_pt_popup_color"><?php _e( 'Popup Color', 'addweb-pt-timer-popup' );?></label></th>
              <td><input type="text" name="<?php echo ADDWEBPT_TEXT_DOMAIN; ?>[addweb_pt_popup_color]" id="popup_color" maxlength="255" size="25" value="<?php echo $addweb_pt_option['addweb_pt_popup_color']; ?>"></td>
            </tr>
            <tr>
              <th scope="row"><label for="addweb_pt_popup_place"><?php _e( 'Popup Place', 'addweb-pt-timer-popup' );?></label></th>
              <td><select name="<?php echo ADDWEBPT_TEXT_DOMAIN; ?>[addweb_pt_popup_place]" id="addweb_pt_popup_place">
              <?php foreach ( $addweb_pt_get_popup_place as $key => $value ): ?>
              <option value="<?php esc_attr_e( $key ); ?>" <?php esc_attr_e( $key == $addweb_pt_option['addweb_pt_popup_place'] ? ' selected="selected"' : '' ); ?>><?php esc_attr_e( $value ); ?></option>
              <?php endforeach;?>
              </select></td>
            </tr>
            <tr>
              <th scope="row"><label for="addweb_pt_popup_top_margin"><?php _e( 'Popup Top Margin', 'addweb-pt-timer-popup' );?></label></th>
              <td><input type="number" name="<?php echo ADDWEBPT_TEXT_DOMAIN; ?>[addweb_pt_popup_top_margin]" id="addweb_pt_popup_top_margin" maxlength="255" size="25" value="<?php echo $addweb_pt_option['addweb_pt_popup_top_margin'];  ?>">%<br>
                <small><?php _e('Top margin is only included if popup place Left or Right is selected. Please enter numeric value.'); ?></small></td>
            </tr>
            <tr><th scope="row" colspan="2"><?php _e('Choose Where To Show Popup'); ?></th></tr><?php  
              foreach ( get_post_types( array(), 'objects' ) as $addweb_pt_post_type ) { 
                $addweb_pt_post_name = $addweb_pt_post_type->name;
                $addweb_pt_post_remove = array('attachment','revision','nav_menu_item','custom_css','customize_changeset','ml-slider','oembed_cache');
                if(in_array($addweb_pt_post_name, $addweb_pt_post_remove)){ echo '';} else{
                  ?><tr>
                    <th scope="row"></th>
                    <td><input type="checkbox" name="<?php echo ADDWEBPT_TEXT_DOMAIN; ?>[addweb_pt_popup_posts][]" id="<?php echo esc_attr( $addweb_pt_post_type->name ); ?>" value="<?php echo esc_attr( $addweb_pt_post_type->name ); ?>" 

                      <?php 
                      if (is_array($addweb_pt_option['addweb_pt_popup_posts'])) {
                        if(in_array($addweb_pt_post_type->name, $addweb_pt_option['addweb_pt_popup_posts']))  echo 'checked="checked"'; else ''; }
                        ?> />
                        <label for="<?php echo esc_attr( $addweb_pt_post_type->name ); ?>"><strong><?php echo esc_html( $addweb_pt_post_type->label ); ?></strong></label>
                    </td>
                  </tr><?php 
                } 
              }
          ?></table>
          <p class="submit">
             <?php submit_button(); ?>
          </p>
        </div>
      </form>
    </div>
    <div id="pt-about">
      <div style="margin:0 auto;width:54%;">
        <a href="http://www.addwebsolution.com" style="outline: hidden;" target="_blank"><img src="<?php echo ADDWEBPT_PLUGIN_URL . '/assets/images/addweb-logo.png';?>" alt="AddwebSolution" height=60px ></a>
      </div><?php
      $arrAddwebPlugins = array(
        'woo-cart-customizer' => 'Simple Customization of Add to Cart Button',
        'widget-social-share' => 'WSS: Widget Social Share',
        //'wp-all-in-one-social' => 'WP All In One Social',
        //'football-match-tracker' => 'Football Match Tracker',
        'aws-cookies-popup' => 'AWS Cookies Popup'
      );?>
      <div class="advertise">
      <div class="ad-heading">Visit Our Other Plugins:</div>
      <div class="ad-content"><?php
        foreach($arrAddwebPlugins as $slug=>$name) {?>
            <div class="ad-detail">
              <a href="https://wordpress.org/plugins/<?php echo $slug;?>" target="_blank"><img src="<?php echo ADDWEBPT_PLUGIN_URL . '/assets/images/'.$slug;?>.svg"></a>
              <a href="https://wordpress.org/plugins/<?php echo $slug;?>" class="ad-link" target="_blank"><?php echo $name;?></a>
            </div><?php
        } ?></div>
      </div>
    </div>
  </div><?php
  $plugin_basename = plugin_basename( plugin_dir_path( __FILE__ ) ); ?>
</div>
