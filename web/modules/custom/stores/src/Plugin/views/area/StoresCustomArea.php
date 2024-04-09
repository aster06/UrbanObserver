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
      '#type' => 'number',
      '#default_value' => $this->options['size'],
      '#required' => TRUE,
      '#min' => 1,
      '#max' => 25,
    ];

    $form['zoom'] = [
      '#title' => $this->t('Select a zoom for the map.'),
      '#type' => 'number',
      '#default_value' => $this->options['zoom'],
      '#required' => TRUE,
      '#min' => 1,
      '#max' => 100,
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
    $build['#markup'] = "<div class='map_leaflet' data-config-id='$config_id'></div>";
    return $build;
  }

}
