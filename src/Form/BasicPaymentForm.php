<?php

namespace Drupal\wp_payflow\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\wp_payflow\Payflow;

/**
 * Basic payment form.
 */
class BasicPaymentForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'wp_payflow_basic_payment_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['card'] = [
      '#type' => 'textfield',
      '#default_value' => '5105105105105100',
      '#title' => $this->t('Credit Card'),
    ];

    $form['expiration_date'] = [
      '#type' => 'textfield',
      '#default_value' => '1219',
      '#title' => $this->t('Expiration Date'),
    ];

    $form['cvv'] = [
      '#type' => 'textfield',
      '#default_value' => '123',
      '#title' => $this->t('Security Code'),
    ];

    $form['firstname'] = [
      '#type' => 'textfield',
      '#default_value' => 'John',
      '#title' => $this->t('First Name'),
    ];

    $form['lastname'] = [
      '#type' => 'textfield',
      '#default_value' => 'Doe',
      '#title' => $this->t('Last Name'),
    ];

    $form['street'] = [
      '#type' => 'textfield',
      '#default_value' => '123 Main Street',
      '#title' => $this->t('Street'),
    ];

    $form['city'] = [
      '#type' => 'textfield',
      '#default_value' => 'San Jose',
      '#title' => $this->t('City'),
    ];

    $form['state'] = [
      '#type' => 'textfield',
      '#default_value' => 'CA',
      '#title' => $this->t('State'),
    ];

    $form['zip'] = [
      '#type' => 'textfield',
      '#default_value' => 95101,
      '#title' => $this->t('Zip'),
    ];

    $form['country'] = [
      '#type' => 'textfield',
      '#default_value' => 'US',
      '#title' => $this->t('Country'),
    ];

    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Pay Now'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('wp_payflow.settings');

    $values = [
      'PARTNER' => $config->get('partner'),
      'VENDOR' => $config->get('vendor'),
      'USER' => $config->get('user'),
      'PWD' => $config->get('password'),
      'TENDER' => 'C',
      'TRXTYPE' => 'S',
      'CURRENCY' => 'USD',
      'AMT' => '1.00',

      'ACCT' => $form_state->getValue('card'),
      'EXPDATE' => $form_state->getValue('expiration_date'),
      'CVV2' => $form_state->getValue('cvv'),

      'BILLTOFIRSTNAME' => $form_state->getValue('firstname'),
      'BILLTOLASTNAME' => $form_state->getValue('lastname'),
      'BILLTOSTREET' => $form_state->getValue('street'),
      'BILLTOCITY' => $form_state->getValue('city'),
      'BILLTOSTATE' => $form_state->getValue('state'),
      'BILLTOZIP' => $form_state->getValue('zip'),
      'BILLTOCOUNTRY' => $form_state->getValue('zip'),
    ];

    Payflow::runCall($values);
  }

}
