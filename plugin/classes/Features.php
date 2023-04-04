<?php

namespace Palasthotel\WordPress\FeatureControlCenter;

use Palasthotel\WordPress\FeatureControlCenter\Components\Component;
use Palasthotel\WordPress\FeatureControlCenter\Model\ControlCenter;
use Palasthotel\WordPress\FeatureControlCenter\Model\Feature;
use WP_Error;

/**
 * @property ControlCenter $controlCenter
 */
class Features extends Component {
	public function onCreate() {
		parent::onCreate();
		$this->controlCenter = new ControlCenter();
		add_action('plugins_loaded', [$this, 'load_features']);
	}

	public function load_features(){
		do_action(Plugin::ACTION_ADD_FEATURES, $this->controlCenter);
	}

	/**
	 *
	 * @return bool|WP_Error
	 */
	public function isFeatureEnabled($post_id, string $post_meta_key) {
		$feature = $this->controlCenter->getFeature($post_meta_key);
		if(!($feature instanceof Feature)){
			return new WP_Error(404, "Unknown feature '$post_meta_key'");
		}
		$value = get_post_meta($post_id, $post_meta_key, true);

		return $value === "1" || $value === true;
	}

	public function getByPostType(string $postType) {
		return array_values(
			array_filter($this->plugin->features->controlCenter->getFeatures(), function($item) use ( $postType ) {
				return empty($item->postTypes) || in_array($postType, $item->postTypes);
			})
		);
	}
}
