<?php

namespace Drupal\registration\Form;

use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Locale\CountryManagerInterface;
use Drupal\user\AccountForm;
use Drupal\user\RegisterForm;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Extends the core RegisterForm class to add custom fields.
 */
class RegistrationForm extends RegisterForm {

  /**
   * Constructs a new RegistrationForm object.
   */
  public function __construct(
    protected CountryManagerInterface $countryManager,
    protected EntityRepositoryInterface $entity_repository,
    protected LanguageManagerInterface $language_manager,
    protected EntityTypeManagerInterface $entity_type_manager,
    protected Connection $database,
  ) {
    parent::__construct($entity_repository, $language_manager);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): AccountForm|ContentEntityForm|RegistrationForm|static {
    return new static(
      $container->get('country_manager'),
      $container->get('entity.repository'),
      $container->get('language_manager'),
      $container->get('entity_type.manager'),
      $container->get('database'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'register_form';
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state): array {
    $form = parent::form($form, $form_state);
    $countries = $this->countryManager->getList();
    unset(
      $form['account']['pass']['#description'],
      $form['account']['name']['#description'],
      $form['account']['mail']['#description']
    );

    $form['country'] = [
      '#type' => 'select',
      '#options' => $countries,
      '#title' => $this->t('Country'),
      '#required' => TRUE,
    ];
    $form['user_city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
    ];

    $terms = $this->entityTypeManager
      ->getStorage('taxonomy_term')
      ->loadTree('genres');

    $options = [];
    foreach ($terms as $term) {
      $options[$term->tid] = $term->name;
    }
    $form['categories'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Categories'),
      '#options' => $options,
      '#required' => TRUE,
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   *
   * @throws \Exception
   */
  public function save(array $form, FormStateInterface $form_state) {
    parent::save($form, $form_state);
    $values = $form_state->getValues();
    $city = $values['user_city'];
    $country = $values['country'];

    $genres = $values['categories'];
    $categories = array_filter($genres);

    $account = $this->entity;
    $uid = $account->id();

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
    foreach ($categories as $item) {
      $category_row->values([$uid, $item]);
    }
    $category_row->execute();
  }

}
