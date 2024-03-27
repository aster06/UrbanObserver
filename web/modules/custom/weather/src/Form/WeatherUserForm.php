<?php

namespace Drupal\weather\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\weather\Services\WeatherApi;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form for user to choose a city for weather block.
 */
class WeatherUserForm extends FormBase {

  /**
   * Constructs a WeatherUserForm object.
   */
  public function __construct(
    ConfigFactoryInterface $config_factory,
    $typedConfigManager,
    protected Connection $connection,
    protected $messenger,
    protected AccountProxyInterface $currentUser,
    protected WeatherApi $openWeatherClient,
  ) {
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): WeatherUserForm|static {
    return new static(
      $container->get('config.factory'),
      $container->get('config.typed'),
      $container->get('database'),
      $container->get('messenger'),
      $container->get('current_user'),
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
    $city = $this->openWeatherClient->getCityName();
    $form['user_city'] = [
      '#required' => TRUE,
      '#type' => 'textfield',
      '#title' => $this->t('City for weather'),
      '#description' => $this->t('Write a city to show the weather.'),
      '#default_value' => $city ?? $this->t('Lutsk'),
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
    $cityName = $form_state->getValue('user_city');
    if (!$this->openWeatherClient->validateCityApi($cityName)) {
      $form_state->setErrorByName('user_city', $this->t('Your city is not valid.'));
    }
  }

  /**
   * {@inheritdoc}
   *
   * @throws \Exception
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $cityName = $form_state->getValue('user_city');
    $this->openWeatherClient->cityUpdate($cityName);
    $this->messenger->addStatus(t('Your city is set.'));

  }

}
