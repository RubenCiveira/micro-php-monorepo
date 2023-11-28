<?php
return function (\Slim\App $app, \Psr\Container\ContainerInterface $injector) {
    $app->get('/', function (Request $request, Response $response, $args) use($injector) {
        $controller = $injector->get(\Register\Web\Api\Service\ServiceListController::class);
        $controller->list($request, $response, $args);
        return $response;
    });
    $app->post('/', function (Request $request, Response $response, $args) use($injector) {
        $controller = $injector->get(\Register\Web\Api\Service\ServiceCreateController::class);
        $controller->create($request, $response, $args);
        return $response;
    });
    $app->get('/{uid}', function (Request $request, Response $response, $args) use($injector) {
        $controller = $injector->get(\Register\Web\Api\Service\ServiceRetrieveController::class);
        $controller->retrieve($request, $response, $args);
        return $response;
    });
    $app->put('/{uid}', function (Request $request, Response $response, $args) use($injector) {
        $controller = $injector->get(\Register\Web\Api\Service\ServiceUpdateController::class);
        $controller->update($request, $response, $args);
        return $response;
    });
    $app->delete('/{uid}', function (Request $request, Response $response, $args) use($injector) {
        $controller = $injector->get(\Register\Web\Api\Service\ServiceDeleteController::class);
        $controller->delete($request, $response, $args);
        return $response;
    });
};
