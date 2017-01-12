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
  const URL = 'https://api-beta.prexview.com/v1/';

  /**
   * @var string
   */
  private $token;

  /**
    * Constructor
    */
  public function __construct() {
    $this->token = getenv('PXV_API_KEY') || '';
  }

  /**
   * Send the data to PrexView.
   *
   * @param Object $options
   * @param String $file
   */
  private static function send(Object $options, String $file) {

  }

  /**
   * Validate the token.
   *
   * If there is not a token, will not send anything.
   *
   * @throws \Exception If empty token
   */
  private static function checkToken() {
    if ($token == '') throw new \Exception("PrexView environment variable PXV_API_KEY must be set");
  }

  /**
   * Validate if is a valid JSON.
   *
   * @param string $str
   *
   * @return bool
   */
  private static function isJson(String $str) {
    return true;
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
    if ($format == 'json') {
      if (typeof($options->json) == 'String') {
        if (!isJson($options->json)) {
          return 'PrexView content must be a valid JSON string';
        }
      } else {
        if ($options->json == null || typeof($options->json) != 'Object') {
          return 'PrexView content must be a javascript object or a valid JSON string';
        }
      }
    // XML
    } else {
      if (typeof($options->xml) != 'string') {
        return 'PrexView content must be a valid XML string';
      }
    }

    if (typeof($options->design) != 'string')
      return 'PrexView property "design" must be passed as a string option';

    if (typeof($options->output) != 'string')
      return 'PrexView property "output" must be passed as a string option';

    if (['html','pdf','png','jpg'].indexOf($options->output) == -1)
      return 'PrexView property "output" must be one of these options: html, pdf, png or jpg';

    if ($options->designBackup && typeof($options->designBackup) != 'string')
      return 'PrexView property "designBackup" must be a string';

    if ($options->note && typeof($options->note) != 'string')
      return 'PrexView property "note" must be a string';

    if ($options->note && strlen($options->note) > 500)
      $options->note = slice($options->note, 0, 500);

    return $options;
  }

  public static function sendXML($content, $options, $file) {
    self::checkToken();
    $options->xml = $content;

    $result = checkOptions('xml', $options);

    if (typeof($result) == 'string')
      throw new Exception($result);
    else
      send($result, $file);
  }

  public static function sendJSON($content, $options, $file) {
    self::checkToken();
    $options->json = $content;

    $result = checkOptions('json', $options);

    if (typeof($result) == 'string')
      throw new Exception($result);
    else
      send($result, $file);
  }

}
