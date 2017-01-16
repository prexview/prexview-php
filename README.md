# ![PrexView](https://cdn.prexview.com/media/extension/promo.png)

[![Status](https://travis-ci.org/prexview/prexview-js.svg?branch=master)](https://travis-ci.org/prexview/prexview-js) [![npm version](https://badge.fury.io/js/prexview.svg)](https://npmjs.org/package/prexview "View this project on npm")

A composer library to use PrexView a fast, scalable and very friendly service for programatic HTML, PDF, PNG or JPG generation using JSON or XML data.

*See [PrexView](https://prexview.com) for more information about the service.*


## Install composer

```
php composer.phar require prexview/prexview
```

## Install manually

```
git clone https://github.com/prexview/prexview-php.git vendor/prexview
```

## Usage

###### Set up the PXV_API_KEY as an enviroment variable

```
export PXV_API_KEY="API_KEY"
```

If you can't setup the environment variable, create the PrexView object like this

```php
$pxv = new PrexView\PrexView('your_token_here');
```

You can sign up in [PrexView](https://prexview.com/join) in order to get an API Key.

###### Include the library
```php
// Used for composer based installation
require __DIR__  . '/vendor/autoload.php';
// Use below for direct download installation
// require __DIR__  . '/vender/prexview/src/PrexView.php';
```

###### Sending XML

```php
$pxv = new Prexview\Prexview();

$options =  new stdClass();

$options->design = 'custom-invoice';
$options->output = 'pdf';

$xml = '<?xml version="1.0" encoding="UTF-8"?>
<languages>
  <lang code="en">English</lang>
  <lang code="es">Español</lang>
  <lang code="fr">Française</lang>
</languages>';

$file = '/tmp/test.pdf';

try {
  $res = $pxv->sendXML($xml, $options);

  file_put_contents($file, $res->file);

  echo 'File created: ' . $file;
} catch (Exception $e) {
  die($e->getMessage());
}
```

###### Sending JSON

You can pass the json param as a valid json string or as a standard object

```php
$pxv = new Prexview\Prexview();

$options =  new stdClass();

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
  $res = $pxv->sendXML($xml, $options);

  file_put_contents($file, $res->file);

  echo 'File created: ' . $file;
} catch (Exception $e) {
  die($e->getMessage());
}
```

## API

### sendXML(xml, options)

Send data as a XML string

### sendJSON(json, options)

Send data as a JSON string, it can also be can be a valid JSON string or a standard object

#### options

##### design

Type: `string` 
Required: Yes

Name of the design to use.

##### output

Type: `string` 
Required: Yes

The format we want to receive from the service, it can be **html**, **pdf**, **png** or **jpg**

##### designBackup

Type: `string`

Name of another design to use if the option **design** is not available in the service

##### note

Type: `string`

A custom note to add any string limit to 500 chars. It's usefull if you want to add meta data like a document, transaction or customer id.

## License

MIT © [PrexView](https://prexview.com)
