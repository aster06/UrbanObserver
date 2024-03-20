<?php

namespace Drupal\weather\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\weather\Services\WeatherApi;
use GuzzleHttp\ClientInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Weather' Block.
 */
#[Block(
  id: "weather",
  admin_label: new TranslatableMarkup("Weather block"),
  category: new TranslatableMarkup("Weather block")
)]
class WeatherBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Constructs a WeatherBlock object.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    protected ConfigFactoryInterface $configFactory,
    protected ClientInterface $httpClient,
    protected Connection $connection,
    protected WeatherApi $openWeatherClient,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(
    ContainerInterface $container,
    array $configuration,
    $plugin_id,
    $plugin_definition
  ) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('http_client'),
      $container->get('database'),
      $container->get('weather.api_validation'),
    );
  }

  /**
   * Gets weather setting.
   */
  public function getWeatherSetting() {
    $config = $this->configFactory->get('weather.settings');
    return $config->get('api_admin_key');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $city = $this->connection->select('weather_info', 't')
      ->fields('t', ['user_city'])->execute()->fetchAll();
    foreach ($city as $row) {
      $city = $row->user_city;
    }
    // Default value if we do not have value in the database.
    if (empty($city)) {
      $city = "Lutsk";
    }
    $key = $this->getWeatherSetting();
    if (empty($key)) {
      return [];
    }
    $weatherData = $this->openWeatherClient->getWeatherValue($city, $key);
    $tempCel = $weatherData['temperature'];
    $temp = "$city $tempCel °C";

    return [
      '#theme' => 'weather',
      '#temp' => $temp,
    ];
  }

}
