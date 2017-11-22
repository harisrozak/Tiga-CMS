<?php get_header(); ?>
<div class="container main-container">
	<h2>
	  	Articles
	  	<small class="text-muted">View All Articles</small>
	</h2>

	<table class="table table-striped">
	  	<thead class="thead-dark">
		    <tr>
	      		<th scope="col">#</th>
		      	<th scope="col">Title</th>
		      	<th scope="col">Category</th>
		      	<th scope="col" class="col-date">Date</th>
		      	<th scope="col" class="col-actions">Actions</th>
		    </tr>
	  	</thead>
	  	<tbody>

		<?php
			$the_query = new WP_Query($data['args']);
			$total_number = $the_query->found_posts; //total without limit
			$displayed_number =  $the_query->post_count; //total with limit

			if($displayed_number > 0) :

				// loop
				while ($the_query->have_posts()) : $the_query->the_post();
					?>
					
					<tr>
				      	<th scope="row"><?php the_ID() ?></th>
				      	<td><?php the_title() ?></td>
				      	<td><?php the_category( ', ' ); ?></td>
				      	<td><?php the_time( get_option( 'date_format' ) ); ?></td>
				      	<td>
				      		<a href="<?php echo site_url('articles/' . get_the_ID() . '/edit') ?>" class="btn btn-sm btn-outline-info">Edit</a>
				      		<a href="<?php echo site_url('articles/' . get_the_ID() . '/delete') ?>" class="btn btn-sm btn-outline-danger">Delete</a>
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
		      	<th scope="col">Actions</th>
		    </tr>
	  	</thead>	  	
	</table>

	<?php extras::wp_query_paginate($total_number, $data['args'], 'articles') ?>
</div>

<?php get_footer(); ?>