<?php
return function (\Slim\App $app, \Psr\Container\ContainerInterface $injector) {
    $app->get('/', function (Request $request, Response $response, $args) use($injector) {
        $controller = $injector->get(\Register\Web\Api\Host\HostListController::class);
        $controller->list($request, $response, $args);
        return $response;
    });
    $app->post('/', function (Request $request, Response $response, $args) use($injector) {
        $controller = $injector->get(\Register\Web\Api\Host\HostCreateController::class);
        $controller->create($request, $response, $args);
        return $response;
    });
    $app->get('/{uid}', function (Request $request, Response $response, $args) use($injector) {
        $controller = $injector->get(\Register\Web\Api\Host\HostRetrieveController::class);
        $controller->retrieve($request, $response, $args);
        return $response;
    });
    $app->put('/{uid}', function (Request $request, Response $response, $args) use($injector) {
        $controller = $injector->get(\Register\Web\Api\Host\HostUpdateController::class);
        $controller->update($request, $response, $args);
        return $response;
    });
    $app->delete('/{uid}', function (Request $request, Response $response, $args) use($injector) {
        $controller = $injector->get(\Register\Web\Api\Host\HostDeleteController::class);
        $controller->delete($request, $response, $args);
        return $response;
    });
};
