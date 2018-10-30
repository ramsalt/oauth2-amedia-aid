<?php

namespace AmediaId\Api\DataModel;


use League\OAuth2\Client\Provider\ResourceOwnerInterface;

/**
 * Implements a ResourceOwner for Amedia aID Oauth
 *
 * @package AmediaId\Api\ataModel
 *
 * @see https://developer.api.no/aid/OAuth-services#user-info-services
 */
class Profile implements ResourceOwnerInterface {

  /**
   * The unique identifier of the user in aID.
   *
   * @var string
   */
  protected $uuid;

  /**
   * The primary key of the user in the aID database.
   * Needed for linking application specific data to a specific aID user using legacy systems.
   *
   * @var string
   */
  protected $id;

  /**
   * The full name of the user.
   *
   * @var string
   */
  protected $name;

  /**
   * The URL of user’s profile picture, or alternative picture used to represent the user.
   *
   * @var string
   */
  protected $avatar;

  /**
   * The user’s email address.
   *
   * @var string
   */
  protected $email;

  /**
   * The user’s mobile phone number.
   *
   * @var string
   */
  protected $phone;

  /**
   * The user’s birth date.
   *
   * @var \DateTimeImmutable
   */
  protected $birth_date;

  /**
   * A tracking key that is used to anonymously track the user’s behavior.
   * Needed for integration with statistics systems.
   *
   * @important Should never be saved in the application.
   *
   * @var string
   */
  protected $tracking_key;

  /**
   * List of user’s external accounts (Facebook etc.)
   *
   * @var array
   */
  protected $external_accounts;

  /**
   * Given a data array will create a Profile object.
   *
   * @param array $response
   *
   * @return \AmediaId\Api\DataModel\Profile
   */
  public static function createFromApiResponse(array $response): Profile {
    $profile = new static();

    foreach ($response as $property => $value) {
      if (property_exists($profile, $property)) {
        $profile->{$property} = $value;
      }
    }

    return $profile;
  }

  /**
   * @inheritdoc
   */
  public function getId() {
    return $this->uuid;
  }

  /**
   * @inheritdoc
   */
  public function toArray() {
    return (array) $this;
  }

}
