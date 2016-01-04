<?php

namespace KBK\Model\tests;

use KBK\Model\MenuCategory;

/**
 * Class MenuCategoryTest
 * @package KBK\Model\tests
 */
class MenuCategoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetsMenuCategoryCode() {
        // Arrange
        $category = new MenuCategory(1);
        $expectedResult = 1;

        // Act
        $result = $category->getMenuCategoryCode();

        // Assert
        $this->assertEquals($result, $expectedResult);
    }

    public function testSetsGetsMenuCategoryTitle() {
        // Arrange
        $category = new MenuCategory(1);
        $category->setMenuCategoryTitle("Test Category");
        $expectedResult = "Test Category";

        // Act
        $result = $category->getMenuCategoryTitle();

        // Assert
        $this->assertEquals($result, $expectedResult);
    }

    public function testSetsGetsMenuCategoryImage() {
        // Assert
        $category = new MenuCategory(1);
        $category->setMenuCategoryImage("image.png");
        $expectedResult = "image.png";

        // Act
        $result = $category->getMenuCategoryImage();

        // Assert
        $this->assertEquals($result, $expectedResult);
    }

    public function testSetsGetsMenuCategorySummary() {
        // Assert
        $category = new MenuCategory(1);
        $category->setMenuCategorySummary("Test Summary");
        $expectedResult = "Test Summary";

        // Act
        $result = $category->getMenuCategorySummary();

        // Assert
        $this->assertEquals($result, $expectedResult);
    }

}