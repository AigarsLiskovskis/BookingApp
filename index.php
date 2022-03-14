<?php

use App\Controllers\ApartmentControllers;
use App\Controllers\ReviewControllers;
use App\Controllers\UserControllers;
use App\Redirect;
use App\Views\View;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

require_once 'vendor/autoload.php';

session_start();

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/users/signUp', [UserControllers::class, 'signUp']);
    $r->addRoute('POST', '/users/register', [UserControllers::class, 'register']);

    $r->addRoute('GET', '/users', [UserControllers::class, 'login']);
    $r->addRoute('POST', '/users/signIn', [UserControllers::class, 'signIn']);

    $r->addRoute('GET', '/users/message', [UserControllers::class, 'error']);
    $r->addRoute('GET', '/logout', [UserControllers::class, 'logout']);


    $r->addRoute('GET', '/', [ApartmentControllers::class, 'index']);
    $r->addRoute('GET', '/apartments/{id:\d+}', [ApartmentControllers::class, 'show']);

    $r->addRoute('POST', '/apartments', [ApartmentControllers::class, 'store']);
    $r->addRoute('GET', '/apartments/create', [ApartmentControllers::class, 'create']);

    $r->addRoute('POST', '/apartments/{id:\d+}/delete', [ApartmentControllers::class, 'delete']);

    $r->addRoute('GET', '/apartments/{id:\d+}/edit', [ApartmentControllers::class, 'edit']);
    $r->addRoute('POST', '/apartments/{id:\d+}', [ApartmentControllers::class, 'update']);

    $r->addRoute('POST', '/apartments/{id:\d+}/reserve', [ApartmentControllers::class, 'reserve']);


    $r->addRoute('POST', '/apartments/{id:\d+}/rating', [ApartmentControllers::class, 'ratings']);

    $r->addRoute('POST', '/apartments/{id:\d+}/count', [ApartmentControllers::class, 'countMoney']);


    $r->addRoute('POST', '/apartments/{id:\d+}/addReview', [ReviewControllers::class, 'addReview']);
    $r->addRoute('POST', '/reviews/{id:\d+}/delete', [ReviewControllers::class, 'deleteReview']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $controller = $routeInfo[1][0];
        $method = $routeInfo[1][1];

        /** @var View $response */
        $response = (new $controller)->$method($routeInfo[2]);

        $twig = new Environment(new FilesystemLoader('app/Views'));


        if ($response instanceof View) {
            try {
                echo $twig->render($response->getPath() . '.twig', $response->getVariables());
            } catch (LoaderError|RuntimeError|SyntaxError $e) {
            }
        }

        if ($response instanceof Redirect) {
            header('Location: ' . $response->getLocation());
            exit;
        }
        break;
}

if(isset($_SESSION["inputs"])){
    unset($_SESSION["inputs"]);
}
$_SESSION['price'] = 0;


