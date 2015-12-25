<?php
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

//register session provider with Silex
$app->register(new Silex\Provider\SessionServiceProvider());

//register Twig with Silex
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => $myTemplatesPath
));

//********** map routes to controller class/method *************
$app->get('/',      controller('KBK\Controller', 'main/index'));
$app->get('/about', controller('KBK\Controller', 'main/about'));
$app->get('/menu', controller('KBK\Controller', 'main/menu'));
$app->get('/contact', controller('KBK\Controller', 'main/contact'));
$app->get('/error', controller('KBK\Controller', 'main/error'));
$app->get('/search', controller('KBK\Controller', 'main/search'));
$app->get('/categories', controller('KBK\Controller', 'main/categories'));
$app->get('/product', controller('KBK\Controller', 'main/product'));

// ******** login routes GET **************
$app->get('/login', controller('KBK\Controller', 'user/login'));
$app->get('/logout', controller('KBK\Controller', 'user/logout'));

// ********* login routes POST (process submitted form) ******
$app->post('/login',    controller('KBK\Controller', 'user/processLogin'));

// ******** secure pages ********************
$app->get('/admin',     controller('KBK\Controller', 'admin/index'));
$app->get('/adminCodes', controller('KBK\Controller', 'admin/codes'));
//go - process request and decide what needed to be done
$app->run();