<?php
/**
 * @author Divi Space
 * @copyright 2017
 */

if (!defined('ABSPATH')) die();

function ds_ct_enqueue_parent() { wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' ); }

function ds_ct_loadjs() {
	wp_enqueue_script( 'ds-theme-script', get_stylesheet_directory_uri() . '/ds-script.js',
        array( 'jquery' )
    );
}

add_action( 'wp_enqueue_scripts', 'ds_ct_enqueue_parent' );
add_action( 'wp_enqueue_scripts', 'ds_ct_loadjs' );

include('login-editor.php');

function wm_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(https://wavelengthmedia.ca/wp-content/uploads/2022/10/wavelength-media-SHAPES.png);
		height:83px;
		width:300px;
		background-size: 300px 83px;
		background-repeat: no-repeat;
        	padding-bottom: 30px;
        }
        body.login {
            background: #FFF;
        }
        .login form {
            background: #f2f2f2 !important;
			border-radius: 6px !important;
        }
        .login #backtoblog a, .login #nav a {
            text-decoration: none;
            color: #FFF !important;
        }
        .login label {
            color:#000;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'wm_login_logo' );

//add_filter( 'gform_submit_button', 'wm_gf_submit_button', 10, 2 );
function wm_gf_submit_button( $button, $form ) {
    return "<button class='et_pb_button gform_button' id='gform_submit_button_{$form['id']}'><span>Submit</span></button>";
}

?>