<?php


namespace AmediaId\Api;

use AmediaId\Api\DataModel\AccessFeatureType;
use AmediaId\Api\DataModel\GroupList;
use AmediaId\Api\DataModel\PrivacyInfo;
use AmediaId\Api\DataModel\Profile;
use AmediaId\Api\DataModel\PublicationList;
use AmediaId\Api\DataModel\SubscriptionList;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Ramsalt\OAuth2\Client\Provider\AmediaAid;

class OauthUserServices extends AmediaAid implements OauthUserServicesInterface {

  protected const ENDPOINT_USERS = self::API_URL_V2_MERCURY . '/users';

  protected const ENDPOINT_FEATURES = self::API_URL_V1_JUPITER . '/access_features';

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
  public function getUserInfo(AccessTokenInterface $access_token): Profile {
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
  public function getUserSubscriptionList(AccessTokenInterface $access_token): SubscriptionList {
    throw new \RuntimeException("Not implemented.");
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

    $request = $this->getAuthenticatedRequest(self::METHOD_GET, $url, $token);

    $response = $this->getParsedResponse($request);

    return TRUE;
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

  /**
   * @inheritDoc
   */
  public function getUserPublicationListByAccess(
    AccessTokenInterface $access_token,
    AccessFeatureType $feature
  ): PublicationList {
    throw new \RuntimeException("Not implemented.");
  }

}
