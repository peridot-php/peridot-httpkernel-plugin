<?php
use Evenement\EventEmitterInterface;
use Peridot\Plugin\HttpKernel\HttpKernelPlugin;

return function(EventEmitterInterface $emitter) {
    HttpKernelPlugin::register($emitter, include __DIR__ . '/app.php');
};
