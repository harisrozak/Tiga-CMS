<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class( $body_class ); ?>>
	<div id="main">
		<nav class="navbar navbar-expand-md navbar-dark bg-dark">
			<div class="container">
				<a class="navbar-brand" href="<?php echo site_url() ?>">Tiga CMS</a>

				<div class="collapse navbar-collapse" id="navbarsExampleDefault">
        			<ul class="navbar-nav mr-auto">
          				<li class="nav-item active">
            				<a class="nav-link" href="<?php echo site_url('dashboard') ?>">Dashboard</a>
          				</li>
          				<li class="nav-item">
            				<a class="nav-link" href="<?php echo site_url('articles') ?>">Articles</a>
          				</li>
          				<li class="nav-item dropdown">
				            <a class="nav-link dropdown-toggle" href="<?php echo site_url('article') ?>" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Add New</a>
				            <div class="dropdown-menu" aria-labelledby="dropdown01">
				              	<a class="dropdown-item" href="<?php echo site_url('articles/new') ?>">New Article</a>
				            </div>
			          	</li>
          			</ul>

          			<ul class="navbar-nav float-right">
          				<li class="nav-item">
            				<a class="nav-link" href="<?php echo site_url('logout') ?>">Logout</a>
          				</li>
          			</ul>
				</div>
			</div>
		</nav>
