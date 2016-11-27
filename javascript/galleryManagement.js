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
