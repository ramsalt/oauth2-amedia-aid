<?php


namespace AmediaId\Api;


use AmediaId\Api\DataModel\AccessFeatureType;
use AmediaId\Api\DataModel\GroupList;
use AmediaId\Api\DataModel\PrivacyInfo;
use AmediaId\Api\DataModel\Profile;
use AmediaId\Api\DataModel\PublicationList;
use AmediaId\Api\DataModel\SubscriptionList;
use League\OAuth2\Client\Token\AccessTokenInterface;

/**
 * Interface OauthUserServicesInterface
 *
 * @package AmediaId\Api
 */
interface OauthUserServicesInterface {

  /**
   * These services are used to get information about users.
   *
   * @see https://developer.api.no/aid/OAuth-services#user-info-me-endpoint
   *
   * @param AccessTokenInterface $access_token
   *   User access token, for identification.
   *
   * @return \AmediaId\Api\DataModel\Profile
   *   User profile.
   *
   * @throws \AmediaId\Api\Exception\OauthServiceException
   */
  public function getUserInfo(AccessTokenInterface $access_token): Profile;

  /**
   * Loads a list of user groups.
   *
   * @see https://developer.api.no/aid/OAuth-services#user-groups-by-uuid-endpoint
   *
   * @param AccessTokenInterface $access_token
   *   User access token, for identification.
   *
   * @return \AmediaId\Api\DataModel\GroupList
   *   A list of user groups.
   */
  public function getUserGroupList(AccessTokenInterface $access_token): GroupList;

  /**
   * Load user privacy preferences.
   *
   * @see https://developer.api.no/aid/OAuth-services#user-privacy-preferences-by-uuid-endpoint
   *
   * @param AccessTokenInterface $access_token
   *   User access token, for identification.
   *
   * @return mixed
   */
  public function getUserPrivacyPreferences(AccessTokenInterface $access_token): PrivacyInfo;

  /**
   * Returns a list of subscriptions.
   *
   * @param AccessTokenInterface $access_token
   *   User access token, for identification.
   *
   * @see https://developer.api.no/aid/OAuth-services#user-subscriptions---list
   *
   * @return SubscriptionList
   */
  public function getUserSubscriptionList(AccessTokenInterface $access_token): SubscriptionList;

  /**
   * If you need to check if a user has access to a certain publication, this is the endpoint to use.
   *
   * @see https://developer.api.no/aid/OAuth-services#access-by-access-features-endpoint
   *
   * @param AccessTokenInterface $access_token
   *   User access token, for identification.
   * @param string $domain
   *   Domain name to use as identifier.
   * @param string[]|AccessFeatureType[] $feature
   *   List of features, can be strings or AccessFeatureType objects.
   * @param bool  $require_all
   *   Indicates if it should check if user has access ALL OF the features (If false qill check for "ANY OF")
   *
   * @return bool
   */
  public function userHasAccess(AccessTokenInterface $access_token, string $domain, $features, bool $require_all = TRUE): bool;

  /**
   * @see https://developer.api.no/aid/OAuth-services#publications-by-access-feature-endpoint
   *
   * @param AccessTokenInterface $access_token
   *   User access token, for identification.
   * @param \AmediaId\Api\DataModel\AccessFeatureType $feature
   *
   * @return \AmediaId\Api\DataModel\PublicationList
   */
  public function getUserPublicationListByAccess(AccessTokenInterface $access_token, AccessFeatureType $feature): PublicationList;
}
