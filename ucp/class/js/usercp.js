var ajaxFolyamatban = false;

var cookie =
{
	set : function(name, value, sec)
	{
		var expire = "";
		
		if(sec)
		{
			var date = new Date();
			date.setTime(date.getTime() + 1000 * sec);
			expire = date.toUTCString();
		}
		
		document.cookie = name + "=" + value + "; expires=" + expire + "; path=/";
	},
	get : function(name)
	{
		var rname = name + "=";
		var cookiedata = document.cookie.split(';');
		
		for(var x = 0, l = cookiedata.length; x < l; x++)
		{
			var d = cookiedata[x];
			
			while(d.charAt(0) == ' ')
				d = d.substring(1, d.length);
			
			if(d.indexOf(rname) == 0)
				return d.substring(rname.length, d.length);
		}
		
		return null;
	}
};

/**
 * @param data (object) kötelező: .page, .data, .func
 * @param data (object) nem kötelező: .type(json), .url(ajax.php?p=), .efunc
 */
function sendAjax() {
	if(arguments.length < 1 || ajaxFolyamatban) return;
	var d = arguments[0];
	
	quickmenuAjaxf = true;
	
	if(!isExists(d.page, d.data, d.func)) return;
	
	if(!d.hasOwnProperty("type"))
		d.type = "json";
	
	if(!d.hasOwnProperty("url"))
		d.url = "ajax.php?p=";
	
	var ajaxOptions = {
		url: d.url + d.page,
		type: "POST",
		data: d.data,
		dataType: d.type,
		success: function(a, b, c) { ajaxFolyamatban = false; d.func(a, b, c); },
		error: function(jqXHR, textStatus, errorThrown) { console.log("AJAX ERROR: " + textStatus + " / " + errorThrown + "/" + jqXHR.responseText);},
	};
	
	if(d.hasOwnProperty("efunc"))
		ajaxOptions.error = function(jqXHR, textStatus, errorThrown) { 
			console.log("AJAX ERROR: " + textStatus + " / " + errorThrown + "/" + jqXHR.responseText);
			d.efunc(jqXHR, textStatus, errorThrown); 
		};
	
	$.ajax(ajaxOptions);
}

function getArgs(args) {
	var arg = {}, len = args.length;
	
	arg.a = len > 0 ? args[0] : false;
	arg.b = len > 1 ? args[1] : false;
	arg.c = len > 2 ? args[2] : false;
	arg.d = len > 3 ? args[3] : false;
	arg.e = len > 4 ? args[4] : false;
	
	return arg;
}

function setAnchor(anc) {
	window.location.hash = "#" + anc;
}

function getAnchor() {
	return window.location.hash.replace("#", "");
}

function numberFormat(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}