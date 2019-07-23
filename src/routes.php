<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();
    $app->get('/', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        return $container->view->render($response, 'index.php', $args);
    })->setName('home');;

    $app->post('/solve', function (Request $request, Response $response, array $args) use ($container) {
        $combinationSolver = $container->get('combinationSolver');
        $body = $request->getParsedBody();
        $combinationSolver->run(intval($body['cells']), intval($body['coins']));
        return $response->withRedirect($container->get('router')->pathFor('home'));
    })->setName('solve');
};
