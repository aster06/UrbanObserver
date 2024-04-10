<?php

namespace Drupal\copyright\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Copyright' Block.
 */
#[Block(
  id: 'copyright',
  admin_label: new TranslatableMarkup('Copyright block'),
  category: new TranslatableMarkup('Copyright block')
)]
class CopyrightBlock extends BlockBase implements ContainerFactoryPluginInterface {

  public function __construct(array $configuration, $plugin_id, $plugin_definition, protected EntityTypeManagerInterface $entityTypeManager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): static {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $storage = $this->entityTypeManager->getStorage('config_pages');
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
