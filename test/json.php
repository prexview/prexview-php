<?
require __DIR__ . '/../src/PrexView.php';

$pxv = new PrexView\PrexView();

$options = new stdClass();

$options->design = 'design-json';
$options->output = 'pdf';

$json = new StdClass();

$en = new StdClass();
$es = new StdClass();
$fr = new StdClass();

$en->code = 'en';
$en->name = 'English';

$es->code = 'es';
$es->name = 'Español';

$fr->code = 'fr';
$fr->name = 'Française';

$json->languages = [$en, $es, $fr];

$file = 'test_json.pdf';

try {
  $res = $pxv->sendJSON($json, $options);

  file_put_contents($file, $res->file);

  echo 'File created: ' . $file;
} catch (Exception $e) {
  die($e->getMessage());
}

?>
