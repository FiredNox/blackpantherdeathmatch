$(document).ready(function() {
	onLoad();
});

var van = 0;

function onLoad() {
	if (max) {
		pFajl();
	} else {
		fFajl();
	}
}

function onUpload() {
	upProcess(true);
}

function onUploadReady(msg) {
	upProcess(false);

	try {
		data = $.parseJSON(msg);
	} catch (err) {
		return;
	}

	if (!isExists(data.msg, data.left))
		return;

	max = data.left;
	fFajl();

	alert(data.msg);
}

function pFajl() {
	if (van < max) {
		van++;
		$("#fajlok").append(
			"<input class='block' type='file' name='fajl" + van + "' id='fajl" + van + "'>"
		);
		fFajl();
	}
}

function mFajl() {
	if (van >= 2) {
		$("#fajl" + van).remove();
		van--;
		fFajl();
	}
}

function fFajl() {
	$("#fajlokSzama").html(van);
	$("#fajlokSzamaMax").html(max);
}

function upProcess(process) {
	if (process) {
		$("#upForm").css("display", "none");
		$("#upProcess").css("display", "block");
	} else {
		$("#upForm").css("display", "block");
		$("#upProcess").css("display", "none");
	}
}