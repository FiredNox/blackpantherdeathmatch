function isExists() {
	for ( var i = 0; i < arguments.length; i++) {
		if (typeof arguments[i] == "undefined")
			return false;
	}

	return true;
}

function Go(hova, kiterjesztes) {
	if (kiterjesztes)
		window.top.location.href = hova + Ext;
	else
		window.top.location.href = hova;
}

function dump(arr, level) {
	var dumped_text = "";
	if (!level)
		level = 0;

	// The padding given at the beginning of the line.
	var level_padding = "";
	for ( var j = 0; j < level + 1; j++)
		level_padding += "    ";

	if (typeof (arr) == 'object') { // Array/Hashes/Objects
		for ( var item in arr) {
			var value = arr[item];

			if (typeof (value) == 'object') { // If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value, level + 1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value
						+ "\"\n";
			}
		}
	} else { // Stings/Chars/Numbers etc.
		dumped_text = "===>" + arr + "<===(" + typeof (arr) + ")";
	}
	return dumped_text;
}

cDivs = new Array();
function disableDiv(nev) {
	d = document.getElementsByTagName("BODY")[0];
	if (document.getElementById('cDiv_' + nev) || in_array(nev, cDivs)) {
		// enableDiv(id);
		return 1;
	} else {
		if (document.getElementById(nev)) {
			elem = $('#' + nev);
			/*
			 * elemid = document.getElementById(nev); xPos = elemid.offsetLeft;
			 * yPos = elemid.offsetTop; oWidth = elemid.offsetWidth; oHeight =
			 * elemid.offsetHeight;
			 */
			pozicio = elem.position();
			xPos = pozicio.left;
			yPos = pozicio.top;
			oWidth = elem.outerWidth();
			oHeight = elem.outerHeight();
			cDivs.push(nev);
			cDivs[nev] = document.createElement("DIV");
			cDivs[nev].style.width = oWidth + "px";
			cDivs[nev].style.height = oHeight + "px";
			cDivs[nev].style.position = "absolute";
			cDivs[nev].style.left = xPos + "px";
			cDivs[nev].style.top = yPos + "px";
			cDivs[nev].style.backgroundColor = "#CCCCCC";
			cDivs[nev].style.opacity = .4;
			cDivs[nev].style.filter = "alpha(opacity=40)";
			cDivs[nev].id = ("cDiv_" + nev);
			d.appendChild(cDivs[nev]);
		}
	}
}

function enableDiv(id) {
	if (document.getElementById('cDiv_' + id))
		removeElement("cDiv_" + id);
	// document.getElementsByTagName("BODY")[0].removeChild("cDiv_"+id);
	if (in_array("cDiv_" + id))
		removeByElement(cDivs, id);
}

function time(ido) {
	if (arguments.length)
		return ((new Date(ido)).getTime() / 1000);
	else
		return ((new Date()).getTime() / 1000);
}

function IsNumeric(sText) {
	var ValidChars = "0123456789.";
	var IsNumber = true;
	var Char;
	for (var i = 0; i < sText.length && IsNumber == true; i++) {
		Char = sText.charAt(i);
		if (ValidChars.indexOf(Char) == -1) {
			IsNumber = false;
		}
	}
	return IsNumber;
}

function eExist(object) {
	return (object.length > 0);
}

function implode(glue, pieces) {
	var i = '', retVal = '', tGlue = '';
	if (arguments.length === 1) {
		pieces = glue;
		glue = '';
	}
	if (typeof (pieces) === 'object') {
		if (pieces instanceof Array) {
			return pieces.join(glue);
		} else {
			for (i in pieces) {
				retVal += tGlue + pieces[i];
				tGlue = glue;
			}
			return retVal;
		}
	} else {
		return pieces;
	}
}

function isArray(obj) {
	if (obj.constructor.toString().indexOf("Array") == -1)
		return false;
	else
		return true;
}

function Checked(nev) {
	return $("#" + nev).attr("checked");
}

function in_array(needle, haystack, argStrict) {
	var key = '', strict = !!argStrict;

	if (strict) {
		for (key in haystack) {
			if (haystack[key] === needle) {
				return true;
			}
		}
	} else {
		for (key in haystack) {
			if (haystack[key] == needle) {
				return true;
			}
		}
	}
	return false;
}

function removeByElement(arrayName, arrayElement) {
	for ( var i = 0; i < arrayName.length; i++) {
		if (arrayName[i] == arrayElement)
			arrayName.splice(i, 1);
	}
}

function removeElement(divNum) {
	// var d = document.getElementById('myDiv');
	var d = document.getElementsByTagName("BODY")[0];
	var olddiv = document.getElementById(divNum);
	d.removeChild(olddiv);
}

function array2json(arr) {
	var parts = [];
	var is_list = (Object.prototype.toString.apply(arr) === '[object Array]');

	for ( var key in arr) {
		var value = arr[key];
		if (typeof value == "object") { // Custom handling for arrays
			if (is_list)
				parts.push(array2json(value)); /* :RECURSION: */
			else
				parts[key] = array2json(value); /* :RECURSION: */
		} else {
			var str = "";
			if (!is_list)
				str = '"' + key + '":';

			// Custom handling for multiple data types
			if (typeof value == "number")
				str += value; // Numbers
			else if (value === false)
				str += 'false'; // The booleans
			else if (value === true)
				str += 'true';
			else
				str += '"' + value + '"'; // All other things
			// for? (Functions?)

			parts.push(str);
		}
	}
	var json = parts.join(",");

	if (is_list)
		return '[' + json + ']';// Return numerical JSON
	return '{' + json + '}';// Return associative JSON
}