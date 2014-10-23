<?php
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

$app = new Application();

$app->get('/info', function() {
    return JsonResponse::create([
        'project' => 'Peridot',
        'description' => 'Event driven testing framework',
        'styles' => 'BDD, TDD'
    ]);
});

$app->get('/author', function() {
    return JsonResponse::create([
        'name' => 'Brian Scaturro',
        'likes' => 'pizza'
    ]);
});

return $app;
