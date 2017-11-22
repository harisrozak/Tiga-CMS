<?php

/**
 * Routes Class
 */
class HRS_Articles {

	/**
	 * Session
	 *
	 * @var object Session Object
	 */
	private $session;

	/**
	 * Flash
	 *
	 * @var object Flash Object
	 */
	private $flash;

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'tiga_route', array( $this, 'register_routes' ) );
		$this->session = new \Tiga\Session();
		$this->flash = new Flash_Message();
	}

	/**
	 * Register Routes
	 */
	public function register_routes() {		
		TigaRoute::get( '/articles/page/{page:num}', array( $this, 'articles_index' ) );
		TigaRoute::get( '/articles/{id:num}/edit', array( $this, 'articles_edit' ) );
		TigaRoute::post( '/articles/{id:num}/edit', array( $this, 'articles_update' ) );
		TigaRoute::get( '/articles/{id:num}/delete', array( $this, 'articles_delete' ) );
		TigaRoute::get( '/articles/new', array( $this, 'articles_new' ) );
		TigaRoute::post( '/articles/new', array( $this, 'articles_create' ) );	
		TigaRoute::get( '/articles', array( $this, 'articles_index' ) );
	}

	/**
	 * Index Controller
	 */	
	public function articles_index($request) {
		extras::check_login('login');

		global $wpdb;

		$args = array(
    		'post_type' => 'post',
    		'posts_per_page' => 10,
    		'post_status' => 'publish',
    		'paged' => $request->input( 'page', 1 )
    	);
			
		set_tiga_template( 'template/articles-index.php', array('args' => $args) );
	}

	/**
	 * New Item Controller
	 */
	public function articles_new() {
		extras::check_login('login');
		
		// required for wp_category_checklist
		require_once( ABSPATH . '/wp-admin/includes/template.php' );

		$data = array(
			'repopulate' => $this->session->pull( 'input' ),
			'flash' => $this->flash,
		);
		
		set_tiga_template( 'template/articles-new.php', $data );
	}

	/**
	 * New Item Process Controller
	 *
	 * @param object $request   Request object.
	 */
	public function articles_create( $request ) {
		if ( $request->has( 'title' ) ) {
			$data = $request->all();

			/**
			 * The data will be:
			 * title|content|post_category|featured_image
			 */

			$featured_id = intval($request->input( 'featured_image' ));
			$categories = $request->input( 'post_category' );

			// wp_insert_post
			$post_id = wp_insert_post( array(
			    'post_title' => $request->input( 'title' ),
			    'post_content' => wp_slash( $request->input( 'content' ) ),
			    'post_status' => 'publish',
			    'post_type' => 'post',
			) );

			// set category
			if( is_array( $categories ) ) {
				wp_set_post_terms( $post_id, $categories, 'category', false );
			}

			// set featured image
			if( $featured_id > 0 ) {
				set_post_thumbnail( $post_id, $featured_id );
			}

			// success flash message
			$this->flash->success( 'Article created!' );
			wp_safe_redirect( site_url() . '/articles/' . $post_id . '/edit/' );
		} 
		else {
			// error flash message with return data
			$this->flash->error( 'The title still empty!' );
			$this->session->set( 'input', $request->all() );
			wp_safe_redirect( site_url() . '/articles/new/' );
		}
	}

	/**
	 * Update Item Controller
	 *
	 * @param object $request Request object.
	 */
	public function articles_edit( $request ) {
		$post = get_post( $request->input( 'id' ) );
		$thumbnail_id = get_post_thumbnail_id( $post->ID );
		$thumbnail_src = false;

		if(! empty($thumbnail_id)) {
			$thumbnail_src = wp_get_attachment_image_src( $thumbnail_id, 'large' );	
		}		

		// required for wp_category_checklist
		require_once( ABSPATH . '/wp-admin/includes/template.php' );

		$data = array(
			'post' => $post,
			'thumbnail_id' => $thumbnail_id,
			'thumbnail_src' => $thumbnail_src,
			'repopulate' => $this->session->pull( 'input' ),
			'flash' => $this->flash,
		);

		set_tiga_template( 'template/articles-edit.php', $data );
	}

	/**
	 * Update Item Controller
	 *
	 * @param object $request Request object.
	 */
	public function articles_update( $request ) {
		if ( $request->has( 'title' ) ) {
			$data = $request->all();

			/**
			 * The data will be:
			 * title|content|post_category|featured_image
			 */

			$post_id = intval($request->input( 'id' ));
			$featured_id = intval($request->input( 'featured_image' ));
			$categories = $request->input( 'post_category' );

			// wp_insert_post
			wp_update_post( array(
			    'ID' => $post_id,
			    'post_title' => $request->input( 'title' ),
			    'post_content' => wp_slash( $request->input( 'content' ) ),
			    'post_status' => 'publish'
			) );

			// set category
			if( is_array( $categories ) ) {
				wp_set_post_terms( $post_id, $categories, 'category', false );
			}

			// set featured image
			if( $featured_id > 0 ) {
				set_post_thumbnail( $post_id, $featured_id );
			}

			// success flash message
			$this->flash->success( 'Article updated!' );
			wp_safe_redirect( site_url() . '/articles/' . $post_id . '/edit/' );
		} 
		else {
			// error flash message with return data
			$this->flash->error( 'The title still empty!' );
			$this->session->set( 'input', $request->all() );
			wp_safe_redirect( site_url() . '/articles/new/' );
		}
	}
}
new HRS_Articles();