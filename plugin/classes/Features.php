<?php

namespace Palasthotel\WordPress\FeatureControlCenter;

use Palasthotel\WordPress\FeatureControlCenter\Components\Component;
use Palasthotel\WordPress\FeatureControlCenter\Model\ControlCenter;
use Palasthotel\WordPress\FeatureControlCenter\Model\Feature;
use Palasthotel\WordPress\FeatureControlCenter\Model\FeatureValue;
use WP_Error;

class Features extends Component {

	var FeatureRepository $repo;
	var ControlCenter $controlCenter;

	public function onCreate() {
		parent::onCreate();
		$this->repo = new FeatureRepository();
		$this->controlCenter = new ControlCenter();
		add_action('init', [$this, 'load_features'], 1);
		add_action('init', [$this, 'init']);
	}

	public function load_features(){
		do_action(Plugin::ACTION_ADD_FEATURES, $this->controlCenter);
	}

	public function init(){
		$postTypes = get_post_types();
		foreach ($postTypes as $post_type){
			$features = $this->plugin->features->getByPostType($post_type);
			if(count($features)<= 0) continue;
			register_rest_field(
				$postTypes,
				$this->plugin->config->getPostRestField(),
				[
					'get_callback' => function($post){
						$features = $this->getByPostType($post["type"]);
						$result = [];
						foreach ($features as $feature){
							$value = $this->repo->getPostFeature($post["id"], $feature->key);
							if($value instanceof FeatureValue){
								$result[$value->key] = $value->value;
							}
						}
						return $result;
					},
					'update_callback' => function($value, $post){
						if(!is_array($value)) return;
						foreach ($value as $key => $val){
							$this->repo->setPostFeature($post->ID, new FeatureValue(sanitize_text_field($key), boolval($val)));
						}
					},
					'schema' => [
						'description' => 'List of features for this content',
						'type' => 'object',
					]
				]
			);
		}
	}

	/**
	 *
	 * @return bool|WP_Error
	 */
	public function isFeatureEnabled($post_id, string $feature_key) {
		$feature = $this->controlCenter->getFeature($feature_key);
		if(!($feature instanceof Feature)){
			return new WP_Error(404, "Unknown feature '$feature_key'");
		}
		$value = $this->repo->getPostFeature($post_id, $feature_key);
		return $value instanceof FeatureValue ? $value->value : $feature->defaultValue;
	}

	/**
	 * @param string|null $postType
	 *
	 * @return Feature[]
	 */
	public function getByPostType( ?string $postType): array {
		return array_values(
			array_filter($this->plugin->features->controlCenter->getFeatures(), function($item) use ( $postType ) {
				return empty($item->postTypes) || in_array($postType, $item->postTypes);
			})
		);
	}
}
