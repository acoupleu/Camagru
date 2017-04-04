var allowFilter = false;

function setImage(image) {
	if (allowFilter)
	{
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
	else
	{
		alert("Vous devez activez votre camera ou telecharger une image !")
	}
}

function createButtons(tool){
	var button = document.getElementById('saveButton');
	if (!button)
	{
		var button = document.createElement("button");
		var text = document.createTextNode("Sauvegarder l'image");

		button.setAttribute("onclick", "saveImage('"+tool+"');");
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
		createLightbox();
		}
	};
	xhr.open("GET", "pages/minigallery.php", true);
	xhr.send();
}

function saveImage(tool){
	if (tool === 'cam')
	{
		var photo = document.getElementById('photo');
	}
	else if(tool === 'troll')
	{
		var photo = document.getElementById('uploaded-photo');
	}
	else
	{
		takePictureImported();
		return;
	}

	var xhr = getXMLHttpRequest();

	xhr.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		addgallery();
		savedConfirm();
		if (tool === 'troll')
		{
			photo.src = 'pages/img/imgtmp.png';
		}
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

function createLightbox(){
	var links = document.getElementsByClassName('minilink');
	linksLen = links.length;

	for (var i = 0; i < linksLen; i++) {
		links[i].addEventListener('click', function(e) {
			e.preventDefault();
			displayImage(e.currentTarget);
		});
	}
}

function displayImage(link) {
	var img = new Image(),
	overlay = document.getElementById('overlay');

	img.addEventListener('load', function() {
		overlay.innerHTML = '';
		overlay.appendChild(img);
	});

	img.src = link.href;
	overlay.style.display = 'block';
	overlay.innerHTML = '<span>Chargement en cours...</span>';
}

function takePictureImported() {
	var xhr = getXMLHttpRequest();
	var data = "troll";

	xhr.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		document.getElementById('uploaded-photo').src = this.responseText;
		saveImage(data);
		}
	};

	var filtre = document.getElementById('filter').alt;
	if (!filtre || filtre == 'null')
	{
		alert("Vous devez selectionner un filtre !");
		return ;
	}

	xhr.open("POST", "pages/photoshop_room.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("img="+encodeURIComponent(data)+"&filtre="+encodeURIComponent(filtre)+"&with=import");
}

function errorUpload(message) {
	switch (message) {
		case '1':
			message = 'Upload réussi !';
			window.allowFilter = true;
			break;
		case '2':
			message = 'Problème lors de l\'upload !';
			break;
		case '3':
			message = 'Une erreur interne a empêché l\'uplaod de l\'image';
			break;
		case '4':
			message = 'Erreur dans les dimensions de l\'image !';
			break;
		case '5':
			message = 'Le fichier à uploader n\'est pas une image !';
			break;
		case '6':
			message = 'L\'extension du fichier est incorrecte !';
			break;
		case '7':
			message = 'Veuillez remplir le formulaire svp !';
			break;
	}
	alert(message);
}

document.getElementById('overlay').addEventListener('click', function(e) {
	e.currentTarget.style.display = 'none';
});
