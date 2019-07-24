<?php


namespace AmediaId\Api\DataModel;

class PublicationList extends \SplFixedArray {

  /**
   * @inheritDoc
   */
  public static function fromArray(array $groups): PublicationList {
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
  public function offsetGet($index): Publication {
    parent::offsetGet($index);
  }

  /**
   * @inheritDoc
   */
  public function current(): Publication {
    parent::current();
  }

  /**
   * @inheritDoc
   */
  public function next(): Publication {
    parent::next();
  }


}
