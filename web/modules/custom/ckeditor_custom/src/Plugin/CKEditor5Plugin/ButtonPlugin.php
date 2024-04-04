<?php

declare(strict_types=1);

namespace Drupal\ckeditor_custom\Plugin\CKEditor5Plugin;

use Drupal\ckeditor5\Plugin\CKEditor5PluginConfigurableInterface;
use Drupal\ckeditor5\Plugin\CKEditor5PluginConfigurableTrait;
use Drupal\ckeditor5\Plugin\CKEditor5PluginDefault;
use Drupal\ckeditor5\Plugin\CKEditor5PluginElementsSubsetInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\editor\EditorInterface;

/**
 * CKEditor 5 Link Plugin.
 *
 * @internal
 *   Plugin classes are internal.
 */
class ButtonPlugin extends CKEditor5PluginDefault implements CKEditor5PluginConfigurableInterface, CKEditor5PluginElementsSubsetInterface {

  use CKEditor5PluginConfigurableTrait;

  const DEFAULT_CONFIGURATION = [
    'default_color' => 'blue',
  ];

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return static::DEFAULT_CONFIGURATION;
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $options = [
      'blue' => $this->t('blue'),
      'black' => $this->t('black'),
      'grey' => $this->t('grey'),
      'white' => $this->t('white'),
      'gold' => $this->t('gold'),
    ];
    $form['default_color'] = [
      '#type' => 'select',
      '#title' => $this->t('Default Link Color'),
      '#description' => $this->t('Enter the default color.'),
      '#default_value' => $this->configuration['default_color'],
      '#options' => $options,
      '#attributes' => ['type' => 'color'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['default_color'] = $form_state->getValue('default_color');
  }

  /**
   * {@inheritdoc}
   */
  public function getDynamicPluginConfig(array $static_plugin_config, EditorInterface $editor): array {
    $default_color = $this->configuration['default_color'];

    $dynamic_config = [
      'default_color' => $default_color,
    ];

    return $dynamic_config;
  }

  /**
   * {@inheritdoc}
   */
  public function getElementsSubset(): array {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
  }

}
