<?php

use Palasthotel\WordPress\FeatureControlCenter\Plugin;

function feature_control_center_plugin(){
	return Plugin::instance();
}

/**
 * @return bool|WP_Error
 */
function feature_control_center_is_feature_enabled($post_id, string $post_meta_key){
	return feature_control_center_plugin()->features->isFeatureEnabled($post_id, $post_meta_key);
}
