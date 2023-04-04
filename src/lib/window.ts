import {Feature} from "../_types/feature";

declare global {
    interface Window {
        FeatureControlCenter: {
            features: Feature[]
            post_rest_field: string
        }
    }
}

export const getFeatures = () => window.FeatureControlCenter.features;
export const getPostRestField = ()=> window.FeatureControlCenter.post_rest_field;
