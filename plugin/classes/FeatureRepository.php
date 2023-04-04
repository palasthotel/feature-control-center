<?php

namespace Palasthotel\WordPress\FeatureControlCenter;

use Palasthotel\WordPress\FeatureControlCenter\Model\FeatureValue;

class FeatureRepository {

	var FeatureDatabase $database;

	public function __construct() {
		$this->database = new FeatureDatabase();
	}

	public function getPostFeature($post_id, $key){
		return $this->database->getFeature("post", $post_id, $key);
	}

	public function setPostFeature( $post_id, FeatureValue $value ) {
		$this->database->setFeature("post", $post_id, $value);
	}

}
