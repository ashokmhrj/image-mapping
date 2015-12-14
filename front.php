<?php

function mapper_scripts_frontend(){
	if(!wp_script_is('jquery')) {    
      wp_enqueue_script( 'jquery' );
  	}

  	if(!wp_script_is('image_mapper_rwd')){
  		wp_register_script('image_mapper_rwd' ,IMAGE_MAP_URL . 'assets/front/js/jquery.rwdImageMaps.js', array( 'jquery' ),'1.5' );
  		wp_enqueue_script('image_mapper_rwd');
  	}
}

add_action('wp_enqueue_scripts','mapper_scripts_frontend');


// creating short code

function image_mapping_shortcode_fn( $atts ) {
	$param = shortcode_atts( array(
		'id' => '',		
	), $atts , 'image-mapping' );

	// get_coords from post_id
	$metas = get_post_meta( $param['id']);
	// get image
	$image = get_post_meta( $param['id'], 'mapper_meta-image', $single = true );
	if(!empty($image)) { ?>
	<img src="<?php echo $image;?>"  usemap="#mapper_image" alt="" />
	<?php
		$total_coords = get_post_meta( $param['id'], 'mapper_coords_count', true );
		if(!empty($total_coords)) { ?>
			<map name="mapper_image">
				<?php for($i=1;$i<= $total_coords;$i++) {
	    			$poly = get_post_meta( $param['id'],'mapper_block_coords_'.$i,true);
	    			$link = get_post_meta( $param['id'],'mapper_block_link_'.$i,true);
	    			$title = get_post_meta( $param['id'],'mapper_block_title_'.$i,true);
				?>
					<area shape="poly" coords="<?php echo $poly?>" href="<?php echo $link?>" title="<?php echo $title;?>" alt="<?php echo $title;?>" />
				<?php } ?>
			</map>
		<?php }

	} else {
		_e( "You have not added image yet.", 'image-mapping' );	
	}	 
}
add_shortcode( 'image-mapping', 'image_mapping_shortcode_fn' );