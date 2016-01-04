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
$app->get('/contactSent', controller('KBK\Controller', 'main/contactSent'));
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
$app->get('/adminSearch', controller('KBK\Controller', 'admin/search'));
$app->post('/adminUploadImage',     controller('KBK\Controller', 'admin/uploadImage'));

$app->get('/adminChangeCategory', controller('KBK\Controller', 'admin/changeCategory'));
$app->get('/adminAddCategory', controller('KBK\Controller', 'admin/addCategory'));
$app->get('/adminEditCategory', controller('KBK\Controller', 'admin/editCategory'));
$app->get('/adminDeleteCategory', controller('KBK\Controller', 'admin/deleteCategory'));

$app->get('/adminChangeProductSelectCategory', controller('KBK\Controller', 'admin/changeProductSelectCategory'));
$app->get('/adminChangeProductSelectProduct', controller('KBK\Controller', 'admin/changeProductSelectProduct'));
$app->get('/adminEditProduct', controller('KBK\Controller', 'admin/editProduct'));
$app->get('/adminAddProduct', controller('KBK\Controller', 'admin/addProduct'));
$app->get('/adminDeleteProduct', controller('KBK\Controller', 'admin/deleteProduct'));
//go - process request and decide what needed to be done
$app->run();