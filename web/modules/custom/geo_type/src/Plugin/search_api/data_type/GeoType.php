<?php

namespace Drupal\geo_type\Plugin\search_api\data_type;

use Drupal\search_api\DataType\DataTypePluginBase;

/**
 * Provides the location data type.
 *
 * @SearchApiDataType(
 *   id = "wkt",
 *   label = @Translation("WKT"),
 *   description = @Translation("Location data type implementation"),
 *   prefix = "rpt"
 * )
 */
class GeoType extends DataTypePluginBase {

  /**
   * {@inheritdoc}
   */
  public function getFallbackType(): ?string {
    return NULL;
  }

}
