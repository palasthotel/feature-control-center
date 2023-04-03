<?php

namespace Palasthotel\WordPress\FeatureControlCenter;

use Palasthotel\WordPress\FeatureControlCenter\Components\Component;

class PostMeta extends Component {

	public function onCreate() {
		parent::onCreate();

		add_action('init', [$this, 'init']);
	}

	public function init(){

		$features = $this->plugin->features->controlCenter->getFeatures();
		if(count($features) <= 0) return;

		$postTypes = get_post_types( [
			"public" => true,
		] );

		foreach ( $postTypes as $postType ) {
			foreach ($features as $feature){
				register_post_meta(
					$postType,
					$feature->key,
					[
						"show_in_rest" => true,
						"single" => true,
						"type"   => "boolean",
						"default" => $feature->defaultValue,
					]
				);
			}
		}
	}

}
