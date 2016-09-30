IDCIMergeTokenBundle
===================

Symfony2's IDCI Merge Token Bundle.


Installation
------------

Add dependencies in your `composer.json` file:
```json
"repositories": [
    ...,
    {
        "type": "vcs",
        "url": "https://github.com/IDCI-Consulting/MergeTokenBundle.git"
    }
],
"require": {
    ...,
    "idci/merge-token-bundle": "dev-master"
}
```

Install these new dependencies of your application:
```sh
$ php composer.phar update
```

Enable bundles in your application kernel:
```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new IDCI\Bundle\MergeTokenBundle\IDCIMergeTokenBundle(),
    );
}
```
Tests
-----

Install bundle dependencies:
```sh
$ php composer.phar update
```

To execute unit tests:
```sh
$ phpunit --coverage-text
```
