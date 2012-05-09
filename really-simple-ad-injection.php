<?php
/**
 * @package RSAI
 * @version 0.120508
 */
/*
Plugin Name: Really Simple Ad Injection
Plugin URI: http://exclusivewp.com/really-simple-ad-injection/
Author: Purwedi Kurniawan
Author URI: http://exclusivewp.com
Version: 0.120508
Description:  Really Simple Ad Injection plugin will help you automatically inject any kind of ad code inside your post content. <a href="options-general.php?page=rsai">Configure...</a>
*/
/**
 * install and uninstall rsai plugin
**/
register_activation_hook(__file__,'pk_rsai_admin_activation');
register_deactivation_hook(__file__,'pk_rsai_admin_deactivation');
function pk_rsai_admin_activation(){
 	pk_rsai_get_admin_options( false );
}
function pk_rsai_admin_deactivation(){
	delete_option('rsai_options');
}
/**
 * add new menu into WordPress admin menu
**/ 
add_action('admin_menu','pk_rsai_admin_menu_hook');
function pk_rsai_admin_menu_hook(){
    if (function_exists('add_options_page')) {
		add_options_page(
			'Really Simple Ad Injection',
			'Really Simple Ad Injection',
			'manage_options',
			'rsai',
			'pk_rsai_admin_menu'
		);
	}
}

/**
 * Init plugin options to white list our options
 **/
add_action('admin_init', 'pk_rsai_options_init' );
function pk_rsai_options_init(){
	register_setting( 'rsai', 'rsai_options', 'pk_rsai_validate_options' ); 
}

/** 
 * Sanitize and validate input. Accepts an array, return a sanitized array. 
 **/
function pk_rsai_validate_options( $input ) {	
	$input['align'] = intval($input['align']) ;
	$input['paragraph_no'] = addslashes(stripslashes($input['paragraph_no'])); 	
	$input['ad_code'] = addslashes(stripslashes($input['ad_code']));

	return $input;
}

/**
 * admin options, set default values if empty
 **/
function pk_rsai_get_admin_options( $return = true ){
	$options = array(
		  'align' => 0,
		  'paragraph_no' => 2,
		  'ad_code' => ''	  
	  );
	$current_options = get_option('rsai_options');
	if (!empty($current_options)) {
	  foreach ($current_options as $key => $option)
		$options[$key] = $option;
	}
	update_option('rsai_options', $options);
	if ( $return ) return $options;
}

/**
 * framework to handle the admin form
**/ 
function pk_rsai_admin_menu(){	
	pk_rsai_admin_print_admin_page();	
}
/**
 * print admin page
**/
function pk_rsai_admin_print_admin_page(){
?>

<div class = "wrap">
<div class="icon32" id="icon-options-general"> <br>
</div>
<h2>
  <?php _e('Really Simple Ad Injection','rsai'); ?>
</h2>
<div>
  <p> If you think this plugin useful, please consider making a <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=F8M5PLWSHWYNG" target="_blank">donation</a> or write a review about it or at least give it a good rating on <a href="http://wordpress.org/extend/plugins/really-simple-ad-injection/" target="_blank">WordPress.org</a>.</p>
</div>
<div class="postbox-container" style="width: 100%;">
<div class="metabox-holder">
<div class="meta-box-sortables ui-sortable">
<form id="rsai-options" method="post" action="options.php">
<?php //delete_option('rsai_options'); ?>
<?php settings_fields('rsai'); ?>
<?php $options = pk_rsai_get_admin_options(); ?>
<div id="seo_alrp_auto_links_settings" class="postbox">
  <div class="handlediv"> <br />
  </div>
  <h3 class="hndle"> <span> Really Simple Ad Injection </span></h3>
  <div class="inside">
    <div style="padding: 0 10px;">
      <table class="form-table">
        <tbody
          <tr valign="top">
            <th scope="row" style="width:25%"><label for="rsai_options[align]">
                <?php _e('Ad block position: ','rsai'); ?>
              </label></th>
            <td><input type="radio" name="rsai_options[align]" id="rsai_options[align]" value="0" <?php checked( $options['align'], 0 ); ?> />
              Left<br />
              <input type="radio" name="rsai_options[align]" id="rsai_options[align]" value="1" <?php checked( $options['align'], 1 ); ?> />
              Right<br />
              <input type="radio" name="rsai_options[align]" id="rsai_options[align]" value="2" <?php checked( $options['align'], 2 ); ?> />
              Center </td>
          </tr>
          <tr valign="top">
            <th scope="row"><label for="rsai_options[paragraph_no]">
                <?php _e('Place ad after paragraph no: ','rsai'); ?>
              </label></th>
            <td><input type="text" name="rsai_options[paragraph_no]" id="rsai_options[paragraph_no]" size="5" value="<?php echo $options['paragraph_no']; ?>">
              <?php _e('Type <strong>rand</strong> if you want to randomize the ad position, or a number for specific location. <br />For example if you put 2, then the ad code will be added between paragraph 2 and 3. ','rsai'); ?></td>
          </tr>
          <tr valign="top">
            <th scope="row"><label for="rsai_options[ad_code]">
                <?php _e('Paste your ad code here: ','rsai'); ?>
              </label>
            </th>
            <td><textarea id="rsai_options[ad_code]" name="rsai_options[ad_code]" cols="75" rows="10" ><?php echo stripslashes( $options['ad_code'] ); ?></textarea></td>
           </tr>
        </tbody>
      </table>
      <p>
        <input class="button-primary" type="submit" name="rsai_save" id="rsai_save" value="Save Options" />
      </p>
    </div>
  </div>
</div>
</div>
</div>
  <div class="postbox-container" style="width: 100%;">
    <div class="metabox-holder">
      <div id="seo-alrp-copyright" class="postbox">
        <div class="inside">
          <div class="frame" style="text-align:center">
            <p><strong>Recommended SEO plugins: <a href="http://9cab9omg4qgd8r98wbjl1jucfe.hop.clickbank.net/?tid=alrp" target="_blank">Indexing Tool</a> | <a href="http://ed94dfjezefg9u0nhg0qgewkvu.hop.clickbank.net/?tid=alrp" target="_blank">SEOPressor</a> | <a href="http://5508coi61qlh0mco1k9jkcqk4z.hop.clickbank.net/?tid=alrp" target="_blank">WPSyndicator</a></strong></p>
            <p>Copyright &copy; 2011 by Purwedi Kurniawan. Feel free to <a href="http://exclusivewp.com/contact/" target="_blank">contact me</a> if you need help with the plugin.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php
}

/**
 * main function to inject ad code inside post content
 **/
function pk_rsai_ad_injection( $content ){
    if ( is_single() ){
		$options = get_option( 'rsai_options' );
		if ( 0 == intval($options['align']) ){
			$align = '<div style="float: left; margin: 0px 10px 5px 0px;">';
		} elseif( 1 == intval($options['align']) ){
			$align = '<div style="float: right; margin: 0px 0px 5px 10px;">';
		} elseif( 2 == intval($options['align']) ){
			$align = '<div style="text-align:center; margin: 10px auto;">';
		} 
		
		$paragraphs = explode( '</p>',$content );
		if ( 'rand'==$options['paragraph_no'] ){
			$i = mt_rand(1, count($paragraphs)-1);
		} elseif ( 0 < intval( $options['paragraph_no'] ) ){
			$i = intval( $options['paragraph_no'] );						 	
		}
		
		$ix = 1; $temp = '';
		foreach( $paragraphs as $p )	{ 
			$temp .= $p.'</p>'; 
			if ( $ix == $i )
				$temp .= $align.stripslashes($options['ad_code']).'</div>';     
			$ix += 1;
		}
		$temp = substr( $temp,0,strlen($temp)-4 );
		$content = $temp;
	} 
	return $content;    
}    
add_filter('the_content','pk_rsai_ad_injection');    
?>