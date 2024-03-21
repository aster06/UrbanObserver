<?php

namespace Drupal\weather\Cache;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Cache\Context\CacheContextInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\weather\Services\WeatherApi;

/**
 * Defines a cache context for weather information based on user.
 */
class WeatherCacheContext implements CacheContextInterface {

  /**
   * Constructs a new WeatherCacheContext object.
   */
  public function __construct(
    protected AccountProxyInterface $currentUser,
    protected Connection $database,
    protected WeatherApi $openWeatherClient,
  ) {
  }

  /**
   * {@inheritdoc}
   */
  public static function getLabel(): string {
    return t('City and User Cache Context');
  }

  /**
   * {@inheritdoc}
   */
  public function getContext(): string {
    $city = $this->openWeatherClient->getCityName();

    return 'custom_cache_context:' . $city;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheableMetadata(): CacheableMetadata {
    return new CacheableMetadata();
  }

}
