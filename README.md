YiiDB2
======

Support the DB2 database in Yii Framework

## Requirements

One of the following installed:
* PHP module pdo_ibm with DB2 Client
* DB2 ODBC driver for your client platform
* iSeries Client Access ODBC driver for your client platform
 
## Installation
* clone this repo to `protected/extensions/yiidb2` or extract the `yiidb2` 
  directory from the zip to `protected/extensions`
* In your `protected/config/main.php`, add the following under the `components` 
  section:

```php
...
  'components' => array(
  ...
    'db' => array(
      'connectionString' => 'ibm:DRIVER={IBM DB2 ODBC DRIVER};DATABASE=database;HOSTNAME=hostname;PORT=port;PROTOCOL=TCPIP;',
      'username' => 'username',
      'password' => 'password',
      'class' => 'ext.yiidb2.CIbmDB2Connection',
    ),
    ...
  ),
...
```

__For connecting to an iSeries DB2 (also known as as/400 DB2)__:

* Make sure to add a `DATABASE=SCHEMA;` parameter to your ODBC connection string
  where `SCHEMA` == your schema that will contain tables used in your Yii 
  models. Here is an example `connectionString` for your `main.php` if you are
  connecting to the iSeries DB2 database on a Windows server running your Yii 
  application:
  
```php
...
'db' => array(
      'connectionString' => 'odbc:Driver={Client Access ODBC Driver (32-bit)};System=PUTSERVERNAMEHERE;DATABASE=PUTSCHEMAHERE;UID=PUTUSERHERE;PWD=PUTPASSWORDHERE;',
	  ),
...
```

* In your `protected/config/main.php`, add the following under the `params` 
  section:
  
```php
...
	'params'=>array(
		...
        'yiidb2'=>array(
            'systemServer' => 'as400'
        )
		...
	),
...
```

## Notes on iSeries (as/400) compatibility

iSeries compatibility is still a work in progress. Basic Gii functionality 
exists, but I would recommend against generating models or any of the `CUD` 
portion of `CRUD` and instead consider iSeries capabilities as _read only_ for 
now until a more stable version is released. Model generation via Gii just 
straight up fails right now.

### Current plans for the iSeries functionality are:

* Enhance Schema definition and detection (this will be done **ASAP**)
* Full CRUD for iSeries
* Full Gii compatibility