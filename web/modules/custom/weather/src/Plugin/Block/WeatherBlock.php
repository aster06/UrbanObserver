<?php

namespace Drupal\weather\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
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
   * Constructs a ConfigFactory a Client object.
   */
  public function __construct(array $configuration,
                                                               $plugin_id,
                                                               $plugin_definition,
                              protected ConfigFactoryInterface $configFactory,
                              protected ClientInterface $httpClient,
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
                       $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('http_client')
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
    $city = 'Lutsk';
    $key = $this->getWeatherSetting();
    $res = $this->httpClient->get('https://api.openweathermap.org/data/2.5/weather?q=' . $city . '&units=metric&appid=' . $key);
    $body = (string) $res->getBody();
    $res = json_decode($body, TRUE);
    $tempCel = intval(round($res['main']['temp']));
    $temp = "$city $tempCel °C";
    return [
      '#theme' => 'weather',
      '#temp' => $temp,
    ];
  }

}
