<?php

/**
 * Class for storing all the menu categories in a single
 * object. It provides a function which can easily extract
 * all categories from the database
 */

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
     *
     * @var array
     */
    private $categories;


    /**
     * constructor for any new object
     */

    function __construct()
    {
        $this->getAllMenuCategories();
    }

    /**
     * add the given menu item category to the repository
     * please note that this is a public method to be used
     * by the constructor and in testing
     *
     * @param MenuCategory $category
     */
    public function addMenuCategory(MenuCategory $category)
    {
        // obtain ID from the menu category object
        $id = $category->getMenuCategoryCode();

        //add menu category object to the array, with index of the ID
        $this->categories[$id] = $category;
    }

    /**
     * return an array containing all menu categories after connecting to the database
     *
     * @return array
     */
    public function getAllMenuCategories()
    {
        $connection = open_database_connection();
        $query = "SELECT * FROM `categories`";
        $results = mysqli_query($connection, $query);
        $this->categories = array();

        if (mysqli_num_rows($results) > 0) {
            while ($rows = $results->fetch_assoc()) {
                $this->categories[$rows['CategoryID']] = new MenuCategory($rows['CategoryID']);
                $this->categories[$rows['CategoryID']]->setMenuCategoryTitle($rows['CategoryName']);
                $this->categories[$rows['CategoryID']]->setMenuCategoryImage($rows['CategoryImage']);
                $this->categories[$rows['CategoryID']]->setMenuCategorySummary($rows['CategorySummary']);
                $this->addMenuCategory($this->categories[$rows['CategoryID']]);
            }
        }

        close_database_connection($connection);
        return $this->categories;
    }

    /**
     * this is a method that will try to retrieve one menu category item
     * for a given id = $id
     *
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