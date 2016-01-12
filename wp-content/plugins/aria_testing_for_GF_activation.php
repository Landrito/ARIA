<?php
/*
Plugin Name: Aria: Testing for Gravity Forms
Plugin URI: http://google.com
Description: Checks to see if the Gravity Forms plugin is enabled.  
Author: Wes
Version: 1.2
Author URI: http://wkepke.com
*/


function aria_add_admin_notice_success() {
	?>
	<div class="updated notice">
		<p>
			<?php
			_e('ARIA: Testing for Gravity Forms plugin has been successfully activated.'); 
			?>
		</p>
	</div>
	<?php
}

function aria_add_admin_notice_error() {
	?>
	<div class="error notice">
		<p>
			<?php
			_e('ARIA: Testing for Gravity Forms was not acivated; please activate the Gravity Forms plugin.'); 
			?>
		</p>
	</div>
	<?php
}

function aria_activation_func_GF() {
	require_once(ABSPATH . 'wp-admin/includes/plugin.php');
	if (!is_plugin_active('gravityforms/gravityforms.php')) {  	
		add_action('admin_notices', 'aria_add_admin_notice_error');
		do_action('admin_init');
		exit();   
	}
}



/*
this works all the time
add_action('admin_notices', 'aria_add_admin_notice_error'); 
function aria_add_admin_notice_error() {
	if (!is_plugin_active('gravityforms/gravityforms.php')) { 
		echo '<div class="error">
				<p>ARIA: Testing for Gravity Forms was not acivated; 
				please activate the Gravity Forms plugin.</p>
				</div>';  
		}
}
*/

/*
function aria_activation_func() {
	require_once(ABSPATH . 'wp-admin/includes/plugin.php');
	if (!is_plugin_active('gravityforms/gravityforms.php')) {  	
		add_action('admin_notices', 'aria_add_admin_notice_error'); 
		//do_action('admin-notices');
		//die(); 
	}
}
*/
register_activation_hook(__FILE__, 'aria_activation_func_GF'); 
?>