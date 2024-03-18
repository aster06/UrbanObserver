<?php

namespace Drupal\weather\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
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
   * Variable for Config Factory.
   */
  protected $configFactory;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $configFactory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $configFactory;
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
      $container->get('config.factory')
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
    $client = \Drupal::httpClient();
    $res = $client->get('https://api.openweathermap.org/data/2.5/weather?q=' . $city . '&units=metric&appid=' . $key);
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
