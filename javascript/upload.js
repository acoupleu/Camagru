function supportAjaxUploadWithProgress() {
	return supportFileAPI() && supportAjaxUploadProgressEvents() && supportFormData();

	function supportFileAPI() {
		var fi = document.createElement('INPUT');
		fi.type = 'file';
		return 'files' in fi;
	};

	function supportAjaxUploadProgressEvents() {
		var xhr = new XMLHttpRequest();
		return !! (xhr && ('upload' in xhr) && ('onprogress' in xhr.upload));
	};

	function supportFormData() {
		return !! window.FormData;
	}
}

if (supportAjaxUploadWithProgress()) {
	var notice = document.getElementById('support-notice');
	var uploadBtn = document.getElementById('upload-button-id');
	notice.innerHTML = "Your browser supports HTML uploads. Go try me! :-)";
	uploadBtn.removeAttribute('disabled');
	// Init the Ajax form submission
	initFullFormAjaxUpload();
	// Init the single-field file upload
	initFileOnlyAjaxUpload();
}
function initFullFormAjaxUpload() {
	var form = document.getElementById('form-id');
	form.onsubmit = function() {
		// FormData receives the whole form
		var formData = new FormData(form);
		// We send the data where the form wanted
		var action = form.getAttribute('action');
		// Code common to both variants
		sendXHRequest(formData, action);
		// Avoid normal form submission
		return false;
	}
}
function initFileOnlyAjaxUpload() {
	var uploadBtn = document.getElementById('upload-button-id');
	uploadBtn.onclick = function (evt) {
		var formData = new FormData();
		// Since this is the file only, we send it to a specific location
		var action = '/upload';
		// FormData only has the file
		var fileInput = document.getElementById('file-id');
		var file = fileInput.files[0];
		formData.append('our-file', file);
		// Code common to both variants
		sendXHRequest(formData, action);
	}
}
// Once the FormData instance is ready and we know
// where to send the data, the code is the same
// for both variants of this technique
function sendXHRequest(formData, uri) {
	// Get an XMLHttpRequest instance
	var xhr = new XMLHttpRequest();
	// Set up events
	xhr.upload.addEventListener('loadstart', onloadstartHandler, false);
	xhr.upload.addEventListener('progress', onprogressHandler, false);
	xhr.upload.addEventListener('load', onloadHandler, false);
	xhr.addEventListener('readystatechange', onreadystatechangeHandler, false);
	// Set up request
	xhr.open('POST', uri, true);
	// Fire!
	xhr.send(formData);
}
// Handle the start of the transmission
function onloadstartHandler(evt) {
	var div = document.getElementById('upload-status');
	div.innerHTML = 'Upload started.';
}
// Handle the end of the transmission
function onloadHandler(evt) {
	var div = document.getElementById('upload-status');
	div.innerHTML += '<' + 'br>File uploaded. Waiting for response.';
}
// Handle the progress
function onprogressHandler(evt) {
	var div = document.getElementById('progress');
	var percent = evt.loaded/evt.total*100;
	div.innerHTML = 'Progress: ' + percent + '%';
}
// Handle the response from the server
function onreadystatechangeHandler(evt) {
	var status, text, readyState;
	try {
		readyState = evt.target.readyState;
		text = evt.target.responseText;
		status = evt.target.status;
	}
	catch(e) {
		return;
	}
	if (readyState == 4 && status == '200' && evt.target.responseText) {
		var status = document.getElementById('upload-status');
		status.innerHTML += '<' + 'br>Success!';
		var result = document.getElementById('result');
		result.innerHTML = '<p>The server saw it as:</p><pre>' + evt.target.responseText + '</pre>';
	}
}
  </script>

  <!-- Placeholders for messages set by event handlers -->
  <p id="upload-status"></p>
  <p id="progress"></p>
  <pre id="result"></pre>
