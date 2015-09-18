<?php


function avada_child_scripts() {
	if ( ! is_admin() && ! in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) {
		$theme_info = wp_get_theme();
		wp_enqueue_style( 'avada-child-stylesheet', get_template_directory_uri() . '/style.css', array(), $theme_info->get( 'Version' ) );
	}
}
add_action('wp_enqueue_scripts', 'avada_child_scripts');


/**
 * Allow .ies files for media upload
 *
*/


function enable_extended_upload ( $mime_types =array() ) {
 
   // The MIME types listed here will be allowed in the media library.
   // You can add as many MIME types as you want.
   $mime_types['ies']  = 'application/ies';
        return $mime_types;
}
 
add_filter('upload_mimes', 'enable_extended_upload');





/**
 * Insert responsive column sidebar above products
 *
*/
add_action('woocommerce_before_main_content', 'woocommerce_sidebar', 40);

function woocommerce_sidebar()
{
	if (is_woocommerce())
	{
		echo do_shortcode( '[responsive_column_widgets]' );
	}
}



/**
 * Add custom fields to product variations
 *
*/

// http://wordpress.stackexchange.com/questions/180590/save-custom-fields-for-variations-product

//add_action( 'woocommerce_after_add_to_cart_form', 'variable_display', 8, 0 );

//Display Fields
add_action( 'woocommerce_product_after_variable_attributes', 'variable_fields', 12,3 );
//add_action( 'woocommerce_variation_options', 'variable_fields', 12, 3 );
//JS to add fields for new variations
add_action( 'woocommerce_product_after_variable_attributes_js', 'variable_fields_js' );
//Save variation fields
//add_action( 'woocommerce_process_product_meta_variable', 'save_variable_fields', 12, 1 );
add_action( 'woocommerce_save_product_variation', 'save_variable_fields', 12, 1 );
/**
 * Create new fields for variations
 *
*/
function variable_fields( $loop, $variation_data , $variation ) {
?>
	<tr>
		<td>
		</br>
			<?php

			/*
			echo "</br>";  
			var_dump($variation_data); 
			echo "</br>";
			var_dump($variation); 
			echo "</br>";
			*/
			
			//$_pg_field = $variation_data['_pg_field'][0]
			$variation_id = $variation->ID;
			$_pg_field  = get_post_meta( $variation_id , '_pg_field', true );
			
			//var_dump($_pg_field); 
			//echo "</br>"."_pg_field : ". $_pg_field ."</br>";

			woocommerce_wp_text_input( 
				array( 
					'id'          => '_pg_field['.$loop.']', 
					'label'       => __( 'Product Generator Data', 'woocommerce' ), 
					'placeholder' => 'angle="33" lux="100" luxD="100" minD="100" maxD="500"',
					'desc_tip'    => 'true',
					'description' => __( 'Enter the Product Generator Data here.', 'woocommerce' ),
					'value'       => $_pg_field 
				)
			);
				
			?>
		</td>
	</tr>
    
    <?php
}


/**
 * Create new fields for new variations
 *
*/
function variable_fields_js() {
?>
	<tr>
		<td>
		</br>
			<?php
			
			$variation_id = $variation->ID;
			$_pg_field  = get_post_meta( $variation_id , '_pg_field', true );
	
			woocommerce_wp_text_input( 
				array( 
					'id'          => '_pg_field[ + loop + ]', 
					'label'       => __( 'Product Generator Data', 'woocommerce' ), 
					'placeholder' => 'angle="33" lux="100" luxD="100" minD="100" maxD="500"',
					'desc_tip'    => 'true',
					'description' => __( 'Enter the Product Generator Data here.', 'woocommerce' ),
					'value'       => $_pg_field 
				)
			);
			
			?>
		</td>
	</tr>
   <?php
}

/**
 * Save new fields for variations
 *
*/
function save_variable_fields( $post_id ) {

	if (isset( $_POST['variable_sku'] ) ) :

		$variable_sku          = $_POST['variable_sku'];
		$variable_post_id      = $_POST['variable_post_id'];
	
		$_pg_field = $_POST['_pg_field'];
		for ( $i = 0; $i < sizeof( $variable_sku ); $i++ ) :
			$variation_id = (int) $variable_post_id[$i];
			if ( isset( $_pg_field[$i] ) ) {
				update_post_meta( $variation_id, '_pg_field', stripslashes( $_pg_field[$i] ) );
				//update_post_meta( $variation_id, '_pg_field', 'test' );
			}
		endfor;
		
	endif;
}