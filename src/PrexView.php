<?php
/*
 * This file is part of the PrexView package.
 *
 * (c) PrexView
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PrexView;

require __DIR__ . '/../vendor/autoload.php';

/**
 * PrexView
 *
 * @author PrexView <hi@prexview.com>
 */
class PrexView
{

  /**
   * @var string
   */
  const URL = 'https://api.prexview.com/v1/';

  /**
   * @var string
   */
  private $token = '';

  /**
    * Constructor
    */
  public function __construct($token = null) {
    if (gettype($token) == 'string' && !empty($token)) {
      $this->token = $token;
    }

    if (getenv('PXV_API_KEY')) {
      $this->token = getenv('PXV_API_KEY');
    }
  }

  /**
   * Send the data to PrexView.
   *
   * @param Object $data
   * @param String $file
   */
  private function send($data) {
    $headers = array(
      'Authorization' => $this->token
    );

    $response = \Requests::post(self::URL . 'transform', $headers, $data);

    if (!$response->success) {
      var_dump($response);
      return null;
    }

    $result = new \stdClass();

    $result->rateLimit = $response->headers['x-ratelimit-limit'];
    $result->rateLimitReset = $response->headers['x-ratelimit-reset'];
    $result->rateRemaining = $response->headers['x-ratelimit-remaining'];

    if ($response->status_code === 200) {
      $result->id = $response->headers['x-transaction-id'];
      $result->file = $response->body;
      $result->responseTime = $response->headers['x-response-time'];
    }

    return $result;
  }

  /**
   * Validate if is a valid JSON.
   *
   * @param string $str
   *
   * @return bool
   */
  private static function isJson($str) {
    $valid = true;
    $result = json_decode($str);

    if (json_last_error() !== JSON_ERROR_NONE) {
      $valid = false;
    }

    if ($result === FALSE) {
      $valid = false;
    }

    return $valid;
  }

  /**
   * Validate the options.
   *
   * If there is any wrong option return an string.
   *
   * @param string $format
   * @param Object $options
   *
   * @return Object|string
   */
  private static function checkOptions($format, $options) {
    // JSON
    if ($format === 'json') {
      if (gettype($options->json) === 'string') {
        if (!self::isJson($options->json)) {
          throw new \Exception('PrexView content must be a valid JSON string');
        }
      } else {
        if ($options->json === null || gettype($options->json) !== 'object') {
          throw new \Exception('PrexView content must be a javascript object or a valid JSON string');
        }
      }
    // XML
    } else {
      if (gettype($options->xml) !== 'string') {
        throw new \Exception('PrexView content must be a valid XML string');
      }
    }

    if (gettype($options->design) !== 'string')
      throw new \Exception('PrexView property "design" must be passed as a string option');

    if (gettype($options->output) !== 'string')
      throw new \Exception('PrexView property "output" must be passed as a string option');

    if (!in_array($options->output, ['html','pdf','png','jpg']))
      throw new \Exception('PrexView property "output" must be one of these options: html, pdf, png or jpg');

    if ($options->designBackup && gettype($options->designBackup) !== 'string')
      throw new \Exception('PrexView property "designBackup" must be a string');

    if ($options->note && gettype($options->note) !== 'string')
      throw new \Exception('PrexView property "note" must be a string');

    if ($options->note && strlen($options->note) > 500)
      $options->note = slice($options->note, 0, 500);

    return $options;
  }

  /**
   * Validate the token.
   *
   * If there is not a token, will not send anything.
   *
   * @throws \Exception If empty token
   */
  private static function checkToken($token) {
    if ($token === '') throw new \Exception('PrexView environment variable PXV_API_KEY must be set');
  }

  public function sendXML($content, $options) {
    self::checkToken($this->token);

    $options->xml = $content;

    $result = self::checkOptions('xml', $options);

    return self::send($result);
  }

  public function sendJSON($content, $options) {
    self::checkToken($this->token);

    $options->json = $content;

    $result = self::checkOptions('json', $options);

    return self::send($result);
  }

}
