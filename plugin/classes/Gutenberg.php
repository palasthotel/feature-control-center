<?php

namespace Palasthotel\WordPress\FeatureControlCenter;

use Palasthotel\WordPress\FeatureControlCenter\Components\Assets;
use Palasthotel\WordPress\FeatureControlCenter\Components\Component;

class Gutenberg extends Component {
	public function onCreate() {
		parent::onCreate();
		add_action('admin_init', [$this, 'admin_init']);
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue' ] );
	}

	public function admin_init(){
		$assets = new Assets($this->plugin);
		$assets->registerScript(
			Plugin::HANDLE_GUTENBERG_SCRIPTS,
			"dist/gutenberg.ts.js"
		);
		$assets->registerStyle(
			Plugin::HANDLE_GUTENBERG_STYLES,
			"dist/gutenberg.ts.css"
		);
	}

	public function enqueue(){
		wp_enqueue_script(Plugin::HANDLE_GUTENBERG_SCRIPTS);
		wp_localize_script(
			Plugin::HANDLE_GUTENBERG_SCRIPTS,
			"FeatureControlCenter",
			[
				"features" => $this->plugin->features->getByPostType(get_post_type()),
				"post_rest_field" => $this->plugin->config->getPostRestField(),
			]
		);
		wp_enqueue_style(Plugin::HANDLE_GUTENBERG_STYLES);
	}
}
