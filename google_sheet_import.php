<?php
// Include necessary files
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}
require_once 'wp-load.php';
require_once __DIR__ . '/vendor/autoload.php';

set_time_limit(1200); // Set the limit to 1200 seconds (20 minutes)

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

// Set up Google Sheet URL
$spreadsheetUrl = 'https://docs.google.com/spreadsheets/d/1c5Lkopp_mZfeK3Zo-tUUF8cInB5QdoPaZaXJnOliuw8/export?format=csv';


// Set temporary file path for the downloaded Google Sheets file
$tempFilePath = 'barbaracartlandSheet1.csv';
$csvrecords=file_get_contents($spreadsheetUrl);
$no_blanks = str_replace("\r\n\r\n", "\r\n", $csvrecords);
// Download the Google Sheets file
file_put_contents($tempFilePath, $no_blanks);

// Load the downloaded Google Sheets file into PhpSpreadsheet
$spreadsheet = IOFactory::load($tempFilePath);
$sheet = $spreadsheet->getSheet(0);

// Get the highest row and column indices
$highestRow = $sheet->getHighestRow();
echo '<pre class="dhd">';
//print_r($sheet);
$highestColumn = $sheet->getHighestColumn();


$log = ''; // Initialize the log variable

// Retrieve column headers
//$columnHeaders = [];
/*for ($columnIndex = 1; $columnIndex <= Coordinate::columnIndexFromString($highestColumn); $columnIndex++) {
    $cellValue = $sheet->getCellByColumnAndRow($columnIndex, 1)->getValue();
    $columnHeaders[] = $cellValue;
}

// Print column headers
echo "Column Headers:\n";
print_r($columnHeaders);
*/
$columnMapping = array(
    'sku' => 'SKU',
    'regular_price' => 'hanooot price',
    'stock_quantity' => 'Stock',
    'discount' => 'hanooot discount',
	'status' => 'Live Status',
    // Add more column mappings as needed
);

$columnIndices = array(); // Initialize an array to store column indices

// Retrieve column indices based on column titles (headers)
foreach ($columnMapping as $columnName => $columnTitle) {
    $columnIndex = null;
    for ($column = 1; $column <= Coordinate::columnIndexFromString($highestColumn); $column++) {
        $cellValue = $sheet->getCellByColumnAndRow($column, 1)->getValue();
//        print_r($cellValue);
//        exit();
        if ($cellValue === $columnTitle) {
            $columnIndex = $column;
            break;
        }
    }
    if ($columnIndex !== null) {
        $columnIndices[$columnName] = $columnIndex;
    }
}

// Retrieve data from the Google Sheet and insert into WooCommerce
for ($row = 2; $row <= $highestRow; $row++) {
    $sku = $sheet->getCellByColumnAndRow($columnIndices['sku'], $row)->getValue();
    // Check if a product with the SKU already exists
    $action = get_option('synic_products_action');
    print_r($action);
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 1,
        'post_status' => array('publish', 'draft'),
        'meta_query' => array(
            array(
                'key' => '_sku',
                'value' => $sku,
            ),
        ),
    );

    $product_query = new WP_Query($args);

    if ($product_query->have_posts()) {
        $product_query->the_post();
        $product = wc_get_product(get_the_ID());

        if ($action === 'sync_prices') {
            // Update the product's regular and sale prices
            $price_formula = $sheet->getCellByColumnAndRow($columnIndices['regular_price'], $row)->getValue();
            $product->set_regular_price($price_formula);
            $product->set_price($price_formula);
            $product->save();

            $log .= "Prices synced for product '{$product->get_name()}' (SKU: {$sku}). Product ID: {$product->get_id()}\n";
        } elseif ($action === 'update_stock') {
            // Update the product's stock quantity
            $stock = $sheet->getCellByColumnAndRow($columnIndices['stock_quantity'], $row)->getValue();
            echo '<pre>';
            print_r($product->get_name());
            print_r($stock);

            $product->set_stock_quantity($stock);
            $product->save();

            $log .= "Stock updated for product '{$product->get_name()}' (SKU: {$sku}). Product ID: {$product->get_id()}\n";
        } elseif ($action === 'sync_discounts') {
            // Update the product's discount
            $discount_string = $sheet->getCellByColumnAndRow($columnIndices['discount'], $row)->getValue();
            $product->set_sale_price($discount_string);
            $product->save();

            $log .= "Discount synced for product '{$product->get_name()}' (SKU: {$sku}). Product ID: {$product->get_id()}\n";
      	} elseif ($action === 'sync_all') {

            // Update all product data
            $discount_string = $sheet->getCellByColumnAndRow($columnIndices['discount'], $row)->getValue();
            $stock = $sheet->getCellByColumnAndRow($columnIndices['stock_quantity'], $row)->getValue();
            $price_formula = $sheet->getCellByColumnAndRow($columnIndices['regular_price'], $row)->getValue();
            $status_string = $sheet->getCellByColumnAndRow($columnIndices['status'], $row)->getValue();

           echo $stock."<br>";

            $product->set_sale_price($discount_string);
            $product->set_stock_quantity($stock);
            $product->set_regular_price($price_formula);
            $product->set_price($price_formula);
            //$product->save();

            // Update the product's post status
           /* wp_update_post(array(
                'ID' => $product->get_id(),
                'post_status' => $status_string
            ));

            $log .= "Prices, Discounts, Stock, and Status synced for product '{$product->get_name()}' (SKU: {$sku}). Product ID: {$product->get_id()}\n";
*/
}


    } else {
        $log .= "Sorry, the product with SKU '{$sku}' was not found\n";
        // Handle product not found case
    }
}

// Create a log file and write the log
$logFilePath = 'log.txt';
file_put_contents($logFilePath, $log);

// Unlink the temporary CSV file
@unlink($tempFilePath);

/**
 * Uploads an image from the given URL and attaches it to a post.
 *
 * @param string $image_url The URL of the image to upload.
 * @param int $post_id The ID of the post to attach the image to.
 * @return int|WP_Error The ID of the uploaded image or a WP_Error object on failure.
 */
function upload_product_image($image_url, $post_id)
{
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image_url);
    $filename = basename($image_url);
    if (wp_mkdir_p($upload_dir['path'])) {
        $file = $upload_dir['path'] . '/' . $filename;
    } else {
        $file = $upload_dir['basedir'] . '/' . $filename;
    }
    file_put_contents($file, $image_data);
    $wp_filetype = wp_check_filetype($filename, null);
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $attach_id = wp_insert_attachment($attachment, $file, $post_id);
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata($attach_id, $file);
    wp_update_attachment_metadata($attach_id, $attach_data);
    return $attach_id;
}