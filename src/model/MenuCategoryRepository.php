<?php
// see documentation folder for generated API doc for this class


namespace KBK\Model;


/**
 * Class MenuCategoryRepository
 * class for storing and serving menu categories objects
 * @package KBK\Model
 */
class MenuCategoryRepository
{
    /**
     * an associative array containing menu categories items objects which
     * are indexed by the unique PK field 'menuCategoryCode'
     * @var array
     */
    private $categories;


    /**
     * create a new MenuCategoryRepository object and
     * initialize it with a number of menu category products
     */
    function __construct()
    {
        $mc1 = new MenuCategory(1);
        $mc1->setMenuCategoryTitle('Vegetarian Burgers');
        $mc1->setMenuCategoryImage('vegetarian_burger.png');
        $this->addMenuCategory($mc1);

        $mc2 = new MenuCategory(2);
        $mc2->setMenuCategoryTitle('Salads');
        $mc2->setMenuCategoryImage('salad.jpg');
        $this->addMenuCategory($mc2);

        $mc3 = new MenuCategory(3);
        $mc3->setMenuCategoryTitle('Drinks');
        $mc3->setMenuCategoryImage('black_tea.png');
        $this->addMenuCategory($mc3);

        $mc4 = new MenuCategory(4);
        $mc4->setMenuCategoryTitle('Desserts');
        $mc4->setMenuCategoryImage('dessert.jpg');
        $this->addMenuCategory($mc4);

    }

    /**
     * add the given menu item category to the repository
     * please note that this is a private method to be used only by the constructor
     * @param MenuCategory $category
     */
    private function addMenuCategory(MenuCategory $category)
    {
        // obtain ID from the menu category object
        $id = $category->getMenuCategoryCode();

        //add menu category object to the array, with index of the ID
        $this->categories[$id] = $category;
    }

    /**
     * return an array containing all menu categories
     * @return array
     */
    public function getAllMenuCategories()
    {
        return $this->categories;
    }

    /**
     * this is a method that will try to retrieve one menu category item
     * for a given id = $id
     * @param int $id
     * @return menu category item (if one found)
     * @return null (if not found)
     */
    public function getOneMenuCategoryItem($id)
    {
        if(array_key_exists($id, $this->categories)){
            return $this->categories[$id];
        } else {
            return null;
        }
    }
}