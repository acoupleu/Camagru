function deleteImg(element){
	if (confirm("Voulez vous vraiment supprimer cette photo ?"))
	{
		var deldiv = element.parentNode.parentNode;

		var xhr = getXMLHttpRequest();

		xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			deldiv.parentElement.removeChild(deldiv);
			deleteConfirm();
			}
		};

		xhr.open("POST", "pages/delete_photo.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("photo="+encodeURIComponent(deldiv.childNodes[0].firstChild.src));
	}
	else
	{
		return;
	}
}

function deleteConfirm(){
	var divtempo = document.createElement("div");
	var text = document.createTextNode("Votre photo a été supprimée !");

	divtempo.setAttribute("id", "tempo");
	divtempo.appendChild(text);
	document.body.appendChild(divtempo);
	window.setTimeout(function() {
		document.body.removeChild(divtempo);
	}, 1600);
}

function likeImg(element){
	var imgElem = element.parentNode.parentNode.firstChild.firstChild,
	inPhotoBox = 0, nblike = element.parentNode.parentNode.firstChild;
	if (imgElem.src == null)
	{
		imgElem = element.parentNode.parentNode.parentNode.parentNode.firstChild.firstChild;
		inPhotoBox = 1;
	}
	var imgSrc = imgElem.src,
	imgPath = '..' + imgSrc.substring(imgSrc.lastIndexOf("/", imgSrc.lastIndexOf("/", imgSrc.lastIndexOf("/") - 1) - 1), imgSrc.length);

	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		var allImg = document.getElementsByClassName(imgElem.className),
		imgLen = allImg.length;
		if (this.responseText == "dislike") {
			for (var i = 0; i < imgLen; i++) {
				if (allImg[i].parentNode.getAttribute('id') === "like"){
					allImg[i].src = 'img/nolike.png';
				}
			}
			if (inPhotoBox === 1) {
				nblike.innerHTML = parseInt(nblike.innerHTML, 10) - 1;
			}
		}
		else {
			for (var i = 0; i < imgLen; i++) {
				if (allImg[i].parentNode.getAttribute('id') === "like"){
					allImg[i].src = 'img/like.png';
				}
			}
			if (inPhotoBox === 1) {
				nblike.innerHTML = parseInt(nblike.innerHTML, 10) + 1;
			}
		}
	}
	};

	xhr.open("POST", "pages/like.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("photo="+encodeURIComponent(imgPath));
}

function createLightboxCom(){
	var links = document.getElementsByClassName('photogallery');
	linksLen = links.length;

	for (var i = 0; i < linksLen; i++) {
		links[i].firstChild.addEventListener('click', function(e) {
			e.preventDefault();
			ORIGINLINK = new Object;
			ORIGINLINK.link = e.currentTarget.firstChild.className;
			Object.freeze(ORIGINLINK);
			displayImageCom(e.currentTarget);
		});
	}
}

function displayImageCom(link){
	var imgSrc = link.firstChild.src,
	imgPath = imgSrc.substring(imgSrc.lastIndexOf("/", imgSrc.lastIndexOf("/", imgSrc.lastIndexOf("/") - 1) - 1) + 1, imgSrc.length);
	overlay = document.getElementById('overlayGal');

	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		overlay.innerHTML = this.responseText;
		var specifiedElement = document.getElementById('actionBox');
		document.addEventListener('click', function clickedOn(e) {
			var isClickInside = specifiedElement.contains(e.target);

			if (!isClickInside) {
				overlay.style.display = 'none';
				document.removeEventListener('click', clickedOn);
			}
		});
	}
	};

	overlay.innerHTML = 'Chargement en cours';
	overlay.style.display = 'block';
	xhr.open("POST", "pages/photo.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("photoPath="+encodeURIComponent(imgPath));
}

function checkSubmit(e, element, isConnect) {
	if(e && e.keyCode == 13 && !e.shiftKey) {
		e.preventDefault();
		if (isConnect)
		{
			var com = document.getElementById("commentaire").value;

			if (com != "")
			{
				document.getElementById("commentaire").value = "";
				addComment(com, element);
			}
		}
		else
		{
			alert("Vous devez vous connecter afin de commenter cette photo !");
		}
	}
}

function displayNewCom(elem) {
	var getPhoto = document.getElementsByClassName(elem)[0].parentNode;

	displayImageCom(getPhoto);
}

function addComment(com, element) {
	var nextCom = element.parentNode.lastChild;
	imgElem = element.parentNode.parentNode.parentNode.firstChild.firstChild.firstChild,
	imgSrc = imgElem.src,
	photoPath = '..' + imgSrc.substring(imgSrc.lastIndexOf("/", imgSrc.lastIndexOf("/", imgSrc.lastIndexOf("/") - 1) - 1), imgSrc.length);

	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		var newdiv = document.createElement("div");

		newdiv.setAttribute("class", "comment");
		newdiv.innerHTML = this.responseText;
		nextCom.insertBefore(newdiv, nextCom.firstChild);
	}
	};

	xhr.open("POST", "pages/addComment.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("comment="+encodeURIComponent(com)+"&photoPath="+encodeURIComponent(photoPath)+"&photofrom="+encodeURIComponent(ORIGINLINK.link));
}
