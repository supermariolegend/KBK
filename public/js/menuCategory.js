/*
 function displayNextImage() {
 x = (x === images.length - 1) ? 0 : x + 1;
 document.getElementById("1").src = images[x];
 }

 function displayPreviousImage() {
 x = (x <= 0) ? images.length - 1 : x - 1;
 document.getElementById("1").src = images[x];
 }
 */
var request;
request = new XMLHttpRequest();
request.open('GET', '/db/menuCategoryData.json');

var categories;

request.onreadystatechange = function() {
    if ((request.readyState === 4) && (request.status === 200)) {
        categories = JSON.parse(request.responseText);
    }
}

var currentImage = 0;

function displayNextImage() {
    for(var i = 1; i < 5; i++) {
        var image = document.getElementById(JSON.parse(i));
        switch (i)
        {
            case 1:
                image.src = categories.burger[currentImage];
                console.log("burger:");
                break;
            case 2:
                image.src = categories.salad[currentImage];
                console.log("salad:");
                break;
            case 3:
                image.src = categories.drink[currentImage];
                console.log("drink:");
                break;
            case 4:
                image.src = categories.dessert[currentImage];
                console.log("dessert:");
                break;
        }
        currentImage = Math.floor((Math.random() * 3) + 1);
        console.log(currentImage);
    }
}

function startTimer() {
    setInterval(displayNextImage, 8000);
}

request.send();