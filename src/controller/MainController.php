<?php

/**
 * Controller responsible for handling all web pages in the public part of
 * the website (where the user is not logged in)
 */

namespace KBK\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use KBK\Model\MenuCategoryRepository;
use KBK\Model\ItemsInCategory;
use KBK\Model\Search;

/**
 * Class MainController
 * @package KBK\Controller
 */
class MainController
{
    /**
     * Action for the homepage of the website
     *
     * Action for route: /
     *
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
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
     * Action for the about page of the website
     *
     * Action for route: /about
     *
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function aboutAction(Request $request, Application $app)
    {
        //check if username is stored in session
        $username = getAuthenticatedUsername($app);

        // build arrgs array
        $argsArray = array(
            'username' => $username,
            'title' => 'About us'
        );

        //render template
        $templateName = 'about';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Action for the menu page of the website. This action makes a new
     * MenuCategoryRepository and gets all the data from the database.
     *
     * Action for route: /menu
     *
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
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
     * Action for the contact page of the website.
     *
     * Action for route: /contact
     *
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function contactAction(Request $request, Application $app)
    {
        //check if username is stored in session
        $username = getAuthenticatedUsername($app);

        // build arrgs array
        $argsArray = array(
            'title' => 'Contact Us',
            'username' => $username
        );

        //render template
        $templateName = 'contact';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Action for the contact sent page. The visitor is taken to this page
     * after their contact details and message have been sent.
     *
     * Action for route: /contactSent
     *
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function contactSentAction(Request $request, Application $app)
    {
        //check if username is stored in session
        $username = getAuthenticatedUsername($app);

        // build arrgs array
        $argsArray = array(
            'title' => 'Contact Us',
            'username' => $username,
            'name' => $_GET['name']
        );

        //render template
        $templateName = 'contactSent';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Action for making a new product search from the menu page.
     *
     * Action for route: /search
     *
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function searchAction(Request $request, Application $app)
    {
        //check if username is stored in session
        $username = getAuthenticatedUsername($app);

        $params = $request->query->all();
        if(isset($params['search'])) {
            $search = $params['search'];
        } else {
            $search = "";
        }
        $results = "";
        $searchTitle = NULL;

        $searchObject = new Search();

        $connection = open_database_connection();
        if(!$connection) {
            $_SESSION['errorCategory'] = 'Database';
            $_SESSION['errorMessage'] = 'DB connection failed: '.mysqli_connect_error();
            header('Location: /error');
        }

        if(isset($_GET['search'])) {
            if(isset($_GET['name'])) {
                if ($_GET['name'] == "ascending") {
                    $results = $searchObject->showAscendingBySearch($connection, $_GET['search'], "ProductName");
                } else if ($_GET['name'] == "descending") {
                    $results = $searchObject->showDescendingBySearch($connection, $_GET['search'], "ProductName");
                }
            } else if(isset($_GET['calories'])) {
                if($_GET['calories'] == "ascending") {
                    $results = $searchObject->showAscendingBySearch($connection, $_GET['search'], "ProductCalories");
                } else if($_GET['calories'] == "descending") {
                    $results = $searchObject->showDescendingBySearch($connection, $_GET['search'], "ProductCalories");
                }
            } else {
                $results = $searchObject->makeSearch($connection, $_GET['search']);
            }
        } else if(isset($_GET['name'])) {
            if($_GET['name'] == "ascending") {
                $results = $searchObject->showAscending($connection, "ProductName");
            } else {
                $results = $searchObject->showDescending($connection, "ProductName");
            }
        } else if(isset($_GET['calories'])) {
            if($_GET['calories'] == "ascending") {
                $results = $searchObject->showAscending($connection, "ProductCalories");
            } else {
                $results = $searchObject->showDescending($connection, "ProductCalories");
            }
        }


        // build args array
        // ------------

        $argsArray = array(
            'username' => $username,
            'results' => $results,
            'title '=> $search.' search results',
            'searchTitle' => $searchTitle,
            'search' => $search
        );
        // render (draw) template
        // ------------
        $templateName = 'search';

        close_database_connection($connection);
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Action for displaying an error message when the website doesn't function
     * properly.
     *
     * Action for route: /error
     *
     * @param Request $request
     * @param Application $
     */
    public function errorAction(Request $request, Application $app)
    {
        //check if username is stored in session
        $username = getAuthenticatedUsername($app);

        $errorMessage = "";
        if(isset($_SESSION['errorCategory'] ) || isset($_SESSION['errorMessage'])) {
            $errorMessage = 'Error type: ' . $_SESSION['errorCategory'] . '<br>' . 'Error details: ' . $_SESSION['errorMessage'];
        } else {
            $errorMessage = '<br>The website encountered an error.';
        }

        $errorMessage .= "<br>If you see this page often, please contact an admininstrator.";

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
     * Action for displaying all items from a category
     *
     * Action for route: /categories
     *
     * @param Request $request
     * @param Application $
     * @param $app
     */
    public function categoriesAction(Request $request, Application $app)
    {
        //check if username is stored in session
        $username = getAuthenticatedUsername($app);

        if(isset($_GET['categoryNumber']) || isset($_GET['categoryName']) || isset($_GET['categorySummary'])) {
            $categoryNumber = $_GET['categoryNumber'];
            $categoryName = $_GET['categoryName'];
            $categorySummary = $_GET['categorySummary'];
        } else {
            return $app->redirect("/error");
        }

        $connection = open_database_connection();

        $categoryObject = new ItemsInCategory();
        $categoryHTML = $categoryObject->getProductHTML($connection, $categoryNumber, $categoryName, $categorySummary, "/product");

        // build args array
        $argsArray = array(
            'username' => $username,
            'title'=>$categoryName." category",
            'html'=>$categoryHTML
        );

        close_database_connection($connection);

        //render template
        $templateName = 'categories';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Action for displaying all the information about a product to the user
     *
     * Action for route: /product
     *
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function productAction(Request $request, Application $app)
    {
        //check if username is stored in session
        $username = getAuthenticatedUsername($app);

        $params = $request->query->all();
        $productName = $_GET['product_name'];
        $error = "";

        $connection = open_database_connection();
        if(!$connection) {
            $_SESSION['errorCategory'] = 'Database';
            $_SESSION['errorMessage'] = 'DB connection failed: '.mysqli_connect_error();
            header('Location: /error');
        }

        $query = "SELECT * FROM `products` WHERE ProductName = '".$productName."'";
        $resultSet = mysqli_query($connection, $query);


        if(mysqli_num_rows($resultSet) > 0) {
            $rows = mysqli_fetch_assoc($resultSet);

            $productName = $rows['ProductName'];
            $productImageURL = $rows['ProductImageURL'];
            $productDescription = $rows['ProductDescription'];
            $productCalories = $rows['ProductCalories'];
            $productAllergyInfo = $rows['ProductAllergyInfo'];
            $productPrice = sprintf("%01.2f", $rows['ProductPrice']);
        } else {
            $error = "An internal server error occurred. Please try again later.";
        }

        close_database_connection($connection);

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