<?php
/***************************
 *
 */
class CatalystConnectFrontend extends CatalystConnect {

	/**
	 * Setup backend functionality in WordPress
	 */
	function CatalystConnectFrontend () {
		CatalystConnect::CatalystConnect ();

		// Add the custom css and Javascript files for the admin page that are 
		// listed in $this->frontend_css and $this->frontend_js vars.
		add_action('wp_enqueue_scripts', array( &$this , 'load_frontend_custom') );

		if ( class_exists( 'BuddyPress' ) && ! $this->get_option('disable_buddypress_connect') ) {
			add_action( 'wp', 'catalyst_connect_buddypress_actions' );

			if ( ! $this->get_option('disable_buddypress_connect_css') ) {
				// Add Catalyst/BuddyPress Custom CSS code
				add_action( 'wp_head', 'catalyst_connect_buddypress_custom_css' );
			}
		}
		/**
		 * Add/Remove Action certain elements to make Catalyst more compatible with BuddyPress
		 */
		function catalyst_connect_buddypress_actions() {
			// Re-position the Catalyst Custom Layout globals so they still take effect when BuddyPress is active
			remove_action( 'wp','catalyst_layout_globals' );
			add_action( 'wp_head','catalyst_layout_globals' );

			if ( defined( 'DYNAMIK_ACTIVE' ) ) {
				// Re-position the Dynamik Stylesheet so it still takes effect when BuddyPress is active
				remove_action( 'template_redirect', 'catalyst_add_stylesheets' );
				add_action( 'wp_head', 'catalyst_add_stylesheets', 1 );
				remove_action( 'catalyst_meta', 'catalyst_default_css', 11 );
			}

			// Wrap the BuddyPress "primary" Div ID around the Catalyst "content-wrap" div
			add_action( 'catalyst_hook_before_content_wrap', 'catalyst_connect_buddypress_open_primary' );
			add_action( 'catalyst_hook_after_content_wrap', 'catalyst_connect_buddypress_close_primary' );
		}

		/**
		 * Echo Custom CSS to address some Catalyst/BuddyPress styling issues
		 */
		function catalyst_connect_buddypress_custom_css() {
echo "\n" . '<!-- Begin Catalyst/BuddyPress Custom CSS -->' . "\n";
echo '<style type="text/css">' . "\n";
echo 'div.item-list-tabs { margin: 25px 0 20px; } div.item-list-tabs#subnav { margin: -15px 0 15px; } .padder div.pagination { margin: -20px 0 0; } form#whats-new-form textarea { width: 97%; } table.forum { margin: 0; } table.forum tr > td:first-child, table.forum tr > th:first-child { padding: 10px 15px; } ul#topic-post-list p { padding: 0 0 20px; } div.dir-search { margin: -29px 0 0; } ul.button-nav li, div#item-header ul li { list-style: none; } ul#topic-post-list { margin: 0 0 15px; } #post-topic-reply { margin: 15px 0 0; } #sidebar-1 .item-options, #sidebar-2 .item-options, #sidebar-1 .avatar-block, #sidebar-2 .avatar-block { padding: 10px 10px 0; } #sidebar-1 .avatar-block, #sidebar-2 .avatar-block { overflow: auto; } #sidebar-1 a img.avatar, #sidebar-2 a img.avatar { margin: 0 10px 10px 0; float: left; padding: 5px; background: #F6F6F6; }  #sidebar-1 ul.item-list, #sidebar-2 ul.item-list { width: auto; padding: 0 10px; } #primary ul.item-list, #primary ul.item-list li { list-style-type: none; } .widget-error { padding: 10px; }' . "\n";
echo '</style>' . "\n";
echo '<!-- End Catalyst/BuddyPress Custom CSS -->' . "\n\n";
		}

		/**
		 * Echo opening BuddyPress "primary" div ID
		 */
		function catalyst_connect_buddypress_open_primary() {
			echo '<div id="primary">' . "\n";
		}

		/**
		 * Echo closing BuddyPress "primary" div ID
		 */
		function catalyst_connect_buddypress_close_primary() {
			echo '</div><!-- end #primary -->' . "\n";
		}
		
		if ( class_exists( 'bbPress' ) && ! $this->get_option('disable_bbpress_connect') ) {
			add_action( 'wp', 'catalyst_connect_bbpress_actions' );

			if ( ! $this->get_option('disable_bbpress_connect_css') ) {
				// Add Catalyst/BBPress Custom CSS code
				add_action( 'wp_head', 'catalyst_connect_bbpress_custom_css' );
			}
		}
		/**
		 * Remove common Catalyst post elements that don't quite fit in the BBPress pages
		 */
		function catalyst_connect_bbpress_actions() {
			if ( is_bbpress() ) {
				remove_action( 'catalyst_hook_before_loop', 'catalyst_build_breadcrumbs' );
				remove_action( 'catalyst_hook_after_post_title', 'catalyst_byline_meta' );
				remove_action( 'catalyst_hook_after_post_content', 'catalyst_post_meta' );
				remove_action( 'catalyst_hook_after_post_content', 'catalyst_post_author_info' );
			}
		}

		/**
		 * Echo Custom CSS to address some Catalyst/BBPress styling issues
		 */
		function catalyst_connect_bbpress_custom_css() {
echo "\n" . '<!-- Begin Catalyst/BBPress Custom CSS -->' . "\n";
echo '<style type="text/css">' . "\n";
echo '.bbPress #content article p, .bbpress #content article p { padding: 0; } .bbPress #content article ul li p, .bbpress #content article ul li p { padding: 0 0 20px; } .bbPress #content article ul, .bbpress #content article ul { padding: 0; } .bbPress #content article ul li, .bbpress #content article ul li { margin: 0; list-style: none; } .bbPress .post-format-icon, .bbpress .post-format-icon { display: none; }' . "\n";
echo '</style>' . "\n";
echo '<!-- End Catalyst/BBPress Custom CSS -->' . "\n\n";
		}
		
		if ( class_exists( 'Woocommerce' ) && ! $this->get_option('disable_woocommerce_connect') ) {
			add_action( 'wp', 'catalyst_connect_woocommerce_actions' );

			if ( $this->get_option('woocommerce_breadcrumbs') == 'cat' ) {
				// Remove WooCommerce breadcrumbs.
				remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
				// Add Catalyst breadcrumbs.
				add_action( 'woocommerce_before_main_content', 'catalyst_build_breadcrumbs', 20, 0);

				add_filter( 'catalyst_archive_crumb', 'catalyst_connect_get_archive_crumb_filter', 10, 2 );
				/**
				 * Filter the Catalyst Breadcrumbs archive crumb
				 */
				function catalyst_connect_get_archive_crumb_filter( $crumb, $args ) {
					if ( is_post_type_archive( 'product') && get_option( 'page_on_front' ) !== woocommerce_get_page_id( 'shop' ) ) {
						$shop_id = woocommerce_get_page_id( 'shop' );
						$shop_name = $shop_id ? get_the_title( $shop_id ) : ucwords( get_option('woocommerce_shop_slug') );

						if ( is_search() ) {
							$crumb = catalyst_connect_get_crumb_link( get_post_type_archive_link( 'product' ), $shop_name, $shop_name, $args['sep'] . __( 'Search results for &ldquo;', 'woocommerce' ) . get_search_query() . '&rdquo;' );
						} else {
							$crumb = catalyst_connect_get_crumb_link( get_post_type_archive_link( 'product' ), $shop_name, $shop_name );
						}

						return apply_filters( 'catalyst_connect_product_archive_crumb', $crumb, $args );
					}

					if ( is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) {
						$crumb = '';
						$prepend = '';
						$shop_url = get_option( 'woocommerce_prepend_shop_page_to_urls' );
						$shop_id = woocommerce_get_page_id( 'shop' );
						$shop_title = get_the_title( $shop_id );

						if ( 'yes' == $shop_url && $shop_id && get_option( 'page_on_front' ) !== $shop_id )
							$prepend = catalyst_connect_get_crumb_link( get_permalink( $shop_id ), $shop_title, $shop_title, $args['sep'] );
					}

					if ( is_tax( 'product_cat' ) ) {
						$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
						$parents = array();
						$parent = $term->parent;
						while ( $parent ):
							$parents[] = $parent;
							$new_parent = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ) );
							$parent = $new_parent->parent;
						endwhile;

						$crumb .= $prepend;

						if ( ! empty( $parents ) ) :
							$parents = array_reverse( $parents );
							foreach ( $parents as $parent ) :
								$item = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ) );
								$crumb .= catalyst_connect_get_crumb_link( get_term_link( $item->slug, 'product_cat' ), $item->name, $item->name, $args['sep'] );
							endforeach;
						endif;

						$crumb .= single_term_title( '', false );

						return $crumb;
					}

					if ( is_tax( 'product_tag' ) ) {
						$crumb .= $prepend . __( 'Products tagged &ldquo;', 'gencwooc' ) . single_term_title( '', false ) . _x( '&rdquo;', 'endquote', 'gencwooc' );

						return $crumb;
					}

					return $crumb;
				}

				add_filter( 'catalyst_single_crumb', 'catalyst_connect_get_single_crumb', 10, 2 );
				/**
				 * Filter the Catalyst Breadcrumbs singular crumb
				 */
				function catalyst_connect_get_single_crumb( $crumb, $args ) {
					if ( is_singular( 'product' ) ) {
						global $post;

						$crumb = '';
						$prepend = '';
						$shop_url = get_option( 'woocommerce_prepend_shop_page_to_urls' );
						$shop_id = woocommerce_get_page_id( 'shop' );
						$shop_title = get_the_title( $shop_id );

						if ( 'yes' == $shop_url && $shop_id && get_option( 'page_on_front' ) !== $shop_id )
							$prepend = catalyst_connect_get_crumb_link( get_permalink( $shop_id ), $shop_title, $shop_title, $args['sep'] );

						$crumb .= $prepend;

						if ( $terms = wp_get_object_terms( $post->ID, 'product_cat' ) ) :
							$term = current( $terms );
							$parents = array();
							$parent = $term->parent;
							while ( $parent ):
								$parents[] = $parent;
								$new_parent = get_term_by( 'id', $parent, 'product_cat' );
								$parent = $new_parent->parent;
							endwhile;

							if( ! empty( $parents ) ):
								$parents = array_reverse( $parents );
								foreach ( $parents as $parent ) :
									$item = get_term_by( 'id', $parent, 'product_cat' );
									$crumb .= catalyst_connect_get_crumb_link( get_term_link( $item->slug, 'product_cat' ), $item->name, $item->name, $args['sep'] );
								endforeach;
							endif;
							$crumb .= catalyst_connect_get_crumb_link( get_term_link( $term->slug, 'product_cat' ), $term->name, $term->name, $args['sep'] );
						endif;

						$crumb .= get_the_title();

						return apply_filters( 'catalyst_connect_single_product_crumb', $crumb, $args );
					}

					return $crumb;
				}

				/**
				 * Helper function to create anchor link for a single crumb.
				 */
				function catalyst_connect_get_crumb_link( $url, $title, $content, $sep = false ) {
					$link = sprintf( '<a href="%s" title="%s">%s</a>', esc_attr( $url ), esc_attr( $title ), esc_html( $content ) );

					if ( $sep )
						$link .= $sep;

					return $link;
				}
			}

			if ( ! $this->get_option('disable_woocommerce_connect_css') ) {
				// Add Catalyst/WooCommerce Custom CSS code
				add_action( 'wp_head', 'catalyst_connect_woocommerce_custom_css' );
			}
		}
		/**
		 * Add/Remove Action certain elements to make Catalyst more compatible with WooCommerce
		 */
		function catalyst_connect_woocommerce_actions() {
			// Remove WooCommerce content wrappers.
			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
			remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

			// Add opening Catalyst content wrappers, organizing them using different hook priorities.
			add_action('woocommerce_before_main_content', create_function('', 'echo "<div id=\"container-wrap\" class=\"clearfix\"><div id=\"container\">";'), 10);
			add_action('woocommerce_before_main_content', create_function('', 'echo "<div id=\"content-sidebar-wrap\">";'), 12);
			add_action('woocommerce_before_main_content', create_function('', 'echo "<div id=\"content-wrap\"><div id=\"content\">";'), 14);

			// Add closing Catalyst content wrappers, organizing them using different hook priorities.
			add_action('woocommerce_after_main_content', create_function('', 'echo "</div></div>";'), 14);
			add_action('woocommerce_after_main_content', create_function('', 'echo "</div>";'), 12);
			add_action('woocommerce_after_main_content', create_function('', 'echo "</div></div>";'), 10);
			
			// Remove WooCommerce sidebar.
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
			// Add Catalyst sidebars, organizing them using different hook priorities.
			add_action( 'woocommerce_after_main_content', 'catalyst_dual_sidebars', 11);
			add_action( 'woocommerce_after_main_content', 'catalyst_sidebar_1', 11);
			add_action( 'woocommerce_after_main_content', 'catalyst_sidebar_2', 13);

			if ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ||
				is_page( 'order-received' ) || is_page( 'order-tracking' ) ) {
				// Remove Catalyst breadcrumbs.
				remove_action( 'catalyst_hook_before_loop', 'catalyst_build_breadcrumbs' );
			}
		}

		/**
		 * Echo Custom CSS to address some Catalyst/WooCommerce styling issues
		 */
		function catalyst_connect_woocommerce_custom_css() {
echo "\n" . '<!-- Begin Catalyst/WooCommerce Custom CSS -->' . "\n";
echo '<style type="text/css">' . "\n";
echo '#content .page #payment ul { padding: 5px 0; } #content .page #payment ul.payment_methods li { margin: 0 15px; list-style: none; } .entry-content a.button.alt, .entry-content button.button.alt, .entry-content input.button.alt, .entry-content #respond input#submit.alt, .entry-content #content input.button.alt { color: #FFFFFF; }' . "\n";
echo '</style>' . "\n";
echo '<!-- End Catalyst/WooCommerce Custom CSS -->' . "\n\n";
		}
	}

	/**
	 * Add Javascript and stylesheet files
	 */
	function load_frontend_custom() {
		if( !empty($this->frontend_css) ) {
			$this->load_frontend_css();			
		}
		
		if( !empty($this->frontend_js) ) {
			$this->load_frontend_scripts();
		}
	}

	/** 
	 * Load CSS files listed in the $this->admin_css var
	 */
	function load_frontend_css() {		
		foreach($this->frontend_css as $css) {			
			if ( file_exists($this->css_dir . $css) ) {
				wp_register_style( $css, $this->css_url . "/" . $css );
		        wp_enqueue_style( $css );
			}
		}
	}
	
	/** 
	 * Load scripts listed in the $this->admin_js var
	 */
	function load_frontend_scripts() {
		foreach($this->frontend_js as $js) {
			if ( file_exists($this->js_dir . $js) ) {
				wp_deregister_script( $js );
				wp_register_script( $js, $this->js_url . "/" . $js );
				wp_enqueue_script( $js );
			}
		}
	}
	
} // End CatalystConnectFrontend class
