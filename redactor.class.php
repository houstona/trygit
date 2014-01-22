<?php
/**
 * Plugin Name: Wordpress Redactor Editor
 * Description: Replaces Wordpress editor with Redactor.
 * Version: 1.0
 * Author: Revel
 * Author URI: http://www.revel.in
 */

class Redactor {

	public function __construct() {
		add_filter( 'user_can_richedit', '__return_false' );
		add_action('admin_enqueue_scripts', array($this, 'redactor_js'));
		add_action('admin_enqueue_scripts', array($this, 'redactor_css'));
		add_action('edit_form_after_editor', array($this, 'add_redactor'));
		remove_filter( 'the_content', 'wpautop' );
		remove_filter( 'the_excerpt', 'wpautop' );

	}

	public function add_redactor()
	{
	?>
	
	<script type="text/javascript">
		jQuery(document).ready(
	        function($)
	        {
	                $('textarea#content.wp-editor-area').redactor({
	                	iframe: true,
	                	convertDivs: false
	                });
	                $('#ed_toolbar').remove();
	        }
		);
	</script>

	<?php
	}

	public function redactor_js() {
		$pluginurl = plugin_dir_url(__FILE__);
		wp_enqueue_script( 'redactor', $pluginurl .'redactor/redactor.min.js' );
	}

	public function redactor_css() {
		$pluginurl = plugin_dir_url(__FILE__);
		wp_enqueue_style( 'redactor' , $pluginurl .'redactor/redactor.css' );
	}
}

global $pagenow;

if($pagenow == 'post.php' || $pagenow == 'post-new.php' ) {
	$redactor = new Redactor();
}

?>