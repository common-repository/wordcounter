<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wordcounter
 * @subpackage Wordcounter/public
 * @author     NearchX <contact@nearchx.com>
 */
class Wordcounter_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wordcounter-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wordcounter-public.js', array( 'jquery' ), $this->version, false );

	}

	public function wordcounter_content_runner($content) {
		// Only do this when a single post is displayed
		if ( is_single() ) { 

			$text_content = wordcounter_remove_uncountable_characters_from_text($content);
			$word_count = wordcounter_count_words($text_content);
			$reading_time = wordcounter_count_reading_time($word_count);

			$reading_time_content = "";
			if (get_option('wordcounter_counter_show_reading_time') == "1") {
				$reading_time_content = $reading_time . " to read";
			}
	
			$word_count_content = "";
			if (get_option('wordcounter_counter_show_word_count') == "1") {
				$word_count_content = $word_count . " words";
			}

			$powered_by = "";
			if (get_option('wordcounter_counter_show_powered_by') == "1") {
				$powered_by = '<span style="font-size: 0.5rem">Powered by <a href="https://wordcounter.world" rel="nofollow" target="_blank">word counter</a></span>';
			}

			$wordcount_msg = '
				<p class="has-text-align-center" style="display: flex; flex-direction: column;">
					<span>'. implode(", ", array_filter([$reading_time_content, $word_count_content]))  . '</span>
					'. $powered_by .'
				</p>
			';

			$word_count_msg_position = get_option('wordcounter_counter_position');
			if ($word_count_msg_position == "top") {
				$content = $wordcount_msg . $content;
			} else {
				$content = $content . $wordcount_msg;
			}		
		} 
		
		return $content; 
	}

}
