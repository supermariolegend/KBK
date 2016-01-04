<?php

namespace KBK\Model\tests;

use KBK\JS\getImgFromDb;

require_once __DIR__ . '/../src/utility/helperFunctions.php';

/**
 * Class getImgDataFromDbTest
 * @package KBK\Model\tests
 */
class getImgDataFromDbTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test for getting image data for the js scripts changing images
     * NOTE: By changing the the any products in the database, this test
     *      will no longer work unless $expectedResult is changed based on
     *      getImageDataFromDb::getImageURLArray's new output (which can
     *      be found by opening the developer tools in google chrome (F12),
     *      and going to any page with changing images (homepage or menu). Then,
     *      go to Sources->/js and open randomImage.js or homepageRandomImage.js.
     *      Add a breakpoint anywhere in the for loop and on the "watches" window
     *      on the right side of the page, click the "+" button to add a new
     *      expression and enter "imageData" to see all the image data that
     *      getImageDataFromDb returns)
     */
    public function testGetImageURLArray() {
        // Arrange
        $getImgFromDb = new getImgFromDb();
        $expectedResult = array(
            0 => 5,
            1 => array(
                0 => 5,
                1 => "/images/backyard_burger.png",
                2 => "/images/red_robin_burger.png",
                3 => "/images/jimmy_john_sandwich.png",
                4 => "/images/vegetarian_burger.png",
                5 => "/images/kbk_house_burger.png"
            ),
            2 => array(
                0 => 5,
                1 => "/images/goat_cheese_salad.png",
                2 => "/images/veggie_delight_salad.png",
                3 => "/images/salad.png",
                4 => "/images/queen_salad.png",
                5 => "/images/garden_salad.png"
            ),
            3 => array(
                0 => 6,
                1 => "/images/mineral_water.png",
                2 => "/images/cappuccino.png",
                3 => "/images/tomato_juice.png",
                4 => "/images/black_tea.png",
                5 => "/images/orange_juice.png",
                6 => "/images/lemon_tea.png"
            ),
            4 => array(
                0 => 5,
                1 => "/images/chocolate_pudding.png",
                2 => "/images/strawberry_cheesecake.png",
                3 => "/images/dessert.png",
                4 => "/images/donuts.png",
                5 => "/images/chocolate_cheesecake.png"
            ),
            5 => array(
                0 => 5,
                1 => "/images/tzatziki.png",
                2 => "/images/chips.png",
                3 => "/images/cranberry_sauce.png",
                4 => "/images/fried_green_tomatoes.png",
                5 => "/images/alfalfa_sprouts.png"
            )
        );

        // Act
        $result = $getImgFromDb->getImageUrlArray();

        // Assert
        $this->assertEquals($result, $expectedResult);
    }
}