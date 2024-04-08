<?php

namespace Drupal\stores\Plugin\views\area;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\area\AreaPluginBase;

/**
 * Alter the Map Stores used by the view.
 *
 * @ingroup views_area_handlers
 *
 * @ViewsArea("custom_stores")
 */
class StoresCustomArea extends AreaPluginBase {

  /**
   * {@inheritdoc}
   */
  protected function defineOptions(): array {
    $options = parent::defineOptions();
    $options['color_border'] = ['default' => 'null'];
    $options['color'] = ['default' => 'null'];
    $options['size'] = ['default' => 10];
    $options['zoom'] = ['default' => 12];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state): void {
    parent::buildOptionsForm($form, $form_state);

    $form['color_border'] = [
      '#title' => $this->t('Select a color for markers border.'),
      '#type' => 'color',
      '#default_value' => $this->options['color_border'],
      '#required' => TRUE,
    ];

    $form['color'] = [
      '#title' => $this->t('Select a color for markers backgrounds.'),
      '#type' => 'color',
      '#default_value' => $this->options['color'],
      '#required' => TRUE,
    ];

    $form['size'] = [
      '#title' => $this->t('Select a size of the markers.'),
      '#type' => 'textfield',
      '#default_value' => $this->options['size'],
      '#required' => TRUE,
    ];

    $form['zoom'] = [
      '#title' => $this->t('Select a zoom for the map.'),
      '#type' => 'textfield',
      '#default_value' => $this->options['zoom'],
      '#required' => TRUE,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function render($empty = FALSE): array {
    $build['#attached']['library'][] = 'stores/custom_stores_leaflet';
    $stores = $this->view->result;
    $config_id = $this->view->id() . '_' . $this->view->current_display;
    $stores_variables = [
      'color_border' => $this->options['color_border'],
      'color' => $this->options['color'],
      'size' => $this->options['size'],
      'zoom' => $this->options['zoom'],
    ];
    foreach ($stores as $store) {
      $entity = $store->_entity;
      $location = $entity->get('field_location')->getValue();
      $title = $entity->get('title')->value;
      $build['#attached']['drupalSettings']['coordinates'][$config_id][] = [
        'title' => $title,
        'location' => $location,
      ];
    }

    $build['#attached']['drupalSettings']['stores'][$config_id] = $stores_variables;
    $build['#markup'] = "<div id='map' data-config-id='$config_id'></div>";
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function validate():array {
    $errors = parent::validate();
    $size = $this->options['size'];
    if (!is_numeric($size) || $size < 0 || $size > 25) {
      $errors[] = $this->t('Marker size must be a number between 0 and 25.');
    }
    $zoom = $this->options['zoom'];
    if (!is_numeric($zoom) || $zoom < 0) {
      $errors[] = $this->t('Zoom should be a positive number.');
    }
    return $errors;
  }

}
