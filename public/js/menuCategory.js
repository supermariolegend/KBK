
// make a new request to get the data from the json file
var request;
request = new XMLHttpRequest();
request.open('GET', '/db/menuCategoryData.json');

// declare a new variable to hold data about the menu categories
// so we can get the urls for our images
var categories;

// ensure onreadystate is equal to 4 and status is 200
request.onreadystatechange = function() {
    if ((request.readyState === 4) && (request.status === 200)) {
        categories = JSON.parse(request.responseText);
    }
}

/**
 * declare and initialize a variable to hold the image index
 * from our array of images in the variable 'categories'
 */
var currentImage = 1;

// declare a function to change all of the images on the page
function changeImage() {
    /*
     * loop through each category on the page. i will represent
     * the 'index' of the category we're currently processing
     */
    for(var i = 1; i < 5; i++) {
        /**
         * randomize the currentImage index to get a random image
         * from the images we have listed in menuCategoryData.json
         */
        currentImage = Math.floor((Math.random() * 4) + 1);
        /**
         * get the image element from the html page by parsing
         * the integer i to a string so we can find it by its
         * id
         */
        var image = document.getElementById(JSON.parse(i));
        /**
         * use the 'category index' to determine which category
         * we'll pick a random image from
         */
        switch (i)
        {
            case 1:
                /**
                 * if it's the burger we're processing, we'll
                 * set it's src to be the url from a random
                 * index from our burger array in menuCategoryData.json
                 */
                image.src = categories.burger[currentImage];
                console.log("burger:");
                break;
            case 2:
                // similar to case one, but for salad
                image.src = categories.salad[currentImage];
                console.log("salad:");
                break;
            case 3:
                // similar to case one, but for drinks
                image.src = categories.drink[currentImage];
                console.log("drink:");
                break;
            case 4:
                // similar to case one, but for desserts
                image.src = categories.dessert[currentImage];
                console.log("dessert:");
                break;
        }
    }
}

/** declare a function which will call changeImage every 8 seconds
 * this function is triggered when the body of _base.html.twig
 * is loaded
 */
function changeImageTimer() {
    setInterval(changeImage, 8000);
}

// send the request to the server for processing
request.send();