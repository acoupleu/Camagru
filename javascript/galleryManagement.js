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
		xhr.send("photo="+encodeURIComponent(deldiv.childNodes[0].src));
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
	var imgSrc = element.parentNode.parentNode.firstChild.src;
	var imgPath = '..' + imgSrc.substring(imgSrc.lastIndexOf("/", imgSrc.lastIndexOf("/", imgSrc.lastIndexOf("/") - 1) - 1), imgSrc.length);

	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		if (this.responseText == "dislike")
			element.firstChild.src = 'img/nolike.png';
		}
		else
			element.firstChild.src = 'img/like.png';
	};

	xhr.open("POST", "pages/like.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("photo="+encodeURIComponent(imgPath));
}
