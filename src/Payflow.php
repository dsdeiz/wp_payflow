<?php

namespace Drupal\wp_payflow;

use GuzzleHttp\Exception\RequestException;

/**
 * Basic Payflow integration.
 */
class Payflow {

  /**
   * Hardcode sandbox endpoint.
   */
  const ENDPOINT = 'https://pilot-payflowpro.paypal.com/';

  /**
   * Run a call.
   *
   * @param array $values
   *   The values to pass to the endpoint.
   */
  public static function runCall(array $values) {
    $client = \Drupal::httpClient();

    try {
      $request = $client->post(Payflow::ENDPOINT, [
        'verify' => FALSE,
        'form_params' => $values,
      ]);

      parse_str($request->getBody(), $parameters);
      $message = $parameters['RESULT'] != 0 ? $parameters['RESPMSG'] : t('Successfully sent payment.');
      drupal_set_message($message, ($parameters['RESULT'] != 0 ? 'error' : 'status'));
    }
    catch (RequestException $e) {
      \Drupal::logger('wp_payflow')->error(\Psr7\str($e->getRequest()));
    }
  }

}
