<?php
/**
 * crystal functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package crystal
 */

if (!function_exists('crystal_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function crystal_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on crystal, use a find and replace
         * to change 'crystal' to the name of your theme in all the template files.
         */
        load_theme_textdomain('crystal', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // default post thumbnail size
        set_post_thumbnail_size( 770, 350, true );

        add_image_size( 'crystal-thumb-xl', 1920, 1080, true );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => esc_html__('Primary', 'crystal'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        /*
         * Enable support for Post Formats.
         * See https://developer.wordpress.org/themes/functionality/post-formats/
         */
        add_theme_support('post-formats', array(
            'image',
            'gallery',
            'audio',
            'video',
            'aside',
            'quote',
            'link',
            'status',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('crystal_custom_background_args', array(
            'default-color' => 'C9CBCE',
            'default-image' => get_template_directory_uri() . '/assets/images/background.jpg',
            'default-repeat' => 'no-repeat',
            'default-position-x' => 'center',
        )));
    }
endif;
add_action('after_setup_theme', 'crystal_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function crystal_content_width()
{
    $GLOBALS['content_width'] = apply_filters('crystal_content_width', 640);
}

add_action('after_setup_theme', 'crystal_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function crystal_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Sidebar', 'crystal'),
        'id' => 'sidebar-1',
        'description' => '',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer Sidebar 1', 'crystal'),
        'id' => 'footer-sidebar-1',
        'description' => '',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer Sidebar 2', 'crystal'),
        'id' => 'footer-sidebar-2',
        'description' => '',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
}

add_action('widgets_init', 'crystal_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function crystal_scripts()
{
    //styles
    wp_enqueue_style('crystal-style', get_stylesheet_uri(), false, '1.0.0');

    //fonts
    wp_enqueue_style('crystal-font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', false, '4.5.0' );
    wp_enqueue_style( 'crystal-fonts', crystal_fonts_url() );

    //scripts
    wp_enqueue_script( 'crystal-magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.js', array( 'jquery' ), '1.0.0', true );
    wp_enqueue_script('crystal-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true);
    wp_enqueue_script('crystal-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true);
    wp_enqueue_script( 'crystal-custom-script', get_template_directory_uri() . '/js/script.js', array( 'jquery' ), '1.0.0', true );

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'crystal_scripts');

/**
 * Get necessary Google fonts URL
 */
function crystal_fonts_url() {

    $fonts_url = '';

    $locale = get_locale();
    $cyrillic_locales = array( 'ru_RU', 'mk_MK', 'ky_KY', 'bg_BG', 'sr_RS', 'uk', 'bel' );

    /* Translators: If there are characters in your language that are not
     * supported by Tinos, translate this to 'off'. Do not translate
     * into your own language.
     */
    $tinos = _x( 'on', 'Tinos font: on or off', 'crystal' );

    /* Translators: If there are characters in your language that are not
     * supported by Roboto, translate this to 'off'. Do not translate
     * into your own language.
     */
    $roboto = _x( 'on', 'Roboto font: on or off', 'crystal' );


    if ( 'off' == $tinos && 'off' == $roboto ) {
        return $fonts_url;
    }

    $font_families = array();

    if ( 'off' !== $tinos ) {
        $font_families[] = 'Tinos:400,400italic,700';
    }

    if ( 'off' !== $roboto ) {
        $font_families[] = 'Roboto:400,100,100italic,400italic,300,300italic,500,500italic,700,700italic,900,900italic';
    }

    $query_args = array(
        'family' => urlencode( implode( '|', $font_families ) ),
        'subset' => urlencode( 'latin,latin-ext' ),
    );

    if ( in_array($locale, $cyrillic_locales) ) {
        $query_args['subset'] = urlencode( 'latin,latin-ext,cyrillic' );
    }

    $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

    return $fonts_url;
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions hooked to custom theme actions.
 */
require get_template_directory() . '/inc/template-actions.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';