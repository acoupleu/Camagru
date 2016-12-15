var nbImage = 10;

document.addEventListener("scroll", function (event)
{
	checkForNewDiv(page);
});

var checkForNewDiv = function(page) {
	var galleryDiv = document.querySelector("#gallery"),
	galleryDivOffset = galleryDiv.offsetTop + galleryDiv.clientHeight,
	pageOffset = window.pageYOffset + window.innerHeight;

	if (pageOffset > galleryDivOffset && nbImage < tot_image) {
		var newDiv = document.getElementById("gallery")

		var xhr = getXMLHttpRequest();

		xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			newDiv.innerHTML += this.responseText;
			createLightboxCom();
			galleryDivOffset = galleryDiv.offsetTop + galleryDiv.clientHeight;
			if (pageOffset > galleryDivOffset && nbImage < tot_image)
			{
				checkForNewDiv(page);
			}
		}
		};
		xhr.open("POST", "pages/gallery_append.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("nbImage="+nbImage+"&page="+page);
		nbImage += 10;
	}
};

var setPage = (function(){
	var galleryDiv = document.querySelector("#gallery"),
	galleryDivOffset = galleryDiv.offsetTop + galleryDiv.clientHeight,
	pageOffset = window.pageYOffset + window.innerHeight;

	if (pageOffset > galleryDivOffset)
	{
		checkForNewDiv(page);
	}
})();
