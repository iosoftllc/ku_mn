function checkSearchInfo(stext, page) {
	if (stext.value == "") {
		alert("검색어를 입력해 주십시오.");
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
			if (ch < "0" || ch > "9") return false;
		}
	}
	return true;
}

function checkJuminNumber(reg_no) {
	var i, sum = 0;
	var buf = new Array(13);
	var multipliers = [2,3,4,5,6,7,8,9,2,3,4,5];
	
	for (i = 0; i < 13; i++) {
		buf[i] = parseInt(reg_no.charAt(i));
	}
	
	for (i = 0; i < 12; i++) {
		sum += (buf[i] *= multipliers[i]);
	}
	sum = 11 - (sum % 11);
	if (sum == 11) sum = 1;
	else if (sum == 10) sum = 0;
	
	if (sum != buf[12]) return false;
	else return true;
}

function checkForeignNumber(reg_no) {
	var i, sum = 0, odd = 0;
	var buf = new Array(13);
	var multipliers = [2,3,4,5,6,7,8,9,2,3,4,5];
	
	for (i = 0; i < 13; i++) {
		buf[i] = parseInt(reg_no.charAt(i));
	}
	
	odd = buf[7]*10 + buf[8];
	if (odd%2 != 0) return false;
	if ((buf[11] != 6) && (buf[11] != 7) && (buf[11] != 8) && (buf[11] != 9)) return false;
	
	for (i = 0, sum = 0; i < 12; i++) {
		sum += (buf[i] *= multipliers[i]);
	}
	sum = 11 - (sum % 11);
	if (sum >= 10) sum -= 10;
	sum += 2;
	if (sum >= 10) sum -= 10;
	
	if (sum != buf[12]) return false;
	else return true;
}

function getAge(num1, num2) {
	var year, month, day, age, today = new Date();
	if (num2.substr(0, 1) == "3" || num2.substr(0, 1) == "4" || num2.substr(0, 1) == "7" || num2.substr(0, 1) == "8") year = "20" + num1.substr(0, 2);
	else year = "19" + num1.substr(0, 2);
	year = parseInt(year);
	if (num1.substr(2, 1) == "0") month = parseInt(num1.substr(3, 1));
	else month = parseInt(num1.substr(2, 2));
	if (num1.substr(4, 1) == "0") day = parseInt(num1.substr(5, 1));
	else day = parseInt(num1.substr(4, 2));
	age = today.getYear() - year;
	if (today.getMonth()+1 < month) age--;
	else if (today.getMonth()+1 == month && today.getDate() < day) age--;
	return age;
}

function getToday() {
	var cdate, cdate_yy, cdate_mm, cdate_dd, today = new Date();
	cdate_yy = today.getYear();
	if (today.getMonth() + 1 < 10) cdate_mm = "0" + (today.getMonth() + 1);
	else cdate_mm = today.getMonth();
	if (today.getDate() < 10) cdate_dd = "0" + today.getDate();
	else cdate_dd = today.getDate();
	cdate = "" + cdate_yy + "-" + cdate_mm + "-" + cdate_dd;
	return cdate;
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
		if (retval != "") retval = retval.substring(0, retval.length - 1);
	}
	return retval;
}

function getMultipleValue(element1, element2) {
	var retval = "";
	if (element1 != null) {
		var count = element1.length;
		if (count > 1) {
			for (i = 0; i < count; i++) {
				if (element1[i].checked == true) retval += element2[i].value + ";";
			}
		} else {
			if (element1.checked == true) retval += element2.value + ";";
		}
		if (retval != "") retval = retval.substring(0, retval.length-1);
	}
	return retval;
}

function updateCharLen(msg, limit) {
	var length = calculateMsgLen(msg.value);
	document.getElementById(msg.name + "_limit").innerText = length;
	if (length > limit) {
		alert("최대 " + limit + "byte이므로 초과된 글자수는 자동으로 삭제됩니다.");
		msg.value = msg.value.replace(/\r\n$/, "");
		msg.value = assertMsgLen(msg, limit);
	}
}

function calculateMsgLen(msg) {
	var nbytes = 0;
	for (i = 0; i < msg.length; i++) {
		var ch = msg.charAt(i);
		if (escape(ch).length > 4) nbytes += 2;
		else if (ch == '\n' && msg.charAt(i-1) != '\r') nbytes += 1;
		else if (ch == '<' || ch == '>') nbytes += 4;
		else nbytes += 1;
	}
	return nbytes;
}

function assertMsgLen(message, max) {
	var inc = 0;
	var nbytes = 0;
	var msg = "";
	var msglen = message.value.length;
	for (i = 0; i < msglen; i++) {
		var ch = message.value.charAt(i);
		if (escape(ch).length > 4) inc = 2;
		else if (ch == '\n' && message.value.charAt(i-1) != '\r') inc = 1;
		else if (ch == '<' || ch == '>') inc = 4;
		else inc = 1;
		if ((nbytes + inc) > max) break;
		nbytes += inc;
		msg += ch;
	}
	document.getElementById(message.name + "_limit").innerText = nbytes;
	return msg;
}

function calculateFileSize(attach, attach_size, att_total) {
	var img = new Image();
	img.src = getImagePath(attach.value);
	if (img.fileSize > 0) {
		att_total.value = img.fileSize;
		attach_size.innerText = Math.round(img.fileSize / 1024);
	}
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
	dayObject.options[0] = new Option("--", "");
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