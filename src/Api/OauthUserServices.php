<?php


namespace AmediaId\Api;

use AmediaId\Api\DataModel\AccessFeatureType;
use AmediaId\Api\DataModel\GroupList;
use AmediaId\Api\DataModel\PrivacyInfo;
use AmediaId\Api\DataModel\Profile;
use AmediaId\Api\DataModel\PublicationList;
use AmediaId\Api\DataModel\SubscriptionList;
use AmediaId\Api\DataModel\SubscriptionSource;
use InvalidArgumentException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Ramsalt\OAuth2\Client\Provider\AmediaAid;

/**
 * Class OauthUserServices
 *
 * @package AmediaId\Api
 */
class OauthUserServices extends AmediaAid implements OauthUserServicesInterface {

  protected const ENDPOINT_USERS = self::API_URL_V2_MERCURY . '/users';

  protected const ENDPOINT_FEATURES = self::API_URL_V1_JUPITER . '/access_features';

  protected const ENDPOINT_PUBLICATIONS = self::API_URL_V1_JUPITER . '/publications';

  /**
   * @inheritDoc
   */
  protected function getDefaultScopes() {
    // Add required extra scopes.
    return [
        'groups',
        'privacy_preferences',
        'access',
      ] + parent::getDefaultScopes();
  }

  /**
   * @inheritDoc
   */
  public function getUserInfo(AccessToken $access_token): Profile {
    /** @noinspection PhpIncompatibleReturnTypeInspection */
    return $this->getResourceOwner($access_token);
  }

  /**
   * @inheritDoc
   */
  public function getUserGroupList(AccessTokenInterface $access_token): GroupList {
    throw new \RuntimeException("Not implemented.");
  }

  /**
   * @inheritDoc
   */
  public function getUserPrivacyPreferences(AccessTokenInterface $access_token): PrivacyInfo {
    throw new \RuntimeException("Not implemented.");
  }

  /**
   * @inheritDoc
   */
  public function getUserSubscriptionList(AccessTokenInterface $access_token, string $domain, SubscriptionSource $source): SubscriptionList {
    $path_components = [
      self::ENDPOINT_USERS,
      self::UUID_SELF,
      'subscriptions',
      $domain,
      (string) $source,
    ];
    $url = $this->getApiUrl(implode('/', $path_components));

    $request = $this->getAuthenticatedRequest(self::METHOD_GET, $url, $access_token);
    $response = $this->getParsedResponse($request);

    return SubscriptionList::fromApiResponseArray($response);
  }

  /**
   * @inheritDoc
   */
  public function userHasAccess(AccessTokenInterface $access_token, string $domain, $features, $require_all = TRUE): bool {
    // Ensure we always handle a aray of Access Features.
    if (!is_array($features)) {
      $features = [$features];
    }

    $feature_list = implode(',', AccessFeatureType::featureListToStringArray($features));
    $path_components = [
      self::ENDPOINT_FEATURES,
      $domain,
      $feature_list,
    ];
    $url = $this->getApiUrl(implode('/', $path_components)) . '?require=';
    $url .= '?require=' . ($require_all) ? 'all' : 'any';

    $request = $this->getAuthenticatedRequest(self::METHOD_GET, $url, $access_token);
    $response = $this->getParsedResponse($request);

    return $response['access'] === TRUE;
  }

  /**
   * @inheritDoc
   */
  public function getUserPublicationListByAccess(AccessTokenInterface $access_token, $feature): PublicationList {
    $path_components = [
      self::ENDPOINT_PUBLICATIONS,
      (string) $this->validateAccessFeature($feature),
    ];
    $url = $this->getApiUrl(implode('/', $path_components));

    $request = $this->getAuthenticatedRequest(self::METHOD_GET, $url, $access_token);
    $response = $this->getParsedResponse($request);

    return PublicationList::fromArray($response);
  }

  /**
   * Validates an access feature type.
   *
   * @param string|\AmediaId\Api\DataModel\AccessFeatureType $item
   *   The item to ba validated.
   *
   * @return \AmediaId\Api\DataModel\AccessFeatureType
   *   The validated access feature object.
   *
   * @throws \InvalidArgumentException
   *   If the validation fails.
   */
  protected function validateAccessFeature($item) {
    // Ensure we get a valid value as paameter.
    if (!is_string($item) && !is_a($item, AccessFeatureType::class)) {
      throw new InvalidArgumentException("Feature argument MUST be a string or an AccessFeatureType object.");
    }
    elseif (is_string($item)) {
      // Validate the feature if passed as sring, by creating the object will throw an exception if is not valid.
      $item = new AccessFeatureType($item);
    }

    return $item;
  }

  /**
   * Builds an URL to the OAuth endpoints.
   *
   * @param string $path
   *   Sub-path to append to the base endpoint.
   *
   * @return string
   *   Complete and valid URL
   */
  protected function getApiUrl(string $path): string {
    // Create the actual full URI path
    return implode('/', [self::BASE_API_URL, $path]);
  }
}
