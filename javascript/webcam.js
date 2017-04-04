var put_cam = function()
{
	// The width and height of the captured photo. We will set the
	// width to the value defined here, but the height will be
	// calculated based on the aspect ratio of the input stream.

	var width = 500;    // We will scale the photo width to this
	var height = 0;     // This will be computed based on the input stream

	// |streaming| indicates whether or not we're currently streaming
	// video from the camera. Obviously, we start at false.

	var streaming = false;

	// The various HTML elements we need to configure or control. These
	// will be set by the startup() function.

	var video = null;
	var canvas = null;
	var photo = null;
	var startbutton = null;

	function startup()
	{
		video = document.getElementById('video');
		canvas = document.getElementById('canvas');
		photo = document.getElementById('photo');
		startbutton = document.getElementById('printbutton');

		navigator.getMedia = ( navigator.getUserMedia ||
								navigator.webkitGetUserMedia ||
								navigator.mozGetUserMedia ||
								navigator.msGetUserMedia);

		navigator.getMedia(
			{
				video: true,
				audio: false
			},

			function(stream)
			{
				if (navigator.mozGetUserMedia)
				{
					video.mozSrcObject = stream;
				}
				else
				{
					var vendorURL = window.URL || window.webkitURL;
					video.src = vendorURL.createObjectURL(stream);
				}
				video.play();
				},

			function(err)
			{
				console.log("An error occured! " + err);
			}
		);

		video.addEventListener('canplay', function(ev)
		{
			if (!streaming)
			{
				height = video.videoHeight / (video.videoWidth/width);

				// Firefox currently has a bug where the height can't be read from
				// the video, so we will make assumptions if this happens.

				if (isNaN(height))
				{
					height = width / (4/3);
				}

				video.setAttribute('width', width);
				video.setAttribute('height', height);
				canvas.setAttribute('width', width);
				canvas.setAttribute('height', height);
				streaming = true;
			}
		}, false);

		startbutton.addEventListener('click', function(ev)
		{
			takepicture();
			ev.preventDefault();
		}, false);

		clearphoto();
	}

	// Fill the photo with an indication that none has been
	// captured.

	function clearphoto()
	{
		var context = canvas.getContext('2d');
		context.fillStyle = 'rgba(0, 0, 0, 0)';
		context.fillRect(0, 0, canvas.width, canvas.height);

		var data = canvas.toDataURL('image/png');
		photo.setAttribute('src', data);
	}

// Capture a photo by fetching the current contents of the video
// and drawing it into a canvas, then converting that to a PNG
// format data URL. By drawing it on an offscreen canvas and then
// drawing that to the screen, we can change its size and/or apply
// other changes before drawing it.
	function takepicture()
	{
		var context = canvas.getContext('2d');
		if (width && height)
		{
			canvas.width = width;
			canvas.height = height;
			context.drawImage(video, 0, 0, width, height);

			var data = canvas.toDataURL('image/png');

			var xhr = getXMLHttpRequest();
			xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("photo").src = this.responseText;
				createButtons('cam');
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
			xhr.send("img="+encodeURIComponent(data)+"&filtre="+encodeURIComponent(filtre)+"&with=cam");
		}
		else
		{
			clearphoto();
		}
	}

	// Set up our event listener to run the startup process
	// once loading is complete.
	startup();

	var eID = document.getElementById("camImport")

	eID.options[1].selected = true;
};

function camOrImport(value) {
	if (value === "cam")
	{
		var parentCam = document.getElementsByClassName("main-frame")[0];

		var divUpload = document.getElementById('upload-div');
		divUpload.style.display = 'none';
		var divUploaded = document.getElementById('uploaded-div');
		if (divUploaded)
		{
			divUploaded.style.display = 'none';
		}

		var saveButtonExist = document.getElementById('saveButton');
		if (saveButtonExist)
		{
			saveButtonExist.parentNode.removeChild(saveButtonExist);
		}

		var xhr = getXMLHttpRequest();

		xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			parentCam.innerHTML += this.responseText;
			window.allowFilter = true;
			put_cam();
			}
		};
		xhr.open("GET", "pages/camOn.php", true);
		xhr.send();
	}
	else
	{
		location.assign("http://localhost:8080/Camagru/index.php?p=mount");
	}
}
