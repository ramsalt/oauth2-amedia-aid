<?php


namespace AmediaId\Api\DataModel;

class SubscriptionList extends \SplFixedArray {

  /**
   * @inheritDoc
   */
  public static function fromArray(array $groups): SubscriptionList {
    throw new \BadMethodCallException("Not implemented");

    $groupObjects = [];
    foreach ($groups as $group) {
      // @TODO
      $groupObjects[] = new Subscription();
    }

    return parent::fromArray($groupObjects, TRUE);
  }

  /**
   * @inheritDoc
   */
  public function offsetGet($index): Subscription {
    parent::offsetGet($index);
  }

  /**
   * @inheritDoc
   */
  public function current(): Subscription {
    parent::current();
  }

  /**
   * @inheritDoc
   */
  public function next(): Subscription {
    parent::next();
  }


}
