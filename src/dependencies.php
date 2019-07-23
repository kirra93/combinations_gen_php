<?php
    use Slim\App;
    use App\Services\Сombination;

    return function (App $app) {
        $container = $app->getContainer();

        $container['combinationSolver'] = function ($container) {
            $combinationSolver = new Сombination($container->get('settings')['data_path'] . 'file.txt');
            return $combinationSolver;
        };

        $templateVariables = [
            "msg" => ""
        ];

        // Register component on container
        $container['view'] = function ($container) use ($templateVariables) {
            return new \Slim\Views\PhpRenderer('./templates/', $templateVariables);
        };
    };
