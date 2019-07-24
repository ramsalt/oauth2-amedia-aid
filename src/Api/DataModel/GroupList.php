<?php


namespace AmediaId\Api\DataModel;

class GroupList extends \SplFixedArray {

  /**
   * @inheritDoc
   */
  public static function fromArray(array $groups): \SplFixedArray {
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
  public function offsetGet($index): Group {
    parent::offsetGet($index);
  }

  /**
   * @inheritDoc
   */
  public function current(): Group {
    parent::current();
  }

  /**
   * @inheritDoc
   */
  public function next(): Group {
    parent::next();
  }


}
