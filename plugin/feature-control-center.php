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

require_once __DIR__ . "/vendor/autoload.php";


class Plugin extends Components\Plugin {

	const DOMAIN = "fcc";

	const HANDLE_GUTENBERG_SCRIPTS = "fcc_gutenberg_scripts";
	const HANDLE_GUTENBERG_STYLES = "fcc_gutenberg_styles";

	const ACTION_ADD_FEATURES = "feature_control_center_add_features";
	const FILTER_POST_REST_FIELD = "feature_control_post_rest_field";

	var Configuration $config;
	var Features $features;

	function onCreate() {

		$this->config = new Configuration($this);
		$this->features = new Features( $this );

		new Gutenberg( $this );

		if ( WP_DEBUG ) {
			$this->features->repo->database->createTables();
		}
	}

	public function onSiteActivation() {
		parent::onSiteActivation();
		$this->features->repo->database->createTables();
	}
}

Plugin::instance();

require_once __DIR__ . "/public-functions.php";
