<?php

namespace Drupal\weather\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\weather\Services\WeatherApi;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form for user to choose a city for weather block.
 */
class WeatherUserForm extends FormBase {

  /**
   * Constructs a WeatherApi object.
   */
  public function __construct(ConfigFactoryInterface $config_factory,
                                                             $typedConfigManager,
                              protected WeatherApi $openWeatherClient) {
    parent::__construct($config_factory, $typedConfigManager);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): WeatherUserForm|static {
    return new static(
      $container->get('config.factory'),
      $container->get('config.typed'),
      $container->get('weather.api_validation')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'weather_user_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['user_form'] = [
      '#required' => TRUE,
      '#type' => 'textfield',
      '#title' => $this->t('City for weather'),
      '#description' => $this->t('Write a city to show the weather.'),
      '#default_value' => 'Lutsk',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    $cityName = $form_state->getValue('user_form');
    if (!$this->openWeatherClient->validateCityApi($cityName)) {
      $form_state->setErrorByName('user_form', $this->t('Your city is not valid.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {}

}
