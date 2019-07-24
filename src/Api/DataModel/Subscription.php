<?php


namespace AmediaId\Api\DataModel;


/**
 * Class Subscription
 *
 * @see https://developer.api.no/aid/OAuth-services#user-subscriptions-services
 *
 * @package AmediaId\Api\DataModel
 */
class Subscription {

  public const PRIMARY = 'primary';

  public const SECONDARY = 'secondary';

  /**
   * Can be either 'primary' or 'secondary'.
   *
   * @var string
   */
  protected $connectionType;

  /**
   * The subscription identifier.
   *
   * @var string
   */
  protected $subscriptionId;

  /**
   * Subscription constructor.
   *
   * @param string $type
   *   One of self::PRIMARY or self::SECONDARY.
   * @param string $id
   *   Any subscription Identifier.
   */
  protected function __construct($type, $id) {
    if ($type !== self::PRIMARY && $type !== self::SECONDARY) {
      throw new \InvalidArgumentException("Subscription type MUST be either primary or secondary");
    }

    $this->connectionType = (string) $type;
    $this->subscriptionId = (string) $id;
  }

  /**
   * Builds a new instance given the data in an array form.
   *
   * @param array $data
   *   Must contain 'subscription_id' and can also contain 'connection_type'.
   *
   * @return \AmediaId\Api\DataModel\Subscription
   */
  public static function fromArray(array $data): Subscription {
    if (!isset($data['subscription_id'])) {
      throw new \InvalidArgumentException("A subscriptio needs an ID.");
    }

    if (!isset($data['connection_type'])) {
      $data['connection_type'] = static::PRIMARY;
    }

    return new static(
      $data['connection_type'],
      $data['subscription_id']
    );
  }

  /**
   * Checks whether it's a primary subscription.
   *
   * @return bool
   */
  public function isPrimary(): bool {
    return $this->connectionType === self::PRIMARY;
  }

  /**
   * Checks whether it's a seconday subscription.
   *
   * @return bool
   */
  public function isSecondary(): bool {
    return $this->connectionType === self::SECONDARY;
  }

  /**
   * @return string
   */
  public function getConnectionType(): string {
    return $this->connectionType;
  }

  /**
   * Sets the subscription connection type.
   *
   * @param string $connectionType
   *
   * @return self
   */
  public function withConnectionType(string $connectionType): self {
    $this->connectionType = $connectionType;

    return $this;
  }

  /**
   * Returns the current Subscription ID.
   *
   * @return string
   */
  public function getSubscriptionId(): string {
    return $this->subscriptionId;
  }

  /**
   * Sets the Subscription ID.
   *
   * @param string $subscriptionId
   *
   * @return self
   */
  public function withSubscriptionId(string $subscriptionId): self {
    $this->subscriptionId = $subscriptionId;

    return $this;
  }


}
