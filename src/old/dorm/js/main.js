function setRollOver() {
	for (i = 0; i < main_menu_count; i++) {
		mainMenuOut[i] = new Image();
		mainMenuOver[i] = new Image();
		subMenuOut[i] = new Array();
		subMenuOver[i] = new Array();
		for (j = 0; j < sub_menu_count[i]; j++) {
			subMenuOut[i][j] = new Image();
			subMenuOver[i][j] = new Image();
			if (i == main_menu_index - 1) {
				pageMenuOut[j] = new Image();
				pageMenuOver[j] = new Image();
			}
		}
	}
	for (i = 0; i < etc_menu_count; i++) {
		etcMenuOut[i] = new Image();
		etcMenuOver[i] = new Image();
	}
	for (i = 0; i < footer_menu_count; i++) {
		footerMenuOut[i] = new Image();
		footerMenuOver[i] = new Image();
	}
}

function swapLayers(no, display) {
	var i, obj;
	for (i = 1; i <= main_menu_count; i++) {
		obj = document.getElementById("subMenuLayer_" + i);
		if (obj != null) {
			if (obj.style && i == no && obj.style.visibility != display) obj.style.visibility = display;
			else if (main_menu_index != no && obj.style.visibility != "hidden") obj.style.visibility = "hidden";
		}
	}
}

function swapMenu(id, mode) {
	var main_menu_obj, sub_menu_obj, page_menu_obj, etc_menu_obj, obj = document.getElementById(id);
	var arr_id = id.split("_"), menu_index1, menu_index2, display;
	if (!isNaN(arr_id[2])) menu_index1 = arr_id[2] - 1;
	if (!isNaN(arr_id[3])) menu_index2 = arr_id[3] - 1;
	if (mode == "over") display = "visible";
	else display = "hidden";
	if (id.match("main_menu")) {
		for (i = 1; i <= main_menu_count; i++) {
			main_menu_obj = document.getElementById("main_menu_" + i);
			if (main_menu_obj != null) {
				if (main_menu_obj.src != null && main_menu_obj.src.match("o_")) main_menu_obj.src = main_menu_obj.src.replace("o_", "");
				else if (main_menu_obj.className != null && main_menu_obj.className == "mainMenuOver") main_menu_obj.className = "mainMenuOut";
			}
		}
		if (obj != null) {
			if (obj.src != null) {
				if (mode == "over") obj.src = mainMenuOver[menu_index1].src;
				else obj.src = mainMenuOut[menu_index1].src;
			} else if (obj.className != null) {
				if (mode == "over") obj.className = "mainMenuOver";
				else obj.className = "mainMenuOut";
			}
		}
		swapLayers(menu_index1 + 1, display);
	}
	if (id.match("sub_menu")) {
		for (i = 1; i <= page_menu_count; i++) {
			sub_menu_obj = document.getElementById("sub_menu_" + (menu_index1 + 1) + "_" + i);
			if (sub_menu_obj != null) {
				if (sub_menu_obj.src != null && sub_menu_obj.src.match("o_")) sub_menu_obj.src = sub_menu_obj.src.replace("o_", "");
				else if (sub_menu_obj.className != null && sub_menu_obj.className == "subMenuOver") sub_menu_obj.className = "subMenuOut";
			}
		}
		if (obj != null) {
			if (obj.src != null) {
				if (mode == "over") obj.src = subMenuOver[menu_index1][menu_index2].src;
				else obj.src = subMenuOut[menu_index1][menu_index2].src;
			} else if (obj.className != null) {
				if (mode == "over") obj.className = "subMenuOver";
				else obj.className = "subMenuOut";
			}
		}
	}
	if (id.match("page_menu")) {
		for (i = 1; i <= page_menu_count; i++) {
			page_menu_obj = document.getElementById("page_menu_" + (menu_index1 + 1) + "_" + i);
			if (page_menu_obj != null) {
				if (page_menu_obj.src != null && page_menu_obj.src.match("o_")) page_menu_obj.src = page_menu_obj.src.replace("o_", "");
				else if (page_menu_obj.className != null && page_menu_obj.className == "pageMenuOver") page_menu_obj.className = "pageMenuOut";
			}
		}
		if (obj != null) {
			if (obj.src != null) {
				if (mode == "over") obj.src = pageMenuOver[menu_index2].src;
				else obj.src = pageMenuOut[menu_index2].src;
			} else if (obj.className != null) {
				if (mode == "over") obj.className = "pageMenuOver";
				else obj.className = "pageMenuOut";
			}
		}
	}
	if (id.match("etc_menu")) {
		for (i = 1; i <= etc_menu_count; i++) {
			etc_menu_obj = document.getElementById("etc_menu_" + i);
			if (etc_menu_obj != null) {
				if (etc_menu_obj.src != null && etc_menu_obj.src.match("o_")) etc_menu_obj.src = etc_menu_obj.src.replace("o_", "");
				else if (etc_menu_obj.className != null && etc_menu_obj.className == "etcMenuOver") etc_menu_obj.className = "etcMenuOut";
			}
		}
		if (obj != null) {
			if (obj.src != null) {
				if (mode == "over") obj.src = etcMenuOver[menu_index1].src;
				else obj.src = etcMenuOut[menu_index1].src;
			} else if (obj.className != null) {
				if (mode == "over") obj.className = "etcMenuOver";
				else obj.className = "etcMenuOut";
			}
		}
	}
	if (mode == "out") {
		if (main_menu_index > 0) {
			main_menu_obj = document.getElementById("main_menu_" + main_menu_index);
			if (main_menu_obj != null) {
				if (main_menu_obj.src != null) main_menu_obj.src = mainMenuOver[main_menu_index - 1].src;
				else if (main_menu_obj.className != null) main_menu_obj.className = "mainMenuOver";
			}
			sub_menu_obj = document.getElementById("sub_menu_" + main_menu_index + "_" + page_menu_index);
			if (sub_menu_obj != null) {
				if (sub_menu_obj.src != null) sub_menu_obj.src = subMenuOver[main_menu_index - 1][page_menu_index - 1].src;
				else if (sub_menu_obj.className != null) sub_menu_obj.className = "subMenuOver";
			}
			page_menu_obj = document.getElementById("page_menu_" + main_menu_index + "_" + page_menu_index);
			if (page_menu_obj != null) {
				if (page_menu_obj.src != null) page_menu_obj.src = pageMenuOver[page_menu_index - 1].src;
				else if (page_menu_obj.className != null) page_menu_obj.className = "pageMenuOver";
			}
			//swapLayers(main_menu_index, "visible");
		} else if (etc_menu_index > 0) {
			etc_menu_obj = document.getElementById("etc_menu_" + etc_menu_index);
			if (etc_menu_obj != null) {
				if (etc_menu_obj.src != null) etc_menu_obj.src = etcMenuOver[etc_menu_index - 1].src;
				else if (etc_menu_obj.className != null) etc_menu_obj.className = "etcMenuOver";
			}
		}
	}
}

function swapBlocks(name, num) {
	var i, obj;
	for (i = 1; i <= block_count; i++) {
		obj = document.getElementById(name + "_" + i);
		if (obj != null) {
			if (obj.style != null && i == num) obj.style.display = "block";
			else obj.style.display = "none";
		}
	}
}

function getCookieVal(cookieName) {
	var thisCookie = document.cookie.split("; ");
	for (i = 0; i < thisCookie.length; i++) {
		if(cookieName == thisCookie[i].split("=")[0]) return thisCookie[i].split("=")[1];
	}
	return "";
}

function checkLoginInfo(id, pw) {
	if (!checkID(id)) return false;
	if (!checkPassword(pw, pw)) return false;
	return true;
}

function logout() {
	var ans = confirm("로그아웃 하시겠습니까?");
	if (ans == true) top.location = "https://reslife.korea.ac.kr:5008/v1/src/main/logout.php";
}

function openFlash(w, h, c, src) {
	var flash;
	flash = "<object width=\"" + w + "\" height=\"" + h + "\" classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\">";
	flash += "<param name=\"allowScriptAccess\" value=\"sameDomain\">";
	flash += "<param name=\"movie\" value=\"" + src + "\">";
	flash += "<param name=\"loop\" value=\"false\">";
	flash += "<param name=\"menu\" value=\"false\">";
	flash += "<param name=\"quality\" value=\"high\">";
	flash += "<param name=\"bgcolor\" value=\"" + c + "\">";
	//flash += "<param name=\"wmode\" value=\"transparent\">\n";
	flash += "<embed src=\"" + src + "\" width=\"" + w + "\" height=\"" + h + "\" allowScriptAccess=\"sameDomain\" loop=\"false\" menu=\"false\" quality=\"high\" bgcolor=\"" + c + "\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\">";
	flash += "</object>";
	document.write(flash);
}

function openVod(w, h, src) {
	if (src != "") {
		var vod;
		vod = "<object id=\"Player\" classid=\"clsid:22d6f312-b0f6-11d0-94ab-0080c74c7e95\" codebase=\"http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,5,715\" standby=\"Loading Microsoft Windows Media Player components...\" style=\"width:" + w + "px; height:" + h + "px; left:0px; top:0px\" type=\"application/x-oleobject\">";
		vod += "<param name=\"Filename\" value=\"mms://wm-001.cafe24.com/intia1/" + src + "\">";
		vod += "<param name=\"animationatstart\" value=\"0\">";
		vod += "<param name=\"AutoRewind\" value=\"1\">";
		vod += "<param name=\"AutoSize\" value=\"1\">";
		vod += "<param name=\"AutoStart\" value=\"1\">";
		vod += "<param name=\"ClickToPlay\" VALUE=\"0\">";
		vod += "<param name=\"EnableContextMenu\" value=\"1\">";
		vod += "<param name=\"playCount\" value=\"0\">";
		vod += "<param name=\"ShowControls\" value=\"1\">";
		vod += "<param name=\"ShowDisplay\" value=\"0\">";
		vod += "<param name=\"ShowPositionControls\" value=\"1\">";
		vod += "<param name=\"ShowSelectionControls\" value=\"1\">";
		vod += "<param name=\"ShowStatusBar\" value=\"1\">";
		vod += "<param name=\"ShowTracker\" value=\"1\">";
		vod += "<param name=\"TransparentAtStart\" value=\"1\">";
		vod += "<param name=\"Volume\" value=\"0\">";
		vod += "</object>";
		document.write(vod);
	} else {
		alert("해당하는 동영상이 존재하지 않습니다.");
		self.close();
	}
}

function openPopup(link, left, top, width, height) {
	//if (getCookieVal("2016_notice") != "1") {
		//width = parseInt(width) + 20;
		var style = "resizable=no,scrollbars=no,left=" + left + ",top=" + top + ",width=" + width + ",height=" + height;
		window.open(link, '_Popup', style);
	//}
}

function openPopup1(link, left, top, width, height) {
	//if (getCookieVal("2020_winter") != "1") {
		//width = parseInt(width) + 20;
		var style = "resizable=no,scrollbars=no,left=" + left + ",top=" + top + ",width=" + width + ",height=" + height;
		window.open(link, '_Popup1', style);
	//}
}

function openPopup2(link, left, top, width, height) {
	//if (getCookieVal("faculty_close") != "1") {
		//width = parseInt(width) + 20;
		var style = "resizable=no,scrollbars=no,left=" + left + ",top=" + top + ",width=" + width + ",height=" + height;
		window.open(link, '_Popup2', style);
	//}
}

function openPopup3(link, left, top, width, height) {
	//if (getCookieVal("faculty_close") != "1") {
		//width = parseInt(width) + 20;
		var style = "resizable=no,scrollbars=no,left=" + left + ",top=" + top + ",width=" + width + ",height=" + height;
		window.open(link, '_Popup3', style);
	//}
}

function previewImage(img_url) {
	if (img_url != "") {
		if (popup != null && !popup.closed) popup.close();
		var URL = "https://reslife.korea.ac.kr:5008/v1/src/popup/preview.php?url=" + img_url;
		popup = window.open(URL, '_View', 'resizable=no,scrollbars=yes');
	}
}