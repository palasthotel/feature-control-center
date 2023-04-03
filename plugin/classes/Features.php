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
		return $value === "1" ? true : $feature->defaultValue;
	}
}
