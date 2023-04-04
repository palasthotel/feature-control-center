<?php

namespace Palasthotel\WordPress\FeatureControlCenter;


use Palasthotel\WordPress\FeatureControlCenter\Model\FeatureValue;

class FeatureDatabase extends Components\Database {

	private string $table;

	private const TRUTHY_VALUE = "1";
	private const FALSY_VALUE = "0";

	function init() {
		$this->table = $this->wpdb->prefix."feature_control";
	}

	public function getFeatures($contentType, $contentId){
		$query = $this->wpdb->prepare(
			"SELECT feature_key, feature_value FROM $this->table WHERE content_id = %d AND content_type = %s",
			$contentId, $contentType
		);
		$values = $this->wpdb->get_results($query);

		return array_map(function($item){
			return new FeatureValue(
				$item->feature_key,
				$item->feature_value == self::TRUTHY_VALUE,
			);
		},$values);
	}

	/**
	 * @param string $contentType
	 * @param int $contentId
	 * @param string $key
	 *
	 * @return FeatureValue|null
	 */
	public function getFeature($contentType, $contentId, $key){
		$query = $this->wpdb->prepare(
			"SELECT feature_value FROM $this->table WHERE content_id = %d AND content_type = %s AND feature_key = %s",
			$contentId, $contentType, $key
		);
		$value = $this->wpdb->get_var($query);

		if(!is_string($value)) return null;

		return new FeatureValue($key, $value == self::TRUTHY_VALUE);
	}

	public function setFeature($contentType, $contentId, FeatureValue $feature){
		$before = $this->getFeature($contentType, $contentId, $feature->key);
		if($before instanceof FeatureValue){
			return $this->wpdb->update(
				$this->table,
				[
					"feature_value" => $feature->value ? self::TRUTHY_VALUE : self::FALSY_VALUE,
				],
				[
					"content_type" => $contentType,
					"content_id" => $contentId,
					"feature_key" => $feature->key,
				],
				[ "%s"],
				[ "%s", "%d", "%s"]
			);
		}
		return $this->wpdb->insert(
			$this->table,
			[
				"content_type" => $contentType,
				"content_id" => $contentId,
				"feature_key" => $feature->key,
				"feature_value" => $feature->value ? self::TRUTHY_VALUE : self::FALSY_VALUE,
			],
			[ "%s", "%d", "%s", "%s"]
		);
	}

	public function removeAllFeatures($contentType, $contentId){
		return $this->wpdb->delete(
			$this->table,
			[
				"content_type" => $contentType,
				"content_id" => $contentId,
			],
			["%s", "%d"]
		);
	}

	public function createTables() {
		parent::createTables();
		\dbDelta( "CREATE TABLE IF NOT EXISTS $this->table
			(
			 id bigint(20) unsigned auto_increment,
    		 content_id bigint(20) unsigned NOT NULL,
    		 content_type varchar(60) NOT NULL,
    		 feature_key varchar(160) NOT NULL,
    		 feature_value varchar(160) NOT NULL,
			 primary key (id),
    		 key (feature_key),
    		 key (feature_value),
    		 unique key content_feature (content_id, content_type, feature_key)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
	}
}
