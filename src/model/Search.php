<?php

namespace KBK\Model;

class Search
{
    /**
     * @param $db
     * @param $search_keyword
     * @return null|string
     */
    public function makeSearch($db, $search_keyword)
    {
        $output = NULL;

        if (isset($_GET['submit'])) {

            $search_query = "SELECT * FROM products WHERE ProductName LIKE '%$search_keyword%' or ProductDescription LIKE '%$search_keyword%'";

            $resultSet = mysqli_query($db, $search_query);

            if(mysqli_num_rows($resultSet) > 0) {
                while($rows = $resultSet->fetch_assoc()) {
                    $product_name = $rows['ProductName'];
                    $product_description = $rows['ProductDescription'];

                    $output .= '<form id="product_result'.$rows['ProductID'].'" action= "/product" method="get">
        ';
                    $output .= '<span class="search" onclick="document.getElementById(\'product_result'.$rows['ProductID'].'\').submit();">'.$product_name.'</span> - '.$product_description.'</p>';
                    $output .= '<input type="hidden" name="product_name" value="'.$product_name.'" ></input>';
                    $output .= '</form>';
                }
            } else {
                $output = "No results found";
            }

            return $output;
        }
    }
}