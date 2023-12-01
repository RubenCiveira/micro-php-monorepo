<?php
use Civi\Micro\Context;
use Civi\Micro\WebContext;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/../vendor/autoload.php';

Context::registerDefinitions(require '../resources/starter/repository-definitions.php');
Context::registerDefinitions(require '../resources/starter/web-definitions.php');
Context::registerDefinitions(require '../resources/starter/service-definitions.php');

$context = new WebContext('../', dirname($_SERVER['SCRIPT_NAME']).'/agents');
$context->start( function (\Slim\App $app, \Psr\Container\ContainerInterface $injector) {
    $app->get('/', function (Request $request, Response $response, $args) use($injector) {
        $controller = $injector->get(\Register\Web\Api\Agent\AgentListController::class);
        $controller->list($request, $response, $args);
        return $response;
    });
    $app->post('/', function (Request $request, Response $response, $args) use($injector) {
        $controller = $injector->get(\Register\Web\Api\Agent\AgentCreateController::class);
        $controller->create($request, $response, $args);
        return $response;
    });
    $app->get('/{uid}', function (Request $request, Response $response, $args) use($injector) {
        $controller = $injector->get(\Register\Web\Api\Agent\AgentRetrieveController::class);
        $controller->retrieve($request, $response, $args);
        return $response;
    });
    $app->put('/{uid}', function (Request $request, Response $response, $args) use($injector) {
        $controller = $injector->get(\Register\Web\Api\Agent\AgentUpdateController::class);
        $controller->update($request, $response, $args);
        return $response;
    });
    $app->delete('/{uid}', function (Request $request, Response $response, $args) use($injector) {
        $controller = $injector->get(\Register\Web\Api\Agent\AgentDeleteController::class);
        $controller->delete($request, $response, $args);
        return $response;
    });
});
