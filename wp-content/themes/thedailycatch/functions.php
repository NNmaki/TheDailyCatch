<?php
// Estä suora pääsy tiedostoon
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}



// Teeman "asetukset"
function thedailycatch_setup() {
    // Automaattinen <title>-tagin hallinta (SEO-pluginit yms. luottavat tähän)
    add_theme_support( 'title-tag' );

    // Kuvattu artikkelikuva (featured image) - tarvitset tämän saaliskuville
    add_theme_support( 'post-thumbnails' );

    // HTML5-merkkaus lomakkeille, kommenteille, gallerioille
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    // Custom logo -tuki (Ulkoasu > Muokkaa sivustoa -asetuksiin)
    add_theme_support( 'custom-logo' );

    // Rekisteröi navigointivalikko
    register_nav_menus( array(
        'primary' => __( 'Main Menu', 'thedailycatch' ),
    ) );
}
add_action( 'after_setup_theme', 'thedailycatch_setup' );


// CSS ja JS Lataus
function thedailycatch_scripts() {
    wp_enqueue_style(
        'thedailycatch-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get( 'Version' )
    );
}
add_action( 'wp_enqueue_scripts', 'thedailycatch_scripts' );



// Rekisteroidaan custom post types CPT

function thedailycatch_register_post_types() {

    $labels = array(
        'name'                  => _x( 'Catch Reports', 'Post type general name', 'thedailycatch' ),
        'singular_name'         => _x( 'Catch Report', 'Post type singular name', 'thedailycatch' ),
        'menu_name'             => _x( 'Catch Reports', 'Admin Menu text', 'thedailycatch' ),
        'add_new_item'          => __( 'Add New Catch Report', 'thedailycatch' ),
        'edit_item'             => __( 'Edit Catch Report', 'thedailycatch' ),
        'view_item'             => __( 'Show Catch Report', 'thedailycatch' ),
        'all_items'             => __( 'All Catch Reports', 'thedailycatch' ),
        'search_items'          => __( 'Find Catch Report', 'thedailycatch' ),
        'not_found'             => __( 'No Catch Reports', 'thedailycatch' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'show_in_rest'       => true,        // Gutenberg-editorin tuki
        'menu_icon'          => 'dashicons-palmtree', // vaihda mieluummin esim. dashicons-location tms.
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'rewrite'            => array( 'slug' => 'catchreport' ),
        'menu_position'      => 5,
    );

    register_post_type( 'catchreport', $args );
}
add_action( 'init', 'thedailycatch_register_post_types' );

// Lisataan taksonimiat
function thedailycatch_register_taxonomies() {

    // Kalalaji
    register_taxonomy( 'species', 'catchreport', array(
        'labels' => array(
            'name'          => _x( 'Species', 'taxonomy general name', 'thedailycatch' ),
            'singular_name' => _x( 'Species', 'taxonomy singular name', 'thedailycatch' ),
            'search_items'  => __( 'Search Species', 'thedailycatch' ),
            'all_items'     => __( 'All Species', 'thedailycatch' ),
            'edit_item'     => __( 'Edit Species', 'thedailycatch' ),
            'add_new_item'  => __( 'Add New Species', 'thedailycatch' ),
            'menu_name'     => __( 'Species', 'thedailycatch' ),
        ),
        'hierarchical'      => true,   // toimii kuin kategoriat (ei kuin tagit)
        'public'            => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'species' ),
    ) );

    // Vesistö
    register_taxonomy( 'waterbody', 'catchreport', array(
        'labels' => array(
            'name'          => _x( 'Waterbodies', 'taxonomy general name', 'thedailycatch' ),
            'singular_name' => _x( 'Waterbody', 'taxonomy singular name', 'thedailycatch' ),
            'search_items'  => __( 'Search Waterbodies', 'thedailycatch' ),
            'all_items'     => __( 'All Waterbodies', 'thedailycatch' ),
            'edit_item'     => __( 'Edit Waterbody', 'thedailycatch' ),
            'add_new_item'  => __( 'Add New Waterbody', 'thedailycatch' ),
            'menu_name'     => __( 'Waterbodies', 'thedailycatch' ),
        ),
        'hierarchical'      => true,
        'public'            => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'waterbody' ),
    ) );
}
add_action( 'init', 'thedailycatch_register_taxonomies' );