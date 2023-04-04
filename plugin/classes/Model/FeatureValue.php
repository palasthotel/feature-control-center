<?php

namespace Palasthotel\WordPress\FeatureControlCenter\Model;

class FeatureValue {
	var string $key;
	var bool $value;

	public function __construct(string $key, bool $value = true) {
		$this->key = $key;
		$this->value = $value;
	}
}
