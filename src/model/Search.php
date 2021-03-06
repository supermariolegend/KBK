<?php

/**
 * Class for handling all searches on the pages where the user
 * isn't logged in, sorted and not sorted.
 */

namespace KBK\Model;

/**
 * Class Search
 * @package KBK\Model
 */
class Search
{
    /**
     * Function for making a simple search based only
     * on a text query. Outputs formatted html to be put
     * into a twig template.
     *
     * @param $db
     * @param $search_string
     * @return null|string
     */
    public function makeSearch($db, $search_string)
    {
        if(empty($search_string)) {
            $output = "Please enter a search query in the search box";
        } else {
            $output = NULL;
            $search_keywords = explode(" ", $search_string);

            $keyword_count = sizeof($search_keywords);
            for($i = 0; $i < $keyword_count; $i++) {
                $search_query = "SELECT * FROM products WHERE ProductName LIKE '%".$search_keywords[$i]."%' or ProductDescription LIKE '%".$search_keywords[$i]."%'";

                $resultSet = mysqli_query($db, $search_query);

                $output .= "<h3>Search results for ".$search_keywords[$i]."</h3>";

                if (mysqli_num_rows($resultSet) > 0) {
                    while ($rows = $resultSet->fetch_assoc()) {
                        $product_name = $rows['ProductName'];
                        $product_description = $rows['ProductDescription'];

                        $output .= '<form id="product_result' . $rows['ProductID'] . '" action= "/product" method="get">
        ';
                        $output .= '<p><span class="search" onclick="document.getElementById(\'product_result' . $rows['ProductID'] . '\').submit();">' . $product_name . '</span> - ' . $product_description . '</p>';
                        $output .= '<input type="hidden" name="product_name" value="' . $product_name . '" ></input>';
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
     * Function for showing all products sorted in ascending order
     * based on either ProductName, or ProductCalories
     *
     * @param $db
     * @param $orderBy
     * @return null|string
     */
    public function showAscending($db, $orderBy)
    {
        if (isset($_GET['submit'])) {
            $output = NULL;
            $search_query = "SELECT * FROM products ORDER BY ".$orderBy." ASC";

            $resultSet = mysqli_query($db, $search_query);

            if (mysqli_num_rows($resultSet) > 0) {
                while ($rows = $resultSet->fetch_assoc()) {
                    $product_name = $rows['ProductName'];
                    $product_description = $rows['ProductDescription'];

                    $output .= '<form id="product_result' . $rows['ProductID'] . '" action= "/product" method="get">
    ';
                    $output .= '<p><span class="search" onclick="document.getElementById(\'product_result' . $rows['ProductID'] . '\').submit();">' . $product_name . '</span> - ' . $product_description . '</p>';
                    $output .= '<input type="hidden" name="product_name" value="' . $product_name . '" ></input>';
                    $output .= '</form>';
                }
            } else {
                $output = "No results found";
            }
            return $output;
        }
    }

    /**
     * Function for showing all products sorted in ascending order based
     * on one or more keywords
     *
     * @param $db
     * @param $search_string
     * @param $orderBy
     * @return null|string
     */
    public function showAscendingBySearch($db, $search_string, $orderBy) {
        $output = NULL;
        $search_keywords = explode(" ", $search_string);

        $keyword_count = sizeof($search_keywords);
        for($i = 0; $i < $keyword_count; $i++) {
            $search_query = "SELECT * FROM products WHERE ProductName LIKE '%".$search_keywords[$i]."%' or ProductDescription LIKE '%".$search_keywords[$i]."%' ORDER BY ".$orderBy." ASC";

            $resultSet = mysqli_query($db, $search_query);

            $output .= "<h3>Search results for ".$search_keywords[$i]."</h3>";

            if (mysqli_num_rows($resultSet) > 0) {
                while ($rows = $resultSet->fetch_assoc()) {
                    $product_name = $rows['ProductName'];
                    $product_description = $rows['ProductDescription'];
                    $product_calories = $rows['ProductCalories'];

                    $output .= '<form id="product_result' . $rows['ProductID'] . '" action= "/product" method="get">
    ';
                    $output .= '<p><span class="search" onclick="document.getElementById(\'product_result' . $rows['ProductID'] . '\').submit();">' . $product_name . '</span> - ' . $product_description . '</p>';
                    $output .= '<p>Calories: '.$product_calories.'</p>';
                    $output .= '<input type="hidden" name="product_name" value="' . $product_name . '" ></input>';
                    $output .= '</form>';
                }
            } else {
                $output = "No results found";
            }
        }
        return $output;
    }

    /**
     * Function for showing all products sorted in descending order based on
     * ProductName or ProductCalories
     *
     * @param $db
     * @param $orderBy
     * @return null|string
     */
    public function showDescending($db, $orderBy) {
        $output = NULL;

        $search_query = "SELECT * FROM products ORDER BY ".$orderBy." DESC";

        $resultSet = mysqli_query($db, $search_query);

        if(mysqli_num_rows($resultSet) > 0) {
            while($rows = $resultSet->fetch_assoc()) {
                $product_name = $rows['ProductName'];
                $product_description = $rows['ProductDescription'];
                $product_calories = $rows['ProductCalories'];

                $output .= '<form id="product_result'.$rows['ProductID'].'" action= "/product" method="get">
    ';
                $output .= '<p><span class="search" onclick="document.getElementById(\'product_result'.$rows['ProductID'].'\').submit();">'.$product_name.'</span> - '.$product_description.'</p>';
                $output .= '<p>Calories: '.$product_calories.'</p>';
                $output .= '<input type="hidden" name="product_name" value="'.$product_name.'" ></input>';
                $output .= '</form>';
                $output .= '<br>';
            }
        }
        return $output;
    }

    /**
     * Function for showing all products sorted in descending order based on
     * either ProductName or ProductCalories and one or more keywords
     *
     * @param $db
     * @param $search_string
     * @param $orderBy
     * @return null|string
     */
    public function showDescendingBySearch($db, $search_string, $orderBy) {
        $output = NULL;
        $search_keywords = explode(" ", $search_string);

        $keyword_count = sizeof($search_keywords);
        for($i = 0; $i < $keyword_count; $i++) {
            $search_query = "SELECT * FROM products WHERE ProductName LIKE '%".$search_keywords[$i]."%' or ProductDescription LIKE '%".$search_keywords[$i]."%' ORDER BY ".$orderBy." DESC";

            $resultSet = mysqli_query($db, $search_query);

            $output .= "<h3>Search results for ".$search_keywords[$i]."</h3>";

            if (mysqli_num_rows($resultSet) > 0) {
                while ($rows = $resultSet->fetch_assoc()) {
                    $product_name = $rows['ProductName'];
                    $product_description = $rows['ProductDescription'];
                    $product_calories = $rows['ProductCalories'];

                    $output .= '<form id="product_result' . $rows['ProductID'] . '" action= "/product" method="get">
    ';
                    $output .= '<p><span class="search" onclick="document.getElementById(\'product_result' . $rows['ProductID'] . '\').submit();">' . $product_name . '</span> - ' . $product_description . '</p>';
                    $output .= '<p>Calories: '.$product_calories.'</p>';
                    $output .= '<input type="hidden" name="product_name" value="' . $product_name . '" ></input>';
                    $output .= '</form>';
                }
            } else {
                $output = "No results found";
            }
        }
        return $output;
    }
}