<?php
use Evenement\EventEmitterInterface;
use Peridot\Plugin\Silex\SilexPlugin;

return function(EventEmitterInterface $emitter) {
    SilexPlugin::register($emitter, include __DIR__ . '/app.php');
};
