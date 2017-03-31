<?
require __DIR__ . '/../src/PrexView.php';

$pxv = new PrexView\PrexView();

$options = new stdClass();

$options->design = 'design-json';
$options->output = 'pdf';

$json = '{
  "languages": [
    {"code": "en", "name": "English"},
    {"code": "es", "name": "Español"},
    {"code": "fr", "name": "Française"}
  ]
}';

$file = 'test_json.pdf';

try {
  $res = $pxv->sendJSON($json, $options);

  file_put_contents($file, $res->file);

  echo 'File created: ' . $file;
} catch (Exception $e) {
  die($e->getMessage());
}

?>
