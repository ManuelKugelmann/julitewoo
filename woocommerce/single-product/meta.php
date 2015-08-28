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

global $woocommerce, $product, $post;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );

?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper"><?php _e( 'SKU:', 'woocommerce' ); ?> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'N/A', 'woocommerce' ); ?></span></span>

	<?php endif; ?>
	
	<div class="variations_meta">
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
	<?php 
	if(is_product() and $product->product_type == 'variable') :
		$available_variations = $product->get_available_variations();
		foreach( $available_variations as $variation ) :
			$post_id = $variation['variation_id'];
			$_pg_field = get_post_meta( $post_id, '_pg_field', true );
			echo("<!-- variation_sku: ".$variation['sku']." post_id: ".$post_id." _pg_field: ".$_pg_field."-->");
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
	endif;
	?>
	</div>	
	<br/>
	
	<?php echo $product->get_categories( ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', $cat_count, 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php echo $product->get_tags( ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', $tag_count, 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
