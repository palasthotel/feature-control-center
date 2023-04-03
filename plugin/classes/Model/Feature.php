<?php

namespace Palasthotel\WordPress\FeatureControlCenter\Model;

/**
 * @property string $key
 * @property string $label
 * @property bool $defaultValue
 * @property string[] $postTypes
 */
class Feature {

	public function __construct(string $postMetaKey, string $label, bool $defaultValue) {
		$this->key = $postMetaKey;
		$this->label = $label;
		$this->defaultValue = $defaultValue;
		$this->postTypes = [];
	}

	public static function build(string $postMetaKey, string $label, bool $defaultValue = true) {
		return new self($postMetaKey, $label, $defaultValue);
	}

	/**
	 * @param string[] $postTypes
	 *
	 * @return $this
	 */
	public function postTypes(array $postTypes): self {
		$this->postTypes = $postTypes;
		return $this;
	}
}
