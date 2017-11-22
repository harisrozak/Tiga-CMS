<?php

if(! class_exists('extras')):
class extras {
	public static function check_login($redirect) {
		global $user_ID;
		
		if (! $user_ID) {
			wp_safe_redirect( site_url() . '/' . $redirect ); 
		}
	}

	public static function wp_query_paginate($total_number, $args, $route) {
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
		$pagination->render();
		echo '</ul>';
	}
}
endif;