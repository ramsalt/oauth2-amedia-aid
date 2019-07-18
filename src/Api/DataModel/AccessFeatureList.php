<?php


namespace AmediaId\Api\DataModel;

class AccessFeatureList extends \SplFixedArray {

  /**
   * @inheritDoc
   */
  public static function fromArray(array $groups): AccessFeatureList {
    throw new \BadMethodCallException("Not implemented");

    $groupObjects = [];
    foreach ($groups as $group) {
      // @TODO
      $groupObjects[] = new Group();
    }

    return parent::fromArray($groupObjects, TRUE);
  }

  /**
   * @inheritDoc
   */
  public function offsetGet($index): AccessFeature {
    parent::offsetGet($index);
  }

  /**
   * @inheritDoc
   */
  public function current(): AccessFeature {
    parent::current();
  }

  /**
   * @inheritDoc
   */
  public function next(): AccessFeature {
    parent::next();
  }


}
