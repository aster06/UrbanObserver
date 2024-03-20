<?php

namespace Drupal\weather\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
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
    protected WeatherApi $openWeatherClient,
  ) {
    parent::__construct($config_factory, $typedConfigManager);
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
    $city = $this->connection->select('weather_info', 't')
      ->fields('t', ['user_city'])->execute()->fetchAll();
    foreach ($city as $row) {
      $city = $row->user_city;
    }
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
    $data = [
      'user_city' => $cityName,
    ];
    $this->connection->insert('weather_info')
      ->fields($data)
      ->execute();
    $this->messenger->addStatus(t('Your city is set.'));
  }

}
