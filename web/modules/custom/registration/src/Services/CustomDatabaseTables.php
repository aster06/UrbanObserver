<?php

namespace Drupal\registration\Services;

use Drupal\Core\Database\Connection;

/**
 * Provides methods for handling custom database tables.
 */
class CustomDatabaseTables {

  public function __construct(
    protected Connection $database,
  ) {
  }

  /**
   * Constructs a new CustomDatabaseTables object.
   *
   * @throws \Exception
   */
  public function databaseTables($uid, $city, $country, $genres): void {
    $this->database->insert('registration_info')
      ->fields([
        'uid' => $uid,
        'user_city' => $city,
        'country' => $country,
      ])
      ->execute();
    $category_row = $this->database->insert('categories_info')
      ->fields([
        'uid',
        'categories',
      ]);
    $categories = array_filter($genres);
    foreach ($categories as $item) {
      $category_row->values([$uid, $item]);
    }
    $category_row->execute();
  }

}
