<?php

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		} );
	return;
}

Timber::$dirname = array('templates', 'views');

class StarterSite extends TimberSite {

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		parent::__construct();
	}

	function register_post_types() {
		//this is where you can register custom post types
		// Sample Register Post
		$postName         = 'Work'; // Name of post type
		$postNameSlug     = 'my-work'; // Name of post type
		$postNameSingular = 'Work Post'; // Singular Name
		$postNamePlural   = 'Work Posts'; // Plural Name
		register_post_type(
			$postNameSlug, array(
				'labels' => array(
			       'name' => $postName,
			       'singular_name' => $postNameSingular,
			       'add_new' => 'Add ' . $postNameSingular,
			       'add_new_item' => 'Add ' . $postNameSingular,
			       'edit_item' => 'Edit ' . $postNameSingular,
			       'search_items' => 'Search ' . $postNamePlural,
			       'not_found' => 'No ' . $postNamePlural. ' found',
			       'not_found_in_trash' => 'No ' . $postNamePlural. ' found in trash'
			    ),
				'public' => true,
				'show_ui' => true,
				'capability_type' => 'post',
				'hierarchical' => true,
				'rewrite' => array('slug' => $postNameSlug),
				'query_var' => true,
				'show_in_nav_menus' => true,
				'exclude_from_search' => false,
				'has_archive' => false,
				'menu_icon' => 'dashicons-portfolio',
				'supports' => array(
		    		'title',
		    		'editor',
		    		'author',
		    		'thumbnail', //featured image, theme must also support thumbnails
		    		'excerpt',
		    		//'trackbacks',
		    		'custom-fields',
		    		//'comments',
		    		'revisions',
		    		'page-attributes' //template and menu order, hierarchical must be true
				)
			)
		);

	}

	function register_taxonomies() {
		//this is where you can register custom taxonomies
	}

	function add_to_context( $context ) {
		$context['foo'] = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::get_context();';
		$context['menu'] = new TimberMenu();
		$context['site'] = $this;
		return $context;
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own fuctions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter( 'myfoo', new Twig_Filter_Function( 'myfoo' ) );
		return $twig;
	}

}

new StarterSite();

function myfoo( $text ) {
	$text .= ' bar!';
	return $text;
}

//Styles
function wpdocs_scripts() {
    wp_enqueue_style( 'style', get_stylesheet_directory_uri().'/css/style.css', array(), '1.0.0', 'screen' );
    //wp_enqueue_script( '', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_scripts' );
//Javascripts
