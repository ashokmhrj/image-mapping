<?php
/**
* Registers a new post type
* @uses $wp_post_types Inserts new post type object into the list
*
* @param string  Post type key, must not exceed 20 characters
* @param array|string  See optional args description above.
* @return object|WP_Error the registered post type object, or an error object
*/
function img_map_register_cpt(){
	
	$labels = array(
		'name'                => __( 'Mappers', 'image-mapping' ),
		'singular_name'       => __( 'Mapper', 'image-mapping' ),
		'add_new'             => _x( 'Add New Mapper', 'image-mapping', 'image-mapping' ),
		'add_new_item'        => __( 'Add New Mapper', 'image-mapping' ),
		'edit_item'           => __( 'Edit Mapper', 'image-mapping' ),
		'new_item'            => __( 'New Mapper', 'image-mapping' ),
		'view_item'           => __( 'View Mapper', 'image-mapping' ),
		'search_items'        => __( 'Search Mappers', 'image-mapping' ),
		'not_found'           => __( 'No Mappers found', 'image-mapping' ),
		'not_found_in_trash'  => __( 'No Mappers found in Trash', 'image-mapping' ),
		'parent_item_colon'   => __( 'Parent Mapper:', 'image-mapping' ),
		'menu_name'           => __( 'Mappers', 'image-mapping' ),
	);

	$args = array(
		'labels'              => $labels,
		'hierarchical'        => false,
		'description'         => 'description',
		'taxonomies'          => array(),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => null,
		'menu_icon'           => null,
		'show_in_nav_menus'   => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'has_archive'         => true,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => true,
		'capability_type'     => 'post',
		'supports'            => array(
									'title' 
									)
	);

	register_post_type( 'image_mapper', $args );
	
	
}

add_action('init','img_map_register_cpt');