<?php


namespace AmediaId\Api\DataModel;


class AccessFeatureType {

  public const ALLOWED_VALUES = [
    'newspaper',
    'amedia_staff',
    'epaper',
    'pluss',
    'weekendmag',
  ];

  /**
   * @var string
   *   One of self::ALLOWED_VALUES
   */
  protected $value;

  /**
   * @inheritDoc
   */
  public function __construct(string $value) {
    if (!in_array($value, self::ALLOWED_VALUES)) {
      throw new \InvalidArgumentException('Invalid access feature type.');
    }
    $this->value = $value;
  }

  /**
   * @inheritDoc
   */
  public function __toString() {
    return $this->value;
  }

  /**
   * Given a list of items it will try to validate them.
   *
   * @param array $list
   *   List of AccessFeatureType and/or strings.
   *
   * @return \AmediaId\Api\DataModel\AccessFeatureType[]
   *   Validated and normalised list of features.
   */
  public static function validateList(array $list): array {
    $valid_features = [];
    // Ensure each item in the aray is either a valid AccessFeatureType or a string rappresenting an
    // acceptable value for AccessFeatureType.
    foreach ($list as $feature) {
      if (is_string($feature)) {
        // The creation will fail if it's not a valid acces feature.
        $feature = new AccessFeatureType($feature);
      }
      elseif (!is_a($feature, static::class)) {
        throw new \InvalidArgumentException("Item must be a valid access feature type");
      }

      $valid_features[] = $feature;
    }

    return $valid_features;
  }

  /**
   * @param array $list
   *
   * @return array
   */
  public static function featureListToStringArray(array $list): array {
    $list = static::validateList($list);
    foreach ($list as &$item) {
      $item = (string) $item;
    }

    return $list;
  }
}
