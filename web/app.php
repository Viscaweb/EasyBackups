<?php
require_once __DIR__.'/../app/bootstrap.php';
$container = getContainer();

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

$monitoringController = $container->get('controller.monitoring');

$datePattern = '[0-9]+-[0-9]+-[0-9]+';
$route = new Route(
    '/monitoring/database/{strategyIdentifier}/{requestedFromDate}/{requestedUntilDate}',
    ['_controller' => [$monitoringController, 'testAction']],
    ['requestedFromDate' => $datePattern, 'requestedUntilDate' => $datePattern]
);

$routes = new RouteCollection();
$routes->add(
    'monitoring_database',
    $route
);

$request = Request::createFromGlobals();

$matcher = new UrlMatcher($routes, new RequestContext());

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new RouterListener($matcher, new RequestStack()));

$resolver = new ControllerResolver();
$kernel = new HttpKernel($dispatcher, $resolver);

$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
