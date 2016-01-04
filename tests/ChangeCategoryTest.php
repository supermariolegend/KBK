<?php

namespace KBK\Model\tests;

require_once __DIR__ . '/../src/utility/helperFunctions.php';

use KBK\Model\ChangeCategory;

class ChangeCategoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test for getting the select input for all the images that are used from all products
     * NOTE: By adding a product in the database, this test will no longer work
     *      unless $expectedResult is changed based on
     *      ChangeCategory::getCategoriesForSelection's new output
     */
    public function testGetCategoriesForSelection() {
        // Arrange
        $changeCategory = new ChangeCategory();
        $connection = open_database_connection();
        $expectedResult = '<select name="categoryImageURL1" form="editCategory"><option value="0">Select an existing image</option><option value="backyard_burger.png">backyard_burger.png</option><option value="red_robin_burger.png">red_robin_burger.png</option><option value="jimmy_john_sandwich.png">jimmy_john_sandwich.png</option><option value="vegetarian_burger.png">vegetarian_burger.png</option><option value="garden_salad.png">garden_salad.png</option><option value="queen_salad.png">queen_salad.png</option><option value="salad.png">salad.png</option><option value="veggie_delight_salad.png">veggie_delight_salad.png</option><option value="orange_juice.png">orange_juice.png</option><option value="lemon_tea.png">lemon_tea.png</option><option value="black_tea.png">black_tea.png</option><option value="tomato_juice.png">tomato_juice.png</option><option value="cappuccino.png">cappuccino.png</option><option value="mineral_water.png">mineral_water.png</option><option value="chocolate_cheesecake.png">chocolate_cheesecake.png</option><option value="donuts.png">donuts.png</option><option value="dessert.png">dessert.png</option><option value="strawberry_cheesecake.png">strawberry_cheesecake.png</option><option value="tzatziki.png">tzatziki.png</option><option value="alfalfa_sprouts.png">alfalfa_sprouts.png</option><option value="chips.png">chips.png</option><option value="cranberry_sauce.png">cranberry_sauce.png</option><option value="fried_green_tomatoes.png">fried_green_tomatoes.png</option><option value="kbk_house_burger.png">kbk_house_burger.png</option><option value="goat_cheese_salad.png">goat_cheese_salad.png</option><option value="chocolate_pudding.png">chocolate_pudding.png</option></select>';

        // Act
        $result = $changeCategory->getCategoriesForSelection($connection, "editCategory");

        // Assert
        $this->assertEquals($result, $expectedResult);
    }

    /**
     * test for getting the select input for all the images that are used from all products
     * NOTE: By adding or removing a category in the database, this test will no longer work
     *      unless $expectedResult is changed based on ChangeCategory::getCategoriesWithProducts's
     *      new output
     */
    public function testGetCategoriesWithProducts() {
        // Arrange
        $changeCategory = new ChangeCategory();
        $connection = open_database_connection();
        $expectedResult = '<input type="hidden" id="productCat1" value="1" />
        <input type="hidden" id="productCat2" value="1" />
        <input type="hidden" id="productCat3" value="1" />
        <input type="hidden" id="productCat4" value="1" />
        <input type="hidden" id="productCat5" value="1" />
        ';

        // Act
        $result = $changeCategory->getCategoriesWithProducts($connection);

        // Assert
        $this->assertEquals($result, $expectedResult);
    }

    /**
     * test for getting the adding a category to the database
     */
    public function testAddCategory() {
        // Arrange
        $changeCategory = new ChangeCategory();
        $connection = open_database_connection();
        $expectedResult = "Success!";

        // Act
        $result = $changeCategory->addCategory($connection, "PHP Unit Test Category", "", "", "PHP Unit Test Summary");

        // Assert
        if($result == "Success!") {
            $changeCategory->deleteCategory($connection, "PHP Unit Test Category");
        }
        $this->assertEquals($result, $expectedResult);
    }

    public function testDeleteCategory() {
        // Arrange
        $changeCategory = new ChangeCategory();
        $connection = open_database_connection();
        $expectedResult = $changeCategory->addCategory($connection, "PHP Unit Test Category", "", "", "PHP Unit Test Summary");

        // Act
        $result = $changeCategory->deleteCategory($connection, "PHP Unit Test Category");

        // Assert
        $this->assertEquals($result, $expectedResult);
    }
}