<?php get_header(); ?>
<div class="container main-container">
	<h2>
	  	Articles
	  	<small class="text-muted"> View <?php extras::print_status( $data['status'] ) ?> articles</small>
	</h2>

	<?php
	// query
	$the_query = new WP_Query($data['args']);
	$total_number = $the_query->found_posts; //total without limit
	$displayed_number =  $the_query->post_count; //total with limit

	// nonce
	$nonce = wp_create_nonce( 'article_actions_nonce' );

	// flash message
	extras::flash_message($data);
	?>

	<div class="row post-list-top-panel">
		<div class="col-md-6">
			<a class="btn btn-outline-primary <?php echo $data['active_status'][0] ?>" href="<?php echo site_url('articles') ?>">
				Published (<?php echo $data['count_posts']->publish ?>)
			</a>
			<a class="btn btn-outline-danger <?php echo $data['active_status'][1] ?>"" href="<?php echo site_url('articles/status/trash') ?>">
				Trashed (<?php echo $data['count_posts']->trash ?>)
			</a>
			<div class="btn-group">
				<a class="btn btn-outline-dark dropdown-toggle <?php echo $data['active_status'][2] ?>"" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Other Status	
				</a>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
					<a class="dropdown-item" href="<?php echo site_url('articles/status/future') ?>">
						Future (<?php echo $data['count_posts']->future ?>)
					</a>
			      	<a class="dropdown-item" href="<?php echo site_url('articles/status/draft') ?>">
			      		Draft (<?php echo $data['count_posts']->draft ?>)
			      	</a>
			      	<a class="dropdown-item" href="<?php echo site_url('articles/status/pending') ?>">
			      		Pending (<?php echo $data['count_posts']->pending ?>)
			      	</a>
			      	<a class="dropdown-item" href="<?php echo site_url('articles/status/private') ?>">
			      		Private (<?php echo $data['count_posts']->private ?>)
			      	</a>
			      	<a class="dropdown-item" href="<?php echo site_url('articles/status/auto-draft') ?>">
			      		Auto Draft (<?php echo $data['count_posts']->{'auto-draft'} ?>)
			      	</a>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<?php extras::wp_query_paginate($total_number, $data['args'], 'articles') ?>
		</div>
	</div>

	<table class="table table-striped">
	  	<thead class="thead-dark">
		    <tr>
	      		<th scope="col" class="col-id">#</th>
		      	<th scope="col">Title</th>
		      	<th scope="col" class="col-category">Category</th>
		      	<th scope="col" class="col-status">Status</th>
		    </tr>
	  	</thead>
	  	<tbody>

		<?php
		if($displayed_number > 0) :

			// loop
			while ($the_query->have_posts()) : $the_query->the_post();
				?>
				
				<tr>
			      	<th scope="row"><?php the_ID() ?></th>
			      	<td>
			      		<a href="<?php echo site_url('articles/' . get_the_ID() . '/edit') ?>" class="post-list-title">
			      			<?php the_title() ?>
			      		</a>

			      		<div class="post-list-item-actions">
			      		<?php if($data['status'] == 'trash'): ?>

			      		<a href="<?php echo site_url('articles/' . get_the_ID() . '/restore') ?>?_cmsnonce=<?php echo $nonce ?>" class="btn btn-sm btn-outline-info">Restore</a>
			      		<a href="<?php echo site_url('articles/' . get_the_ID() . '/delete_permanent') ?>?_cmsnonce=<?php echo $nonce ?>" class="btn btn-sm btn-outline-danger">Delete Permanently</a>

			      		<?php else: ?>
			      		
			      		<a href="<?php echo site_url('articles/' . get_the_ID() . '/edit') ?>?_cmsnonce=<?php echo $nonce ?>" class="btn btn-sm btn-outline-info">Edit</a>
			      		<a href="<?php echo site_url('articles/' . get_the_ID() . '/trash') ?>?_cmsnonce=<?php echo $nonce ?>" class="btn btn-sm btn-outline-danger">Trash</a>
			      		
			      		<?php endif ?>
			      		</div>
			      			
			      	</td>
			      	<td><?php the_category( ', ' ); ?></td>
			      	<td>
			      		<?php extras::post_status( get_the_ID() ) ?><br />
			      		<?php the_time( get_option( 'date_format' ) ); ?>
					</td>
			    </tr>

	    		<?php
			endwhile;
			wp_reset_postdata();

		else :
			?> <tr><td colspan="4">No available data.</td></tr> <?php				
		endif;
		?>
	
		</tbody>
		<thead class="thead-grey">
		    <tr>
	      		<th scope="col">#</th>
		      	<th scope="col">Title</th>
		      	<th scope="col">Category</th>
		      	<th scope="col">Date</th>
		    </tr>
	  	</thead>	  	
	</table>

	<?php extras::wp_query_paginate($total_number, $data['args'], 'articles') ?>
</div>

<?php get_footer(); ?>