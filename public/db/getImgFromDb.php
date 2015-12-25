<?php

namespace KBK\Model;
/**
 * This php file will be responsible for getting data from the database
 * and creating a json object for the randomImage.js script to get
 * so it can use the image urls to display random images
 *
 * The JSON object structure of the object we're making is this:
 * {
 *      0:      < the amount of categories found from the database >
 *      1: {    < all data for products with CategoryID 1 >
 *          0:  < the amount of products found from this category >
 *          1:  < the image url to the first product from this category >
 *          2:  < the image url to the second product from this category >
 *          etc...
 *      }
 *      2: {    < all data for products with CategoryID 2 >
 *          0:  < the amount of products found from this category >
 *          1:  < the image url to the first product from this category >
 *          etc...
 *      }
 *      etc...
 * }
 * see "json object example.jpg" in public/screenshots for a clear example
 *
 * It is a function because it needs to be used in MenuCategoryRepository.php as well
 */

/**
 * Class getImgFromDb
 */
class getImgFromDb
{
    public function getImageUrlArray()
    {
        // make a new connection to the database
        $db = mysqli_connect('localhost', 'fred', 'smith', 'kbk');
        // make a new query for the CategoryID and ProductImageURL from all rows from `products`
        $query = "SELECT CategoryID, ProductImageURL FROM `products`";

        // get the results from the query
        $results = mysqli_query($db, $query);

        // declare imageData to be an empty array
        // this variable will hold all the data in php array format before we json_encode() it
        $imageData = array();

        // declaring and defining a variable to represent which category(the CategoryID)
        // we're processing in the loop below
        $categoryToProcess = 0;
        // declaring and defining a variable to represent which index in its respective
        // category array in imageData we're processing
        $categoryIndexToProcess = 0;

        // check to make sure there are results from the mysql query we made earlier
        if (mysqli_num_rows($results) > 0) {
            // as long as we can retrieve another row from the database, add the row's ProductImageURL to imageData
            while ($rows = $results->fetch_assoc()) {
                // set the category we're processing to be the CategoryID of the row we retrieved
                $categoryToProcess = $rows['CategoryID'];

                if (array_key_exists($categoryToProcess, $imageData)) {
                    // If an array key exists in the object for the category we're processing,
                    // then there is an array dedicated to storing data for that category, so
                    // insert the image url in the category's array, in the next index
                    $imageData[$categoryToProcess][$categoryIndexToProcess] = "/images/" . $rows['ProductImageURL'];
                } else {
                    // If there isn't an array key for the category we're processing,
                    // then there isn't an array for this category, so create a new array,
                    $imageData[$categoryToProcess] = array();
                    // reset the index of the item we're processing to 1,
                    $categoryIndexToProcess = 1;
                    // and insert the image's url into that index
                    $imageData[$categoryToProcess][$categoryIndexToProcess] = "/images/" . $rows['ProductImageURL'];
                }
                // update the amount of items in the array of the category we're processing
                // to be the last index we processed
                $imageData[$categoryToProcess][0] = $categoryIndexToProcess;
                // update the amount of categories in the object to be the category we're processing
                // for the same reason as above
                $imageData[0] = $rows['CategoryID'];
                // process the next index
                $categoryIndexToProcess++;
            }
        }
        // close the database connection
        mysqli_close($db);

        // return the imageData
        return $imageData;
    }
}

$myGetImageObject = new getImgFromDb();
// get the image data for the js script
$randomImageData = $myGetImageObject->getImageUrlArray();
// encode imageData to be in JSON format
$jsonImageData = json_encode($randomImageData);
// echo the jsonImageData so randomImage.js can find it
echo $jsonImageData;