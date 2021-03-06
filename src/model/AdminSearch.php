<?php

/**
 * Class for making modifications to product categories in the
 * database
 */

namespace KBK\Model;

/**
 * Class AdminSearch
 * @package KBK\Model
 */
class AdminSearch
{

    /**
     * Function for making a category search
     *
     * @param $db - mysqli database connection
     * @param $search_string - string
     * @return null|string
     */
    public function makeCategorySearch($db, $search_string)
    {
        if(empty($search_string)) {
            $output = "Please enter a search query in the search box";
        } else {
            $output = NULL;
            $search_keywords = explode(" ", $search_string);

            $keyword_count = sizeof($search_keywords);
            for ($i = 0; $i < $keyword_count; $i++) {
                $search_query = "SELECT * FROM `categories` WHERE `CategoryName` LIKE '%" . $search_keywords[$i] . "%' OR `CategorySummary` LIKE '%" . $search_keywords[$i] . "%'";

                $resultSet = mysqli_query($db, $search_query);

                $output .= '<h3>Search results for ' . $search_keywords[$i] . '</h3>';

                if (mysqli_num_rows($resultSet) > 0) {
                    while ($rows = $resultSet->fetch_assoc()) {
                        $categoryID = $rows['CategoryID'];
                        $categoryName = $rows['CategoryName'];
                        $categoryImageURL = $rows['CategoryImage'];
                        $categorySummary = $rows['CategorySummary'];

                        $output .= '<form id="categoryResult' . $rows['CategoryID'] . '" action= "/adminEditCategory" method="get">
    ';
                        $output .= '<p><span class="search" onclick="document.getElementById(\'categoryResult' . $rows['CategoryID'] . '\').submit();">' . $categoryName . '</span> - ' . $categorySummary . '</p>';
                        $output .= '<input type="hidden" name="categoryID" value="' . $categoryID . '" />';
                        $output .= '<input type="hidden" name="categoryName" value="' . $categoryName . '" />';
                        $output .= '<input type="hidden" name="categoryImageURL" value="' . $categoryImageURL . '" />';
                        $output .= '<input type="hidden" name="categorySummary" value="' . $categorySummary . '" />';
                        $output .= '<input type="hidden" name="categoryImageURL1" value="" />';
                        $output .= '<input type="hidden" name="categoryImageURL2" value="' . $categoryImageURL . '" />';
                        $output .= '</form>';
                    }
                } else {
                    $output = "No results found";
                }
            }
        }
        return $output;
    }

    /**
     * Function to sort all categories based on name or description
     * in ascending or descending order
     *
     * @param $db
     * @param $sortBy
     * @param $order
     * @return null|string
     */
    public function sortCategory($db, $sortBy, $order)
    {
        $output = NULL;

        $search_query = "SELECT * FROM `categories` ORDER BY `".$sortBy."` ".$order;

        $resultSet = mysqli_query($db, $search_query);

        if (mysqli_num_rows($resultSet) > 0) {
            while ($rows = $resultSet->fetch_assoc()) {
                $categoryName = $rows['CategoryName'];
                $categoryID = $rows['CategoryID'];
                $categorySummary = $rows['CategorySummary'];
                $categoryImageURL = $rows['CategoryImage'];

                // for PHP Unit Testing
                if($categoryName != "PHP Unit Test Category") {
                    $output .= '<form id="category_result' . $categoryID . '" action= "/adminEditCategory" method="get">
    ';
                    $output .= '<p><span class="search" onclick="document.getElementById(\'category_result' . $categoryID . '\').submit();">' . $categoryName . '</span> - ' . $categorySummary . '</p>';
                    $output .= '<input type="hidden" name="categoryName" value="' . $categoryName . '" />';
                    $output .= '<input type="hidden" name="categoryID" value="' . $categoryID . '" />';
                    $output .= '<input type="hidden" name="categoryImageURL" value="' . $categoryImageURL . '" />';
                    $output .= '<input type="hidden" name="categorySummary" value="' . $categorySummary . '" />';
                    $output .= '<input type="hidden" name="categoryImageURL1" value="" />';
                    $output .= '<input type="hidden" name="categoryImageURL2" value="" />';
                    $output .= '</form>';
                    $output .= '<br>';
                }
            }
        }
        return $output;
    }

    /**
     * Function for sorting all categories based on a search and
     * based on name or description in ascending or descending order
     *
     * @param $db - mysqli database connection
     * @param $sortBy - string
     * @param $orderBy - string
     * @param $search_string - string
     * @return null|string
     */
    public function sortCategoryBySearch($db, $sortBy, $orderBy, $search_string) {
        $output = NULL;
        $search_keywords = explode(" ", $search_string);

        $keyword_count = sizeof($search_keywords);
        for($i = 0; $i < $keyword_count; $i++) {
            $search_query = "SELECT * FROM `categories` WHERE `CategoryName` LIKE '%".$search_keywords[$i]."%' OR `CategorySummary` LIKE '%".$search_keywords[$i]."%' ORDER BY ".$orderBy." ".$sortBy;

            $resultSet = mysqli_query($db, $search_query);

            $output .= '<h3>Search results for '.$search_keywords[$i].'</h3>';

            if (mysqli_num_rows($resultSet) > 0) {
                while ($rows = $resultSet->fetch_assoc()) {
                    $categoryID = $rows['CategoryID'];
                    $categoryName = $rows['CategoryName'];
                    $categoryImageURL = $rows['CategoryImage'];
                    $categorySummary = $rows['CategorySummary'];

                    $output .= '<form id="categoryResult'.$rows['CategoryID'].'" action= "/adminEditCategory" method="get">
    ';
                    $output .= '<p><span class="search" onclick="document.getElementById(\'categoryResult'.$rows['CategoryID'].'\').submit();">'.$categoryName.'</span> - '.$categorySummary.'</p>';
                    $output .= '<input type="hidden" name="categoryID" value="'.$categoryID.'" />';
                    $output .= '<input type="hidden" name="categoryName" value="'.$categoryName.'" />';
                    $output .= '<input type="hidden" name="categoryImageURL" value="'.$categoryImageURL.'" />';
                    $output .= '<input type="hidden" name="categorySummary" value="'.$categorySummary.'" />';
                    $output .= '<input type="hidden" name="categoryImageURL1" value="" />';
                    $output .= '<input type="hidden" name="categoryImageURL2" value="'.$categoryImageURL.'" />';
                    $output .= '</form>';
                }
            } else {
                $output = "No results found";
            }
        }
        return $output;
    }

    /**
     * Function for making a product search
     *
     * @param $db - mysqli database connection
     * @param $search_string - string
     * @return null|string
     */
    public function makeProductSearch($db, $search_string) {
        if(empty($search_string)) {
            $output = "Please enter a search query in the search box";
        } else {
            $output = NULL;
            $search_keywords = explode(" ", $search_string);

            $keyword_count = sizeof($search_keywords);
            for ($i = 0; $i < $keyword_count; $i++) {
                $search_query = "SELECT * FROM `products` WHERE `ProductName` LIKE '%" . $search_keywords[$i] . "%' OR `ProductDescription` LIKE '%" . $search_keywords[$i] . "%'";

                $resultSet = mysqli_query($db, $search_query);

                $output .= '<h3>Search results for ' . $search_keywords[$i] . '</h3>';

                if (mysqli_num_rows($resultSet) > 0) {
                    while ($rows = $resultSet->fetch_assoc()) {
                        $categoryID = $rows['CategoryID'];

                        $query = "SELECT * FROM `categories` WHERE CategoryID = " . $categoryID;
                        $result = mysqli_query($db, $query);
                        $row = $result->fetch_assoc();

                        $categoryName = $row['CategoryName'];
                        $categorySummary = $row['CategorySummary'];

                        $productID = $rows['ProductID'];
                        $productName = $rows['ProductName'];
                        $productImageURL = $rows['ProductImageURL'];
                        $productDescription = $rows['ProductDescription'];
                        $productCalories = $rows['ProductCalories'];
                        $productAllergyInfo = $rows['ProductAllergyInfo'];
                        $productPrice = sprintf("%01.2f", $rows['ProductPrice']);

                        $output .= '<form id="productResult' . $rows['ProductID'] . '" action= "/adminEditProduct" method="get">
    ';
                        $output .= '<p><span class="search" onclick="document.getElementById(\'productResult' . $rows['ProductID'] . '\').submit();">' . $productName . '</span> - ' . $productDescription . '</p>';
                        $output .= '<input type="hidden" name="product_ID" value="' . $productID . '" />';
                        $output .= '<input type="hidden" name="product_name" value="' . $productName . '" />';
                        $output .= '<input type="hidden" name="product_image_URL" value="' . $productImageURL . '" />';
                        $output .= '<input type="hidden" name="product_description" value="' . $productDescription . '" />';
                        $output .= '<input type="hidden" name="product_calories" value="' . $productCalories . '" />';
                        $output .= '<input type="hidden" name="product_allergy_info" value="' . $productAllergyInfo . '" />';
                        $output .= '<input type="hidden" name="product_price" value="' . $productPrice . '" />';

                        $output .= '<input type="hidden" name="category_ID" value="' . $categoryID . '" />';
                        $output .= '<input type="hidden" name="category_name" value="' . $categoryName . '" />';
                        $output .= '<input type="hidden" name="category_summary" value="' . $categorySummary . '" />';

                        $output .= '<input type="hidden" name="productImageURL1" value="" />';
                        $output .= '<input type="hidden" name="productImageURL2" value="' . $productImageURL . '" />';
                        $output .= '</form>';
                    }
                } else {
                    $output = "No results found";
                }
            }
        }
        return $output;
    }

    /**
     * Function for sorting all categories based on product name, description,
     * calories, etc. in ascending or descending order
     *
     * @param $db - mysqli database connection
     * @param $sortBy - string
     * @param $order - string
     * @return null|string
     */
    public function sortProduct($db, $sortBy, $order) {
        $output = NULL;

        $search_query = "SELECT * FROM `products` ORDER BY `".$sortBy."` ".$order;
        $resultSet = mysqli_query($db, $search_query);

        if (mysqli_num_rows($resultSet) > 0) {
            while ($rows = $resultSet->fetch_assoc()) {
                $categoryID = $rows['CategoryID'];

                $query = "SELECT * FROM `categories` WHERE CategoryID = ".$categoryID;
                $result = mysqli_query($db, $query);
                $row = $result->fetch_assoc();

                $categoryName = $row['CategoryName'];
                $categorySummary = $row['CategorySummary'];

                $productID = $rows['ProductID'];
                $productName = $rows['ProductName'];
                $productImageURL = $rows['ProductImageURL'];
                $productDescription = $rows['ProductDescription'];
                $productCalories = $rows['ProductCalories'];
                $productAllergyInfo = $rows['ProductAllergyInfo'];
                $productPrice = sprintf("%01.2f", $rows['ProductPrice']);

                $output .= '<form id="productResult'.$rows['ProductID'].'" action= "/adminEditProduct" method="get">
';
                $output .= '<p><span class="search" onclick="document.getElementById(\'productResult'.$rows['ProductID'].'\').submit();">'.$productName.'</span> - '.$productDescription.'</p>';
                $output .= '<p>Calories: '.$productCalories.'</p>';
                $output .= '<p>Price: '.$productPrice.'</p>';
                $output .= '<input type="hidden" name="product_ID" value="'.$productID.'" />';
                $output .= '<input type="hidden" name="product_name" value="'.$productName.'" />';
                $output .= '<input type="hidden" name="product_image_URL" value="'.$productImageURL.'" />';
                $output .= '<input type="hidden" name="product_description" value="'.$productDescription.'" />';
                $output .= '<input type="hidden" name="product_calories" value="'.$productCalories.'" />';
                $output .= '<input type="hidden" name="product_allergy_info" value="'.$productAllergyInfo.'" />';
                $output .= '<input type="hidden" name="product_price" value="'.$productPrice.'" />';

                $output .= '<input type="hidden" name="category_ID" value="'.$categoryID.'" />';
                $output .= '<input type="hidden" name="category_name" value="'.$categoryName.'" />';
                $output .= '<input type="hidden" name="category_summary" value="'.$categorySummary.'" />';

                $output .= '<input type="hidden" name="productImageURL1" value="" />';
                $output .= '<input type="hidden" name="productImageURL2" value="'.$productImageURL.'" />';
                $output .= '</form>';
            }
        } else {
            $output = "No results found";
        }
        return $output;
    }

    /**
     * Function for making product search sorted by product name,
     * description, calories, etc. in ascending or descending order
     *
     * @param $db - mysqli database connection
     * @param $sortBy - string
     * @param $orderBy - string
     * @param $search_string - string
     * @return null|string
     */
    public function sortProductBySearch($db, $sortBy, $orderBy, $search_string) {
        $output = NULL;
        $search_keywords = explode(" ", $search_string);

        $keyword_count = sizeof($search_keywords);
        for($i = 0; $i < $keyword_count; $i++) {
            $search_query = "SELECT * FROM `products` WHERE `ProductName` LIKE '%".$search_keywords[$i]."%' OR `ProductDescription` LIKE '%".$search_keywords[$i]."%' ORDER BY ".$orderBy." ".$sortBy;

            $resultSet = mysqli_query($db, $search_query);

            $output .= '<h3>Search results for '.$search_keywords[$i].'</h3>';

            if (mysqli_num_rows($resultSet) > 0) {
                while ($rows = $resultSet->fetch_assoc()) {
                    $categoryID = $rows['CategoryID'];

                    $query = "SELECT * FROM `categories` WHERE CategoryID = ".$categoryID;
                    $result = mysqli_query($db, $query);
                    $row = $result->fetch_assoc();

                    $categoryName = $row['CategoryName'];
                    $categorySummary = $row['CategorySummary'];

                    $productID = $rows['ProductID'];
                    $productName = $rows['ProductName'];
                    $productImageURL = $rows['ProductImageURL'];
                    $productDescription = $rows['ProductDescription'];
                    $productCalories = $rows['ProductCalories'];
                    $productAllergyInfo = $rows['ProductAllergyInfo'];
                    $productPrice = sprintf("%01.2f", $rows['ProductPrice']);

                    $output .= '<form id="productResult'.$rows['ProductID'].'" action= "/adminEditProduct" method="get">
    ';
                    $output .= '<p><span class="search" onclick="document.getElementById(\'productResult'.$rows['ProductID'].'\').submit();">'.$productName.'</span> - '.$productDescription.'</p>';
                    $output .= '<p>Calories: '.$productCalories.'</p>';
                    $output .= '<p>Price: '.$productPrice.'</p>';
                    $output .= '<input type="hidden" name="product_ID" value="'.$productID.'" />';
                    $output .= '<input type="hidden" name="product_name" value="'.$productName.'" />';
                    $output .= '<input type="hidden" name="product_image_URL" value="'.$productImageURL.'" />';
                    $output .= '<input type="hidden" name="product_description" value="'.$productDescription.'" />';
                    $output .= '<input type="hidden" name="product_calories" value="'.$productCalories.'" />';
                    $output .= '<input type="hidden" name="product_allergy_info" value="'.$productAllergyInfo.'" />';
                    $output .= '<input type="hidden" name="product_price" value="'.$productPrice.'" />';

                    $output .= '<input type="hidden" name="category_ID" value="'.$categoryID.'" />';
                    $output .= '<input type="hidden" name="category_name" value="'.$categoryName.'" />';
                    $output .= '<input type="hidden" name="category_summary" value="'.$categorySummary.'" />';

                    $output .= '<input type="hidden" name="productImageURL1" value="" />';
                    $output .= '<input type="hidden" name="productImageURL2" value="'.$productImageURL.'" />';
                    $output .= '</form>';
                }
            } else {
                $output = "No results found";
            }
        }
        return $output;
    }
}