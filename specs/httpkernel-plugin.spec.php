<?php
use Evenement\EventEmitter;
use Peridot\Plugin\HttpKernel\HttpKernelPlugin;
use Peridot\Runner\Context;
use Silex\Application;
use Symfony\Component\HttpKernel\Client;

describe('HttpKernelPlugin', function() {
    beforeEach(function() {
        $this->application = include __DIR__ . '/../app/app.php';
        $this->emitter = new EventEmitter();
        $this->plugin = new HttpKernelPlugin($this->emitter, $this->application);
    });

    describe('->onRunnerStart()', function() {
        it('should mix the scope in to the root suite', function() {
            $this->plugin->onRunnerStart();
            $root = Context::getInstance()->getCurrentSuite();
            $scope = $root->getScope();
            assert($scope->client instanceof Client, 'root suite $scope->client should be Client');
        });
    });
});
