// make a new request to get the data from the json file
var request;
request = new XMLHttpRequest();
request.open('GET', '/js/getImgFromDb.php');

// declare a new variable to hold data about the menu categories
// so we can get the urls for our images
var imageData;

// ensure onreadystate is equal to 4 and status is 200
request.onreadystatechange = function() {
    if ((request.readyState === 4) && (request.status === 200)) {
        // get the image data(parse the JSON object we created in getImgFromDb.php)
        imageData = JSON.parse(request.responseText);
    }
}

// declare a function to change all of the images on the page
function changeImage() {
    /*
     * loop through each category on the page. 'category' will represent
     * the 'index' of the category we're changing the image of
     *
     * our condition is as long as our iterator is less than the amount
     * of categories in menuCategories
     */
    for(var category = 1; category <= imageData[0]; category++) {
        /**
         * randomize the randomImageIndex to get a random image
         * from the images we have listed in menuCategories
         *
         * our range is from 1 to the amount of products in that category
         */
        var randomImageIndex = Math.floor((Math.random() * imageData[category][0]) + 1);
        /**
         * get the image element from the html page by parsing
         * the integer i to a string and appending "image" to the beginning
         * so we can find it by its id
         */
        var image = document.getElementById("image" + JSON.parse(category));
        /**
         * use the 'category index'(category) to determine which category
         * we'll pick a random image from and set our image's src to be
         * equal to the image of the randomImageIndex of the category we're
         * randomizing the image for
         */
        image.src = imageData[category][randomImageIndex];
    }
}

/**
 * declare a function which will call changeImage every 8 seconds
 * this function is triggered when the body of _base.html.twig
 * is loaded
 */
function changeImageTimer() {
    setInterval(changeImage, 5000);
}

// send the request to the server for processing
request.send();