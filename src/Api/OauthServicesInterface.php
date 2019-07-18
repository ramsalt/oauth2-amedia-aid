<?php


namespace AmediaId\Api;


use AmediaId\Api\DataModel\Profile;
use MongoDB\Driver\Monitoring\Subscriber;

interface OauthServicesInterface {

  public const UUID_ME = 'me';

  /**
   * These services are used to get information about users.
   *
   * @see https://developer.api.no/aid/OAuth-services#user-info-me-endpoint
   *
   * @param string $uuid
   *   User UUID or the special value "me".
   *
   * @return \AmediaId\Api\DataModel\Profile
   *   User profile.
   *
   * @throws \AmediaId\Api\Exception\OauthServiceException
   */
  public function getUserInfo(string $uuid = self::UUID_ME): Profile;

  /**
   * For use cases where you need to look up a user based only on a username, this is the service for you.
   *
   * @see https://developer.api.no/aid/OAuth-services#user-info-by-username-endpoint
   *
   * @param string $name
   *   Mobile phone number or email address to look for.
   *
   * @return \AmediaId\Api\DataModel\Profile
   *   User profile.
   *
   * @throws \AmediaId\Api\Exception\OauthServiceException
   */
  public function findUserByName(string $username): Profile;

  /**
   * This is the endpoint to check for the existence of a phone or email (username) in aID.
   *
   * @see https://developer.api.no/aid/OAuth-services#user-info-existence-by-username
   *
   * @param string $name
   *   Mobile phone number or email address to look for.
   *
   * @return bool
   *   Whether the profile exists or not.
   *
   * @throws \AmediaId\Api\Exception\OauthServiceException
   */
  public function userExists(string $username): bool;

  /**
   * Loads a list of user groups.
   *
   * @see https://developer.api.no/aid/OAuth-services#user-groups-by-uuid-endpoint
   *
   * @param string $uuid
   *   User UUID or the special value "me".
   *
   * @return \AmediaId\Api\GroupList
   *   A list of user groups.
   */
  public function getUserGroupList(string $uuid = self::UUID_ME): GroupList;

  /**
   * Load user privacy preferences.
   *
   * @see https://developer.api.no/aid/OAuth-services#user-privacy-preferences-by-uuid-endpoint
   *
   * @param string $uuid
   *
   * @return mixed
   */
  public function getPrivacyPrefences(string $uuid = self::UUID_ME): PrivacyInfo;

  /**
   * Returns a list of subscriptions.
   *
   * @see https://developer.api.no/aid/OAuth-services#user-subscriptions---list
   *
   * @return SubscriptionList
   */
  public function getSubscriptionList(): SubscriptionList;

  /**
   * Add a new subscription to a user.
   *
   * @see https://developer.api.no/aid/OAuth-services#user-subscriptions---add-service
   */
  public function addSubscription();


  /**
   * If you need to check if a user has access to a certain publication, this is the endpoint to use.
   *
   * @see https://developer.api.no/aid/OAuth-services#access-by-access-features-endpoint
   *
   * @param string                          $domain
   * @param \AmediaId\Api\AccessFeatureType $feature
   *
   * @return bool
   */
  public function hasAccess(string $domain, AccessFeatureType $feature): bool;

  /**
   * @see https://developer.api.no/aid/OAuth-services#publications-by-access-feature-endpoint
   *
   * @param \AmediaId\Api\AccessFeatureType $feature
   *
   * @return \AmediaId\Api\PublicationList
   */
  public function getPublicationListByAccess(AccessFeatureType $feature): PublicationList;
}
