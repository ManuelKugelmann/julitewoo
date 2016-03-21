<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $woocommerce, $product, $post;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );

?>
<div class="product_meta">

	<script>
	
		function updateVisibility(var_id)
		{
			// Display only the custom_variation div with the specific id
			jQuery( '.per_variation#variation_' + var_id ).css( 'display', 'block' );
			
			//var sliderObj = jQuery( "#pg_"+var_id+"_slider" );
			//sliderObj.slider('value', pg_value);
			
			var pgObj = jQuery( "#pg_"+var_id+"_pg" );
			pgObj.trigger('update');
		}
	
		//jQuery(window).load(function(){
		
			//jQuery('.per_variation').css( 'display', 'none' );
			var var_id = jQuery('input.variation_id').val();
			updateVisibility(var_id);
		  
			// get the specific select element by id #model
			jQuery('input.variation_id').change(function() {    
				// Hide all custom_variation divs
				jQuery('.per_variation').css( 'display', 'none' );
				
				var var_id =  jQuery(this).val();
				updateVisibility(var_id);
			});

		//});
		
	</script>

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper"><?php _e( 'SKU:', 'woocommerce' ); ?> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'N/A', 'woocommerce' ); ?></span></span>

	<?php endif; ?>

	<?php echo $product->get_categories( ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', $cat_count, 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php echo $product->get_tags( ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', $tag_count, 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>