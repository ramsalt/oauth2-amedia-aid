<?php


namespace AmediaId\Api\DataModel;

class SubscriptionList extends \SplFixedArray {

  /**
   * Builds an object based on the raw api response.
   *
   * @see https://developer.api.no/aid/OAuth-services#user-subscriptions---list
   *
   * @param array $api_response
   *   Parsed json array as returned from the api.
   *
   * @return \AmediaId\Api\DataModel\SubscriptionList
   */
  public static function fromApiResponseArray(array $api_response): SubscriptionList {
    return static::fromArray($api_response['subscriptions'] ?? []);
  }

  /**
   * @inheritDoc
   */
  public static function fromArray(array $subscription_list): SubscriptionList {
    $subscriptions = [];
    foreach ($groups as $subsription_data) {
      $subscriptions[] = Subscription::fromArray($subsription_data);
    }

    return parent::fromArray($subscriptions, TRUE);
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
