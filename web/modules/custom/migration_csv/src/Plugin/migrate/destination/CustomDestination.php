<?php

namespace Drupal\migration_csv\Plugin\migrate\destination;

use Drupal\Core\Database\Connection;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\migrate\Plugin\migrate\destination\DestinationBase;
use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate\Row;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a destination plugin for importing user fields.
 *
 * @MigrateDestination(
 *   id = "custom_destination"
 * )
 */
class CustomDestination extends DestinationBase implements ContainerFactoryPluginInterface {

  /**
   * Constructs a new CustomDestination object.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    MigrationInterface $migration,
    protected Connection $connection
  ) {
    parent::__construct(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $migration);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(
    ContainerInterface $container,
    array $configuration,
    $plugin_id,
    $plugin_definition,
    MigrationInterface $migration = NULL): CustomDestination|ContainerFactoryPluginInterface|static {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $migration,
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getIds(): array {
    $ids['uid']['type'] = 'integer';
    return $ids;
  }

  /**
   * {@inheritdoc}
   */
  public function fields(): array {
    return [
      'uid' => $this->t('The user id.'),
      'user_city' => $this->t('The user city.'),
      'country' => $this->t('The user country.'),
    ];
  }

  /**
   * {@inheritdoc}
   *
   * @throws \Exception
   */
  public function import(Row $row, array $old_destination_id_values = []): void {
    $uid = $row->getDestinationProperty('uid');
    $city = $row->getDestinationProperty('user_city');
    $country = $row->getDestinationProperty('country');
    $this->connection->upsert('registration_info')
      ->fields([
        'uid' => $uid,
        'country' => $country,
        'user_city' => $city,
      ])
      ->key('uid')
      ->execute();
  }

}
