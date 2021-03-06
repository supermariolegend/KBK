<?php

/**
 * Class containing all functions needed for manipulating
 * categories in the database
 */

namespace KBK\Model;

/**
 * Class ChangeCategory
 * @package KBK\Model
 */
class ChangeCategory
{
    /**
     * Function for getting all the product images that are used by
     * products in the database and putting them in a dropdown menu
     * to be used in addCategory and editCategory.
     *
     * @param $db - mysqli database connection
     * @param $form - string
     * @return null|string
     */
    public function getCategoriesForSelection($db, $form) {
        $output = NULL;
        $query = "SELECT * FROM `products`";
        $results = mysqli_query($db, $query);

        $output .= '<select name="categoryImageURL1" form="'.$form.'">';
        $output .= '<option value="0">Select an existing image</option>';
        if (mysqli_num_rows($results) > 0) {
            while ($rows = $results->fetch_assoc()) {
                $output .= '<option value="'.$rows['ProductImageURL'].'">'.$rows['ProductImageURL'].'</option>';
            }
        }

        $output .= "</select>";

        return $output;
    }

    /**
     * Function used to get hidden inputs containing information about
     * whether a category has products in it or not. This data is used
     * by changeCategory.js to alert the user if a category has products
     * in it so that a user doesn't delete a category if it has products
     * in it.
     *
     * @param $db - mysqli database connection
     * @return string
     */
    public function getCategoriesWithProducts($db) {
        $query = "SELECT DISTINCT `CategoryID` FROM `products`";
        $results = mysqli_query($db, $query);

        $output = "";
        if (mysqli_num_rows($results) > 0) {
            while ($rows = $results->fetch_assoc()) {
                $output .= '<input type="hidden" id="productCat'.$rows['CategoryID'].'" value="1" />
        ';
            }
        }
        return $output;
    }

    /**
     * Function for adding a category to the database
     *
     * @param $db - mysqli database connection
     * @param $categoryName - string
     * @param $categoryImageURL1 - string
     * @param $categoryImageURL2 - string
     * @param $categorySummary - string
     * @return string
     */
    public function addCategory($db, $categoryName, $categoryImageURL1, $categoryImageURL2, $categorySummary) {
        $categoryImageURL = "missing_image.png";
        if (!empty($categoryImageURL1)) {
            $categoryImageURL = $categoryImageURL1;
        }
        if (!empty($categoryImageURL2)) {
            $categoryImageURL = $categoryImageURL2;
        }

        $query = "SELECT CategoryID FROM `categories`";
        $results = mysqli_query($db, $query);

        $categoryID = 0;
        $previousID = 0;
        $foundInnerID = false;
        if (mysqli_num_rows($results) > 0) {
            while ($rows = $results->fetch_assoc()) {
                $categoryID = $rows['CategoryID'];
                if($categoryID != ($previousID + 1)) {
                    $foundInnerID = true;
                    $categoryID = ($previousID + 1);
                    break;
                }
                $previousID = $categoryID;
            }
        }
        if($foundInnerID == false) {
            $categoryID++;
        }

        $query = "INSERT INTO `categories` VALUES (".$categoryID.", '".$categoryName."', '".$categoryImageURL."', '".$categorySummary."')";
        mysqli_query($db, $query);

        if (mysqli_errno($db)) {
            return mysqli_error($db);
        } else {
            return "Success!";
        }
    }

    /**
     * Function for editing a category in the database
     *
     * @param $db - mysqli database connection
     * @param $categoryID - integer
     * @param $categoryName - string
     * @param $categoryImageURL1 - string
     * @param $categoryImageURL2 - string
     * @param $categorySummary - string
     * @return string
     */
    public function editCategory($db, $categoryID, $categoryName, $categoryImageURL1, $categoryImageURL2, $categorySummary) {
        if(isset($_GET['submit'])) {
            $categoryImageURL = "missing_image.png";
            if (!empty($categoryImageURL1)) {
                $categoryImageURL = $categoryImageURL1;
            }
            if (!empty($categoryImageURL2)) {
                $categoryImageURL = $categoryImageURL2;
            }

            $query = "UPDATE `categories` SET `CategoryName` = '".$categoryName."', `CategoryImage` = '".$categoryImageURL."', `CategorySummary` = '".$categorySummary."' WHERE `CategoryID` = ".$categoryID;

            mysqli_query($db, $query);
            if (mysqli_errno($db)) {
                return mysqli_error($db);
            } else {
                return "Success!";
            }
        }
    }

    /**
     * Function for deleting a category
     *
     * @param $db - mysqli database connection
     * @param $categoryID - integer
     * @return string
     */
    public function deleteCategory($db, $categoryID) {
        // for PHP Unit Testing
        if($categoryID == "PHP Unit Test Category") {
            $query = "DELETE FROM `categories` WHERE CategoryName = 'PHP Unit Test Category'";
        } else {
            $query = "DELETE FROM `categories` WHERE `CategoryID` = " . $categoryID;
        }

        mysqli_query($db, $query);
        if (mysqli_errno($db)) {
            return mysqli_error($db);
        } else {
            return "Success!";
        }
    }
}