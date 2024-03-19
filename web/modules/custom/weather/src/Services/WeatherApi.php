<?php

namespace Drupal\weather\Services;

use Drupal\Core\Config\ConfigFactoryInterface;
use GuzzleHttp\ClientInterface;

/**
 * Class WeatherApi.
 */
class WeatherApi {

  /**
   * Constructor.
   */
  public function __construct(
    protected ConfigFactoryInterface $configFactory,
    protected ClientInterface $httpClient,
  ) {}

  /**
   * Weather Api Validation.
   */
  public function validateApi(string $apiKey): bool {
    try {
      $client = $this->httpClient->get('http_client');
      $client->get('https://api.openweathermap.org/data/2.5/weather?q=London&appid=' . $apiKey);
    }
    catch (\Exception $error) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Weather City Validation.
   */
  public function validateCityApi(string $cityName): bool {
    $config = $this->configFactory->get('weather.settings');
    $apiKey = $config->get('api_admin_key');
    try {
      $client = \Drupal::httpClient();
      $res = $client->get('https://api.openweathermap.org/data/2.5/weather?q=' . $cityName . '&units=metric&appid=' . $apiKey);
      $body = (string) $res->getBody();
      json_decode($body, TRUE);
    }
    catch (\Exception $error) {
      return FALSE;
    }
    return TRUE;
  }

}
