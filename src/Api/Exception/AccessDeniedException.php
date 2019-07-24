<?php


namespace AmediaId\Api\Exception;


use Throwable;

/**
 * Identifies an Access Denied error while communicating with the API.
 *
 * @package AmediaId\Api\Exception
 */
class AccessDeniedException extends OauthServiceException {

  /**
   * The data returned from the API.
   *
   * @var array
   */
  protected $data;

  /**
   * @inheritDoc
   */
  public function __construct($message, array $data, $code = 0, Throwable $previous = NULL) {
    parent::__construct($message, $code, $previous);
  }

  /**
   * @return array
   */
  public function getData(): array {
    return $this->data ?? [];
  }
}
