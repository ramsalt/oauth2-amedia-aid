<?php


namespace AmediaId\Api;


use AmediaId\Api\DataModel\AccessFeatureType;
use AmediaId\Api\DataModel\GroupList;
use AmediaId\Api\DataModel\PrivacyInfo;
use AmediaId\Api\DataModel\Profile;
use AmediaId\Api\DataModel\PublicationList;
use AmediaId\Api\DataModel\SubscriptionList;
use AmediaId\Api\DataModel\SubscriptionSource;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;

/**
 * Interface OauthUserServicesInterface
 *
 * @package AmediaId\Api
 */
interface OauthUserServicesInterface {

  /**
   * Special value of the UUIDs to reflect the same user making the request.
   */
  public const UUID_SELF = 'me';

  /**
   * These services are used to get information about users.
   *
   * @see https://developer.api.no/aid/OAuth-services#user-info-me-endpoint
   *
   * @param AccessToken $access_token
   *   User access token, for identification.
   *
   * @return \AmediaId\Api\DataModel\Profile
   *   User profile.
   *
   * @throws \AmediaId\Api\Exception\OauthServiceException
   */
  public function getUserInfo(AccessToken $access_token): Profile;

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
   * @see https://developer.api.no/aid/OAuth-services#user-subscriptions---list
   *
   * @param AccessTokenInterface $access_token
   *   User access token, for identification.
   * @param string $domain
   *   Domain name to use as identifier.
   * @param \AmediaId\Api\DataModel\SubscriptionSource $source
   *   Subscription system owning the subscription
   *
   * @return SubscriptionList
   */
  public function getUserSubscriptionList(AccessTokenInterface $access_token, string $domain, SubscriptionSource $source): SubscriptionList;

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
   * @param string|\AmediaId\Api\DataModel\AccessFeatureType $feature
   *   Access feature, can be string or AccessFeatureType.
   *
   * @return \AmediaId\Api\DataModel\PublicationList
   */
  public function getUserPublicationListByAccess(AccessTokenInterface $access_token, $feature): PublicationList;
}
