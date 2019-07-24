<?php


namespace AmediaId\Api\DataModel;


class SubscriptionSource {

  /**
   * @var string
   *   The name of the subscription service.
   */
  protected $name;

  /**
   * SubscriptionSource constructor.
   *
   * @param string $service_name
   */
  protected function __construct(string $service_name) {
    $this->name = $service_name;
  }

  public static function createInfosoft(): self {
    return new static(
      'infosoft'
    );
  }

  /**
   * @return string
   */
  public function getName(): string {
    return $this->name;
  }

  /**
   * @inheritDoc
   */
  public function __toString() {
    return $this->name;
  }


}
