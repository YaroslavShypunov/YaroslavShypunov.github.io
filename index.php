<?php

include_once __DIR__ . '/includes/dbh.inc.php';
include_once  __DIR__ .'/Request.php';
include_once  __DIR__ .'/Router.php';


$router = new Router(new Request($conn));




$router->get('/', function() {
    
 
  return <<<HTML
  <h1>Hello world</h1>

  <p>  Lasalsafl</p>
HTML;
});


$router->get('/profile', function($request) {
  return <<<HTML
  <h1>Profile</h1>
HTML;
});

$router->post('/data', function($request) {

  return json_encode($request->getBody());
});

$router->get('/data', function($request) {

  return json_encode($request->getBody());
});