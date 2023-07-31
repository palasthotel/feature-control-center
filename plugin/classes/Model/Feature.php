<?php

namespace Palasthotel\WordPress\FeatureControlCenter\Model;

/**
 */
class Feature {

	public string $key;
	public string $label;
	public bool $defaultValue;
	/**
	 * @var string[]
	 */
	public array $postTypes;

	public function __construct(string $postMetaKey, string $label, bool $defaultValue) {
		$this->key = $postMetaKey;
		$this->label = $label;
		$this->defaultValue = $defaultValue;
		$this->postTypes = [];
	}

	public static function build(string $postMetaKey, string $label, bool $defaultValue) {
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
