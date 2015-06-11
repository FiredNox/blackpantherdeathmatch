var quickmenu;
var quickmenuWidth = 100;
var quickmenuHeight = 30;
var quickmenuFrakcioUtolso = null;
var quickmenuFrakcioTag = null;

$(document).ready(function() {
	quickmenu = $("#admin-quickmenu-dialog");
	
	quickmenu.dialog({
		autoOpen: false,
		//title: "Admin gyorsmenü",
		minWidth: quickmenuWidth,
		width: quickmenuWidth,
		minHeight: quickmenuHeight,
		height: quickmenuHeight,
		resizable: false,
		draggable: false,
		show: "blind",
		hide: "blind",
		closeOnEscape: false,
		create: function(event, ui) { $(".ui-dialog-titlebar, .ui-dialog-titlebar-close", quickmenu.parent()).hide(); },
		//open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); },
	});
	
	$(document).click(function(e) {
		if($(e.target).attr("id") != $("#adminQuickmenu").attr("id") && !$(quickmenu.parent()).has(e.target).length && quickmenu.dialog("isOpen")) {
			quickmenu.dialog("close");
		}
	});
	
	quickmenuAjax = $("#admin-quickmenuAjax-dialog");
	
	quickmenuAjax.dialog({
		autoOpen: false,
		title: "Admin gyorsmenü",
		position: "center",
		show: "blind",
		hide: "blind",
		width: 800,
		minWidth: 800,
		height: 600,
		minHeight: 200,
	});
});

function adminQuickmenu() {
	
	var x = arguments.length;
	
	var a = x < 1 ? false : arguments[0];
	
	if(a === false) {
		var el = $("#adminQuickmenu");
		var offsets = el.offset();
		var left = offsets.left;
		var top = offsets.top;
		
		var wel = $(window);
		
		left -= wel.scrollLeft();
		top -= wel.scrollTop();
		
		quickmenu.dialog({
			position: [left - quickmenuWidth - 25, top],
		});
		
		if(!quickmenu.dialog("isOpen"))
			quickmenu.dialog("open");
		
		if(quickmenuAjax.dialog("isOpen"))
			quickmenuAjax.dialog("close");
		
	} else {
		if(a == "frakciokezelo") {
			adminFrakciokezelo("load");
		}
		
		if(quickmenu.dialog("isOpen"))
			quickmenu.dialog("close");
		
		if(!quickmenuAjax.dialog("isOpen")) {
			var wHeight = $(window).height();
			
			if(wHeight < 600 ) wHeight = wHeight * 0.9;
			else if(wHeight > 600) wHeight = 600;
			
			quickmenuAjax.dialog({
				height: wHeight
			});
			
			quickmenuAjax.dialog("open");
		}
	}
}

function adminFrakciokezelo() {
	var x = arguments.length;
	if(!x) return;
	
	var a = arguments[0];
	var b = x < 2 ? false : arguments[1];
	var c = x < 3 ? false : arguments[2];
	var d = x < 4 ? false : arguments[3];
	
	if(a == "load" && b === false) {
		sendAjax({
			page: "qm_frakciokezelo",
			data: {
				a: "load"
			},
			func: function(msg){ adminFrakciokezelo("ajax", "load", msg); },
		});
	} else if(a == "change" && b !== false) {
		quickmenuFrakcioUtolso = b;
		
		sendAjax({
			page: "qm_frakciokezelo",
			data: {
				a: "fload",
				b: b,
			},
			func: function(msg){ adminFrakciokezelo("ajax", "change", msg); },
		});
	} else if(a == "reload") {
		if(quickmenuFrakcioUtolso != null) {
			adminFrakciokezelo("change", quickmenuFrakcioUtolso);
		}
	} else if(a == "manage") {
		var selector, el, x, y, z;
		var data = {
			rang: {ki: [], rang: -1},
			leader: {},
			kirug: []
		};
		
		// Rang
		selector = $("input[type='checkbox'][name='qm_frakcio_rang[]']");
		if(selector.length) {
			el = $("#qm_frakcio_rang");
			
			if(el.length && el.val().length) {
				data.rang.rang = el.val();
				
				selector.each(function(){
					el = $(this);
					
					x = el.val();
					
					if(el.is(":checked")) {
						y = $("#qm_frakcio_rang_"+x).val();
						
						if(data.rang.rang != y)
							data.rang.ki.push( el.val() );
					}
				});
			}
		}
		
		// Leader
		selector = $("input[type='checkbox'][name='qm_frakcio_leader[]']");
		if(selector.length) {
			selector.each(function() {
				el = $(this);
				
				x = el.val();
				
				y = el.is(":checked") ? 1 : 0;
				z = $("#qm_frakcio_leader_"+x).val();
				
				if(y != z)
					data.leader[x] = y;
			});
		}
		
		// Kirúgás
		selector = $("input[type='checkbox'][name='qm_frakcio_kirug[]']");
		if(selector.length) {
			selector.each(function() {
				el = $(this);
				
				if(el.is(":checked"))
					data.kirug.push(el.val());
			});
		}
		
		if(data.rang.rang != -1 || !$.isEmptyObject(data.leader) || data.kirug.length) {
			sendAjax({
				page: "qm_frakciokezelo",
				data: {
					a: "manage",
					b: data
				},
				func: function(msg) { adminFrakciokezelo("ajax", "manage", msg); }
			});
		}
	} else if(a == "invite") {
		var tag = quickmenuFrakcioTag;
		
		if(tag == null) {
			alert("Nincs tag kijelölve");
			return;
		}
		
		sendAjax({
			page: "qm_frakciokezelo",
			data: {
				a: "invite",
				b: {
					nev: tag,
					frakcio: quickmenuFrakcioUtolso
				}
			},
			func: function(msg) { adminFrakciokezelo("ajax", "invite", msg, tag); }
		});
	}
	
	if(a == "ajax") {
		if(b == "load" && isExists(c.html)) {
			quickmenuAjax.html(c.html);
		} else if(b == "change" && isExists(c.html)) {
			$("#admin-frakciokezelo-ajax").html(c.html);
			
			$("#qm_frakcio_tag").autocomplete({
				minLength: 3,
				source: function(request, response) {
					var t = request.term;
					var el, dt;

					el = $("#qm_frakcio_tag_ac");
					dt = {};
					
					sendAjax({
						page: "search",
						data: {
							t: "karakter",
							w: t
						},
						func: function(m) {
							if(isExists(m.status)) {
								if(m.status == "not")
									el.html("Nincs találat: " + t);
								else if(m.status == "many")
									el.html("Túl sok találat a keresett kifejezésre: \""+t+"\"");
								else if(m.status == "ok") {
									el.html("");
									dt = m.found;
								}
								
								response(dt);
							}
						}
					});
				},
				select: function(event, ui) {
					quickmenuFrakcioTag = ui.item.value;
					$("#qm_frakcio_tag_nev").html(quickmenuFrakcioTag);
					$("#qm_frakcio_tag").val("");
					
					return false;
				}
			});
		} else if(b == "manage" && isExists(c.msg)) {
			alert(c.msg);
			
			adminFrakciokezelo("reload");
		} else if(b == "invite" && isExists(c.status)) {
			if(c.status == "already")
				alert(d + " már tagja a frakciónak!");
			else if(c.status == "other")
				alert(d + " már tagja egy másik frakciónak!");
			else if(c.status == "online")
				alert(d + " jelenleg online, így nem hívható meg!");
			else if(c.status == "invited" || c.status == "invitedfrom") {
				adminFrakciokezelo("reload");
				
				if(c.status == "invitedfrom") {
					alert(d + " egy másik frakció tagja volt, de felvéve a frakcióba");
				} else {
					alert(d + " felvéve a frakcióba");
				}
			}
			
			$("#qm_frakcio_tag_nev").html("Várakozás...");
			quickmenuFrakcioTag = null;
		}
	}
}