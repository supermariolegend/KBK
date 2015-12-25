<?php
namespace KBK\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use KBK\Model\MenuCategoryRepository;
use KBK\Model\ItemsInCategory;
use KBK\Model\Search;

class MainController
{
    /**
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    //action for route:     /
    public function indexAction(Request $request, Application $app)
    {
        //check if username is stored in session
        $username = getAuthenticatedUsername($app);

        // build args array
        $argsArray = array(
            'username' => $username,
            'title' => "Kevin's Vegeburger Kitchen",
        );

        //render template
        $templateName = 'index';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    //action for route:     /about
    public function aboutAction(Request $request, Application $app)
    {
        //check if username is stored in session
        $username = getAuthenticatedUsername($app);

        // build arrgs array
        $argsArray = array(
            'username' => $username,
            'title' => 'About us',
            'content'=> 'About us - we`re a great food company'
        );

        //render template
        $templateName = 'about';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    //action for route:     /menu
    public function menuAction(Request $request, Application $app)
    {
        //check if username is stored in session
        $username = getAuthenticatedUsername($app);

        // get reference to our Menu category repository
        $menuCategoryRepository = new MenuCategoryRepository();

        // build args array
        $argsArray = array(
            'username' => $username,
            'categories' => $menuCategoryRepository->getAllMenuCategories()
        );

        //render template
        $templateName = 'menu';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    //action for route:     /contact
    public function contactAction(Request $request, Application $app)
    {
        //check if username is stored in session
        $username = getAuthenticatedUsername($app);

        // build arrgs array
        $argsArray = array(
            'username' => $username,
            'title' => 'Contact Details',
            'content'=> 'These are our contact details: ...'
        );

        //render template
        $templateName = 'contact';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    // action for route:    /search keyword={search}
    public function searchAction(Request $request, Application $app)
    {
        //check if username is stored in session
        $username = getAuthenticatedUsername($app);

        $params = $request->query->all();
        $search = $params['search'];

        $connection = open_database_connection();
        if(!$connection) {
            $_SESSION['errorCategory'] = 'Database';
            $_SESSION['errorMessage'] = 'DB connection failed: '.mysqli_connect_error();
            header('Location: /error');
        }

        $searchObject = new Search();
        $results = $searchObject->makeSearch($connection, $search);

        // build args array
        // ------------

        $argsArray = array(
            'username' => $username,
            'results'=>$results,
            'title'=>$search.' search results',
            'searchQuery'=>$search
        );
        // render (draw) template
        // ------------
        $templateName = 'search';

        close_database_connection($connection);
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * @param Request $request
     * @param Application $
     */
    // action for route: /error
    public function errorAction(Request $request, Application $app)
    {
        //check if username is stored in session
        $username = getAuthenticatedUsername($app);

        $params = $request->query->all();

        $errorMessage = 'Error type: '.$_SESSION['errorCategory'].'<br>'.'Error details: '.$_SESSION['errorMessage'];

        // build args array
        // ------------

        $argsArray = array(
            'username' => $username,
            'title'=>'Error',
            'errorMessage'=>$errorMessage
        );
        // render (draw) template
        // ------------
        $templateName = 'error';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * @param Request $request
     * @param Application $
     * @param $app
     */
    // action for route: /categories
    public function categoriesAction(Request $request, Application $app)
    {
        //check if username is stored in session
        $username = getAuthenticatedUsername($app);

        $categoryNumber = $_GET['categoryNumber'];
        $categoryName = $_GET['categoryName'];

        $db = open_database_connection();

        $categoryObject = new ItemsInCategory();
        $categoryHTML = $categoryObject->getProductHTML($db, $categoryNumber);

        // build args array
        $argsArray = array(
            'username' => $username,
            'title'=>$categoryName." category",
            'html'=>$categoryHTML
        );

        //render template
        $templateName = 'categories';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    // action for route: /product
    public function productAction(Request $request, Application $app)
    {
        //check if username is stored in session
        $username = getAuthenticatedUsername($app);

        $params = $request->query->all();
        $productName = $_GET['product_name'];
        $error = "";

        $db = open_database_connection();
        if(!$db) {
            $_SESSION['errorCategory'] = 'Database';
            $_SESSION['errorMessage'] = 'DB connection failed: '.mysqli_connect_error();
            header('Location: /error');
        }

        $query = "SELECT * FROM `products` WHERE ProductName = '".$productName."'";
        $resultSet = mysqli_query($db, $query);


        if(mysqli_num_rows($resultSet) > 0) {
            $rows = mysqli_fetch_assoc($resultSet);

            $productName = $rows['ProductName'];
            $productImageURL = $rows['ProductImageURL'];
            $productDescription = $rows['ProductDescription'];
            $productCalories = $rows['ProductCalories'];
            $productAllergyInfo = $rows['ProductAllergyInfo'];
            $productPrice = $rows['ProductPrice'];
        } else {
            $error = "An internal server error occurred. Please try again later.";
        }

        close_database_connection($db);

        // build args array
        // -------------

        $argsArray = array(
            'username' => $username,
            'title'=>$productName,
            'productName'=>$productName,
            'productImageURL'=>$productImageURL,
            'productDescription'=>$productDescription,
            'productCalories'=>$productCalories,
            'productAllergyInfo'=>$productAllergyInfo,
            'productPrice'=>$productPrice,
            'errorMessage'=>$error
        );
        // render template
        // --------------
        $templateName = 'product';
        return $app['twig']->render($templateName.'.html.twig', $argsArray);
    }
}