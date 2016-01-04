-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jan 04, 2016 at 12:10 PM
-- Server version: 10.0.20-MariaDB
-- PHP Version: 5.6.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kbk`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `CategoryID` int(8) NOT NULL,
  `CategoryName` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `CategoryImage` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `CategorySummary` varchar(256) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`CategoryID`, `CategoryName`, `CategoryImage`, `CategorySummary`) VALUES
(1, 'Vegetarian Burgers', 'vegetarian_burger.png', 'Freshly made selection of vegetarian burgers and sandwiches using the finest ingredients available today. Try one and you will want more!'),
(2, 'Salads', 'salad.png', 'A healthy menu item that can be enjoyed in any season and has the benefit of low calories and a good source of energy. Our range of salads are carefully prepared from fresh leaves on the day it is served.'),
(3, 'Drinks', 'orange_juice.png', 'Quench your thirst with our selection of freshly made drinks or warm yourself up with a selection of hot drinks that we offer!'),
(4, 'Desserts', 'donuts.png', 'From a range of fresh donuts to a mouth watering pumpkin pie or strawberry cheesecake, there is something for everyone!'),
(5, 'Extra Burger Toppings', 'extra_toppings.png', 'Try and add a little extra to your burger by adding one of these extra toppings meant to add a special touch to your meal. You will be glad and always come back to it or try a different one next time!');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `ProductID` int(24) NOT NULL,
  `CategoryID` int(2) NOT NULL COMMENT 'linked to CategoryID in categories table',
  `ProductName` varchar(222) COLLATE utf8_unicode_ci NOT NULL,
  `ProductImageURL` varchar(222) COLLATE utf8_unicode_ci NOT NULL,
  `ProductDescription` varchar(380) COLLATE utf8_unicode_ci NOT NULL,
  `ProductCalories` int(4) NOT NULL,
  `ProductAllergyInfo` varchar(222) COLLATE utf8_unicode_ci NOT NULL,
  `ProductPrice` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductID`, `CategoryID`, `ProductName`, `ProductImageURL`, `ProductDescription`, `ProductCalories`, `ProductAllergyInfo`, `ProductPrice`) VALUES
(1, 1, 'Backyard Burger', 'backyard_burger.png', 'A delicious vegetable burger made with wholemeal flour buns, ring sliced red onion, organic tomato slices, cheddar cheese, pickles, ketchup and crisp salad.', 435, 'This product might contain nuts', 7.95),
(2, 1, 'Red Robin Vegetarian Burger', 'red_robin_burger.png', 'The Red Robin Vegetarian burger is topped with lettuce, pickles, tomatoes and our Country Dijon sauce on a lovely whole-grain bun!', 795, 'May contain traces of nuts', 7.95),
(3, 1, 'Jimmy John Sandwich', 'jimmy_john_sandwich.png', 'This delicious vegetarian sandwich is made from layers of provolone cheese separated by real avocado spread, tomato and mayonnaise, sliced cucumber and lettuce.', 784, 'Sandwich bread may contain traces of nuts', 6.85),
(4, 1, 'Vegetarian Burger', 'vegetarian_burger.png', 'Our home made vegetarian burger is made with organic fresh vegetables including freshly cut lettuce, white onions, succulent tomatoes, pickles mayonnaise and ketchup served on a toasted sesame seed bun.', 640, 'Buns may contain traces of nuts', 8.95),
(5, 2, 'Garden Salad', 'garden_salad.png', 'Our house garden salad is a mixture of specially selected lettuces blending in harmony with juicy tomatoes, three-style-cheese, crispy croutons and our KBK salad dressing.', 220, 'No allergens present', 4.95),
(6, 2, 'Queen Salad', 'queen_salad.png', 'Our KBK Queen salad is made of carefully chopped lettuce, mixed with tiny tomatoes, leafy greens, spinach,cheddar cheese, finely sliced red cabbage, avocado and dressed with apple cider vinegar.', 280, 'No allergens present', 4.65),
(7, 2, 'Traditional Salad', 'salad.png', 'Our traditional KBK salad is made of mixed green and red leaves, cherry tomatoes, spinach, avocado and dressed with our premium vinaigrette dressing.', 230, 'No allergens present', 4.45),
(8, 2, 'Veggie Delight Salad', 'veggie_delight_salad.png', 'The veggie delight salad offers an abundance of energy from its ingredients such as round sliced organic cucumbers and tomatoes, green peppers and red onion on a bed of finely chopped crisp lettuce dressed with lemon dressing.', 345, 'No allergens found', 4.75),
(9, 3, 'Fresh Orange juice', 'orange_juice.png', 'Our KBK orange juice is made fresh in house from squeezing 4 whole sun kissed Florida oranges. A truly energizing drink full of life and vitamin C.', 120, 'No allergens present', 3.95),
(10, 3, 'Lemon Tea', 'lemon_tea.png', 'KBK lemon tea is inspired from the Indian cuisine and it is a very refreshing drink which could be served at any time of the day indulging yourself or when meeting with your next door neighbor. It is made of aromatic Indian black tea, lemon, and spring water. Best served with a slice of lemon and some ice!', 40, 'no allergens are present on this product.', 2.95),
(11, 3, 'Black Tea', 'black_tea.png', 'KBK serves a classic flavoured black tea known as Earl Grey which is flavoured with bergamot essential oil or citrus flavour. It is a long term perfect companion for a quiet afternoon or while browsing a family photo album. Experience the magic of a cup of KBK black tea!', 2, 'there are no known allergens for this drink', 2.25),
(12, 3, 'Tomato juice', 'tomato_juice.png', 'We are taking pride in presenting this healthy tomato juice drink as we have our own source of organic tomatoes. The difference in our juice is the low salt content which mixed with the lycopene content (an antioxidant that may help with lowering the risk of some serious health conditions) makes a good choice for a side drink on the vegetarian KBK range of burgers.', 21, 'not suitable for people with allergy to latex or people with allergy to potatoes or tobacco.', 2.45),
(13, 3, 'Cappuccino', 'cappuccino.png', 'This creamy, delicious, rich flavoured coffee specialty is made from 1/3 Espresso, 1/3 steamed milk and 1/3 foamed milk and garnished with your choice of Cinnamon or powder chocolate. We use  high altitude(above 3000 ft) grown Arabica coffee beans.', 115, 'no allergens are present on this drink product but consideration for those with low toleration to milk products should be given.', 3.45),
(14, 3, 'Mineral Water', 'mineral_water.png', 'This mineral water is bottled fresh at its source in the French Alps. You are what you drink, so hydration is very important, so do not leave out this vital supplement in any meal.', 10, 'None', 1.49),
(15, 4, 'Chocolate Cheesecake', 'chocolate_cheesecake.png', 'This chocolate cheesecake is made to excellence by our chefs to satisfy the most critic connoisseurs. It has a fine and subtle vanilla taste and its topped with raspberries and chocolate curls to accomplish an unforgettable experience!  ', 580, 'this product contain traces of nuts', 5.95),
(16, 4, 'KBK Donuts', 'donuts.png', 'Our donuts make a perfect dessert choice for the sweet lovers. Topped up with different toppings including chocolate, glazed, powdered sugar, cinnamon, vanilla or strawberry frosted, there is one for everyone!', 350, 'Contains milk, wheat and soy.', 4.85),
(17, 4, 'Pumpkin Pie', 'dessert.png', 'The traditional KBK pumpkin pie is made from a blend of three different types of organic pumpkin made into a smooth puree and baked to perfection in house giving a fine crust and a distinct taste. A must try in the autumn from Halloween through Christmas season!', 320, 'contain traces of soy, nuts as well as milk.', 3.65),
(18, 4, 'Strawberry Cheesecake', 'strawberry_cheesecake.png', 'This is a classic, delicious cheesecake made from a vanilla spongecake bottom with fresh strawberries baked throughout and Greek style natural yogurt. This symbolises a true piece of culinary art in baking cheesecake. One that we recommend!', 268, 'this product may contain gluten and nuts and also contains milk.', 3.95),
(19, 5, 'Tzatziki', 'tzatziki.png', 'Alternative to mayo on your vegetarian burger, glamorous taste with added garlic and cucumber. Great companion to feta cheese and Kalamata olive tapenade.', 140, 'Milk', 0.49),
(20, 5, 'Alfalfa Sprouts ', 'alfalfa_sprouts.png', 'These sprouts are a perfect match for any vegetarian burger. It is a light a refreshing topping for your burger and a great source of iron for your diet.', 120, 'None', 1.19),
(21, 5, 'Potato Chips', 'chips.png', 'The crisp and crunchy texture of the potato chips is what makes your burger special. They came in two flavours on our menu: spicy and barbecue.', 160, 'May contain traces of nuts', 1.39),
(22, 5, 'Cranberry Sauce', 'cranberry_sauce.png', 'Did you ever think of adding Cranberry Sauce to your vegetarian burger? If not, you will be amazed at what an experience to your palate this can offer by adding a little extra sweetness to your already delicious choice of KBK burger!', 90, 'None', 0.49),
(23, 5, 'Fried Green Tomatoes ', 'fried_green_tomatoes.png', 'They are not just crunchy but juicy on the inside and a different experience to the ordinary tomatoes. Try one today!', 185, 'May contain gluten and traces of nuts', 1.79),
(24, 1, 'KBK House Burger', 'kbk_house_burger.png', 'Steamed cooked baby potatoes cooked to perfection with magic KBK spices, house made buns with pumpkin seeds, lettuce, sun dried tomatoes and mayo, peas and fine chopped green onions are just the companion for this delicious mild spiced vegetarian burger proudly made by KBK.', 480, 'Contains seeds. May contain gluten and traces of nuts.', 6.49),
(25, 2, 'Goat Cheese Leafy Salad ', 'goat_cheese_salad.png', 'A marvellous collection of salad leafs, spinach, nuts and topped up with selected goat cheese dressed with vinaigrette dressing.', 130, 'Contains milk based products, seeds, and nuts.', 2.29),
(26, 4, 'Chocolate Pudding', 'chocolate_pudding.png', 'This sweet and tasty chocolate pudding is a good source of antioxidants and the cocoa gives you 10% of your daily recommended allowance of iron. Topped up with fresh raspberries makes it the most popular KBK dessert so far!', 220, 'Contains nuts and milk based products.', 2.99);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(222) NOT NULL,
  `username` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `password`) VALUES
(1, 'admin', 'admin'),
(2, 'fred', 'smith'),
(3, 'user', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `CategoryID` (`CategoryID`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `CategoryID` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(24) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(222) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`CategoryID`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
