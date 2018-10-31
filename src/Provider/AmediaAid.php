<?php

namespace Ramsalt\OAuth2\Client\Provider;

use AmediaId\Api\DataModel\Profile;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

/**
 * Defines a client Provider for league/oauth2-client
 *
 * @package Ramsalt\OAuth2\Client\Provider
 */
class AmediaAid extends AbstractProvider {

  protected $isTesting = FALSE;

  protected const BASE_DOMAIN = 'www.aid.no';
  protected const BASE_OAUTH_PATH = 'api/portunus/v1/oauth';
  protected const BASE_API_PATH = 'api/mercury/v2';

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
   * Returns the base URL for authorizing a client.
   *
   * Eg. https://oauth.service.com/authorize
   *
   * @return string
   */
  public function getBaseAuthorizationUrl() {
    return $this->getOAuthUrl('authorize');
  }

  /**
   * Returns the base URL for requesting an access token.
   *
   * Eg. https://oauth.service.com/token
   *
   * @param array $params
   * @return string
   */
  public function getBaseAccessTokenUrl(array $params) {
    return $this->getOAuthUrl('token');
  }

  /**
   * Returns the URL for requesting the resource owner's details.
   *
   * @param AccessToken $token
   * @return string
   */
  public function getResourceOwnerDetailsUrl(AccessToken $token) {
    return $this->getApiUrl('users/me');
  }

  /**
   * Returns the default scopes used by this provider.
   *
   * This should only be the scopes that are required to request the details
   * of the resource owner, rather than all the available scopes.
   *
   * @return array
   */
  protected function getDefaultScopes() {
    if (!is_array($this->scopes)) {
      throw new \InvalidArgumentException('The oaUth scopes MUST be an array');
    }

    return $this->scopes;
  }

  /**
   * Returns the string that should be used to separate scopes when building
   * the URL for requesting an access token.
   *
   * @return string Scope separator, defaults to ' ', which encoded with RFC1738 becomes a `+`
   */
  protected function getScopeSeparator() {
    return ' ';
  }

  /**
   * Checks a provider response for errors.
   *
   * @throws IdentityProviderException
   * @param  ResponseInterface $response
   * @param  array|string $data Parsed response data
   * @return void
   */
  protected function checkResponse(ResponseInterface $response, $data) {
    $statusCode = $response->getStatusCode();
    xdebug_break();
    $r = $response;
    $d = $data;
  }

  /**
   * Generates a resource owner object from a successful resource owner
   * details request.
   *
   * @param  array $response
   * @param  AccessToken $token
   * @return ResourceOwnerInterface
   */
  protected function createResourceOwner(array $response, AccessToken $token) {
    return Profile::createFromApiResponse($response);
  }

  /**
   * Build a query string from an array.
   *
   * @note aMedia aID seems to use RFC1738 instead of oauth2 standard RFC3986
   *
   * @param array $params
   *
   * @return string
   */
  protected function buildQueryString(array $params) {
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
    return sprintf('https://%s/%s/%s', self::BASE_DOMAIN, self::BASE_OAUTH_PATH, $path);
  }

  /**
   * Builds an URL to the API endpoints.
   *
   * @param string $path
   *   Sub-path to append to the base api endpoint.
   *
   * @return string
   *   Complete and valid URL
   */
  protected function getApiUrl(string $path): string {
    return sprintf('https://%s/%s/%s', self::BASE_DOMAIN, self::BASE_API_PATH, $path);
  }


  /**
   * Attempts to refresh an access token.
   *
   * @param \League\OAuth2\Client\Token\AccessToken $accessToken
   *
   * @return \League\OAuth2\Client\Token\AccessToken
   *   The renewed access_token and relative refresh_token.
   */
  public function refreshAccessToken(AccessToken $accessToken) {
    $fresh_access_token = $this->getAccessToken(
      'refresh_token',
      ['refresh_token' => $accessToken->getRefreshToken(),]
    );

    return $fresh_access_token;
  }
}
