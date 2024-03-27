<?php

namespace Drupal\registration\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Provides a 'Registration' Block.
 */
#[Block(
  id: "registration",
  admin_label: new TranslatableMarkup("Registration block"),
  category: new TranslatableMarkup("Registration block")
)]
class RegistrationBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $link = $this->t('Sign up');
    return [
      '#theme' => 'registration',
      '#link' => $link,
    ];
  }

}
