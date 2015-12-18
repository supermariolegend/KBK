<?php
// We want to ensure we have session
if(session_id() === ""){
    session_start();
}

// autoloader and other functions to include
require_once __DIR__ .'/../vendor/autoload.php';
require_once __DIR__ . '/../src/utility/helperFunctions.php';

//my settings
$myTemplatesPath = __DIR__ . '/../templates';

//setup Twig
$loader = new Twig_Loader_Filesystem($myTemplatesPath);
$twig = new Twig_Environment($loader);

//setup Silex
$app = new Silex\Application();

//register Twig with Silex
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => $myTemplatesPath
));

//map routes to controller class/method
$app->get('/',      controller('KBK\Controller', 'main/index'));
$app->get('/about', controller('KBK\Controller', 'main/about'));
$app->get('/menu', controller('KBK\Controller', 'main/menu'));
$app->get('/contact', controller('KBK\Controller', 'main/contact'));

//go - process request and decide what needed to be done
$app->run();