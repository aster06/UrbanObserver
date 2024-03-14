<?php

namespace Drupal\weather\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Provides a 'Weather' Block.
 */
#[Block(
  id: "weather",
  admin_label: new TranslatableMarkup("Weather block"),
  category: new TranslatableMarkup("Weather block")
)]
class WeatherBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $city = 'Lutsk';
    $key = '00be8ffdef324d4ca2c112336241403';
    $res = file_get_contents('http://api.weatherapi.com/v1/current.json?key=' . $key . '&q=' . $city);
    $res = json_decode($res, TRUE);
    $tempCel = intval(round($res['current']['temp_c']));
    $temp = "$city $tempCel °C";
    return [
      '#theme' => 'weather',
      '#temp' => $temp,
    ];
  }

}
