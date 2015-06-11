var el = {};
var loaded = "";
var tcache = {
	b_type: "sms"	
};
/*var tam = {
	sms: [400, 800, 1600, 4000],
	smsT: ["06-20-555-2222", "06-20-666-2222", "06-20-777-2222", "06-20-888-2222"],
	pp: [1000, 15000],
	ppb: [[3000, 5], [7000, 10], [10000, 15]]
};*/
var price = {
	pp: 0
};

$(document).ready(function(){
	el.t_sms = $("#t_sms");	
	el.t_sms.mouseover(function(){Event("mover", "sms");});
	el.t_sms.mouseout(function(){Event("mout", "sms");});
	el.t_sms.click(function(){Event("tclick", "sms");});
	
	el.t_paypal = $("#t_paypal");
	el.t_paypal.mouseover(function(){Event("mover", "paypal");});
	el.t_paypal.mouseout(function(){Event("mout", "paypal");});
	el.t_paypal.click(function(){Event("tclick", "paypal");});
	
	el.t_bevalt = $("#t_bevalt");
	el.t_bevalt.mouseover(function(){Event("mover", "bevalt");});
	el.t_bevalt.mouseout(function(){Event("mout", "bevalt");});
	el.t_bevalt.click(function(){Event("tclick", "bevalt");});
	
	el.p_type = $("#p_type");
	el.p_sms = $("#p_sms");
	el.p_paypal = $("#p_paypal");
	el.p_bevalt = $("#p_bevalt");
	
	el.p_paypalp = $("#p_paypal_price");
	el.p_paypalr = $("#p_paypal_reward");
	
	el.p_paypalpc = $("#p_paypal_price_c");
	el.p_paypalpc.slider({
		min: tam.pp[0],
		max: tam.pp[1],
		step: 100,
		value: 3000,
		slide: function(event, ui) {Event("change", "paypal-price", ui.value);},
		create: function(){Event("change", "paypal-price", 3000);}
	});
	
	el.b_paypal_k = $("#b_paypal_k");
	
	el.m_sms = $("#m_sms");
	el.m_sms.click(function(){Event("tclick", "sms");});
	
	el.m_paypal = $("#m_paypal");
	el.m_paypal.click(function(){Event("tclick", "paypal");});
	
	el.m_bevalt = $("#m_bevalt");
	el.m_bevalt.click(function(){Event("tclick", "bevalt");});
	
	el.b_sms = $("#b_sms");
	el.b_sms.click(function(){Event("click", "b-type-sms");});
	
	el.b_paypal= $("#b_paypal");
	el.b_paypal.click(function(){Event("click", "b-type-paypal");});
	
	el.b_sms_v = $("#b_sms_v");
	el.b_paypal_v = $("#b_paypal_v");
	
	el.b_kod = {
		a: $("#b_kod_a"),
		b: $("#b_kod_b"),
		c: $("#b_kod_c")
	};
	
	el.b_v = {
		sms_k: $("#b_sms_number_k"),
		sms_s: $("#b_sms_number_s"),
		paypal: $("#b_paypal_address")
	};
	
	el.b_kod.a.keyup(function(){Event("change", "kod-a", $(this).val());});
	el.b_kod.b.keyup(function(){Event("change", "kod-b", $(this).val());});
	el.b_kod.c.keyup(function(){Event("change", "kod-c", $(this).val());});
	
	var a = getAnchor();
	if(a == "sms" || a == "paypal" || a == "bevalt") {
		type = a;
		
		(a == "sms" ? el.m_sms : (a == "paypal" ? el.m_paypal : el.m_bevalt)).removeClass("link");
		
		Event("tclick", a);
	} else {
		el.p_type.css("display", "block");
	}
	
	$(".tamButton").button().click(function(){ListData("sms", $(this).val());});
	$("#start_paypal").click(function(){Donate("paypal");});
	$("#b_start").click(function(){Donate("bevalt");});
	$("#b_types").buttonset();
});

function Event(e, i, v) {
	if(e == "mover") {
		(i == "sms" ? el.t_sms : (i == "paypal" ? el.t_paypal : el.t_bevalt)).attr("src", "img/d_" + i + "_h.png");
	} else if(e == "mout") {
		(i == "sms" ? el.t_sms : (i == "paypal" ? el.t_paypal : el.t_bevalt)).attr("src", "img/d_" + i + ".png");
	} else if(e == "tclick" && loaded != i) {
		if(!loaded.length)
			el.p_type.css("display", "none");
		else {
			(loaded == "sms" ? el.p_sms : (loaded == "paypal" ? el.p_paypal : el.p_bevalt)).css("display", "none");
			(loaded == "sms" ? el.m_sms : (loaded == "paypal" ? el.m_paypal : el.m_bevalt)).addClass("link");
		}
		
		(i == "sms" ? el.p_sms : (i == "paypal" ? el.p_paypal : el.p_bevalt)).css("display", "block");
		(i == "sms" ? el.m_sms : (i == "paypal" ? el.m_paypal : el.m_bevalt)).removeClass("link");

		setAnchor(i);
		Load(i);
		loaded = i;
	} else if(e == "change") {
		if(i == "paypal-price") {
			price.pp = v;
			
			el.p_paypalp.html(numberFormat(v));
			
			var b = Bonus("paypal", v);
			var bm = v * (b / 100);
			
			if(!b)
				el.p_paypalr.html(numberFormat(v));
			else
				el.p_paypalr.html(numberFormat(v) + " (+" + b + "% bónusz) = " + numberFormat(v+bm));
		} else if(i == "kod-a" || i == "kod-b" || i == "kod-c") {
			if(v.length == 4) {
				(i == "kod-a" ? el.b_kod.b : (i == "kod-b" ? el.b_kod.c : (tcache.b_type == "sms" ? el.b_v.sms_s : el.b_v.paypal))).focus();
			}
		}
	} else if(e == "click") {
		if(i == "b-type-sms" || i == "b-type-paypal") {
			el.b_sms_v.css("display", (i == "b-type-sms" ? "block" : "none"));
			el.b_paypal_v.css("display", (i == "b-type-paypal" ? "block" : "none"));
			tcache.b_type = (i == "b-type-sms" ? "sms" : "paypal");
		}
	}
}

function Bonus(t, v) {
	var b = 0;
	
	if(t == "paypal") {
		tam.ppb.forEach(function(entry){
			a = entry;
			
			if(a[0] <= v) {
				b = a[1];
			}
		});
	}
	
	return b;
}

function Load(i) {

}

function Donate() {
	var x = getArgs(arguments);
	var t = x.a;
	var f = x.b;
	
	if(t == "paypal") {
		if(f === false) {
			console.log(price.pp);
			sendAjax({
				page: "tamogatas",
				data: {
					a: "paypal_generate",
					data: {
						price: price.pp
					}
				},
				func: function(msg) { Donate(t, "ajaxReady", msg); console.log(msg); }
			});
			
			$("#tp_bef_a").html("<img src='img/ajax-loader.gif'>");
		} else if (f == "ajaxReady") {
			AjaxReady(t, x.c);
		}
	} else if(t == "bevalt") {
		if(f === false) {
			
			var kod = el.b_kod.a.val() + "-" + el.b_kod.b.val() + "-" + el.b_kod.c.val();
			if(kod.length != 14) {
				alert("Kérlek add meg a kódot");
				return;
			}
			
			var patt = /[0-9]{4}-[0-9]{4}-[0-9]{4}/;
			if(!patt.test(kod)) {
				alert("Hibás kód");
				return;
			}
			
			var address;
			if(tcache.b_type == "sms") {
				address = "36" + el.b_v.sms_k.val() + el.b_v.sms_s.val();
				
				if(address.length != 11) {
					alert("Kérlek add meg a kódhoz tartozó telefonszámot");
					return;
				}
			} else {
				address = el.b_v.paypal.val();
				
				var patt = /^[\w\.\_\%\+\-]+@[\w\.\-]+\.[\w]{2,4}$/i;
				if(!patt.test(address)) {
					alert("Hibás E-Mail cím");
					return;
				}
			}
			
			var karakter = el.b_paypal_k.val();
			
			sendAjax({
				page: "tamogatas",
				data: {
					a: "bevalt",
					data: {
						type: tcache.b_type,
						kod: kod,
						address: address,
						karakter: karakter
					}
				},
				func: function(msg) { Donate(t, "ajaxReady", msg); }
			});
		} else if(f == "ajaxReady"){
			AjaxReady(t, x.c);
		}
	}
}

function ListData(t, i) {
	if(t == "sms") {
		$("#ts_bef").html('<h2>Támogatásod: '+tam.sms[i]+'Ft</h2>A támogatás befejezéséhez küld el a <span class="marked">classreborn</span> szót a <span id="f_tel" class="marked">'+tam.smsT[i]+'</span> telefonszámra.<br>A válasz SMSben kapott kódot a Támogatás lapon a Beváltás képre kattintva válthatod be.');
	}
}

function AjaxReady(t, msg) {
	if(t == "paypal") {
		if(msg.success && msg.buttonCode && !isExists(msg.error)) {
			$("#tp_bef_a").html(msg.buttonCode);
		} else {
			$("#tp_bef_a").html("<i>Technikai hiba történt, kérlek próbáld meg később</i>" + (isExists(msg.error) ? " (#"+msg.error+")" : ""));
		}
	} else if(t == "bevalt") {
		if(msg.msg) {
			alert(msg.msg);
		} else {
			alert("Hiba történt");
		}
	}
}