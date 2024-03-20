<?php

namespace Drupal\weather\Services;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Session\AccountProxyInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Service class WeatherApi.
 */
class WeatherApi {

  /**
   * Constructs a new WeatherApi object.
   */
  public function __construct(
    protected ConfigFactoryInterface $configFactory,
    protected ClientInterface $httpClient,
    protected Connection $connection,
    protected AccountProxyInterface $currentUser,
  ) {
  }

  /**
   * Weather Api Validation.
   */
  public function validateApi(string $apiKey): bool {
    if (empty($apiKey)) {
      return FALSE;
    }
    try {
      $this->httpClient->request('GET', 'https://api.openweathermap.org/data/2.5/weather?q=London&appid=' . $apiKey);
    }
    catch (GuzzleException $e) {
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
      $this->httpClient->request('GET', 'https://api.openweathermap.org/data/2.5/weather?q=' . $cityName . '&units=metric&appid=' . $apiKey);
    }
    catch (GuzzleException $e) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Get the value from OpenWeather.
   */
  public function getWeatherValue(string $city): array {
    $config = $this->configFactory->get('weather.settings');
    $apiKey = $config->get('api_admin_key');
    try {
      $response = $this->httpClient->request('GET', 'https://api.openweathermap.org/data/2.5/weather?q=' . $city . '&units=metric&appid=' . $apiKey);
      $body = (string) $response->getBody();
      $data = json_decode($body, TRUE);
      $tempCel = (int) round($data['main']['temp']);
      if (empty($apiKey)) {
        return [];
      }
      return [
        'city' => $city,
        'temperature' => $tempCel,
      ];
    }
    catch (GuzzleException $e) {
      return [];
    }
  }

  /**
   * Get a city name.
   */
  public function getCityName() {
    $uid = $this->currentUser->id();
    $city = $this->connection
      ->select('weather_info', 't')
      ->condition('uid', $uid)
      ->fields('t', ['user_city'])
      ->execute();

    return $city->fetchField();
  }

  /**
   * Update field with a city.
   */
  public function cityUpdate($cityName): void {
    $user = $this->currentUser->id();
    $data = [
      'uid' => $user,
      'user_city' => $cityName,
    ];
    $this->connection->merge('weather_info')
      ->keys(['uid' => $user])
      ->fields($data)
      ->execute();
  }

}
