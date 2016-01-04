<?php

namespace KBK\Model\tests;

use KBK\Model\MenuCategoryRepository;
use KBK\Model\MenuCategory;

class MenuCategoryRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function testAddGetMenuCategory() {
        // Arrange
        $repository = new MenuCategoryRepository();
        $category = new MenuCategory(1);
        $expectedResult = $category;

        // Act
        $repository->addMenuCategory($category);
        $result = $repository->getOneMenuCategoryItem(1);

        // Assert
        $this->assertEquals($result, $expectedResult);
    }

    public function testGetAllMenuCategories() {
        // Arrange
        $repository = new MenuCategoryRepository();
        $category = new MenuCategory(1);
        $expectedResult = new MenuCategory(2);
        $expectedResult->setMenuCategoryTitle("Salads");
        $expectedResult->setMenuCategoryImage("salad.png");
        $expectedResult->setMenuCategorySummary("A healthy menu item that can be enjoyed in any season and has the benefit of low calories and a good source of energy. Our range of salads are carefully prepared from fresh leaves on the day it is served.");

        // Act
        $repository->getAllMenuCategories();
        $result = $repository->getOneMenuCategoryItem(2);

        // Assert
        $this->assertEquals($result, $expectedResult);
    }
}