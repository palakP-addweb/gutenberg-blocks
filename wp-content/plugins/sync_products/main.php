<?php
/*
Plugin Name: Sync Products
Plugin URI: https://your-plugin-uri.com/
Description: Syncs product data and performs based on google sheets.
Version: 1.0.0
Author: Caiantec
Author URI: https://your-author-uri.com/
*/

// Enqueue scripts or stylesheets if needed
// wp_enqueue_script('my-plugin-script', plugins_url('js/my-plugin-script.js', __FILE__), array('jquery'), '1.0.0', true);
// wp_enqueue_style('my-plugin-style', plugins_url('css/my-plugin-style.css', __FILE__));

// Add options page to WordPress admin menu
function synic_products_options_page()
{
    if (isset($_POST['submit'])) {
        // Process and save the selected options
//        include_once dirname( __FILE__ ).'/google_sheet_import.php';
        update_option('synic_products_action', $_POST['action']);
            echo $_POST['action'];
//            exit();
        // Display a success message
        echo '<div class="updated"><p>Options saved.</p></div>';
    }

    // Retrieve the selected option
    $action = get_option('synic_products_action', '');

    // Generate the HTML form
    ?>
    <div class="wrap">
        <h2>Sync Products Settings</h2>
        <form method="post" action="">
            <label for="action">Select Action:</label>
            <select name="action" id="action">
                <option value="sync_prices" <?php selected($action, 'sync_prices'); ?>>Sync Prices</option>
                <option value="update_stock" <?php selected($action, 'update_stock'); ?>>Update Stock</option>
                <option value="sync_discounts" <?php selected($action, 'sync_discounts'); ?>>Sync Discounts</option>
                <option value="sync_all" <?php selected($action, 'sync_all'); ?>>Sync All</option>

              
            </select>
            <br>
            <br>
            <input type="submit" name="submit" class="button-primary" value="Save Changes">
        </form>
    </div>
    <?php
}

// Hook the options page function into the admin_menu action
add_action('admin_menu', 'synic_products_add_options_page');
function synic_products_add_options_page()
{
    add_options_page('Sync Products Settings', 'Sync Products', 'manage_options', 'synic-products-settings', 'synic_products_options_page');
}
