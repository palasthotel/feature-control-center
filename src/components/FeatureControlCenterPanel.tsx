import {PluginDocumentSettingPanel} from '@wordpress/edit-post';
import {CheckboxControl} from "@wordpress/components";
import {useEntityProp} from '@wordpress/core-data'
import {useSelect} from "@wordpress/data";
import {getFeatures} from "../lib/window";
import {Feature} from "../_types/feature";

type FeatureControlProps = {
    feature: Feature
    postType: string
}

const FeatureControl = (
    {
        feature,
        postType,
    }: FeatureControlProps
)=>{

    const [ meta, setMeta ] = useEntityProp( 'postType', postType, 'meta' );
    const checked = meta[feature.key] ?? feature.defaultValue;

    return (
        <CheckboxControl
            key={feature.key}
            label={feature.label}
            checked={checked}
            onChange={(isChecked)=> {
                setMeta({
                    ...meta,
                    [feature.key]: isChecked
                })
            }}
        />
    )
}


export default function FeatureControlCenterPanel(){

    const features = getFeatures();
    const postType = useSelect(
        ( select ) => select( 'core/editor' ).getCurrentPostType(),
        []
    );

    return (
        <PluginDocumentSettingPanel
            title="Feature control"
        >
            {features.map(feature => {
                return (
                    <FeatureControl
                        key={feature.key}
                        feature={feature}
                        postType={postType}
                    />
                )
            })}

        </PluginDocumentSettingPanel>
    )
}
