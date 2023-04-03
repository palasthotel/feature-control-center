<?php

namespace Palasthotel\WordPress\FeatureControlCenter;

/**
 * Plugin Name: Feature control center
 * Description: Get control over features on a per content basis.
 * Version: 1.0.0
 * Author: Palasthotel <rezeption@palasthotel.de> (in person: Edward Bock)
 * Author URI: http://www.palasthotel.de
 * Requires at least: 5.0
 * Tested up to: 6.1.1
 * License: http://www.gnu.org/licenses/gpl-2.0.html GPLv2
 * @copyright Copyright (c) 2023, Palasthotel
 *
 */

require_once __DIR__."/vendor/autoload.php";


/**
 * @property Features $features
 */
class Plugin extends Components\Plugin {

	const DOMAIN = "fcc";

	const HANDLE_GUTENBERG_SCRIPTS = "fcc_gutenberg_scripts";
	const HANDLE_GUTENBERG_STYLES = "fcc_gutenberg_styles";

	const ACTION_ADD_FEATURES = "feature_control_center_add_features";

	function onCreate() {

		$this->features = new Features($this);

		new PostMeta($this);
		new Gutenberg($this);
	}
}

Plugin::instance();

require_once __DIR__."/public-functions.php";
