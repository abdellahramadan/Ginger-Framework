<?php

require_once __DIR__ . './../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing;

$request = Request::createFromGlobals();
$response = new Response();
$routes = include __DIR__ . '/../src/app.php';

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

//$attributes = $matcher->match($request->getPathInfo());

try {
    extract($matcher->match($request->getPathInfo(), EXTR_SKIP));
    ob_start();
    include sprintf(__DIR__ . '/../src/pages/%s.php', $_route);

    $response = new Response(ob_get_clean());
} catch (Routing\Exception\ResourceNotFoundException $e) {
    $response = new Response('404 not found', 404);
} catch (Exception $e) {
    $response = new Response('An error occured', 500);
}
/*
$map = [
    '/' => 'index',
    '/hello' => 'hello',
    '/bye' => 'bye'
];

$path = $request->getPathInfo();

if(isset($map[$path])) {
    ob_start();
    extract($request->query->all(), EXTR_SKIP);
    include sprintf(__DIR__ . '/../src/pages/%s.php', $map[$path]);
    $response = new Response(ob_get_clean());
} else {
    $response = new Response('404 not found', 404);
}
*/

$response->send();