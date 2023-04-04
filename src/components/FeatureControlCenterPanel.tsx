import {PluginDocumentSettingPanel} from '@wordpress/edit-post';
import {CheckboxControl} from "@wordpress/components";
import {useSelect, useDispatch} from "@wordpress/data";
import {getFeatures, getPostRestField} from "../lib/window";
import {Feature} from "../_types/feature";

type FeatureControlProps = {
    feature: Feature
}

const FeatureControl = (
    {
        feature,
    }: FeatureControlProps
)=>{

    const restField = getPostRestField();
    const features =  useSelect(
        ( select ) => select( 'core/editor' ).getEditedPostAttribute(restField),
        []
    );

    const {editPost} = useDispatch('core/editor');
    const checked = typeof features[feature.key] == "boolean" ? features[feature.key] : feature.defaultValue;

    return (
        <CheckboxControl
            key={feature.key}
            label={feature.label}
            checked={checked}
            onChange={(isChecked)=> {
                editPost({
                    [restField]: {
                        ...features,
                        [feature.key]: isChecked,
                    }
                })
            }}
        />
    )
}


export default function FeatureControlCenterPanel(){

    const features = getFeatures();

    return (
        <PluginDocumentSettingPanel
            title="Feature control"
        >
            {features.map(feature => {
                return (
                    <FeatureControl
                        key={feature.key}
                        feature={feature}
                    />
                )
            })}

        </PluginDocumentSettingPanel>
    )
}
