<?php

namespace Drupal\custom_batch\Commands;

use Drupal\Core\DependencyInjection\DependencySerializationTrait;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drush\Commands\DrushCommands;

/**
 * Defines Drush commands for batch operations.
 */
class BatchDrushCommands extends DrushCommands {
  use DependencySerializationTrait;

  public function __construct(protected EntityTypeManagerInterface $entityTypeManager) {
    parent::__construct();
  }

  /**
   * Updates node text format.
   *
   * @command custom-text-format
   */
  public function customBatchUpdate(): void {
    $batch = [
      'operations' => [
        [[$this, 'batchItemsUpdate'], []],
      ],
    ];

    batch_set($batch);
    drush_backend_batch_process();
  }

  /**
   * Process batch items.
   */
  public function batchItemsUpdate(&$context): void {
    $html_format = 'limited_html';
    $batch_size = 10;
    $type = 'article';
    $nodeStorage = $this->entityTypeManager->getStorage('node');

    $query = $nodeStorage
      ->getQuery()
      ->accessCheck(FALSE)
      ->condition('body.format', $html_format, '<>')
      ->condition('type', $type)
      ->range(0, $batch_size);
    $nodeIds = $query->execute();

    $nodes = $nodeStorage->loadMultiple($nodeIds);

    foreach ($nodes as $node) {
      $node->body->format = $html_format;
      $node->save();
    }

    if (empty($nodes)) {
      $context['#finished'] = 1;
      return;
    }

    $context['#finished'] = 0;
  }

}
