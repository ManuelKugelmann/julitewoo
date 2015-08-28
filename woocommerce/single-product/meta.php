<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );

?>
<div class="product_meta">

	<script>
	//jQuery(window).load(function(){
	  
		// get the specific select element by id #model
		jQuery('input.variation_id').change(function() {    
			var var_id =  jQuery( this ).val();
	
			// Hide all custom_variation divs
			jQuery( '.per_variation').css( 'display', 'none' );
			
			// Display only the custom_variation div with the specific id
			jQuery( '.per_variation#variation_' + var_id ).css( 'display', 'block' );
			
			//var sliderObj = jQuery( "#pg_"+var_id+"_slider" );
			//sliderObj.slider('value', pg_value);
			
			var pgObj = jQuery( "#pg_"+var_id+"_pg" );
			pgObj.trigger('update');
		});

	//});
	</script>

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper"><?php _e( 'SKU:', 'woocommerce' ); ?> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'N/A', 'woocommerce' ); ?></span></span>

	<?php endif; ?>
	
	
	<?php 
	$variation_ids = $product->children;
	foreach( $variation_ids as $var_id ) :
		$_pg_field = get_post_meta( $var_id, '_pg_field', true );
		if( ! empty( $_pg_field ) ) :
		?>
		<div class="per_variation" id="variation_<?php echo $var_id; ?>">
			<?php 
				$sc = '[productgenerator id="pg_'.$var_id.'" '.$_pg_field.']';
				echo "<!-- ". $sc ." --!>";
				echo do_shortcode($sc);
			?>
		</div>
		<?php 
		endif;
	endforeach; 
	?>
		
	<br/>
	
	<?php echo $product->get_categories( ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', $cat_count, 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php echo $product->get_tags( ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', $tag_count, 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
