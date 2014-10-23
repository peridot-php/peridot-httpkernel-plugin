Peridot Silex Plugin
====================

[![Build Status](https://travis-ci.org/peridot-php/peridot-silex-plugin.png)](https://travis-ci.org/peridot-php/peridot-silex-plugin) [![HHVM Status](http://hhvm.h4cc.de/badge/peridot-php/peridot-silex-plugin.svg)](http://hhvm.h4cc.de/package/peridot-php/peridot-silex-plugin)

Easily test [Silex](http://silex.sensiolabs.org/) applications with [Peridot](http://peridot-php.github.io/).

##Usage

We recommend installing this plugin to your project via composer:

```
$ composer require peridot-php/peridot-silex-plugin:~1.0
```

You can register the plugin via your [peridot.php](http://peridot-php.github.io/#plugins) file.

```php
<?php
use Evenement\EventEmitterInterface;
use Peridot\Plugin\Silex\SilexPlugin;

return function(EventEmitterInterface $emitter) {
    //the second argument expects an HttpKernelInterface or a function that returns one
    SilexPlugin::register($emitter, include __DIR__ . '/app.php');
};
```

By registering the plugin, your Peridot tests will now have a `$client` property available:

```php
<?php
describe('Api', function() {
    describe('/info', function() {
        it('should return info about Peridot', function() {
            $this->client->request('GET', '/info');
            $response = $this->client->getResponse();
            $info = json_decode($response->getContent());
            assert($info->project == "Peridot", "project should be Peridot");
            assert($info->description == "Event driven testing framework", "description should describe Peridot");
            assert($info->styles == "BDD, TDD", "styles should be BDD, TDD");
        });
    });

    describe('/author', function() {
        it('should return info about the author', function() {
            $this->client->request('GET', '/author');
            $author = json_decode($this->client->getResponse()->getContent());
            assert($author->name == "Brian Scaturro", "author name should be on response");
            assert($author->likes == "pizza", "author should like pizza");
        });
    });
});
```

Voilà!

Don't want a client in all of your tests? No problem.

###Using on a test by test basis

Like any other peridot [scope](http://peridot-php.github.io/#scopes), you can mix the `SilexScope` provided by this plugin
on a test by test, or suite by suite basis.

```php
<?php
use Peridot\Plugin\Silex\SilexScope;

describe('Api', function() {

    //here we manually mixin the silex scope
    $scope = new SilexScope(include __DIR__ . '/../app.php');
    $this->peridotAddChildScope($scope);

    describe('/author', function() {
        it('should return info about the author', function() {
            $this->client->request('GET', '/author');
            $author = json_decode($this->client->getResponse()->getContent());
            assert($author->name == "Brian Scaturro", "author name should be on response");
            assert($author->likes == "pizza", "author should like pizza");
        });
    });
});
```

###Configuring the client property name

If `$this->client` is a little too generic for your tastes, both the scope and plugin take an optional last argument that allows you to
you set this.

```php
SilexPlugin::register($emitter, include __DIR__ . '/app.php', "browser");
$scope = new SilexScope($application, "browser");
```

Your tests now become:

```php
<?php
use Peridot\Plugin\Silex\SilexScope;

describe('Api', function() {

    describe('/author', function() {
        it('should return info about the author', function() {
            $this->browser->request('GET', '/author');
            $author = json_decode($this->browser->getResponse()->getContent());
            assert($author->name == "Brian Scaturro", "author name should be on response");
            assert($author->likes == "pizza", "author should like pizza");
        });
    });
});
```

##Example specs

This repo comes with a sample Silex application that is tested with this plugin.

To test examples that are using the plugin, run the following:

```
$ vendor/bin/peridot -c app/peridot.php app/specs/api.spec.php
```

To test examples that are manually adding the scope in, run this:

```
$ vendor/bin/peridot app/specs/no-plugin.spec.php
```

##Running plugin tests

```
$ vendor/bin/peridot specs/
```
