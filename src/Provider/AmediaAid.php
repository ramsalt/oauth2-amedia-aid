<?php

namespace Ramsalt\OAuth2\Client\Provider;

use AmediaId\Api\DataModel\Profile;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

/**
 * Defines a client Provider for league/oauth2-client
 *
 * @package Ramsalt\OAuth2\Client\Provider
 */
class AmediaAid extends AbstractProvider {

  use BearerAuthorizationTrait;

  protected const BASE_API_URL = 'https://www.aid.no/api';

  protected const API_URL_V1_JUPITER = 'jupiter/v1';
  protected const API_URL_V1_PORTUNUS = 'portunus/v1';
  protected const API_URL_V2_MERCURY = 'mercury/v2';

  /**
   * OAuth scopes, setting predefined and allow override via constructor $options.
   *
   * @var array
   */
  protected $scopes = [
    'uuid',
    'name',
    'avatar',
    'email',
  ];

  /**
   * @inheritDoc
   *
   * @see  https://developer.api.no/aid/OAuth-authorization#authorization-endpoint---getting-the-authorization-grant-code
   */
  public function getBaseAuthorizationUrl() {
    return $this->getOAuthUrl('authorize');
  }

  /**
   * @inheritDoc
   *
   * @see https://developer.api.no/aid/OAuth-authorization#token-endpoint---getting-the-access-token
   */
  public function getBaseAccessTokenUrl(array $params) {
    return $this->getOAuthUrl('token');
  }

  /**
   * @inheritDoc
   *
   * @see https://developer.api.no/aid/OAuth-services#user-info-me-endpoint
   */
  public function getResourceOwnerDetailsUrl(AccessToken $token) {
    // Create the actual full URI path
    return implode(
      '/',
      [
        self::BASE_API_URL,
        self::URL_API_V2_MERCURY,
        'users/me',
      ]
    );
  }

  /**
   * @inheritDoc
   */
  protected function getDefaultHeaders() {
    $http_headers = parent::getDefaultHeaders();

    $http_headers['accept'] = 'application/json';

    return $http_headers;
  }

  /**
   * @inheritDoc
   */
  protected function getDefaultScopes() {
    if (!is_array($this->scopes)) {
      throw new \InvalidArgumentException('The oauth scopes MUST be an array.');
    }

    return $this->scopes;
  }

  /**
   * @inheritDoc
   */
  protected function getScopeSeparator() {
    return ' ';
  }

  /**
   * @inheritDoc
   */
  protected function checkResponse(ResponseInterface $response, $data) {
    $statusCode = $response->getStatusCode();
    // Status code is in the "Ok" range.
    if (200 <= $statusCode && $statusCode < 300) {

    }
    $r = $response;
    $d = $data;
  }

  /**
   * @inheritDoc
   */
  protected function createResourceOwner(array $response, AccessToken $token) {
    return Profile::createFromApiResponse($response);
  }

  /**
   * @inheritDoc
   */
  protected function buildQueryString(array $params) {
    // aID uses RFC1738 for query string decode instead of oauth2 standard RFC3986.
    return http_build_query($params, null, '&', \PHP_QUERY_RFC1738);
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
  protected function getOAuthUrl(string $path): string {
    // Create the actual full URI path
    return implode(
      '/',
      [
        self::BASE_API_URL,
        self::URL_API_V1_PORTUNUS,
        'oauth',
        $path,
      ]
    );
  }

  /**
   * @internal: this is not currently supported by aMedia
   */
  private function refreshAccessToken(AccessToken $accessToken) {
    throw new \BadMethodCallException('Refreshing token is not yet supported by aID.');

    $fresh_access_token = $this->getAccessToken(
      'refresh_token',
      ['refresh_token' => $accessToken->getRefreshToken(),]
    );

    return $fresh_access_token;
  }
}
