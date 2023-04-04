<?php

namespace Palasthotel\WordPress\FeatureControlCenter;

use Palasthotel\WordPress\FeatureControlCenter\Components\Component;

class Configuration extends Component {

	public function getPostRestField(){
		return apply_filters(Plugin::FILTER_POST_REST_FIELD, "features");
	}

}
