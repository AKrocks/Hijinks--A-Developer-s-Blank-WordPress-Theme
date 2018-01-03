<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php wp_title(); ?></title>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>

	<?php if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' );
	} ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<!--Header-->

<header class="site-header">
    <div class="container">
        <a class="logo" href="<?php bloginfo( 'url' ); ?>"><img
                    src="<?php bloginfo( 'template_url' ); ?>/svgs/logo.svg"
                    alt="<?php bloginfo( 'title' ); ?>"/></a>

        <a class="mobile-menu" href="#">
            <i class="fa fa-bars" aria-hidden="true"></i>
            <i class="fa fa-close" aria-hidden="true"></i>
            <span class="accessibility">Menu</span>
        </a>

        <nav class="nav" role="navigation">
		    <?php html5blank_nav(); ?>
        </nav>
    </div>
</header>
