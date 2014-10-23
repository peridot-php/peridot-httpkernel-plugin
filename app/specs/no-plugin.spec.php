<?php
/**
 * This spec demonstrates a manual use of the SilexScope in
 * case you don't want to register the plugin for all tests. Run this
 * without a configuration file.
 */
use Peridot\Plugin\Silex\SilexScope;

describe('Api', function() {

    //here we manually mixin the silex scope
    $scope = new SilexScope(include __DIR__ . '/../app.php');
    $this->peridotAddChildScope($scope);

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
