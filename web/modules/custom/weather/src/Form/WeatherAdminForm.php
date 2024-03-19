<?php

namespace Drupal\weather\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\weather\Services\WeatherApi;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * {@inheritdoc}
 */
class WeatherAdminForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function __construct(
    ConfigFactoryInterface $config_factory,
    $typedConfigManager,
    protected WeatherApi $openWeatherClient,
  ) {
    parent::__construct($config_factory, $typedConfigManager);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): WeatherAdminForm|ConfigFormBase|static {
    return new static(
      $container->get('config.factory'),
      $container->get('config.typed'),
      $container->get('weather.api_validation'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'weather_admin_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['weather.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = $this->config('weather.settings');
    $form['api_admin_key'] = [
      '#required' => TRUE,
      '#type' => 'textfield',
      '#title' => $this->t('OpenWeather Api Key'),
      '#description' => $this->t('The api key is required to get weather information in your weather block.'),
      '#default_value' => $config->get('api_admin_key'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $apiKey = $form_state->getValue('api_admin_key');

    // Fetching data from the OpenWeather site by entered API key.
    if (!$this->openWeatherClient->validateApi($apiKey)) {
      $form_state->setErrorByName('api_admin_key', $this->t('Your API key is not valid.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    // Saving entered api key in config.
    $config = $this->config('weather.settings');
    $config->set('api_admin_key', $form_state->getValue('api_admin_key'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
