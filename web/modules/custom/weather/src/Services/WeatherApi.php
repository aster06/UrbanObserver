<?php

namespace Drupal\weather\Services;

use Drupal\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
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
  ) {
  }

  /**
   * Creates a new instance of WeatherApi.
   */
  public static function create(ContainerInterface $container): static {
    return new static(
      $container->get('config.factory'),
      $container->get('http_client')
    );
  }

  /**
   * Weather Api Validation.
   */
  public function validateApi(string $apiKey): bool {
    if (empty($apiKey)) {
      return FALSE;
    }
    try {
      $client = $this->httpClient->request('GET', 'https://api.openweathermap.org/data/2.5/weather?q=London&appid=' . $apiKey);
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
      $res = $this->httpClient->request('GET', 'https://api.openweathermap.org/data/2.5/weather?q=' . $cityName . '&units=metric&appid=' . $apiKey);
    }
    catch (GuzzleException $e) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * Get the value from OpenWeather.
   */
  public function getWeatherValue(string $city, $key): array {
    try {
      $response = $this->httpClient->request('GET', 'https://api.openweathermap.org/data/2.5/weather?q=' . $city . '&units=metric&appid=' . $key);
      $body = (string) $response->getBody();
      $data = json_decode($body, TRUE);
      $tempCel = intval(round($data['main']['temp']));
      return [
        'city' => $city,
        'temperature' => $tempCel,
      ];
    }
    catch (GuzzleException $e) {
      return FALSE;
    }
  }

}
