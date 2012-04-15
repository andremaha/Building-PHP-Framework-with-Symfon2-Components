<?php
// front.php
// front controller
// 1) Maps the URL to the template file
// 2) Include the file according to its mapped name

require_once __DIR__ . '/../vendor/.composer/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;
use Symfony\Component\EventDispatcher\EventDispatcher;


$request = Request::createFromGlobals();
$routes = include __DIR__ . '/../src/app.php';

$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);
$resolver = new HttpKernel\Controller\ControllerResolver();

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new Simplex\GoogleListener());

$framework = new Simplex\Framework($dispatcher, $matcher, $resolver);
$response = $framework->handle($request);
 
$response->send();