<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://codezel.com/
 * @since      1.0.0
 *
 * @package    RewriteSlugs
 * @subpackage RewriteSlugs/admin
 */


/**
 * Save Meta options
 * @return 
 */
if( !function_exists( 'cwrs_save_meta_data' ) ) {
	function cwrs_save_meta_data($post_id = '') {
	
		if (!is_admin()) {
			return;
		}

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

	}
	add_action('save_post','cwrs_save_meta_data');
}


/**
 * @init            rewrite Admin Menu init
 * @package         Rewrite Slug
 * @subpackage      combo-wp-rewrite-slugs/admin/partials
 * @since           1.0
 * @desc            This Function Will Produce All Tabs View.
 */
if( !function_exists('cwrs_admin_menu') ) {
	add_action( 'admin_menu', 'cwrs_admin_menu' );
	function cwrs_admin_menu() {
		 add_submenu_page('tools.php', esc_html__('Rewrite Slugs', 'combo-wp-rewrite-slugs'), esc_html__('Rewrite Slugs', 'combo-wp-rewrite-slugs'), 'manage_options', 'rewrite_settings', 'cwrs_slugs_admin_page', '', '10'
        );
		
	}
}

/**
 * @init            RewriteSlugs Admin Page
 * @package         Rewrite Slug
 * @subpackage      combo-wp-rewrite-slugs/admin/partials
 * @since           1.0
 * @desc            This Function Will Produce All Tabs View.
 */
if( !function_exists('cwrs_slugs_admin_page') ) {
	function cwrs_slugs_admin_page() {
		$protocol = is_ssl() ? 'https' : 'http';
		$post_args	= array( '_builtin' => false, 
							 'publicly_queryable' => true, 
							 'show_ui' => true 
						 );

		$term_args	= array( '_builtin' => false, 
						 'publicly_queryable' => true, 
						 'show_ui' => true 
					 );

		$taxonomies = get_taxonomies( $term_args, 'objects' ); 
		$post_types = get_post_types( $post_args,'objects' );
		$settings 	= (array) get_option( 'cwrs_slugs_settings' );
		$wproles 	= get_editable_roles();
		
		ob_start();
		?>
		<div id="cwrs-main" class="cwrs-main cwrs-addnew">
			<div class="wrap">
				<div id="cwrs-tab1s" class="cwrs-tabs">
					<div class="cwrs-tabscontent">
						<div id="cwrs-main" class="cwrs-main cwrs-features settings-main-wrap">
							<div class="cwrs-featureswelcomebox">
								<figure><img src="<?php echo RewriteSlugsGlobalSettings::get_plugin_url();?>/admin/images//welcome/logo.png" alt="<?php esc_html_e('logo','combo-wp-rewrite-slugs');?>"></figure>
								<div class="cwrs-welcomecontent">
									<h3><?php esc_html_e('Welcome to rewrite custom post type slugs','combo-wp-rewrite-slugs');?></h3>
									<div class="cwrs-description">
										<p><?php esc_html_e("The plugin will allow the admin to rewrite slugs of all registered custom post types, taxonomies and user roles. Please don't use WordPress reserved words. You can check below link.",'combo-wp-rewrite-slugs');?></p>
										<p><a target="_blank" href="https://codex.wordpress.org/Reserved_Terms"><?php esc_html_e("WordPress reserved words",'combo-wp-rewrite-slugs');?></a><p>
									</div>
								</div>
							</div>
							<div class="cwrs-featurescontent">
								<div class="cwrs-twocolumns">
									<div class="cwrs-content">
										<div class="cwrs-boxarea">
											<?php if( !empty( $post_types ) || !empty( $taxonomies )){?>
												<form method="post" class="save-settings-form rewrite-form">
													<?php if( !empty( $post_types )){?>
														<div class="cwrs-title">
															<h3><?php esc_html_e('Custom post types','combo-wp-rewrite-slugs');?></h3>
														</div>
														<div class="cwrs-contentbox">
															<?php foreach ($post_types as $key => $post_type) {?>
																<div class="cwrs-privacysetting">
																	<span class="cwrs-tooltipbox">
																		<i>?</i>
																		<span class="tooltiptext"><?php esc_html_e("Leave it empty to use default slug. Use only slugs. Do not write with space and special characters. You can use hyphen ( - ) and underscore ( _ )",'combo-wp-rewrite-slugs');?></span>
																	</span>
																	<span><?php echo esc_attr($post_type->label);?></span>
																	<div class="sp-input-setting">
																		<div class="form-group">
																			<input type="text" name="settings[post][<?php echo esc_attr( $key );?>]" class="form-control" value="<?php echo  !empty( $settings['post'][$key] ) ?  esc_attr( $settings['post'][$key] ) : '';?>">
																		</div>
																	</div>
																</div>
															<?php }?>
													   </div>
													<?php }?>	
													<?php if( !empty( $taxonomies )){?>
														<div class="cwrs-title cwrs-terms-title">
															<h3><?php esc_html_e('Custom Taxonomies','combo-wp-rewrite-slugs');?></h3>
														</div>
														<div class="cwrs-contentbox">
															<?php foreach ($taxonomies as $key => $term) {?>
																<div class="cwrs-privacysetting">
																	<span class="cwrs-tooltipbox">
																		<i>?</i>
																		<span class="tooltiptext"><?php esc_html_e("Leave it empty to use default slug. Use only slugs. Do not write with space and special characters. You can use hyphen ( - ) and underscore ( _ )",'combo-wp-rewrite-slugs');?></span>
																	</span>
																	<span><?php echo esc_attr($term->label);?></span>
																	<div class="sp-input-setting">
																		<div class="form-group">
																			<input type="text" name="settings[term][<?php echo esc_attr( $key );?>]" class="form-control" value="<?php echo  !empty( $settings['term'][$key] ) ?  esc_attr( $settings['term'][$key] ) : '';?>">
																		</div>
																	</div>
																</div>
															<?php }?>
														</div>
													<?php }?>
													
												    <?php if( !empty( $wproles )){?>
														<div class="cwrs-title cwrs-terms-title">
															<h3><?php esc_html_e('User Roles','combo-wp-rewrite-slugs');?></h3>
														</div>
														<div class="cwrs-contentbox">
															<?php foreach ($wproles as $key => $role) {?>
																<div class="cwrs-privacysetting">
																	<span class="cwrs-tooltipbox">
																		<i>?</i>
																		<span class="tooltiptext"><?php esc_html_e("Leave it empty to use default slug. Use only slugs. Do not write with space and special characters. You can use hyphen ( - ) and underscore ( _ )",'combo-wp-rewrite-slugs');?></span>
																	</span>
																	<span><?php echo esc_attr($role['name']);?></span>
																	<div class="sp-input-setting">
																		<div class="form-group">
																			<input type="text" name="settings[role][<?php echo esc_attr( $key );?>]" class="form-control" value="<?php echo  !empty( $settings['role'][$key] ) ?  esc_attr( $settings['role'][$key] ) : '';?>">
																		</div>
																	</div>
																</div>
															<?php }?>
														</div>
													<?php }?>		
													
													<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary save-data-settings" value="Save Changes"></p>
												</form>
											<?php }?>
										</div>
									</div>
								</div>
								<div class="cwrs-socialandcopyright">
									<span class="cwrs-copyright"><?php echo date('Y');?>&nbsp;<?php esc_html_e('All Rights Reserved','combo-wp-rewrite-slugs');?> &copy; <a target="_blank"  href="http://codezel.com/"><?php esc_html_e('CodeZel','combo-wp-rewrite-slugs');?></a></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		echo ob_get_clean();
	}
}


/**
 * @init            Save rewrite slugs
 * @package         Rewrite Slug
 * @subpackage      combo-wp-rewrite-slugs/admin/partials
 * @since           1.0
 * @desc            This Function Will Produce All Tabs View.
 */
if (!function_exists('cwrs_set_custom_rewrite_rule')) {
	function cwrs_set_custom_rewrite_rule() {
		global $wp_rewrite;
		$settings = (array) get_option( 'cwrs_slugs_settings' );
		
		if( !empty( $settings['post'] ) ){
			foreach ( $settings['post'] as $post_type => $slug ) {
				if(!empty( $slug)){
					$args = get_post_type_object($post_type);
					$args->rewrite["slug"] = $slug;
					register_post_type($args->name, $args);
				}
			}
		}

		if( !empty( $settings['term'] ) ){
			foreach ( $settings['term'] as $term => $slug ) {
				if(!empty( $slug ) ){
					$tax = get_taxonomy($term);
					$tax->rewrite["slug"] = $slug;
					register_taxonomy($term, $tax->object_type[0],(array)$tax);
				}
			}
		}

		$wp_rewrite->flush_rules();
	} 
	add_action('init', 'cwrs_set_custom_rewrite_rule');
}

/**
 * @Save settings
 * @return {}
 */
if (!function_exists('cwrs_save_settings')) {
	function  cwrs_save_settings(){
		$settings = isset( $_POST['settings'] ) ? (array)$_POST['settings'] : array();
		$settings	= cwrs_recursive_array_fields_data($settings);

		$json		= array();
		
		update_option( 'cwrs_slugs_settings', $settings, true );
		flush_rewrite_rules();
		
		$json['type']		= 'success';	
		$json['message']	= esc_html__('Settings updated','combo-wp-rewrite-slugs' );
		echo json_encode( $json );
		die;	
	}
	add_action('wp_ajax_rewrite_save_settings', 'cwrs_save_settings');	
}


/**
 * @Recursive array data escape
 * @return {}
 */
if (!function_exists('cwrs_recursive_array_fields_data')) {
	function cwrs_recursive_array_fields_data($array) {
		foreach ( $array as $key => &$value ) {
			if ( is_array( $value ) ) {
				$value = cwrs_recursive_array_fields_data($value);
			}else {
				$value = sanitize_text_field( $value );
			}
		}

		return $array;
	}
}

/**
 * @Admin Menu 
 * @return 
 */
if (!function_exists('cwrs_options_page')) {
	add_action('admin_bar_menu', 'cwrs_options_page', 1000);
	function cwrs_options_page(){
		global $wp_admin_bar;
		if(!is_super_admin() || !is_admin_bar_showing()) return;
		
		$url = admin_url();
		if ( function_exists('fw_get_db_post_option') ) {
			// Add Parent Menu
			$argsParent	= array(
				'id' => 'rewrite_setting',
				'title' => esc_html__('Rewrite Slugs','combo-wp-rewrite-slugs'),
				'href' => esc_url( $url.'tools.php?page=rewrite_settings' ),
			);

			$wp_admin_bar->add_node( $argsParent );	
		}
	}
}



/**
 * @get author slugs
 * @return {}
 */
if ( ! function_exists( 'cwrs_get_users_base_slug' ) ) {
	function cwrs_get_users_base_slug(){
		$settings = (array) get_option( 'cwrs_slugs_settings' );
		
		$author_slug = 'author'; // change slug name
		$author_levels	= array($author_slug);
		
		if( !empty( $settings['role'] ) ) {
		  $author_levels	= $author_levels;
		  $counter	= 0;
		  foreach ($settings['role'] as $key => $role) {
			 $author_levels[]	= $role;
		  }	
		}
        
		return $author_levels;
	}
}

/**
 * @prepare auhtor slugs
 * @return {}
 */
if ( ! function_exists( 'cwrs_prepare_users_base' ) ) {	
	add_action( 'init', 'cwrs_prepare_users_base' );
	function cwrs_prepare_users_base(){
		global $wp_rewrite;
		$author_levels = cwrs_get_users_base_slug();
		
		// Define the tag and use it in the rewrite rule
		add_rewrite_tag( '%author_level%', '(' . implode( '|', $author_levels ) . ')' );
		$wp_rewrite->author_base = '%author_level%';
		$wp_rewrite->flush_rules();
	}
}

/**
 * @refine author base if username and base matched eg : anything/anything
 * @return {}
 */
if ( ! function_exists( 'cwrs_author_rewrite_rules' ) ) {	
	add_filter( 'author_rewrite_rules', 'cwrs_author_rewrite_rules' );
	function cwrs_author_rewrite_rules( $author_rewrite_rules ){
		foreach ( $author_rewrite_rules as $pattern => $substitution ) {
			if ( FALSE === strpos( $substitution, 'author_name' ) ) {
				unset( $author_rewrite_rules[$pattern] );
			}
		}
		return $author_rewrite_rules;
	}
}

/**
 * @refine author base if username and base matched eg : anything/anything
 * @return {}
 */
if ( ! function_exists( 'cwrs_get_user_refined_link' ) ) {
	add_filter( 'author_link', 'cwrs_get_user_refined_link', 10, 3 );
	function cwrs_get_user_refined_link( $link, $author_id, $author_nicename ){
		$author_level = esc_html__('author','combo-wp-rewrite-slugs');
		$settings = (array) get_option( 'cwrs_slugs_settings' );
		$data = get_userdata($author_id);
		
		if ( !empty($data->roles[0]) && !empty( $settings['role'] ) && array_key_exists($data->roles[0], $settings['role'])) {
			$slug 	 = !empty( $settings['role'][$data->roles[0]] ) ?  $settings['role'][$data->roles[0]] : '';
			
			if( !empty( $slug ) ){
				$author_level = $slug;
			}
		}
		
		if( !empty( $author_level ) ){
			$link = str_replace( '%author_level%', $author_level, $link );
		}
		
		return $link;
	}
}

