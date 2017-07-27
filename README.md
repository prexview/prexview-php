# ![PrexView](https://prexview.com/media/extension/promo.png)

[![Status](https://travis-ci.org/prexview/prexview-php.svg?branch=master)](https://travis-ci.org/prexview/prexview-php)

A composer library to use [PrexView][1], a fast, scalable and friendly service for programatic HTML, PDF, PNG or JPG generation using JSON or XML data.

*See [PrexView][1] for more information about the service.*


## Installation

#### Composer

```
php composer.phar require prexview/prexview
```

#### Manually

```
git clone https://github.com/prexview/prexview-php.git vendor/prexview
```

## Getting started

#### Get your API Key

You can get an API Key from [PrexView][1]

#### Set up your API Key

If you can setup enviroment variables

```
export PXV_API_KEY="YOUR_API_KEY"
```

If you can't setup environment variables, create the PrexView object with your API Key as argument

```php
$pxv = new PrexView\PrexView('YOUR_API_KEY');
```

#### Include the library

##### Composer installation

```php
require __DIR__  . '/vendor/autoload.php';
```

##### Manual installation

```php
require __DIR__  . '/vendor/prexview/src/PrexView.php';
```

#### Sending an XML

To send an XML string use ```$pxv->sendXML($xml, $options)``` method, this method will return a [Response object][3] on success or thrown an error.

##### Example

```php
$pxv = new Prexview\Prexview();

$options =  new stdClass();

$options->template = 'supported_languages';
$options->output = 'pdf';

$xml = '<?xml version="1.0" encoding="UTF-8"?>
<languages>
  <lang code="en">English</lang>
  <lang code="es">Español</lang>
  <lang code="fr">Française</lang>
</languages>';

$file = 'test.pdf';

try {
  $res = $pxv->sendXML($xml, $options);

  file_put_contents($file, $res->file);

  echo 'File created: ' . $file;
} catch (Exception $e) {
  die($e->getMessage());
}
```

#### Sending a JSON

To send a JSON string or PHP standard object use ```$pxv->sendJSON($json, $options)``` method, this method will return a [Response object][3] on success or thrown an error.

##### Example

```php
$pxv = new Prexview\Prexview();

$options =  new stdClass();

$options->template = 'supported_languages';
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

$file = 'test.pdf';

try {
  $res = $pxv->sendJSON($json, $options);

  file_put_contents($file, $res->file);

  echo 'File created: ' . $file;
} catch (Exception $e) {
  die($e->getMessage());
}
```

##### Response object

|Property|Type|Description|
|--------|:--:|-----------|
|id|`string`|Transaction ID.|
|file|`binary`|Document created by the service.|
|responseTime|`int`|Response time from service.|
|rateLimit|`int`|Maximum number of calls to the service.|
|rateLimitReset|`int`|Seconds to reset the rate limit.|
|rateRemaining|`int`|Number of remaining call to the service.|

##### Options

|Name|Type|Required|Description|
|----|:--:|:------:|-----------|
|template|`string`|Yes|Template's name to be used to document creation, you can use [dynamic values][2].|
|output|`string`|Yes|Type of document that will be created by PrexView service, it must be **html**, **pdf**, **png** or **jpg**.|
|note|`string`|No|Custom information to be added to the document's metadata, it's limit up to 500 characters and you can use [dynamic values][2].|
|format|`string`|No|Type of data used to the document creation, it must be **xml** or **json**, this should be inferred from library methods.|
|templateBackup|`string`|No|Template's name to use to be used if the option **template** is not available in the service.|

##### Dynamic values

In **template** or **note** options you can use JSON sintax to access data and have dynamic values, for instance having the following JSON data:

```json
{
  "Data": {
    "customer": "123"
  }
}
```

Your **template** or **note** can use any data attribute or text node, for instance:

```
'invoice-customer-{{Data.customer}}'
```

Then we will translate that to the following:

```
'invoice-customer-123'
```

And finally the service will try to find the **template** or **note** ```invoice-customer-123``` in order to transform the data and generate the document.

## License

MIT © [PrexView][1]

[1]: https://prexview.com
[2]: #dynamic-values
[3]: #response-object
