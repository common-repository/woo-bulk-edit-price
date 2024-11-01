<?php 

function WBEP_register_my_custom_menu_page(){
    add_menu_page( 
        __( 'Bulk Edit Price', 'wpep' ),
        'Bulk Edit Price',
        'manage_options',
        'woobep',
        'WBEP_menu_page'
    ); 
}
add_action( 'admin_menu', 'WBEP_register_my_custom_menu_page' );
 
/**
 * Display a custom menu page
 */
function WBEP_menu_page(){
	
	?>
	<script type="text/javascript">
		var ajaxurl = "<?php echo site_url(). '/wp-admin/admin-ajax.php' ?>"; 
	</script>
	<div class="wbep_container">
	<div class="woocatalog_container" id="woocatalog_container">
		<h1><?php _e('Bulk Update Price' , 'wpep') ?></h1>
		<hr>

		<div class="pricing_catalogue">

			<div class="woocatalog_table">
					
				<div class="catalog_header_main woocat_row">
					<div class="woocat_half">
						
						<div class="catalog_header woocat_row">
							<div class="woocat_half"><?php _e('Product') ?></div>
							<div class="woocat_half"><?php _e('Price') ?></div>
						</div>
					</div>
					<div class="woocat_half">
						<div class="catalog_header woocat_row">
							<div class="woocat_half"><?php _e('Product'); ?></div>
							<div class="woocat_half"><?php _e('Price') ?></div>
						</div>
					</div>


				</div>

<?php 
				$ajax_nonce = wp_create_nonce( "wpbep" );


?>

				
				<div class="woocat_row woocat_main_row" data-nonce='<?php echo $ajax_nonce; ?>'>
					<?php 
						$args = array("post_type" => "product" ,
									"orderby"	=> 'menu_order',
									"order"	=> 'ASC',
									"posts_per_page" => -1 ,
									);
						$query = new WP_Query($args);
						while($query->have_posts()) {

							$query->the_post();
							
							$_product = wc_get_product( get_the_ID() );
							$post_id = get_the_ID();
							$regular_price = esc_attr( $_product->get_regular_price() );
							$sale_price = esc_attr( $_product->get_sale_price() );
							//$_product->get_sale_price();
							//$_product->get_price();
							$title = get_the_title();



							echo "<div class='woocat_half ' >
									<div class='woocat_half'>{$title}</div>
									<div class='woocat_half'>
										<label class='wpbep_label'>".__('Regular').": </label> <input type='number' placeholder='Regular Price' class='price_update' data-id='$post_id' value='{$regular_price}'> <br>
										<label class='wpbep_label'>".__("Sale").":</label> <input type='number' placeholder='Sale price' class='price_update_sale' data-id='$post_id' value='{$sale_price}'>
									</div>
									</div>
								";
							
						
						}
					?>
				</div>
			</div>

		</div>
		</div>
		<div class="hidden">
			<a href="" id="hidden_ccat_a"></a>
		</div>
	</div>
	<style type="text/css">
	</style>
	<script type="text/javascript">
	</script>
	</div>
	<?php
}

add_action("wp_ajax_woobulkedit_price" , "ajax_woobulkedit_price");

function ajax_woobulkedit_price() {
	check_ajax_referer('wpbep' , 'nonce');

	if(isset($_POST["price"]) && $_POST["post_id"] ) {

		$price = $_POST["price"];
		$post_id = $_POST["post_id"];
	    
	    if(is_numeric($price) && is_numeric($post_id) ) {

	    	$post_id = sanitize_text_field( $post_id );
	    	$price = sanitize_meta( '_price', $price, "post" );
		    update_post_meta($post_id, '_price', (float)$price);

	    	$price = sanitize_meta( '_regular_price', $price, "post" );
	    	update_post_meta( $post_id, '_regular_price', (float)$price );
	    	echo "OK";
	    }

	}
	exit;
}

add_action("wp_ajax_woobulkedit_sale_price" , "ajax_woobulkedit_price_sale");

function ajax_woobulkedit_price_sale() {
	check_ajax_referer('wpbep' , 'nonce');

	if(isset($_POST["price"]) && $_POST["post_id"] ) {

		$price = $_POST["price"];
		$post_id = $_POST["post_id"];
	    
	    if(is_numeric($price) && is_numeric($post_id)) {

	    	$post_id = sanitize_text_field( $post_id );
		
			$price = sanitize_meta( '_sale_price', $price, "post" );
	    
			update_post_meta( $post_id, '_sale_price', (float)$price );
	    	echo "OK";
	    }

	}
	exit;
}