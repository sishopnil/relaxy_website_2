<?php
/**
 * Change default footer text, asking to review our plugin
 **/
function my_footer_text($default) {
    return _e( 'If you like our <strong>WooCommerce Product Feed PRO</strong> plugin please leave us a <a href="https://wordpress.org/support/plugin/woo-product-feed-pro/reviews?rate=5#new-post" target="_blank" class="woo-product-feed-pro-ratingRequest">&#9733;&#9733;&#9733;&#9733;&#9733;</a> rating. Thanks in advance!','woo-product-feed-pro' );
}
add_filter('admin_footer_text', 'my_footer_text');

/**
 * Create notification object
 */
$notifications_obj = new WooSEA_Get_Admin_Notifications;
$notifications_box = $notifications_obj->get_admin_notifications ( '7', 'false' );

/**
 * Create product attribute object
 **/
$attributes_obj = new WooSEA_Attributes;
$attribute_dropdown = $attributes_obj->get_product_attributes();

/**
 * Update or get project configuration 
 */
$nonce = wp_create_nonce( 'woosea_ajax_nonce' );

/**
 * Update or get project configuration 
 */
if (array_key_exists('project_hash', $_GET)){
        $project = WooSEA_Update_Project::get_project_data(sanitize_text_field($_GET['project_hash']));
        $channel_data = WooSEA_Update_Project::get_channel_data(sanitize_text_field($_GET['channel_hash']));
	$count_mappings = count($project['attributes']);
        $manage_project = "yes";

        if(isset($project['WPML'])){
		if ( ( is_plugin_active('sitepress-multilingual-cms') ) OR ( function_exists('icl_object_id') ) ){
			if( !class_exists( 'Polylang' ) ) {
        	        	// Get WPML language
                		global $sitepress;
                		$lang = $project['WPML'];
                		$sitepress->switch_lang($lang);
			}
      		}
	}
} else {
        // Sanitize values in multi-dimensional POST array        
        if(is_array($_POST)){
                foreach($_POST as $p_key => $p_value){
                        if(is_array($p_value)){
                                foreach($p_value as $pp_key => $pp_value){
                                        if(is_array($pp_value)){
                                                foreach($pp_value as $ppp_key => $ppp_value){
                                                        $_POST[$p_key][$pp_key][$ppp_key] = sanitize_text_field($ppp_value);
                                                }
                                        }       
                                }
                        } else {
                                $_POST[$p_key] = sanitize_text_field($p_value);
                        }
                }
        } else {
                $_POST = array();
        }
	$project = WooSEA_Update_Project::update_project($_POST);
        $channel_data = WooSEA_Update_Project::get_channel_data(sanitize_text_field($_POST['channel_hash']));

        if(isset($project['WPML'])){
		if ( ( is_plugin_active('sitepress-multilingual-cms') ) OR ( function_exists('icl_object_id') ) ){
			if( !class_exists( 'Polylang' ) ) {
                		// Get WPML language
                		global $sitepress;
                		$lang = $project['WPML'];
                		$sitepress->switch_lang($lang);
			}
        	}
	}
}

/**
 * Determine next step in configuration flow
 **/
$step = 4;
if($channel_data['taxonomy'] != "none"){
	$step = 1;
}

/**
 * Get main currency
 **/
$currency = get_woocommerce_currency();
if(isset($project['WCML'])){
	$currency = $project['WCML'];
}

if(isset($project['AELIA'])){
	$currency = $project['AELIA'];
}

/**
 * Create channel attribute object
 **/
require plugin_dir_path(__FILE__) . '../../classes/channels/class-'.$channel_data['fields'].'.php';
$obj = "WooSEA_".$channel_data['fields'];
$fields_obj = new $obj;
$attributes = $fields_obj->get_channel_attributes();	
?>
	<div id="dialog" title="Basic dialog">
  		<p>
			<div id="dialogText"></div>
		</p>
	</div>

	<div class="wrap">
		<div class="woo-product-feed-pro-form-style-2">
			<div class="woo-product-feed-pro-form-style-2-heading"><?php _e( 'Field mapping','woo-product-feed-pro' );?></div>

                	<div class="<?php _e($notifications_box['message_type']); ?>">
                        	<p><?php _e($notifications_box['message'], 'sample-text-domain' ); ?></p>
                	</div>

			<form action="" id="fieldmapping" method="post">
			<input name="nonce_field_mapping" id="nonce_field_mapping" class="nonce_field_mapping" value="<?php print "$nonce";?>" type="hidden">
			<table class="woo-product-feed-pro-table" id="woosea-fieldmapping-table" border="1">
				<thead>
            				<tr>
						<th></th>
                				<th>
						<?php
							print "$channel_data[name] attributes";
						?>
						</th>
                				<th><?php _e( 'Prefix','woo-product-feed-pro' );?></th>
                				<th><?php _e( 'Value','woo-product-feed-pro' );?></th>
						<th><?php _e( 'Suffix','woo-product-feed-pro' );?></th>
            				</tr>
        			</thead>
        
 				<tbody class="woo-product-feed-pro-body">
					<?php
					if (!isset($count_mappings)){	
						$c = 0;
						foreach($attributes as $row_key => $row_value){
							foreach($row_value as $row_k => $row_v){
								if ($row_v['format'] == "required"){
								?>
								<tr class="rowCount <?php print"$c";?>">
									<td><input type="hidden" name="attributes[<?php print "$c";?>][rowCount]" value="<?php print "$c";?>">
                                                                        	<input type="checkbox" name="record" class="checkbox-field">
									</td>
									<td>
										<select name="attributes[<?php print"$c"; ?>][attribute]" class="select-field">
										<?php
											foreach($attributes as $key => $value) {
												print "<optgroup label='$key'><strong>$key</strong>";
												
												foreach($value as $k => $v){
													if($v['feed_name'] == $row_v['feed_name']){
														if (array_key_exists('name',$v)){
															$dialog_value = $v['feed_name'];
															print "<option value='$v[feed_name]' selected>$k ($v[name])</option>";
														} else {
															print "<option value='$v[feed_name]' selected>$k</option>";
														}
													} else {
														if (array_key_exists('name',$v)){
															print "<option value='$v[feed_name]'>$k ($v[name])</option>";
														} else {
															print "<option value='$v[feed_name]'>$k</option>";
														}
													}
												}
											}
										?>
										</select>
									</td>
                							<td>
										<?php
										if($row_v['feed_name'] == "g:price"){
											print "<input type='text' name='attributes[$c][prefix]' value='$currency' class='input-field-medium'>";
										} else {
											print "<input type='text' name='attributes[$c][prefix]' class='input-field-medium'>";
										}
										?>
									</td>
									<td>
										<select name="attributes[<?php print "$c";?>][mapfrom]" class="select-field">
										<option></option>
										<?php
											foreach($attribute_dropdown as $drop_key => $drop_value){
												if(array_key_exists("woo_suggest", $row_v) ){
													if($row_v['woo_suggest'] == $drop_key){
														print "<option value='$drop_key' selected>$drop_value</option>";
													} else {
														print "<option value='$drop_key'>$drop_value</option>";
													}
												} else {
													print "<option value='$drop_key'>$drop_value</option>";
												}
											}
										?>
										</select>
									</td>
                							<td>
										<input type="text" name="attributes[<?php print "$c";?>][suffix]" class="input-field-medium">
									</td>
								</tr>
								<?php
								$c++;
								}
							}
						}
					} else {
                                                foreach ($project['attributes'] as $attribute_key => $attribute_array){
							if(isset($project['attributes'][$attribute_key]['prefix'])){
								$prefix = $project['attributes'][$attribute_key]['prefix'];
							}	
							if(isset($project['attributes'][$attribute_key]['suffix'])){
								$suffix = $project['attributes'][$attribute_key]['suffix'];
							}
							?>
							<tr class="rowCount <?php print "$attribute_key";?>">	
								<td><input type="hidden" name="attributes[<?php print "$attribute_key";?>][rowCount]" value="<?php print "$attribute_key";?>">
									<input type="checkbox" name="record" class="checkbox-field">
								</td>
								<td>
									<select name="attributes[<?php print"$attribute_key"; ?>][attribute]" class="select-field">
									<?php
										print "<option value=\"$attribute_array[attribute]\">$attribute_array[attribute]</option>";
									?>
									</select>
								</td>
 								<td>
									<input type="text" name="attributes[<?php print "$attribute_key";?>][prefix]" class="input-field-medium" value="<?php print "$prefix";?>">
								</td>
								<td>

									<?php
									if(array_key_exists('static_value', $attribute_array)){
										print "<input type=\"text\" name=\"attributes[$attribute_key][mapfrom]\" class=\"input-field-midsmall\" value=\"$attribute_array[mapfrom]\"><input type=\"hidden\" name=\"attributes[$attribute_key][static_value]\" value=\"true\">";
									} else {
										?>
										<select name="attributes[<?php print "$attribute_key";?>][mapfrom]" class="select-field">
										<option></option>
										<?php
											foreach($attribute_dropdown as $drop_key => $drop_value){
												if($project['attributes'][$attribute_key]['mapfrom'] == $drop_key){
													print "<option value='$drop_key' selected>$drop_value</option>";
												} else {
													print "<option value='$drop_key'>$drop_value</option>";
												}
											}
										?>
										</select>
									<?php }
									?>
								</td>
                						<td>
									<input type="text" name="attributes[<?php print "$attribute_key";?>][suffix]" class="input-field-medium" value="<?php print "$suffix";?>">
								</td>
							</tr>
						<?php
						}					
					}
					?>
        			</tbody>
                                
				<tr>
					<td colspan="6">
                                        	<input type="hidden" id="channel_hash" name="channel_hash" value="<?php print "$project[channel_hash]";?>">
                                        	<?php
                                        	if(isset($manage_project)){
                                        	?>
							<input type="hidden" name="project_hash" value="<?php print "$project[project_hash]";?>">
        	        		                <input type="hidden" name="step" value="100">
        	        		               	<input type="hidden" name="addrow" id="addrow" value="1">
                	               			<input type="button" class="delete-field-mapping" value="- Delete">&nbsp;<input type="button" class="add-field-mapping" value="+ Add field mapping">&nbsp;<input type="button" class="add-own-mapping" value="+ Add custom field">&nbsp;<input type="submit" id="savebutton" value="Save" />
	
						<?php
						} else {
						?>
							<input type="hidden" name="project_hash" value="<?php print "$project[project_hash]";?>">
                			                <input type="hidden" name="step" value="<?php print "$step";?>">
        	        		                <input type="hidden" name="addrow" id="addrow" value="1">
                               				<input type="button" class="delete-field-mapping" value="- Delete">&nbsp;<input type="button" class="add-field-mapping" value="+ Add field mapping">&nbsp;<input type="button" class="add-own-mapping" value="+ Add custom field">&nbsp;<input type="submit" id="savebutton" value="Save" />
						<?php
						}
						?>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
