<?php


namespace AmediaId\Api;


use AmediaId\Api\DataModel\Profile;
use League\OAuth2\Client\Token\AccessTokenInterface;

class OauthUserServices implements OauthServicesInterface {

  /**
   * @var \League\OAuth2\Client\Token\AccessTokenInterface
   */
  protected $accessToken;

  /**
   * @inheritDoc
   */
  public function __construct(AccessTokenInterface $access_token) {
    $this->accessToken = $access_token;
  }

  /**
   * @inheritDoc
   */
  public function getUserInfo(string $uuid = self::UUID_ME): Profile {
    throw new \RuntimeException("Not implemented");
  }

  /**
   * @inheritDoc
   */
  public function findUserByName(string $username): Profile {
    throw new \RuntimeException("Not implemented");
  }

  /**
   * @inheritDoc
   */
  public function userExists(string $username): bool {
    throw new \RuntimeException("Not implemented");
  }

  /**
   * @inheritDoc
   */
  public function getUserGroupList(string $uuid = self::UUID_ME): GroupList {
    throw new \RuntimeException("Not implemented");
  }

  /**
   * @inheritDoc
   */
  public function getPrivacyPrefences(string $uuid = self::UUID_ME): PrivacyInfo {
    throw new \RuntimeException("Not implemented");
  }

  /**
   * @inheritDoc
   */
  public function getSubscriptionList(): SubscriptionList {
    throw new \RuntimeException("Not implemented");
  }

  /**
   * @inheritDoc
   */
  public function addSubscription() {
    throw new \RuntimeException("Not implemented");
  }

  /**
   * @inheritDoc
   */
  public function hasAccess(string $domain, AccessFeatureType $feature): bool {
    throw new \RuntimeException("Not implemented");
  }

  /**
   * @inheritDoc
   */
  public function getPublicationListByAccess(AccessFeatureType $feature): PublicationList {
    throw new \RuntimeException("Not implemented");
  }
}
