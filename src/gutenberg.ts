import { registerPlugin } from '@wordpress/plugins';

import FeatureControlCenterPanel from "./components/FeatureControlCenterPanel";
import './gutenberg.css';

registerPlugin('feature-control-center', {
    icon: ()=> null,
    render: FeatureControlCenterPanel,
})
