import {Feature} from "../_types/feature";

declare global {
    interface Window {
        FeatureControlCenter: {
            features: Feature[]
        }
    }
}

export const getFeatures = () => window.FeatureControlCenter.features;
