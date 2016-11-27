var nbImage = 10;

document.addEventListener("scroll", function (event)
{
	checkForNewDiv();
});

var checkForNewDiv = function() {
	var galleryDiv = document.querySelector("#gallery");
	var galleryDivOffset = galleryDiv.offsetTop + galleryDiv.clientHeight;
	var pageOffset = window.pageYOffset + window.innerHeight;

	if (pageOffset > galleryDivOffset && nbImage < tot_image) {
		var newDiv = document.getElementById("gallery")

		var xhr = getXMLHttpRequest();

		xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			newDiv.innerHTML += this.responseText;
			}
		};

		xhr.open("POST", "pages/gallery_append.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("nbImage="+nbImage);
		nbImage += 10;
	}
};

var setPage = (function(){
	var galleryDiv = document.querySelector("#gallery");
	var galleryDivOffset = galleryDiv.offsetTop + galleryDiv.clientHeight;
	var pageOffset = window.pageYOffset + window.innerHeight;

	if (pageOffset > galleryDivOffset)
	{
		checkForNewDiv();
	}
})();
