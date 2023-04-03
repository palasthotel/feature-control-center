<?php

namespace Palasthotel\WordPress\FeatureControlCenter\Model;

class ControlCenter {

	/**
	 * @var Feature[]
	 */
	private array $features;

	public function __construct() {
		$this->features = [];
	}

	public function addFeature(Feature $feature){
		if(isset($this->features[$feature->key])) throw new \Exception("Feature already added");
		$this->features[$feature->key] = $feature;
	}

	/**
	 * @return Feature[]
	 */
	public function getFeatures(): array {
		return array_values($this->features);
	}

	public function hasFeature(string $key){
		return isset($this->features[$key]);
	}

	/**
	 * @param string $key
	 *
	 * @return null|Feature
	 */
	public function getFeature(string $key){
		return $this->hasFeature($key) ? $this->features[$key] : null;
	}

}
