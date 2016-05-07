<?php

remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
remove_action( 'wp_head', 'index_rel_link' ); // index link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version

/* Prevent Login Errors for Security */
add_filter('login_errors',create_function('$a', "return null;"));
/* Globally Hide Admin Meta Boxes */
function hide_meta_boxes() {
     remove_meta_box('postcustom','post','normal'); // custom fields post
     remove_meta_box('postcustom','page','normal'); // custom fields page

     //remove_meta_box('commentstatusdiv','post','normal'); // discussion post
     remove_meta_box('commentstatusdiv','page','normal'); // discussion page

     //remove_meta_box('commentsdiv','post','normal'); // comments post
     //remove_meta_box('commentsdiv','page','normal'); // comments page

     //remove_meta_box('authordiv','post','normal'); // author post
     remove_meta_box('authordiv','page','normal'); // author page

     //remove_meta_box('revisionsdiv','post','normal'); // revisions post
     //remove_meta_box('revisionsdiv','page','normal'); // revisions page

     //remove_meta_box('postimagediv','post','normal'); // featured image post
     remove_meta_box('postimagediv','page','normal'); // featured image page

     //remove_meta_box('pageparentdiv','page','normal'); // page attributes

     //remove_meta_box('tagsdiv-post-tag','post','normal'); // post tags
     //remove_meta_box('categorydiv','post','normal'); // post categories
     //remove_meta_box('postexcerpt','post','normal'); // post excerpt
     remove_meta_box('trackbacksdiv','post','normal'); // track backs
}
add_action('admin_init', 'hide_meta_boxes');

/* ========================================================================= */
/*  Browser detection body_class() output */
/* ========================================================================= */

function alx_browser_body_class( $classes ) {
    global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

    if($is_lynx) $classes[] = 'lynx';
    elseif($is_gecko) $classes[] = 'gecko';
    elseif($is_opera) $classes[] = 'opera';
    elseif($is_NS4) $classes[] = 'ns4';
    elseif($is_safari) $classes[] = 'safari';
    elseif($is_chrome) $classes[] = 'chrome';
    elseif($is_IE) {
        $browser = $_SERVER['HTTP_USER_AGENT'];
        $browser = substr( "$browser", 25, 8);
        if ($browser == "MSIE 7.0"  ) {
            $classes[] = 'ie7';
            $classes[] = 'ie';
        } elseif ($browser == "MSIE 6.0" ) {
            $classes[] = 'ie6';
            $classes[] = 'ie';
        } elseif ($browser == "MSIE 8.0" ) {
            $classes[] = 'ie8';
            $classes[] = 'ie';
        } elseif ($browser == "MSIE 9.0" ) {
            $classes[] = 'ie9';
            $classes[] = 'ie';
        } else {
            $classes[] = 'ie';
        }
    }
    else $classes[] = 'unknown';

    if( $is_iphone ) $classes[] = 'iphone';

    return $classes;
}
add_filter( 'body_class', 'alx_browser_body_class' );

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
	$tloc = get_stylesheet_directory_uri(); wp_deregister_script( 'jquery' );
    wp_enqueue_style( 'style', $tloc.'/css/style.css', array(), '', 'screen' );
    wp_enqueue_script( 'jquery', 'https://code.jquery.com/jquery-1.12.0.min.js', array(), '', false );
	wp_enqueue_script( 'plugins', $tloc.'/js/plugins.js', array(), '', true );
	wp_enqueue_script( 'main', $tloc.'/js/main.js', array(), '', true);
}
add_action( 'wp_enqueue_scripts', 'wpdocs_scripts' );
//Javascripts
