<?php

/**
 * Plugin Name: Design Experiments
 * Plugin URI: https://github.com/wordpress/design-experiments/
 * Description: WP-Admin design experiments from the WordPress.org Design Team
 * Version: 0.1
 * Author: The WordPress.org Design Team
 */

/**
 * Register all the experiments.
 */
$design_experiments = array(
	array( 'default_stylesheet', 'style.css', 'Default Plugin Stylesheet' ),
	array( 'test_stylesheet', 'test.css', 'Test Stylesheet' )
); 

foreach ( $design_experiments as $design_experiment ) {
	echo $design_experiment[0];
}


/**
 * Set up a WP-Admin page for managing turning on and off plugin features.
 */
function design_experiments_add_settings_page() {
	add_options_page('Design Experiments', 'Design Experiments', 'manage_options', 'design-experiments', 'design_experiments_settings_page');

	// Call register settings function
	add_action( 'admin_init', 'design_experiments_settings' );
}
add_action('admin_menu', 'design_experiments_add_settings_page');


/**
 * Register settings for the WP-Admin page.
 */
function design_experiments_settings() {
	global $design_experiments; 

	foreach ( $design_experiments as $design_experiment ) {
		register_setting( 'design-experiments-settings', $design_experiment[0] );
	}
}


/**
 * Build the WP-Admin settings page.
 */
function design_experiments_settings_page() { 
	global $design_experiments; ?>

	<div class="wrap">
	<h1><?php _e('Design Experiments'); ?></h1>

	<form method="post" action="options.php">
		<?php settings_fields( 'design-experiments-settings' ); ?>
		<?php do_settings_sections( 'design-experiments-settings' ); ?>

		<?php foreach ( $design_experiments as $design_experiment ) { ?>
			<table class="form-table">
				<tr valign="top">
				<td>
					<label for="<?php echo $design_experiment[0]; ?>">
						<input name="<?php echo $design_experiment[0]; ?>" type="checkbox" value="1" <?php checked( '1', get_option( $design_experiment[0] ) ); ?> />
						<?php echo $design_experiment[2]; ?>
					</label>
				</td>
		<?php } ?>
				</tr>
			</table>

		<?php submit_button(); ?>
	</form>
	</div>
<?php }


/**
 * Enqueue Stylesheets.
 */
function design_experiments_enqueue_stylesheets() {
	global $design_experiments;

	foreach ( $design_experiments as $design_experiment ) {

		if ( get_option( $design_experiment[0] ) == 1 ) {
			wp_register_style( $design_experiment[0], plugins_url( $design_experiment[1], __FILE__ ), false, '1.0.0' );
			wp_enqueue_style( $design_experiment[0] );
		}

	}

}
add_action( 'admin_enqueue_scripts', 'design_experiments_enqueue_stylesheets' );