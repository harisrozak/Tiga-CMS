<?php

if(! class_exists('extras')):
class extras {
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
			
			default:
				$print = $status;
				break;
		}

		echo $capitalize ? ucfirst( $print ) : $print; 
	}
}
endif;