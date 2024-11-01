<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://nearchx.com
 * @since      1.0.0
 *
 * @package    Wordcounter
 * @subpackage Wordcounter/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wordcounter
 * @subpackage Wordcounter/admin
 * @author     NearchX <contact@nearchx.com>
 */
class Wordcounter_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action( 'admin_init', array( $this, 'wordcounter_register_settings' ));
		add_action('admin_menu', array( $this, 'wordcounter_register_options_page' ));

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wordcounter_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wordcounter_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wordcounter-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wordcounter_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wordcounter_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wordcounter-admin.js', array( 'jquery' ), $this->version, false );

	}

	function wordcounter_register_settings() {
		add_option( 'wordcounter_counter_position', 'top');
		add_option( 'wordcounter_counter_show_word_count', '1');
		add_option( 'wordcounter_counter_show_reading_time', '1');
		add_option( 'wordcounter_counter_show_powered_by', '0');
		register_setting( 'wordcounter_options_group', 'wordcounter_counter_position');
		register_setting( 'wordcounter_options_group', 'wordcounter_counter_show_word_count', array( $this, 'wordcounter_counter_checkbox_callback' ) );
		register_setting( 'wordcounter_options_group', 'wordcounter_counter_show_reading_time', array( $this, 'wordcounter_counter_checkbox_callback' ) );
		register_setting( 'wordcounter_options_group', 'wordcounter_counter_show_powered_by', array( $this, 'wordcounter_counter_checkbox_callback' ) );		
  }

	function wordcounter_register_options_page() {
  	add_options_page('Word Counter Settings', 'Word Counter', 'manage_options', 'wordcounter', array( $this, 'wordcounter_options_page' ));
	}

	function wordcounter_counter_checkbox_callback( $input ) {
		if (is_null($input)) {
			return "0";
		} else {
			return $input;
		}	
	}

	function wordcounter_options_page() { 
	 	?>
	 		<div class="wrap">
	 			<h1>Word Counter Settings</h1>
	 			<form method="post" action="options.php" id="wordcounter_options_form_submit">
	 				<?php settings_fields( 'wordcounter_options_group' ); ?>
					
					<table class="form-table" role="presentation">
						<tbody>
							<tr>
								<th scope="row">
									<label for="wordcounter_counter_position">Word Counter Position</label>
								</th>
								<td>
									<?php $selected_option = get_option('wordcounter_counter_position'); ?>
									<select name="wordcounter_counter_position" id="wordcounter_counter_position" aria-describedby="wordcounter_counter_position_description">
										<option value="top" <?php echo $selected_option == "top" ? 'selected="selected"' : '' ?> >Top</option>
										<option value="bottom" <?php echo $selected_option == "bottom" ? 'selected="selected"' : '' ?>>Bottom</option>
									</select>
									<p class="description" id="wordcounter_counter_position_description">The position where the Word Count and Reading Time will be shown on a post.</p>
								</td>
							</tr>
							<tr>
								<th scope="row">Details to Show</th>
								<td> 
									<fieldset>
										<legend class="screen-reader-text">
											<span>Word Count</span>
										</legend>
										<label for="wordcounter_counter_show_word_count">
											<input name="wordcounter_counter_show_word_count" type="checkbox" id="wordcounter_counter_show_word_count"  value="1" <?php echo get_option('wordcounter_counter_show_word_count') == "1" ? 'checked="checked"' : '' ?>>
											Word Count
										</label>
									</fieldset>
									<fieldset>
										<legend class="screen-reader-text">
											<span>Reading Time</span>
										</legend>
										<label for="wordcounter_counter_show_reading_time">
											<input name="wordcounter_counter_show_reading_time" type="checkbox" id="wordcounter_counter_show_reading_time" value="1" <?php echo get_option('wordcounter_counter_show_reading_time') == "1" ? 'checked="checked"' : '' ?>>
											Reading Time
										</label>
									</fieldset>
								</td>
							</tr>
							<tr>
								<th scope="row">Extra</th>
								<td> 
									<fieldset>
										<legend class="screen-reader-text">
											<span>Show Powered By</span>
										</legend>
										<label for="wordcounter_counter_show_powered_by">
											<input name="wordcounter_counter_show_powered_by" type="checkbox" id="wordcounter_counter_show_powered_by"  value="1" <?php echo get_option('wordcounter_counter_show_powered_by') == "1" ? 'checked="checked"' : '' ?>>
											Show Powered By
										</label>
									</fieldset>
								</td>
							</tr>
						</tbody>
					</table>

					<?php
						$other_attributes = array( 'id' => 'wordcounter_options_form_submit' );
						submit_button( __( 'Save Changes', 'textdomain' ), "primary", "wordcounter_options_form_submit", true, $other_attributes);
					?>
	 			</form>
	 		</div>	
	 	<?php
	} 
}
