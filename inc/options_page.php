<?php
/**
 * Catalyst Connect Options Page
 */
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2><?php _e( 'Catalyst Connect', 'catcon' ); ?></h2>

	<?php settings_errors(); ?>

	<p>
		<?php _e( 'The', 'catcon' ); ?> <a href="http://catalysttheme.com"><?php _e( 'Catalyst Connect', 'catcon' ); ?></a> <?php _e( 'plugin executes the necessary functions to ensure proper Catalyst integration with the <strong>BuddyPress</strong>, <strong>BBPress</strong> and <strong>WooCommerce</strong> Plugins.', 'catcon' ); ?>
	</p>
	
	<form method="post" action="options.php">

		<?php 
			// Setup and retrieve our option values so they're available for use in our form
			settings_fields('catalyst_connect_options');
			$options = get_option('catalyst_connect'); 			
		?>
	
		<table class="form-table">
			<?php if ( class_exists( 'BuddyPress' ) ) { $buddypress_display = ''; $buddypress_is_active_class = 'buddypress-is-active'; $buddypress_active =  __( 'ACTIVE', 'catcon' ); } else { $buddypress_display = ' style="display:none;"';  $buddypress_is_active_class = 'buddypress-not-active'; $buddypress_active = __( 'inactive', 'catcon' ); } ?>
			<tr>
				<td>
					<p class="<?php echo $buddypress_is_active_class; ?>">	
						<?php _e( 'The BuddyPress Plugin is currently...', 'catcon' ); ?> <code style="color:#111111; font-style:normal;"><?php echo $buddypress_active; ?></code>
					</p>
				</td>
			</tr>
			<tr<?php echo $buddypress_display; ?>>
				<td style="padding-left:30px;">
					<input id="disable_buddypress_connect_css" name="catalyst_connect[disable_buddypress_connect_css]" class="checkbox" type="checkbox" value="1" <?php if ( isset( $options['disable_buddypress_connect_css'] ) ) { checked( '1', $options['disable_buddypress_connect_css'] ); } ?> />
					<label for="disable_buddypress_connect_css"> <?php _e( 'Disable the custom BuddyPress CSS code added by the Catalyst Connect Plugin', 'catcon' ); ?></label>
				</td>
			</tr>
			<tr id="disable-buddypress-connect-css-code" style="display:none;">
				<td style="padding-left:50px;">
					<?php _e( 'To manually add this custom BuddyPress CSS code just Copy and Paste', 'catcon' ); ?> <span id="buddypress-css-examples-show" class="catalyst-connect-css-examples-show"><?php _e( '[THIS CSS CODE]', 'catcon' ); ?></span> <?php _e( 'into your Advacned Options > Custom CSS.', 'catcon' ); ?>
				</td>
			</tr>
			<tr id="buddypress-css-examples" style="display:none;">
				<td style="padding-left:50px;">
					<div class="catalyst-connect-scrollbox">
div.item-list-tabs {
	margin: 25px 0 20px;
}
div.item-list-tabs#subnav {
	margin: -15px 0 15px;
}
.padder div.pagination {
	margin: -20px 0 0;
}
form#whats-new-form textarea {
	width: 97%;
}
table.forum {
	margin: 0;
}
table.forum tr > td:first-child,
table.forum tr > th:first-child {
	padding: 10px 15px;
}
ul#topic-post-list p {
	padding: 0 0 20px;
}
div.dir-search {
	margin: -29px 0 0;
}
ul.button-nav li,
div#item-header ul li {
	list-style: none;
}
ul#topic-post-list {
	margin: 0 0 15px;
}
#post-topic-reply {
	margin: 15px 0 0;
}
#sidebar-1 .item-options,
#sidebar-2 .item-options,
#sidebar-1 .avatar-block,
#sidebar-2 .avatar-block {
	padding: 10px 10px 0;
}
#sidebar-1 .avatar-block,
#sidebar-2 .avatar-block {
	overflow: auto;
}
#sidebar-1 ul.item-list,
#sidebar-2 ul.item-list {
	width: auto;
	padding: 0 10px;
}
#sidebar-1 a img.avatar,
#sidebar-2 a img.avatar {
	margin: 0 10px 10px 0;
	float: left;
	padding: 5px;
	background: #F6F6F6;
}
#primary ul.item-list,
#primary ul.item-list li {
	list-style-type: none;
}
.widget-error {
	padding: 10px;
}
					</div>
				</td>
			</tr>
			<tr<?php echo $buddypress_display; ?>>
				<td style="padding-left:30px;">
					<input id="disable_buddypress_connect" name="catalyst_connect[disable_buddypress_connect]" class="checkbox" type="checkbox" value="1" <?php if ( isset( $options['disable_buddypress_connect'] ) ) { checked( '1', $options['disable_buddypress_connect'] ); } ?> />
					<label for="disable_buddypress_connect"> <?php _e( 'Disable Catalyst Connect for BuddyPress (this "turns off" the BuddyPress compatibility functions being applied by this Plugin)', 'catcon' ); ?></label>
				</td>
			</tr>
			<?php if ( class_exists( 'bbPress' ) ) { $bbpress_display = ''; $bbpress_is_active_class = 'bbpress-is-active'; $bbpress_active =  __( 'ACTIVE', 'catcon' ); } else { $bbpress_display = ' style="display:none;"';  $bbpress_is_active_class = 'bbpress-not-active'; $bbpress_active = __( 'inactive', 'catcon' ); } ?>
			<tr style="border-top:1px solid #EEE;">
				<td>
					<p class="<?php echo $bbpress_is_active_class; ?>">	
						<?php _e( 'The BBPress Plugin is currently...', 'catcon' ); ?> <code style="color:#111111; font-style:normal;"><?php echo $bbpress_active; ?></code>
					</p>
				</td>
			</tr>
			<tr<?php echo $bbpress_display; ?>>
				<td style="padding-left:30px;">
					<input id="disable_bbpress_connect_css" name="catalyst_connect[disable_bbpress_connect_css]" class="checkbox" type="checkbox" value="1" <?php if ( isset( $options['disable_bbpress_connect_css'] ) ) { checked( '1', $options['disable_bbpress_connect_css'] ); } ?> />
					<label for="disable_bbpress_connect_css"> <?php _e( 'Disable the custom BBPress CSS code added by the Catalyst Connect Plugin', 'catcon' ); ?></label>
				</td>
			</tr>
			<tr id="disable-bbpress-connect-css-code" style="display:none;">
				<td style="padding-left:50px;">
					<?php _e( 'To manually add this custom BBPress CSS code just Copy and Paste', 'catcon' ); ?> <span id="bbpress-css-examples-show" class="catalyst-connect-css-examples-show"><?php _e( '[THIS CSS CODE]', 'catcon' ); ?></span> <?php _e( 'into your Advacned Options > Custom CSS.', 'catcon' ); ?>
				</td>
			</tr>
			<tr id="bbpress-css-examples" style="display:none;">
				<td style="padding-left:50px;">
					<div class="catalyst-connect-scrollbox">
.bbPress #content article p {
	padding: 0;
}
.bbPress #content article ul li p {
	padding: 0 0 20px;
}
.bbPress #content article ul {
	padding: 0;
}
.bbPress #content article ul li {
	margin: 0;
	list-style: none;
}
.bbPress .post-format-icon {
	display: none;
}
					</div>
				</td>
			</tr>
			<tr<?php echo $bbpress_display; ?>>
				<td style="padding-left:30px;">
					<input id="disable_bbpress_connect" name="catalyst_connect[disable_bbpress_connect]" class="checkbox" type="checkbox" value="1" <?php if ( isset( $options['disable_bbpress_connect'] ) ) { checked( '1', $options['disable_bbpress_connect'] ); } ?> />
					<label for="disable_bbpress_connect"> <?php _e( 'Disable Catalyst Connect for BBPress (this "turns off" the BBPress compatibility functions being applied by this Plugin)', 'catcon' ); ?></label>
				</td>
			</tr>
			<?php if ( class_exists( 'Woocommerce' ) ) { $woocommerce_display = ''; $woocommerce_is_active_class = 'woocommerce-is-active'; $woocommerce_active =  __( 'ACTIVE', 'catcon' ); } else { $woocommerce_display = ' style="display:none;"';  $woocommerce_is_active_class = 'woocommerce-not-active'; $woocommerce_active = __( 'inactive', 'catcon' ); } ?>
			<tr style="border-top:1px solid #EEE;">
				<td>
					<p class="<?php echo $woocommerce_is_active_class; ?>">	
						<?php _e( 'The WooCommerce Plugin is currently...', 'catcon' ); ?> <code style="color:#111111; font-style:normal;"><?php echo $woocommerce_active; ?></code>
					</p>
				</td>
			</tr>
			<tr<?php echo $woocommerce_display; ?>>
				<td style="padding-left:30px;">
					<input id="catalyst_connect_woocommerce_breadcrumbs_cat" name="catalyst_connect[woocommerce_breadcrumbs]" class="radio" type="radio" value="cat" <?php if ( isset( $options['woocommerce_breadcrumbs'] ) ) { checked( 'cat', $options['woocommerce_breadcrumbs'] ); } ?> />
					<label for="catalyst_connect_woocommerce_breadcrumbs_cat"> <?php _e( 'Use the Catalyst Breadcrumbs', 'catcon' ); ?></label>
					<br />
					<input id="catalyst_connect_woocommerce_breadcrumbs_woo" name="catalyst_connect[woocommerce_breadcrumbs]" class="radio" type="radio" value="woo" <?php if ( isset( $options['woocommerce_breadcrumbs'] ) ) { checked( 'woo', $options['woocommerce_breadcrumbs'] ); } ?> />
					<label for="catalyst_connect_woocommerce_breadcrumbs_bp"> <?php _e( 'Use the WooCommerce Breadcrumbs', 'catcon' ); ?></label>
				</td>
			</tr>
			<tr<?php echo $woocommerce_display; ?>>
				<td style="padding-left:30px;">
					<input id="disable_woocommerce_connect_css" name="catalyst_connect[disable_woocommerce_connect_css]" class="checkbox" type="checkbox" value="1" <?php if (isset($options['disable_woocommerce_connect_css'])) { checked('1', $options['disable_woocommerce_connect_css']); } ?> />
					<label for="disable_woocommerce_connect_css"> <?php _e( 'Disable the custom WooCommerce CSS code added by the Catalyst Connect Plugin', 'catcon' ); ?></label>
				</td>
			</tr>
			<tr id="disable-woocommerce-connect-css-code" style="display:none;">
				<td style="padding-left:50px;">
					<?php _e( 'To manually add this custom WooCommerce CSS code just Copy and Paste', 'catcon' ); ?> <span id="woocommerce-css-examples-show" class="catalyst-connect-css-examples-show"><?php _e( '[THIS CSS CODE]', 'catcon' ); ?></span> <?php _e( 'into your Advacned Options > Custom CSS.', 'catcon' ); ?>
				</td>
			</tr>
			<tr id="woocommerce-css-examples" style="display:none;">
				<td style="padding-left:50px;">
					<div class="catalyst-connect-scrollbox">
#content .page #payment ul {
	padding: 5px 0;
}
#content .page #payment ul.payment_methods li {
	margin: 0 15px;
	list-style: none;
}
.entry-content a.button.alt,
.entry-content button.button.alt,
.entry-content input.button.alt,
.entry-content #respond input#submit.alt,
.entry-content #content input.button.alt {
	color: #FFFFFF;
}
					</div>
				</td>
			</tr>
			<tr<?php echo $woocommerce_display; ?>>
				<td style="padding-left:30px;">
					<input id="disable_woocommerce_connect" name="catalyst_connect[disable_woocommerce_connect]" class="checkbox" type="checkbox" value="1" <?php if ( isset( $options['disable_woocommerce_connect'] ) ) { checked( '1', $options['disable_woocommerce_connect'] ); } ?> />
					<label for="disable_woocommerce_connect"> <?php _e( 'Disable Catalyst Connect for WooCommerce (this "turns off" the WooCommerce compatibility functions being applied by this Plugin)', 'catcon' ); ?></label>
				</td>
			</tr>
		</table>

		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>

	</form>
</div>

