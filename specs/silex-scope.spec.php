<?php
use Peridot\Plugin\Silex\SilexScope;
use Silex\Application;
use Symfony\Component\HttpKernel\Client;

describe("SilexScope", function() {
    describe("construction", function() {
        it("can use a factory function that returns an HttpKernelInterface", function() {
            $application = new Application();
            $scope = new SilexScope(function() use ($application) {
                return $application;
            });
            assert($scope->getSilexApplication() === $application, "factory should have returned application");
        });

        it("can use an instantiated HttpKernelInterface", function() {
            $application = new Application();
            $scope = new SilexScope($application);
            assert($scope->getSilexApplication() === $application, "application should be same as that passed in");
        });

        context('when the callable returns something other than a kernel', function() {
            it("should throw a RuntimeException", function() {
                $exception = null;
                try {
                    $scope = new SilexScope(function() {
                        return "Application!!!!";
                    });
                } catch (RuntimeException $e) {
                    $exception = $e;
                }
                assert(!is_null($exception), "expected RuntimeException");
            });
        });

        context("when the callable does return a kernel", function() {

            beforeEach(function() {
                $application = new Application();
                $this->application = $application;
                $this->scope = new SilexScope(function() {
                    return $this->application;
                });
            });

            it("should create a client property on the scope", function() {
                $client = $this->scope->client;
                assert($client instanceof Client, "scope client should be instance of Client");
            });

            it("should allow configuring client property name", function() {
                $scope = new SilexScope(function() {
                    return $this->application;
                }, "browser");
                assert($scope->browser instanceof Client, "browser property should be instance of Client");
            });
        });

        context("when passing in an object", function() {
            it("should throw a RuntimeException if it is not an HttpKernelInterface", function() {
                $exception = null;
                try {
                    new SilexScope(new ArrayObject());
                } catch (RuntimeException $e) {
                    $exception = $e;
                }
                assert(!is_null($exception), "should have thrown exception for wrong object type");
            });
        });
    });

    describe("->setSilexApplication()", function() {
        it("should set the scope's application property", function() {
            $application = new Application();
            $scope = new SilexScope(function() {
                return new Application();
            });
            $scope->setSilexApplication($application);
            assert($scope->getSilexApplication() === $application, "setter should have set application");
        });

        it("should update the client property", function() {
            $application = new Application();
            $scope = new SilexScope(function() {
                return new Application();
            });
            $oldClient = $scope->client;
            $scope->setSilexApplication($application);
            $newClient = $scope->client;
            assert($newClient instanceof Client, "new client should be instance of Client");
            assert($newClient !== $oldClient, "clients should not be the same");
        });
    });
});
