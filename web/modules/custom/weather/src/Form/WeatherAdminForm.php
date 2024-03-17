<?php

namespace Drupal\weather\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * {@inheritdoc}
 */
class WeatherAdminForm extends ConfigFormBase {

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
  public function validateForm(array &$form, FormStateInterface $form_state): bool {
    $api_key = $form_state->getValue('api_admin_key');
    // Checking if we can get data from the OpenWeather site by entered api key.
    try {
      $client = \Drupal::httpClient();
      $res = $client->get('https://api.openweathermap.org/data/2.5/weather?q=London&appid=' . $api_key);
    }
    // If we can`t get data we show error.
    catch (\Exception $error) {
      $form_state->setErrorByName('api_admin_key', $this->t('Your API key is not valid.'));
    }
    return TRUE;
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
