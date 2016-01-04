<?php

/**
 * Admin Controller of the site
 *
 * This controller controls the admin pages of the website
 */

namespace KBK\Controller;

use KBK\Model\ChangeCategory;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

use KBK\Model\MenuCategoryRepository;
use KBK\Model\ChangeProduct;
use KBK\Model\AdminSearch;

/**
 * Class AdminController
 * authentication class
 * @package KBK\Controller
 */
class AdminController
{
    /**
     * Action for the index page.
     *
     * Action for route: /admin
     *
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request, Application $app)
    {
        //check if username is stored in session
        $username = getAuthenticatedUserName($app);

        //check if we are authenticated
        $isAuthenticated = (null != $username);
        if(!$isAuthenticated){
            //not authenticated, so redirecting to login page
            return $app->redirect('/login');
        }

        //store username into argsArray
        $argsArray = array(
            'username' => $username,
            'title' => 'Admin'
        );

        //render template
        $templateName = 'admin/index';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Search action for the admin pages. This function handles all of the possible
     * types of searches that the user might search for.
     *
     * Action for route: /adminSearch
     *
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function searchAction(Request $request, Application $app)
    {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if(!$isAuthenticated){
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $connection = open_database_connection();

        $searchType = $_GET['search_type'];
        if($searchType == "new") {
            $searchType = "product";
        }
        $searchObject = new AdminSearch();
        $searchResults = "";

        if($searchType == "category") {
            if(!empty($_GET['keywords'])) {
                if(isset($_GET['name'])) {
                    if($_GET['name'] == "ascending") {
                        $searchResults = $searchObject->sortCategoryBySearch($connection, "ASC", "CategoryName", $_GET['keywords']);
                    } else if($_GET['name'] == "descending") {
                        $searchResults = $searchObject->sortCategoryBySearch($connection, "DESC", "CategoryName", $_GET['keywords']);
                    }
                } else {
                    $searchResults = $searchObject->makeCategorySearch($connection, $_GET['keywords']);
                }
            } else if(isset($_GET['name'])) {
                if ($_GET['name'] == "ascending") {
                    $searchResults = $searchObject->sortCategory($connection, "CategoryName", "ASC");
                } else {
                    $searchResults = $searchObject->sortCategory($connection, "CategoryName", "DESC");
                }
            } else if(isset($_GET['summary'])) {
                if ($_GET['summary'] == "ascending") {
                    $searchResults = $searchObject->sortCategory($connection, "CategorySummary", "ASC");
                } else {
                    $searchResults = $searchObject->sortCategory($connection, "CategorySummary", "DESC");
                }
            }
        } else if($searchType == "product-category") {
            if(isset($_GET['search'])) {
                if(isset($_GET['name'])) {
                    if($_GET['name'] == "ascending") {
                        $searchResults = $searchObject->sortCategoryBySearch($connection, "ASC", "CategoryName", $_GET['keywords']);
                    } else if($_GET['name'] == "descending") {
                        $searchResults = $searchObject->sortCategoryBySearch($connection, "DESC", "CategoryName", $_GET['keywords']);
                    }
                } else {
                    $searchResults = $searchObject->makeCategorySearch($connection, $_GET['keywords']);
                }
            } else if(isset($_GET['name'])) {
                if ($_GET['name'] == "ascending") {
                    $searchResults = $searchObject->sortCategory($connection, "CategoryName", "ASC");
                } else {
                    $searchResults = $searchObject->sortCategory($connection, "CategoryName", "DESC");
                }
            } else {
                if ($_GET['summary'] == "ascending") {
                    $searchResults = $searchObject->sortCategory($connection, "CategorySummary", "ASC");
                } else {
                    $searchResults = $searchObject->sortCategory($connection, "CategorySummary", "DESC");
                }
            }
        } else if($searchType == "product") {
            if(isset($_GET['keywords'])) {
                if(isset($_GET['name'])) {
                    if ($_GET['name'] == "ascending") {
                        $searchResults = $searchObject->sortProductBySearch($connection, "ASC", "ProductName", $_GET['keywords']);
                    } else if ($_GET['name'] == "descending") {
                        $searchResults = $searchObject->sortProductBySearch($connection, "DESC", "ProductName", $_GET['keywords']);
                    }
                } else if(isset($_GET['calories'])) {
                    if($_GET['calories'] == "ascending") {
                        $searchResults = $searchObject->sortProductBySearch($connection, "ASC", "ProductCalories", $_GET['keywords']);
                    } else if($_GET['calories'] == "descending") {
                        $searchResults = $searchObject->sortProductBySearch($connection, "DESC", "ProductCalories", $_GET['keywords']);
                    }
                } else if(isset($_GET['price'])) {
                    if($_GET['price'] == "ascending") {
                        $searchResults = $searchObject->sortProductBySearch($connection, "ASC", "ProductPrice", $_GET['keywords']);
                    } else if($_GET['price'] == "descending") {
                        $searchResults = $searchObject->sortProductBySearch($connection, "DESC", "ProductPrice", $_GET['keywords']);
                    }
                } else if(isset($_GET['description'])) {
                    if($_GET['description'] == "ascending") {
                        $searchResults = $searchObject->sortProductBySearch($connection, "ASC", "ProductDescription", $_GET['keywords']);
                    } else if($_GET['description'] == "descending") {
                        $searchResults = $searchObject->sortProductBySearch($connection, "DESC", "ProductDescription", $_GET['keywords']);
                    }
                } else {
                    $searchResults = $searchObject->makeProductSearch($connection, $_GET['keywords']);
                }
            } else if(isset($_GET['name'])) {
                if($_GET['name'] == "ascending") {
                    $searchResults = $searchObject->sortProduct($connection, "ProductName", "ASC");
                } else {
                    $searchResults = $searchObject->sortProduct($connection, "ProductName", "DESC");
                }
            } else if(isset($_GET['calories'])) {
                if($_GET['calories'] == "ascending") {
                    $searchResults = $searchObject->sortProduct($connection, "ProductCalories", "ASC");
                } else {
                    $searchResults = $searchObject->sortProduct($connection, "ProductCalories", "DESC");
                }
            } else if(isset($_GET['description'])) {
                if($_GET['description'] == "ascending") {
                    $searchResults = $searchObject->sortProduct($connection, "ProductDescription", "ASC");
                } else {
                    $searchResults = $searchObject->sortProduct($connection, "ProductDescription", "DESC");
                }
            } else if(isset($_GET['price'])) {
                if($_GET['price'] == "ascending") {
                    $searchResults = $searchObject->sortProduct($connection, "ProductPrice", "ASC");
                } else {
                    $searchResults = $searchObject->sortProduct($connection, "ProductPrice", "DESC");
                }
            }
        }

        close_database_connection($connection);

        // store username into args array
        $argsArray = array(
            'title' => $_GET['keywords']." search results",
            'username' => $username,
            'searchType' => $searchType,
            'searchResults' => $searchResults,
            'search' => $_GET['keywords']
        );

        // render (draw) template
        // ------------
        $templateName = 'admin/adminSearch';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Upload action for when an admin wants to upload an image to the images
     * folder on the website. It's used in the changeCategory and changeProduct pages.
     *
     * Action for route: /adminUploadImage
     *
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function uploadImageAction(Request $request, Application $app)
    {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if(!$isAuthenticated){
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $errorMessage = "";
        $uploadOk = 1;
        $target_dir = __DIR__ . '/../../public/images/';

        if(empty($_FILES["imageToUpload"]["name"])) {
            $errorMessage = "Filename cannot be empty";
            $uploadOk = 0;
        } else {
            $target_file = $target_dir . basename($_FILES["imageToUpload"]["name"]);
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            // Check if image file is a actual image or fake image
            if (isset($_POST["submit"])) {
                $check = getimagesize($_FILES["imageToUpload"]["tmp_name"]);
                if ($check != false) {
                    $errorMessage .= "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    $errorMessage .= "File is not an image.";
                    $uploadOk = 0;
                }
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                $errorMessage .= "Sorry, file already exists.";
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["imageToUpload"]["size"] > 1048576) {
                $errorMessage .= "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "JPEG"
                && $imageFileType != "GIF" && $imageFileType != "PNG" && $imageFileType != "bmp"
                && $imageFileType != "BMP"
            ) {
                $errorMessage .= "Sorry, only jpg, jpeg, png, gif, and bmp files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $errorMessage .= "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["imageToUpload"]["tmp_name"], $target_file)) {
                    $errorMessage .= "The file " . basename($_FILES["imageToUpload"]["name"]) . " has been uploaded.";
                    return $app->redirect($_POST['changeItemURL']);
                } else {
                    $errorMessage .= "Sorry, there was an error uploading your file.";
                }
            }
        }

        // store username into args array
        $argsArray = array(
            'title' => 'Admin Upload Image',
            'username' => $username,
            'errorMessage' => $errorMessage,
            'uploadStatus' => $uploadOk
        );

        // render (draw) template
        // ------------
        $templateName = 'admin/uploadImage';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Action for selecting a category to change, edit or delete.
     *
     * Action for route: /adminChangeCategory
     *
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function changeCategoryAction(Request $request, Application $app) {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if(!$isAuthenticated){
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $connection = open_database_connection();

        $menuCategoryRepository = new MenuCategoryRepository();

        $changeCategoryObject = new ChangeCategory();
        // $categoryInputSelection = $changeCategoryObject->getCategoriesForSelection($connection);

        // store username into args array
        $argsArray = array(
            'title' => "Admin Change Categories",
            'username' => $username,
            'categories' => $menuCategoryRepository->getAllMenuCategories(),
            'productCategoriesData' => $changeCategoryObject->getCategoriesWithProducts($connection)
        );

        close_database_connection($connection);

        // render (draw) template
        // ------------
        $templateName = 'admin/changeCategory';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Action for adding a category to the database. This function gets the data from
     * the form, and executes the function in the ChangeCategory class.
     *
     * Action for route: /adminAddCategory
     *
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addCategoryAction(Request $request, Application $app)
    {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if(!$isAuthenticated){
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $resultMessage = "";

        $connection = open_database_connection();
        $changeCategoryObject = new ChangeCategory();

        if(isset($_GET['submit'])) {
            // then we are coming from a request from this page to make a new category
            $resultMessage = $changeCategoryObject->addCategory($connection, $_GET['categoryName'], $_GET['categoryImageURL1'], $_GET['categoryImageURL2'], $_GET['categorySummary']);
        }
        $categoryImageSelection = $changeCategoryObject->getCategoriesForSelection($connection, "addCategory");

        close_database_connection($connection);

        if($resultMessage == "Success!") {
            return $app->redirect("/adminChangeCategory");
        }

        $changeItemURL = $_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'];
        // store username into args array
        $argsArray = array(
            'title' => 'Add new category',
            'username' => $username,
            'categoryImageSelection' => $categoryImageSelection,
            'resultMessage' => $resultMessage,
            'changeItemURL' => $changeItemURL
        );


        // render (draw) template
        // ------------
        $templateName = 'admin/addCategory';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Action for editing a category's properties
     *
     * Action for route: /adminEditCategory
     *
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editCategoryAction(Request $request, Application $app)
    {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if(!$isAuthenticated){
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $categoryID = $_GET['categoryID'];
        $categoryName = $_GET['categoryName'];
        $categoryImageURL = $_GET['categoryImageURL'];
        $categoryImageURL1 = $_GET['categoryImageURL1'];
        $categoryImageURL2 = $_GET['categoryImageURL2'];
        $categorySummary = $_GET['categorySummary'];

        $connection = open_database_connection();

        $changeCategoryObject = new ChangeCategory();
        $resultMessage = $changeCategoryObject->editCategory($connection, $categoryID, $categoryName, $categoryImageURL1, $categoryImageURL2, $categorySummary);
        $categoriesForSelection = $changeCategoryObject->getCategoriesForSelection($connection, "editCategory");

        close_database_connection($connection);

        if($resultMessage == "Success!") {
            return $app->redirect("/adminChangeCategory");
        }

        $changeItemURL = $_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'];
        // store username into args array
        $argsArray = array(
            'title' => "Edit category".$categoryName,
            'username' => $username,
            'categoryID' => $categoryID,
            'categoryName' => $categoryName,
            'categoryImageURL' => $categoryImageURL,
            'categorySummary' => $categorySummary,
            'categoryImageSelection' => $categoriesForSelection,
            'resultMessage' => $resultMessage,
            'changeItemURL' => $changeItemURL
        );


        // render (draw) template
        // ------------
        $templateName = 'admin/editCategory';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Action for deleting a category.
     *
     * Action for route: /adminDeleteCategory
     *
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteCategoryAction(Request $request, Application $app)
    {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);

        // check if we are authenticated --------
        $isAuthenticated = (null != $username);
        if(!$isAuthenticated){
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $categoryID = $_GET['categoryID'];
        $categoryName = $_GET['categoryName'];
        $resultMessage = "";

        $connection = open_database_connection();

        /*
        if(isset($_GET['no'])) {
            return $app->redirect("/adminChangeCategory");
        }
        if(isset($_GET['yes'])) {
            $changeCategoryObject = new ChangeCategory();
            $resultMessage = $changeCategoryObject->deleteCategory($connection, $categoryID);
        }
        */
        $changeCategoryObject = new ChangeCategory();
        $resultMessage = $changeCategoryObject->deleteCategory($connection, $categoryID);

        close_database_connection($connection);

        if($resultMessage == "items_exist") {
            $app['session']->set('items_exist', true);
        }

        return $app->redirect("/adminChangeCategory");

        /**
        // store username into args array
        $argsArray = array(
            'title' => "Delete category ".$categoryName,
            'username' => $username,
            'categoryID' => $categoryID,
            'categoryName' => $categoryName,
            'resultMessage' => $resultMessage,
        );

        // render (draw) template
        // ------------
        $templateName = 'admin/deleteCategory';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
         */
    }

    /**
     * Action for changing a product's properties. This action handles the category
     * selection part of the process
     *
     * Action for route: /adminChangeProductSelectCategory
     *
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function changeProductSelectCategoryAction(Request $request, Application $app) {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if(!$isAuthenticated){
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $menuCategoryRepository = new MenuCategoryRepository();

        // store username into args array
        $argsArray = array(
            'title' => "Admin Change Products - pick a category",
            'categories' => $menuCategoryRepository->getAllMenuCategories(),
            'username' => $username
        );

        // render (draw) template
        // ------------
        $templateName = 'admin/changeProductSelectCategory';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Action for changing a product's properties. This action handles the product
     * selection part of the process.
     *
     * Action for route: /adminChangeProductSelectProduct
     *
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function changeProductSelectProductAction(Request $request, Application $app) {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if(!$isAuthenticated){
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $categoryID = $_GET['categoryID'];
        $categoryName = $_GET['categoryName'];
        $categorySummary = $_GET['categorySummary'];

        $errorInput = "";
        $productObject = new ChangeProduct();
        if(isset($_GET['resultMessage'])) {
            $errorMessage = $_GET['resultMessage'];
            $errorInput = $productObject->errorMessageToJSAlert($errorMessage);
        }

        $connection = open_database_connection();

        $productHTML = $productObject->getProductHTML($connection, $categoryID, $categoryName, $categorySummary);


        // store username into args array
        $argsArray = array(
            'title' => "Admin Change Products - pick a product",
            'username' => $username,
            'html' => $productHTML,
            'categoryID' => $categoryID,
            'categoryName' => $categoryName,
            'categorySummary' => $categorySummary,
            'deleteErrorMessage' => $errorInput
        );

        close_database_connection($connection);

        // render (draw) template
        // ------------
        $templateName = 'admin/changeProductSelectProduct';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Action for adding a product to the database.
     *
     * Action for route: /adminAddProduct
     *
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addProductAction(Request $request, Application $app) {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if(!$isAuthenticated){
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $connection = open_database_connection();

        $changeProductObject = new ChangeProduct();
        $productImageSelection = $changeProductObject->getProductsForSelection($connection, "addProduct");

        $categoryID = $_GET['categoryID'];
        $categoryName = $_GET['categoryName'];
        $categorySummary = $_GET['categorySummary'];

        $resultMessage = "";
        if(isset($_GET['submit'])) {
            // then we are coming from a request from this page to make a new product
            $productName = $_GET['productName'];
            $productImageURL1 = $_GET['productImageURL1'];
            $productImageURL2 = $_GET['productImageURL2'];
            $productDescription = $_GET['productDescription'];
            $productCalories = $_GET['productCalories'];
            $productAllergyInfo = $_GET['productAllergyInfo'];
            $productPrice = $_GET['productPrice'];
            $resultMessage = $changeProductObject->addProduct($connection, $categoryID, $productName, $productImageURL1, $productImageURL2, $productDescription, $productCalories, $productAllergyInfo, $productPrice);
        }

        if($resultMessage == "Success!") {
            $categoryName = str_replace(" ", "+", $categoryName);
            $categorySummary = str_replace(" ", "+", $categorySummary);
            return $app->redirect("/adminChangeProductSelectProduct?categoryID=".$categoryID."&categoryName=".$categoryName."&categorySummary=".$categorySummary);
        }

        $changeItemURL = $_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'];
        // store username into args array
        $argsArray = array(
            'title' => "Admin Add Product",
            'username' => $username,
            'productImageSelection' => $productImageSelection,
            'resultMessage' => $resultMessage,
            'categoryID' => $categoryID,
            'categoryName' => $categoryName,
            'categorySummary' => $categorySummary,
            'changeItemURL' => $changeItemURL
        );

        close_database_connection($connection);

        // render (draw) template
        // ------------
        $templateName = 'admin/addProduct';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Action for editing a product in the database
     *
     * Action for route: /adminEditProduct
     *
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editProductAction(Request $request, Application $app) {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if(!$isAuthenticated){
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $connection = open_database_connection();

        // Product and category variables
        $productID = $_GET['product_ID'];
        $productName = $_GET['product_name'];
        $productImageURL = $_GET['product_image_URL'];
        $productDescription = $_GET['product_description'];
        $productCalories = $_GET['product_calories'];
        $productAllergyInfo = $_GET['product_allergy_info'];
        $productPrice = $_GET['product_price'];

        $categoryID = $_GET['category_ID'];
        $categoryName = $_GET['category_name'];
        $categorySummary = $_GET['category_summary'];

        $resultMessage = "";
        $changeProductObject = new ChangeProduct();
        if(isset($_GET['submit'])) {

            $productImageURL1 = $_GET['productImageURL1'];
            $productImageURL2 = $_GET['productImageURL2'];

            $resultMessage = $changeProductObject->editProduct($connection, $productID, $productName, $productImageURL1, $productImageURL2, $productDescription, $productCalories, $productAllergyInfo, $productPrice);

            if($resultMessage == "Success!") {
                $categoryID = str_replace(" ", "+", $categoryID);
                $categoryName = str_replace(" ", "+", $categoryName);
                $categorySummary = str_replace(" ", "+", $categorySummary);
                return $app->redirect("/adminChangeProductSelectProduct?categoryID=" . $categoryID . "&categoryName=" . $categoryName . "&categorySummary=" . $categorySummary);
            } else {
                $productImageURL = $changeProductObject->getCorrectImage($productImageURL1, $productImageURL2);
            }
        }

        $changeItemURL = $_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'];
        // store username into args array
        $argsArray = array(
            'title' => "Admin Edit Product",
            'username' => $username,
            'productName' => $productName,
            'product_ID' => $productID,
            'productImageSelection' => $changeProductObject->getProductsForSelection($connection, "editProduct"),
            'productImageURL' => $productImageURL,
            'product_image_URL' => $productImageURL,
            'productDescription' => $productDescription,
            'productCalories' => $productCalories,
            'productAllergyInfo' => $productAllergyInfo,
            'productPrice' => $productPrice,
            'categoryID' => $categoryID,
            'categoryName' => $categoryName,
            'categorySummary' => $categorySummary,
            'resultMessage' => $resultMessage,
            'changeItemURL' => $changeItemURL
        );

        close_database_connection($connection);

        // render (draw) template
        // ------------
        $templateName = 'admin/editProduct';
        return $app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    /**
     * Action for deleting a product in the database.
     *
     * Action for route: /adminDeleteProduct
     *
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteProductAction(Request $request, Application $app)
    {
        // test if 'username' stored in session ...
        $username = getAuthenticatedUserName($app);

        // check we are authenticated --------
        $isAuthenticated = (null != $username);
        if(!$isAuthenticated){
            // not authenticated, so redirect to LOGIN page
            return $app->redirect('/login');
        }

        $connection = open_database_connection();

        $productID = $_GET['product_ID'];
        $categoryID = $_GET['category_ID'];
        $categoryName = $_GET['category_name'];
        $categorySummary = $_GET['category_summary'];

        $changeProductObject = new ChangeProduct();
        $resultMessage = $changeProductObject->deleteProduct($connection, $productID);

        close_database_connection($connection);
        $categoryName = str_replace(" ", "+", $categoryName);
        $categorySummary = str_replace(" ", "+", $categorySummary);
        if($resultMessage == "Success!") {
            return $app->redirect("/adminChangeProductSelectProduct?categoryID=".$categoryID."&categoryName=".$categoryName."&categorySummary=".$categorySummary);
        } else {
            return $app->redirect("/adminChangeProductSelectProduct?categoryID=".$categoryID."&categoryName=".$categoryName."&categorySummary=".$categorySummary."&resultMessage=".$resultMessage);
        }
    }
}