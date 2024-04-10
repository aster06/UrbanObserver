<?php

namespace Drupal\copyright\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Url;

/**
 * Provides a 'Copyright' Block.
 */
#[Block(
  id: 'copyright',
  admin_label: new TranslatableMarkup('Copyright block'),
  category: new TranslatableMarkup('Copyright block')
)]
class CopyrightBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $storage = \Drupal::entityTypeManager()->getStorage('config_pages');
    $entity = $storage->load('global_configurations');
    if (!$entity) {
      return [];
    }
    $field = $entity->get('field_copyrights')->view('default');

    return [
      '#theme' => 'copyright',
      '#text' => $field,
      '#cache' => [
        'tags' => $entity->getCacheTags(),
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state): array {
    $form['block_configuration'] = [
      '#type' => 'link',
      '#title' => $this->t('Copyrights text can be edited here.'),
      '#url' => Url::fromRoute('config_pages.global_configurations'),
    ];

    return parent::buildConfigurationForm($form, $form_state);
  }

}
