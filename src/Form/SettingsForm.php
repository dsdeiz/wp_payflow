<?php

namespace Drupal\wp_payflow\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines configuration form for WP Payflow.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'wp_payflow_admin_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['wp_payflow.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('wp_payflow.settings');

    $form['partner'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Partner'),
      '#default_value' => $config->get('partner'),
      '#required' => TRUE,
    ];

    $form['vendor'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Vendor'),
      '#default_value' => $config->get('vendor'),
      '#required' => TRUE,
    ];

    $form['user'] = [
      '#type' => 'textfield',
      '#title' => $this->t('User'),
      '#default_value' => $config->get('user'),
      '#required' => TRUE,
    ];

    $form['password'] = [
      '#type' => 'password',
      '#title' => $this->t('Password'),
      '#required' => empty($config->get('password')),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    $this->config('wp_payflow.settings')
      ->set('partner', $values['partner'])
      ->set('vendor', $values['vendor'])
      ->set('user', $values['user'])
      ->save();

    // Only save the password if it is not empty.
    if (!empty($values['password'])) {
      $this->config('wp_payflow.settings')
        ->set('password', $values['password'])
        ->save();
    }

    parent::submitForm($form, $form_state);
  }

}
