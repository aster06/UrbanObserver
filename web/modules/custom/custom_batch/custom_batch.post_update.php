<?php

/**
 * @file
 * Primary hook post update for text format.
 */

use Drupal\node\Entity\Node;

/**
 * Implements hook_post_update_NAME().
 *
 * @throws \Drupal\Core\Entity\EntityStorageException
 */
function custom_batch_post_update_formatter(&$sandbox) {
  $html_format = 'limited_html';
  $batch_size = 10;
  $type = 'article';

  $query = \Drupal::entityTypeManager()
    ->getStorage('node')
    ->getQuery()
    ->accessCheck(FALSE)
    ->condition('body.format', $html_format, '<>')
    ->condition('type', $type)
    ->range(0, $batch_size);
  $nodeIds = $query->execute();

  $nodes = Node::loadMultiple($nodeIds);

  foreach ($nodes as $node) {
    $node->body->format = $html_format;
    $node->save();
  }

  if (empty($nodes)) {
    $sandbox['#finished'] = 1;
    return;
  }

  $sandbox['#finished'] = 0;
}
