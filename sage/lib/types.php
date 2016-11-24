<?php
	if(!post_type_exists( 'reference' )) {
		add_action( 'init', 'register_reference_post_type' );
	}
	function register_reference_post_type() {		
		register_post_type( 'reference',
			array(
				'labels' => array(
					'name' => __( 'Reference' ),
					'singular_name' => __( 'Reference' )
				),
				'supports' => array( 'title', 'editor', 'thumbnail' ),
				'public' => true,
				'has_archive' => false,
				'rewrite' => array(
					'slug' => 'arbeiten'
				)
			)
		);
	}
	if(!post_type_exists( 'news' )) {
		add_action( 'init', 'register_news_post_type' );
	}
	function register_news_post_type(){
		register_post_type('news', array(
			'label' => 'News',
			'description' => 'News articles',
			'public' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'capability_type' => 'post',
			'map_meta_cap' => true,
			'hierarchical' => false,
			'rewrite' => array('slug' => 'news', 'with_front' => true),
			'query_var' => true,
			'has_archive' => false,
			'menu_icon' => 'dashicons-book',
			'supports' => array('title','editor','excerpt','trackbacks','custom-fields','comments','revisions','thumbnail','author','page-attributes','post-formats'),
			'labels' => array (
				'name' => __('News','roots'),
				'singular_name' => __('News','roots'),
				'menu_name' => 'News',
				'add_new' => 'Add News',
				'add_new_item' => 'Add New News',
				'edit' => 'Edit',
				'edit_item' => 'Edit News',
				'new_item' => 'New News',
				'view' => 'View News',
				'view_item' => 'View News',
				'search_items' => 'Search News',
				'not_found' => 'No News Found',
				'not_found_in_trash' => 'No News Found in Trash',
				'parent' => 'Parent News',
			)
		));
	}
?>