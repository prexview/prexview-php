<?
require __DIR__ . '/../src/PrexView.php';

$pxv = new PrexView\PrexView();

$options = new stdClass();

$options->design = 'design-xml';
$options->output = 'pdf';

$xml = '<?xml version="1.0" encoding="UTF-8"?>
<languages>
  <lang code="en">English</lang>
  <lang code="es">Español</lang>
  <lang code="fr">Française</lang>
</languages>';

$file = 'test_xml.pdf';

try {
  $res = $pxv->sendXML($xml, $options);

  file_put_contents($file, $res->file);

  echo 'File created: ' . $file;
} catch (Exception $e) {
  die($e->getMessage());
}

?>
