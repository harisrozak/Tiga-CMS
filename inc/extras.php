<?php

/**
 * Class extras
 * Much of useful static methods
 */
if(! class_exists('extras')):
class extras {
	public static $nonce_name = 'tiga_cms_nonce';

	public static function check_login( $redirect ) {
		global $user_ID;
		
		if (! $user_ID) {
			wp_safe_redirect( site_url() . '/' . $redirect ); 
		}
	}

	public static function wp_query_paginate( $total_number, $args, $route ) {
		// pagination
		$pagination = new \Tiga\Pagination;

		// set up pagination parameter
		$pagination_args = array(
			'rows' => $total_number,
			'current_page' => $args['paged'],
			'per_page' => $args['posts_per_page'],
			'base_url' => site_url($route . '/page/[paginate]'),
			'start_page' => 1,
			'skip_item' => true,
			'link_attribute' => 'class="page-link"',
			'link_attribute_active' => 'class="page-link"',
			'cur_tag_open' => '<li class="page-item active">',
		);

		$pagination->setup($pagination_args);
		
		// render the pagination
		echo '<ul class="pagination float-right">';
		echo '<span class="total">Total ' . $total_number . ' Items</span>';
		
		if( $total_number > $args['posts_per_page'] ) {
			$pagination->render();
		}
		
		echo '</ul>';
	}

	public static function flash_message( $data ) {
		if( $data['flash']->display() ): ?>

		<div class="row">
			<div class="col-md-12">
				<br>
				<?php $data['flash']->display() ?>
			</div>
		</div>
		<br>

		<?php endif;
	}

	public static function post_status( $post_id ) {
		$status = get_post_status( $post_id );
		self::print_status( $status, true );
	}

	public static function print_status( $status, $capitalize = false ) {
		switch ( $status ) {
			case 'publish':
				$print = "published";
				break;

			case 'trash':
				$print = "trashed";
				break;

			case 'auto-draft':
				$print = "auto draft";
				break;

			case 'pending':
				$print = "pending review";
				break;
			
			default:
				$print = $status;
				break;
		}

		echo $capitalize ? ucfirst( $print ) : $print; 
	}

	public static function nonce_field( $nonce_value ) {
		wp_nonce_field( $nonce_value, self::$nonce_name );
	}

	public static function verify_nonce_field( $nonce_value ) {
		$nonce_name = self::$nonce_name;

		if (! isset( $_POST[$nonce_name] ) || ! wp_verify_nonce( $_POST[$nonce_name], $nonce_value ) ) {
		   	print 'Sorry, your nonce did not verify.';
		   	exit;
		}
	}

	public static function verify_nonce_request( $nonce_value ) {
		$nonce_name = '_cmsnonce';

		if (! isset( $_REQUEST[$nonce_name] ) || ! wp_verify_nonce( $_REQUEST[$nonce_name], $nonce_value ) ) {
		   	print 'Sorry, your nonce did not verify.';
		   	exit;
		}
	}
}
endif;

/**
 * Pre function
 * For debuging purpose
 */
if(! function_exists( 'pre' ) ):
function pre( $data ) {
	echo "<pre>";
	print_r( $data );
	echo "</pre>";
}
endif;