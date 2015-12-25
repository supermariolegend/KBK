<?php

namespace KBK\Model;


class ItemsInCategory
{
    public function getProductHTML($db, $categoryID) {
        $output = NULL;

        $query = "SELECT * FROM `products` WHERE CategoryID = ".$categoryID;
        $results = mysqli_query($db, $query);

        if(mysqli_num_rows($results) > 0) {
            while($rows = $results->fetch_assoc()) {
                $product_name = $rows['ProductName'];
                $product_image_url = $rows['ProductImageURL'];

                $output .= '<tr>';
                $output .= '    <form action="/product" id="product_result'.$rows['ProductID'].'" method="get">';
                $output .= '        <th>';
                $output .= '            <img src="/images/'.$product_image_url.'" alt="'.$product_name.' width="300" height="221">';
                $output .= '        </th>';

                $output .= '        <td>';
                $output .= '            <p><span class="search" onclick="document.getElementById(\'product_result'.$rows['ProductID'].'\').submit();">'.$product_name.'</span></p>';
                $output .= '            <input type="hidden" name="product_name" value="'.$product_name.'" ></input>';
                $output .= '        </td>';
                $output .= '    </form>';
                $output .= '</tr>';
            }
            return $output;
        }
    }
}