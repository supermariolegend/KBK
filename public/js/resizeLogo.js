function resizeLogo() {
    if(window.innerWidth < 647) {
        document.getElementById("website_logo").src = "/images/website_logo_256.png";
    } else {
        document.getElementById("website_logo").src = "/images/website_logo_text.png";
    }
}