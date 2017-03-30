<?
require __DIR__ . '/../src/PrexView.php';

$pxv = new PrexView\PrexView();

$options = new stdClass();

$options->design = 'custom-invoice';
$options->output = 'pdf';

$json = '{
  "languages": {
    "en": "English",
    "es": "Español",
    "fr": "Française"
  }
}';

$file = '/tmp/test.pdf';

try {
  $res = $pxv->sendJSON($json, $options);

  file_put_contents($file, $res->file);

  echo 'File created: ' . $file;
} catch (Exception $e) {
  die($e->getMessage());
}

?>
