<?php
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$args = 'post_type=post&numberposts=-1';
$works = 'post_type=my-work&numberposts=-1';
$context['posts'] = Timber::get_posts($args);
$context['works'] = Timber::get_posts($works);
Timber::render( array( 'front-page.twig'), $context );
