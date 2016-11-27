function setImage(image) {
	if (image == "none")
	{
		document.getElementById('filter').style.display = 'none';
		document.getElementById('filter').alt = null;
	}
	else
	{
		document.getElementById('filter').style.display = null;
		document.getElementById('filter').src="img/"+image+".png";
		document.getElementById('filter').alt=image;
	}
}

function createButtons(){
	var button = document.getElementById('saveButton');
	if (!button)
	{
		var button = document.createElement("button");
		var text = document.createTextNode("Sauvegarder l'image");

		button.setAttribute("onclick", "saveImage();");
		button.setAttribute("id", "saveButton");
		button.appendChild(text);
		document.getElementsByClassName("main-frame")[0].appendChild(button);
		return;
	}
	else
		return;
}

function addgallery(){
	var side = document.getElementsByClassName("side-frame")[0];
	var gallery = document.getElementById('gallery');

	if (gallery)
	{
		side.removeChild(gallery);
	}
	gallery = document.createElement("table");
	gallery.setAttribute("id", "gallery");
	side.appendChild(gallery);

	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		gallery.innerHTML = this.responseText;
		}
	};
	xhr.open("GET", "pages/minigallery.php", true);
	xhr.send();
}

function saveImage(){
	var photo = document.getElementById('photo');

	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		addgallery();
		savedConfirm();
		}
	};

	xhr.open("POST", "pages/save_photo.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("photo="+encodeURIComponent(photo.src));
}

function savedConfirm(){
	var divtempo = document.createElement("div");
	var text = document.createTextNode("Votre photo a bien été sauvegardée");

	divtempo.setAttribute("id", "tempo");
	divtempo.appendChild(text);
	document.body.appendChild(divtempo);
	window.setTimeout(function() {
		document.body.removeChild(divtempo);
	}, 1600);
}
