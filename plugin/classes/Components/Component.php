<?php


namespace Palasthotel\WordPress\FeatureControlCenter\Components;

use Palasthotel\WordPress\FeatureControlCenter\Plugin;

/**
 * Class Component
 *
 * @package Palasthotel\WordPress
 * @version 0.1.1
 */
abstract class Component {
	protected Plugin $plugin;

	/**
	 * _Component constructor.
	 *
	 * @param Plugin $plugin
	 */
	public function __construct(Plugin $plugin) {
		$this->plugin = $plugin;
		$this->onCreate();
	}

	/**
	 * overwrite this method in component implementations
	 */
	public function onCreate(){}
}
