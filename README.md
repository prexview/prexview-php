# ![PrexView](https://prexview.com/media/extension/promo.png)

[![Status](https://travis-ci.org/prexview/prexview-php.svg?branch=master)](https://travis-ci.org/prexview/prexview-php)

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

You can get an API Key by downloading PrexView Studio from [PrexView](https://prexview.com).

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

$file = 'test.pdf';

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
  "languages": [
    {"code": "en", "name": "English"},
    {"code": "es", "name": "Español"},
    {"code": "fr", "name": "Française"}
  ]
}';

$file = 'test.pdf';

try {
  $res = $pxv->sendJSON($json, $options);

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

#### Options

##### -\-format

###### Type: `string` **Required: Yes**

Data to use for the document creation, must be xml or json.

##### -\-design

###### Type: `string` **Required: Yes**

Design's name to use.

You can use json sintax here to access data and have dynamic design names
```json
{
  "Data": {
    "customer": "123"
  }
}
```
Design name can use any data attribute or text node
```
invoice-customer-{{Data.customer}}
```
We will translate that to the following
```
invoice-customer-123
```

And finally the service will try to find the design **invoice-customer-123** in order to transform the data and generate the document.
  
##### -\-output

###### Type: `string` **Required: Yes**

Document response type from the service, it can be **html**, **pdf**, **png** or **jpg**.

##### -\-design-backup

###### Type: `string`

Design's name to use to be used if the option **design** is not available in the service.

##### -\-note

###### Type: `string`

Custom note that can be used to add any information, it's limit up to 500 chars. This is useful if you want to add metadata such as document, transaction or customer ID.

You can use json syntax to access data and get dynamic notes. 
  
```json
{
  "Data": {
    "customer": "123"
  }
}
```
Notes can use any data attribute or text
```
Document: Invoice
Customer: {{Data.customer}}
```
We will translate that to the following
```
Document: Invoice
Customer: 123
```


## License

MIT © [PrexView](https://prexview.com)
