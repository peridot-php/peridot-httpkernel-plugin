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
