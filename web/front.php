<?php

date_default_timezone_set('Europe/Berlin');

require_once __DIR__ . '/../vendor/.composer/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\HttpCache\HttpCache;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Symfony\Component\HttpKernel\HttpCache\ESI;


//$request = Request::createFromGlobals();
$request = Request::create('/is_leap_year/2012');
$routes = include __DIR__ . '/../src/app.php';

$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);
$resolver = new HttpKernel\Controller\ControllerResolver();

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new Simplex\GoogleListener());

$framework = new Simplex\Framework($dispatcher, $matcher, $resolver);
$framework = new HttpCache($framework, new Store(__DIR__. '/../cache'), new ESI(), array('debug' => true));

$response = new Response($request);


$framework->handle($request)->send();

echo $framework->handle($request);