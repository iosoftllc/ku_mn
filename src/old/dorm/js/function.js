var popup;

function previewUpload(attach) {
	if (!checkPhoto(attach)) return;
	var img_url = getImagePath(attach.value);
	if (popup != null && !popup.closed) popup.close();
	var URL = "https://reslife.korea.ac.kr:5008/v1/src/popup/preview.php?url=" + img_url;
	popup = window.open(URL, '_View', 'resizable=yes,scrollbars=yes');
}

function previewImage(img_url) {
	if (img_url != "") {
		if (popup != null && !popup.closed) popup.close();
		var URL = "https://reslife.korea.ac.kr:5008/v1/src/popup/preview.php?url=" + img_url;
		popup = window.open(URL, '_View', 'resizable=no,scrollbars=yes');
	}
}

function checkSearchInfo(stext, page) {
	if (stext.value == "") {
		alert("Please input a word that you want to search.");
		stext.focus();
		return false;
	}
	page.value = "1";
	return true;
}

function checkSpace(txt) {
	for (var k = 0; k <= (txt.length - 1); k++) {
		if (txt.indexOf(" ") >= 0 ) return true;
	}
	return false;
}

function checkLetter(txt) {
	var i, j, idcheck;
	var str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	for (i = 0; i < txt.length; i++) {
		idcheck = txt.charAt(i);
		for (j = 0;  j < str.length; j++) {
			if (idcheck == str.charAt(j)) break;
		}
		if (j == str.length) return true;
	}
	return false;
}

function checkNumber(num) {
	if (num != "") {
		for (var i = 0; i < num.length; i++) {
			var ch = num.substring(i, i + 1);
			if (ch < "0" || ch > "9" || ch == "-") return false;
		}
	}
	return true;
}

function setSelected(objSource, select_value) {
	var i, lenlist = objSource.length;
	for (i = 0; i < lenlist; i++) {
		if (objSource.options[i].value == select_value) {
			objSource.options[i].selected = true;									
			break;
		}
	}
}

function setChecked(objSource, check_value) {
	var i, lenlist = objSource.length;
	if (lenlist > 1) {
		for (i = 0; i < lenlist; i++) {
			if (objSource[i].value == check_value) {
				objSource[i].checked = true;
				break;
			}
		}
	} else {
		if (objSource.value == check_value) {
			objSource.checked = true;
		}
	}
}

function setMultipleChecked(objSource, check_value) {
	var i, j, list_val = check_value.split(",");
	for (i = 0; i < list_val.length; i++) {
		for (j = 0; j < objSource.length; j++) {
			if (objSource[j].value == list_val[i]) objSource[j].checked = true;
		}
	}
}

var all_flag = "F";
function selectAll(objSource) {
	if (objSource != null) {
		var count = objSource.length;
		if (count > 1) {
			if (all_flag == "F") {
				for (i = 0; i < count; i++) {
					objSource[i].checked = true;
				}
				all_flag = "T";
			} else {
				for (i = 0; i < count; i++) {
					objSource[i].checked = false;
				}
				all_flag = "F";
			}
		} else {
			if (all_flag == "F") {
				objSource.checked = true;
				all_flag = "T";
			} else {
				objSource.checked = false;
				all_flag = "F";
			}
		}
	}
}

function getOneValue(element) {
	var retval = "";
	if (element != null) {
		var count = element.length;
		if (count > 1) {
			for (i = 0; i < count; i++) {
				if (element[i].checked == true) {
					if (retval == "") retval += element[i].value;
					else {
						retval = "over";
						break;
					}
				}
			}
		} else {
			if (element.checked == true) retval += element.value;
		}
	}
	return retval;
}

function getSelectedValue(element) {
	var retval = "";
	if (element != null) {
		var count = element.length;
		if (count > 1) {
			for (i = 0; i < count; i++) {
				if (element[i].checked == true) retval += element[i].value + ",";
			}
		} else {
			if (element.checked == true) retval += element.value + ",";
		}
		if (retval != "") retval = retval.substring(0, retval.length-1);
	}
	return retval;
}

function getImagePath(img_url) {
	var str = "";
	if (!(img_url.length > 7 && img_url.substring(0, 7) == 'http://')) {
		var newURL = "file://";
		newURL += img_url.charAt(0);
		newURL += ":";
		img_url = img_url.substring(3);
		dir = img_url.split("\\");
		for(i = 0 ; i < dir.length ; i++) {
			newURL += "/" + dir[i];
		}
		str = newURL;
	}
	return str;
}

function setDayList(yearObject, monthObject, dayObject) {
	var yr = parseInt(yearObject.options[yearObject.selectedIndex].text);
	var mth = parseInt(monthObject.options[monthObject.selectedIndex].text);
	var tempDate = new Date(yr, mth, 0, 0, 0, 0, 0);
	var lastDay = tempDate.getDate();
	for (i = dayObject.length - 1; i >= 0; i--) {
		dayObject.options[i] = null;
	}
	dayObject.options[0] = new Option("dd", "");
	for (i = 1; i <= lastDay; i++) {
		var temp = i;
		if (temp < 10) temp = "0" + temp;
		dayObject.options[i] = new Option(temp, temp);
	}
}

function setHourList(ampmObject, hourObject) {
	var ampm = ampmObject.options[ampmObject.selectedIndex].value;
	for (i = hourObject.length - 1; i >= 0; i--) {
		hourObject.options[i] = null;
	}
	if (ampm == "mid1" || ampm == "mid2") hourObject.options[0] = new Option("12", "12");
	else {
		hourObject.options[0] = new Option("--", "");
		for (i = 1; i <= 11; i++) {
			var temp = i;
			if (temp < 10) temp = "0" + temp;
			hourObject.options[i] = new Option(temp, temp);
		}
	}
}

function getToday() {
	var cdate, cdate_yy, cdate_mm, cdate_dd, today = new Date();
	cdate_yy = today.getYear();
	if (today.getMonth() + 1 < 10) cdate_mm = "0" + (today.getMonth() + 1);
	else cdate_mm = today.getMonth() + 1;
	if (today.getDate() < 10) cdate_dd = "0" + today.getDate();
	else cdate_dd = today.getDate();
	cdate = "" + cdate_yy + "-" + cdate_mm + "-" + cdate_dd;
	return cdate;
}

function getCommaFormat(num) {
	var rtn = "";
	num = new String(num);
	if (checkNumber(num)) {
		var i, val = "", j = 0;
		for (i = num.length; i > 0; i--) {
			if (num.substring(i, i - 1) != ",") val = num.substring(i, i - 1) + val;
		}
		for (i = val.length; i > 0; i--) {
			if (j % 3 == 0 && j != 0) rtn = val.substring(i, i - 1) + "," + rtn; 
			else rtn = val.substring(i, i - 1) + rtn;
			j++;
		}
	}
	return rtn;
}

function setCommaFormat(num) {
	var i, rtn = "", val = "", j = 0;
	for (i = num.value.length; i > 0; i--) {
		if (num.value.substring(i, i - 1) != ",") val = num.value.substring(i, i - 1) + val;
	}
	for (i = val.length; i > 0; i--) {
		if (j % 3 == 0 && j != 0) rtn = val.substring(i, i - 1) + "," + rtn; 
		else rtn = val.substring(i, i - 1) + rtn;
		j++;
	}
	num.value = rtn;
}