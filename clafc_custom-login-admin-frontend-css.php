<?php
/*
Plugin Name: Custom Login Admin Front-end CSS
Plugin URI: http://millionclues.com
Description: Loads custom CSS on WordPress Login, Admin and Front-end pages via the admin interface. Works on Multisites as well.
Author: Arun Basil Lal
Author URI: http://millionclues.com
Version: 1.4
Text Domain: abl_clafc_td
Domain Path: /languages
License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

/**
 * ::TODO::
 * - Update version number CLAFC_VERSION_NUM on every update
 */

// Exit If Accessed Directly
if ( ! defined( 'ABSPATH' ) ) exit;
 
/*------------------------------------------*/
/*			Plugin Setup Functions			*/
/*------------------------------------------*/

// Add Admin Sub Menu: Appearance > Custom Login Admin Front-end CSS
function clafc_add_menu_links() {
	if ( is_multisite() ) {
		if ( get_current_blog_id() == SITE_ID_CURRENT_SITE ) {
			add_theme_page ( __('Custom Login Admin Front-end CSS','abl_clafc_td'), __('Custom LAF CSS','abl_clafc_td'), 'update_core', 'custom-login-admin-frontend-css','clafc_admin_interface_render'  );
		}
	}
	else {
		add_theme_page ( __('Custom Login Admin Front-end CSS','abl_clafc_td'), __('Custom LAF CSS','abl_clafc_td'), 'update_core', 'custom-login-admin-frontend-css','clafc_admin_interface_render'  );
	}
}
add_action( 'admin_menu', 'clafc_add_menu_links' );


// Print Direct Link To Custom Login Admin Front-end CSS Options Page In Plugins List
function clafc_settings_link( $links ) {
	return array_merge(
		array(
			'settings' => '<a href="' . admin_url( 'themes.php?page=custom-login-admin-frontend-css' ) . '">' . __( 'Add CSS', 'abl_clafc_td' ) . '</a>'
		),
		$links
	);
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'clafc_settings_link' );


// Add Donate Link to Plugins list
function clafc_plugin_row_meta( $links, $file ) {
	if ( strpos( $file, 'clafc_custom-login-admin-frontend-css.php' ) !== false ) {
		$new_links = array(
				'donate' 	=> '<a href="http://millionclues.com/donate/" target="_blank">Donate</a>',
				'hireme' 	=> '<a href="http://millionclues.com/portfolio/" target="_blank">Hire Me For A Project</a>',
				);
		$links = array_merge( $links, $new_links );
	}
	return $links;
}
add_filter( 'plugin_row_meta', 'clafc_plugin_row_meta', 10, 2 );


// Load Text Domain
function clafc_load_plugin_textdomain() {
    load_plugin_textdomain( 'abl_clafc_td', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'clafc_load_plugin_textdomain' );


// Register Settings
function clafc_register_settings() {
	register_setting( 'clafc_settings_group', 'clafc_custom_css', 'clafc_clean_css_with_csstidy' );
}
add_action( 'admin_init', 'clafc_register_settings' );

/**
 * Add plugin version to database
 *
 * @since 		1.3
 * @constant 	CLAFC_VERSION_NUM		the version number of the current version
 * @refer		https://codex.wordpress.org/Creating_Tables_with_Plugins#Adding_an_Upgrade_Function
 */
if (!defined('CLAFC_VERSION_NUM'))
    define('CLAFC_VERSION_NUM', '1.4');
// update_option('abl_clafc_version', CLAFC_VERSION_NUM);	// Disabled to set default values for Load CSS checkboxes

/**
 * Set default values for Load CSS checkboxes
 *
 * @since	1.3
 */
if ( is_multisite() ) {
	$installed_ver = get_blog_option( SITE_ID_CURRENT_SITE, 'abl_clafc_version' );
}
else {
	$installed_ver = get_option( 'abl_clafc_version' );
}

if ($installed_ver == '' ) {
	if ( is_multisite() ) {
		$clafc_custom_css_option = get_blog_option( SITE_ID_CURRENT_SITE, 'clafc_custom_css' );
	}
	else {
		$clafc_custom_css_option = get_option( 'clafc_custom_css' );
	}
	
	// All CSS loaded by default
	$clafc_custom_css_option['load_login_css'] 		= 1;
	$clafc_custom_css_option['load_admin_css'] 		= 1;
	$clafc_custom_css_option['load_frontend_css'] 	= 1;
	
	if ( is_multisite() ) {
		update_blog_option(SITE_ID_CURRENT_SITE, 'clafc_custom_css', $clafc_custom_css_option);
		update_blog_option(SITE_ID_CURRENT_SITE, 'abl_clafc_version', CLAFC_VERSION_NUM);
	}
	else {
		update_option('clafc_custom_css', $clafc_custom_css_option);
		update_option('abl_clafc_version', CLAFC_VERSION_NUM);
	}
}


// Delete Options During Uninstall
function clafc_uninstall_plugin() {
	delete_option( 'clafc_custom_css' );
	delete_option( 'abl_clafc_version' );
}
register_uninstall_hook(__FILE__, 'clafc_uninstall_plugin' );

/**
 * Admin footer text
 *
 * @since	1.3
 */
function clafc_footer_text($default) {
    
	// Retun default on non-plugin pages
	$screen = get_current_screen();
	if ( $screen->id !== "appearance_page_custom-login-admin-frontend-css" ) {
		return $default;
	}
	
    $clafc_footer_text = sprintf( __( 'If you like this plugin, please <a href="%s" target="_blank">make a donation</a> or leave a <a href="%s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> rating to support continued development. Thanks a bunch!', 'abl_clafc_td' ), 
								'http://millionclues.com/donate/',
								'https://wordpress.org/support/plugin/custom-login-admin-front-end-css-with-multisite-support/reviews/?rate=5#new-post'
						);
	
	return $clafc_footer_text;
}
add_filter('admin_footer_text', 'clafc_footer_text');



/*--------------------------------------*/
/*			Admin Options Page			*/
/*--------------------------------------*/

// Load Syntax Highlighter
function clafc_register_highlighter( $hook ) {
	if ( 'appearance_page_custom-login-admin-frontend-css' === $hook ) {
		wp_enqueue_style( 'highlighter-css', plugins_url( basename( dirname( __FILE__ ) ) . '/highlighter/codemirror.css' ) );
		wp_enqueue_script( 'highlighter-js', plugins_url( basename( dirname( __FILE__ ) ) . '/highlighter/codemirror.js' ), array(), '20140329', true );
		wp_enqueue_script( 'highlighter-css-js', plugins_url( basename( dirname( __FILE__ ) ) . '/highlighter/css.js' ), array(), '20140329', true );
	}
}
add_action( 'admin_enqueue_scripts', 'clafc_register_highlighter' );


// Sanitize CSS with CSS Tidy - Uses CSS Tidy Modified By The Jetpack Team. 
function clafc_clean_css_with_csstidy ( $input ) {

	$input['clafc_login_css'] 		= clafc_csstidy_helper ( $input['clafc_login_css'] );
	$input['clafc_admin_css'] 		= clafc_csstidy_helper ( $input['clafc_admin_css'] );
	$input['clafc_frontend_css'] 	= clafc_csstidy_helper ( $input['clafc_frontend_css'] );
	
	return $input;
}

// Scrub And Clean With CSS Tidy
function clafc_csstidy_helper ( $css, $minify=false ) {
	
	include_once('csstidy/class.csstidy.php');
	
	$csstidy = new csstidy();
	$csstidy->set_cfg( 'remove_bslash',              false );
	$csstidy->set_cfg( 'compress_colors',            false );
	$csstidy->set_cfg( 'compress_font-weight',       false );
	$csstidy->set_cfg( 'optimise_shorthands',        0 );
	$csstidy->set_cfg( 'remove_last_;',              false );
	$csstidy->set_cfg( 'case_properties',            false );
	$csstidy->set_cfg( 'discard_invalid_properties', true );
	$csstidy->set_cfg( 'css_level',                  'CSS3.0' );
	$csstidy->set_cfg( 'preserve_css',               true );
	
	if ($minify === false) {
		$csstidy->set_cfg( 'template', dirname( __FILE__ ) . '/csstidy/wordpress-standard.tpl' );
	} else {
		$csstidy->set_cfg( 'template', 'highest');
	}
	
	$css = preg_replace( '/\\\\([0-9a-fA-F]{4})/', '\\\\\\\\$1', $css );
	$css = str_replace( '<=', '&lt;=', $css );
	$css = wp_kses_split( $css, array(), array() );
	$css = str_replace( '&gt;', '>', $css ); // kses replaces lone '>' with &gt;
	$css = strip_tags( $css );
	
	$csstidy->parse( $css );
	$css = $csstidy->print->plain();

	return $css;
}

// Admin Interface: Appearance > Custom Login Admin Front-end CSS
function clafc_admin_interface_render () {

	// Load settings and data
	if ( is_multisite() ) {
		$clafc_custom_css_option = get_blog_option( SITE_ID_CURRENT_SITE, 'clafc_custom_css' );
	}
	else {
		$clafc_custom_css_option = get_option( 'clafc_custom_css' );
	}
	
	// Integration with Admin CSS MU plugin - https://wordpress.org/plugins/admin-css-mu/
	if ( is_multisite() ) {
		$admincssmu_custom_css_option = get_blog_option( get_current_blog_id(), 'admincssmu_custom_css' );
	}
	else {
		$admincssmu_custom_css_option = get_option( 'admincssmu_custom_css' );
	}
	
	// Set disabled if Admin CSS MU's settings arent found
	$disabled = ($admincssmu_custom_css_option=='') ? 'disabled' : '';
	
	$clafc_login_css_content = isset( $clafc_custom_css_option['clafc_login_css'] ) && ! empty( $clafc_custom_css_option['clafc_login_css'] ) ? $clafc_custom_css_option['clafc_login_css'] : __( "/* Enter Your Custom Login CSS Here */\r\n", 'abl_clafc_td' );
	
	$clafc_admin_css_content = isset( $clafc_custom_css_option['clafc_admin_css'] ) && ! empty( $clafc_custom_css_option['clafc_admin_css'] ) ? $clafc_custom_css_option['clafc_admin_css'] : __( "/* Enter Your Custom Admin CSS Here */\r\n", 'abl_clafc_td' );
	
	if ( (isset($clafc_custom_css_option['import_admincssmu_css'])) && (boolval($clafc_custom_css_option['import_admincssmu_css'])) ) {
		
		// Copy the CSS from Admin CSS MU
		$css_from_admincssmu	  = str_replace('/* Enter Your Custom Admin CSS Here */','',$admincssmu_custom_css_option['admincssmu_admin_css']);
		$css_from_admincssmu	  = __( "\r\n/* CSS imported from Admin CSS MU */\r\n", 'abl_clafc_td') . $css_from_admincssmu;
		$clafc_admin_css_content .= $css_from_admincssmu;
		
		//Add the new CSS to the database
		$clafc_custom_css_option['clafc_admin_css']	= $clafc_admin_css_content;
		
		// Disable the 'Import and append CSS from Admin CSS MU' checkbox
		$clafc_custom_css_option['import_admincssmu_css'] = 0;
		
		if ( is_multisite() ) {
			update_blog_option(SITE_ID_CURRENT_SITE, 'clafc_custom_css', $clafc_custom_css_option);
		}
		else {
			update_option('clafc_custom_css', $clafc_custom_css_option);
		}
	}
	
	$clafc_frontend_css_content = isset( $clafc_custom_css_option['clafc_frontend_css'] ) && ! empty( $clafc_custom_css_option['clafc_frontend_css'] ) ? $clafc_custom_css_option['clafc_frontend_css'] : __( "/* Enter Your Custom Front-end CSS Here */\r\n", 'abl_clafc_td' );

?>
	<div class="wrap">
		<h1><?php _e('Custom Login Admin Front-end CSS','abl_clafc_td') ?></h1>
		<p><?php _e('Enter your custom css below and it will be loaded in the respecitive pages.','abl_clafc_td') ?></p>
		
		<form method="post" action="options.php" enctype="multipart/form-data">
		
			<?php settings_fields( 'clafc_settings_group' ); ?>
			
			<?php // --- Login CSS --- // ?>
			
			<h2 class="title"><?php _e('Login CSS','abl_clafc_td') ?></h2>
			
			<p><label for="clafc_login_css"><?php _e('Enter the css to be used on your WordPress Login / Register pages below.','abl_clafc_td') ?></label></p>
			<textarea rows="10" class="large-text code" id="clafc_custom_css[clafc_login_css]" name="clafc_custom_css[clafc_login_css]"><?php echo esc_textarea( $clafc_login_css_content ); ?></textarea>
			
			<div style="margin-top: 5px;">
				<input type="checkbox" name="clafc_custom_css[load_login_css]" id="clafc_custom_css[load_login_css]" value="1" 
				<?php if ( isset( $clafc_custom_css_option['load_login_css'] ) ) { checked( '1', $clafc_custom_css_option['load_login_css'] ); } ?>>
				<label for="clafc_custom_css[load_login_css]" style="vertical-align: unset;"><?php _e('Load Login CSS', 'abl_clafc_td') ?></label>
			</div>
			
			<div style="margin-top: 5px;">
				<input type="checkbox" name="clafc_custom_css[minify_login_css]" id="clafc_custom_css[minify_login_css]" value="1" 
				<?php if ( isset( $clafc_custom_css_option['minify_login_css'] ) ) { checked( '1', $clafc_custom_css_option['minify_login_css'] ); } ?>>
				<label for="clafc_custom_css[minify_login_css]" style="vertical-align: unset;"><?php _e('Minify Login CSS', 'abl_clafc_td') ?></label>
			</div>
			
			<?php // --- Admin CSS --- // ?>
			
			<h2 class="title"><?php _e('Admin CSS','abl_clafc_td') ?></h2>
			
			<p><label for="clafc_admin_css"><?php _e('Enter the css to be used on your WordPress Admin pages below.','abl_clafc_td') ?></label></p>
			<textarea rows="10" class="large-text code" id="clafc_custom_css[clafc_admin_css]" name="clafc_custom_css[clafc_admin_css]"><?php echo esc_textarea( $clafc_admin_css_content ); ?></textarea>
			
			<div style="margin-top: 5px;">
				<input type="checkbox" name="clafc_custom_css[load_admin_css]" id="clafc_custom_css[load_admin_css]" value="1" 
				<?php if ( isset( $clafc_custom_css_option['load_admin_css'] ) ) { checked( '1', $clafc_custom_css_option['load_admin_css'] ); } ?>>
				<label for="clafc_custom_css[load_admin_css]" style="vertical-align: unset;"><?php _e('Load Admin CSS', 'abl_clafc_td') ?></label>
			</div>
			
			<div style="margin-top: 5px;">
				<input type="checkbox" name="clafc_custom_css[minify_admin_css]" id="clafc_custom_css[minify_admin_css]" value="1" 
				<?php if ( isset( $clafc_custom_css_option['minify_admin_css'] ) ) { checked( '1', $clafc_custom_css_option['minify_admin_css'] ); } ?>>
				<label for="clafc_custom_css[minify_admin_css]" style="vertical-align: unset;"><?php _e('Minify Admin CSS', 'abl_clafc_td') ?></label>
			</div>
			
			<div style="margin-top: 5px;">
				<input type="checkbox" name="clafc_custom_css[import_admincssmu_css]" id="clafc_custom_css[import_admincssmu_css]" value="1" 
				<?php if ( isset( $clafc_custom_css_option['import_admincssmu_css'] ) ) { checked( '1', $clafc_custom_css_option['import_admincssmu_css'] ); } ?><?php echo $disabled; ?>>
				<label for="clafc_custom_css[import_admincssmu_css]" style="vertical-align: unset;"><?php printf( __( 'Import and append CSS from <a href="%s" target="_blank">Admin CSS MU</a>', 'abl_clafc_td' ), 'https://wordpress.org/plugins/admin-css-mu/'); ?></label>
			</div>
			
			<?php // --- Front-end CSS --- // ?>
			
			<h2 class="title"><?php _e('Front-end CSS','abl_clafc_td') ?></h2>
			
			<p><label for="clafc_admin_css"><?php _e('Enter the css to be used on the Front-end of your website below.','abl_clafc_td') ?></label></p>
			<textarea rows="10" class="large-text code" id="clafc_custom_css[clafc_frontend_css]" name="clafc_custom_css[clafc_frontend_css]"><?php echo esc_textarea( $clafc_frontend_css_content ); ?></textarea>
			
			<div style="margin-top: 5px;">
				<input type="checkbox" name="clafc_custom_css[load_frontend_css]" id="clafc_custom_css[load_frontend_css]" value="1" 
				<?php if ( isset( $clafc_custom_css_option['load_frontend_css'] ) ) { checked( '1', $clafc_custom_css_option['load_frontend_css'] ); } ?>>
				<label for="clafc_custom_css[load_frontend_css]" style="vertical-align: unset;"><?php _e('Load Front-end CSS', 'abl_clafc_td') ?></label>
			</div>
			
			<div style="margin-top: 5px;">
				<input type="checkbox" name="clafc_custom_css[minify_frontend_css]" id="clafc_custom_css[minify_frontend_css]" value="1" 
				<?php if ( isset( $clafc_custom_css_option['minify_frontend_css'] ) ) { checked( '1', $clafc_custom_css_option['minify_frontend_css'] ); } ?>>
				<label for="clafc_custom_css[minify_frontend_css]" style="vertical-align: unset;"><?php _e('Minify Front-end CSS', 'abl_clafc_td') ?></label>
			</div>
			
			<?php submit_button( __( 'Save CSS', 'abl_clafc_td' ), 'primary', 'submit', true ); ?>
		</form>
		
		<?php // Highlighter ?>
		<script language="javascript">
			jQuery( document ).ready( function() {
				var editor_login_css = CodeMirror.fromTextArea( document.getElementById( "clafc_custom_css[clafc_login_css]" ), {lineNumbers: true, lineWrapping: true} );
				var editor_admin_css = CodeMirror.fromTextArea( document.getElementById( "clafc_custom_css[clafc_admin_css]" ), {lineNumbers: true, lineWrapping: true} );
				var editor_frontend_css = CodeMirror.fromTextArea( document.getElementById( "clafc_custom_css[clafc_frontend_css]" ), {lineNumbers: true, lineWrapping: true} );
			});
		</script>
	</div><?php
}



/*----------------------------------*/
/*			Load CSS Styles			*/
/*----------------------------------*/

// Load Login CSS Submited Via Admin
function clafc_load_login_css_from_admin() { 
	
	if ( is_multisite() ) {
		$clafc_custom_css_option = get_blog_option( SITE_ID_CURRENT_SITE, 'clafc_custom_css' );
	}
	else {
		$clafc_custom_css_option = get_option( 'clafc_custom_css' );
	}
	
	// Check if Load CSS is checked
	if ( !((isset($clafc_custom_css_option['load_login_css'])) && (boolval($clafc_custom_css_option['load_login_css']))) ) {
		return;
	}
	
	// Get the CSS
	$clafc_login_css_content = isset( $clafc_custom_css_option['clafc_login_css'] ) && ! empty( $clafc_custom_css_option['clafc_login_css'] ) ? $clafc_custom_css_option['clafc_login_css'] : '' ; 
	
	// Check if minify is on
	$minify = ( (isset($clafc_custom_css_option['minify_login_css'])) && (boolval($clafc_custom_css_option['minify_login_css'])) ) ? true : false;
	
	// Clean CSS
	$clafc_login_css_content = clafc_prepare_css($clafc_login_css_content, $minify);
	
	?>
    <style type="text/css">
        <?php echo $clafc_login_css_content; ?>
    </style><?php
}
add_filter( 'login_enqueue_scripts' , 'clafc_load_login_css_from_admin' );


// Load Admin CSS Submited Via Admin
function clafc_load_admin_css_from_admin() { 
	
	if ( is_multisite() ) {
		$clafc_custom_css_option = get_blog_option( SITE_ID_CURRENT_SITE, 'clafc_custom_css' );
	}
	else {
		$clafc_custom_css_option = get_option( 'clafc_custom_css' );
	}
	
	// Check if Load CSS is checked
	if ( !((isset($clafc_custom_css_option['load_admin_css'])) && (boolval($clafc_custom_css_option['load_admin_css']))) ) {
		return;
	}
	
	// Get the CSS
	$clafc_admin_css_content = isset( $clafc_custom_css_option['clafc_admin_css'] ) && ! empty( $clafc_custom_css_option['clafc_admin_css'] ) ? $clafc_custom_css_option['clafc_admin_css'] : '' ; 
	
	// Check if minify is on
	$minify = ( (isset($clafc_custom_css_option['minify_admin_css'])) && (boolval($clafc_custom_css_option['minify_admin_css'])) ) ? true : false;
	
	// Clean CSS
	$clafc_admin_css_content = clafc_prepare_css($clafc_admin_css_content, $minify);
	
	?>
    <style type="text/css">
        <?php echo $clafc_admin_css_content; ?>
    </style><?php 
}
add_filter( 'admin_enqueue_scripts' , 'clafc_load_admin_css_from_admin' );


// Load Front-end CSS Submited Via Admin
function clafc_load_frontend_css_from_admin() { 
	
	if ( is_multisite() ) {
		$clafc_custom_css_option = get_blog_option( SITE_ID_CURRENT_SITE, 'clafc_custom_css' );
	}
	else {
		$clafc_custom_css_option = get_option( 'clafc_custom_css' );
	}
	
	// Check if Load CSS is checked
	if ( !((isset($clafc_custom_css_option['load_frontend_css'])) && (boolval($clafc_custom_css_option['load_frontend_css']))) ) {
		return;
	}
	
	// Get the CSS
	$clafc_frontend_css_content = isset( $clafc_custom_css_option['clafc_frontend_css'] ) && ! empty( $clafc_custom_css_option['clafc_frontend_css'] ) ? $clafc_custom_css_option['clafc_frontend_css'] : '' ; 
	
	// Check if minify is on
	$minify = ( (isset($clafc_custom_css_option['minify_frontend_css'])) && (boolval($clafc_custom_css_option['minify_frontend_css'])) ) ? true : false;
	
	// Clean CSS
	$clafc_frontend_css_content = clafc_prepare_css($clafc_frontend_css_content, $minify);
	
	?>
    <style type="text/css">
        <?php echo $clafc_frontend_css_content; ?>
    </style><?php 
}
add_filter( 'wp_enqueue_scripts' , 'clafc_load_frontend_css_from_admin' );

/**
 * A function to clean up and optionally minify CSS before use
 *
 * @since	1.3
 */
function clafc_prepare_css($css, $minify) {
	$css = wp_kses( $css, array( '\'', '\"' ) );
	$css = str_replace( '&gt;', '>', $css );
	
	if ($minify === true) {
		$css = clafc_csstidy_helper($css, true);
	}
	
	return $css;
}