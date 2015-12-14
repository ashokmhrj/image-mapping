<?php
 
 function image_mapping_add_image(){
	/*add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );*/
	 add_meta_box("image_mapping_block", __("Image Mapping","image-maping"), "image_mapping_callback", 'image_mapper' );
 }
 add_action( 'add_meta_boxes', 'image_mapping_add_image' );
 
 function mapper_js_css_enqueue() {
    global $typenow;
    if( $typenow == 'image_mapper' ) {
        //For general css
        wp_enqueue_style( 'mapper_meta_box_styles', IMAGE_MAP_URL . 'assets/admin/css/meta-style.css' );
        //For image upload
        wp_enqueue_media();

        wp_register_script( 'mapper_canvas-area-draw', IMAGE_MAP_URL . 'assets/admin/js/jquery.canvasAreaDraw.js', array( 'jquery' ) );
        wp_enqueue_script( 'mapper_canvas-area-draw' );
		
        wp_register_script( 'mapper_meta-box-image', IMAGE_MAP_URL . 'assets/admin/js/meta-image.js', array( 'jquery' ) );
        
        wp_localize_script( 'mapper_meta-box-image', 'meta_image',
											            array(
											                'title' => __( 'Choose/Upload', 'image-mapping' ),
											                'button' => __( 'Use this image', 'image-mapping' ),
											            )
											        );
        wp_enqueue_script( 'mapper_meta-box-image' );
    }
}
add_action( 'admin_enqueue_scripts', 'mapper_js_css_enqueue' );


function image_mapping_callback($post){
	// wp_nonce_field( basename( __FILE__ ), 'mapper_nonce' );
	$mapper_image_meta = get_post_meta( $post->ID,'mapper_meta-image',true );
	?>
	<div class="postbox1 ">
		<!-- Image Upload-->
	    <p>
	        <label for="meta-image" class="mapper-row-title"><?php _e( 'File Upload', 'image-mapping' )?>:</label>
	        <input type="text" name="mapper_meta-image" id="mapper_meta-image" value="<?php echo ( $mapper_image_meta!="" )?$mapper_image_meta:''; ?>" />
	        <input type="button" id="mapper-meta-image-button" class="button" value="<?php _e( 'Choose/Upload', 'image-mapping' )?>" />
	    </p>
	    <div id="mapper_image_preview">
	    <?php if( $mapper_image_meta!="" ){ ?>
	    	<!-- <img id="mapper_event" src="<?php echo $mapper_image_meta;?>" /> -->
	    	<!-- <input type="text" id="polygon"> -->
	    	<textarea style="display:none" id="mapper_coords_hidden" disabled class="canvas-area" data-image-url="<?php echo $mapper_image_meta;?>"></textarea>
	    <?php } ?>
	    </div>
	    <?php 
	    $total_coords = get_post_meta( $post->ID, 'mapper_coords_count', true );
	    ?>
	    <div class="image-coords">
	    	<table id="coords" class="form-table major-publishing-actions" data-count="<?php echo (!empty($total_coords))?$total_coords:'0';?>">
	    	
            <!-- changes made by MS -->
	    	<!-- <colgroup>
			    <col width="45%">
			    <col width="30%">
			    <col width="20%">
		  	</colgroup> -->
		  	<thead>
		    	<tr>
		    		<th><b>Coords</b></th>
		    		<th><b>Link</b></th>
		    		<th><b>Title</b></th>
		    	</tr>
	        </thead>
	        <tbody>
	    	<?php
	    		
	    		if(!empty($total_coords)) {
		    		for($i=1;$i<= $total_coords;$i++){ 

		    			$ploy = get_post_meta($post->ID,'mapper_block_coords_'.$i,true);
		    			$link = get_post_meta($post->ID,'mapper_block_link_'.$i,true);
		    			$title = get_post_meta($post->ID,'mapper_block_title_'.$i,true);
    			?>     
			    			<tr id="mapper_count_<?php echo $i?>" >
				    			<td><textarea  rows="1" name="mapper_block_coords_<?php echo $i?>"><?php echo $ploy;?></textarea></td>
				    			<td><input placeholder="http://example.com" type="text" name="mapper_block_link_<?php echo $i?>" value="<?php echo $link;?>" /></td>
				    			<td><input placeholder="title"  type="text" name="mapper_block_title_<?php echo $i?>" value="<?php echo $title;?>" /></td>
			    			</tr>
	    		<?php
	    			}
    		 	} ?>
    		 	</tbody>
	    	</table>
	    	<input type="hidden" name="mapper_coords_count" id="mapper_coords_count" value="<?php echo (!empty($total_coords))?$total_coords:'0';?>" />
        </div>
    </div>
    <?php
	  
}



/**
 * Saves the custom meta input
 */
function mapper_meta_save( $post_id,$post ) {
	// Checks for input and saves if needed (image upload)
	if($post->post_type != "image_mapper") {
		return;
	}
	// remove all meta data by postid
	// deleted_postmeta
	$metas = get_post_meta( $post_id );
	foreach($metas as $meta_key => $meta_value ) {
		delete_post_meta( $post_id, $meta_key, $meta_value );
	}

    if( isset( $_POST[ 'mapper_meta-image' ] ) ) {
        update_post_meta( $post_id, 'mapper_meta-image', $_POST[ 'mapper_meta-image' ] );
        
        // update_post_meta( $post_id, 'mapper_meta-image-poly', $_POST[ 'mapper_meta-image-poly' ] );
        
        $total_coords = $_POST['mapper_coords_count'];
        update_post_meta( $post_id, 'mapper_coords_count', $total_coords);
        for($i = 1;$i <= $total_coords;$i++){   			
	        update_post_meta( $post_id, 'mapper_block_coords_'.$i, $_POST[ 'mapper_block_coords_'.$i ] );
	        update_post_meta( $post_id, 'mapper_block_link_'.$i, $_POST[ 'mapper_block_link_'.$i ] );
	        update_post_meta( $post_id, 'mapper_block_title_'.$i, $_POST[ 'mapper_block_title_'.$i ] );


        }
    }
}
add_action( 'save_post', 'mapper_meta_save',10,2 );