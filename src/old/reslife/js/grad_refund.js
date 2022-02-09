var xmlHttp;
var total_attach = 1024 * 1024 * 5;

function createXMLHttpRequest() {
	if (window.ActiveXObject) xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	else if (window.XMLHttpRequest) xmlHttp = new XMLHttpRequest();
}

function clearPeriod(obj, kind) {
	while (obj.childNodes.length > 0) {
		obj.removeChild(obj.childNodes[0]);
	}
	var option = document.createElement("option");
	option.setAttribute("value", "");
	if (kind == "new") option.appendChild(document.createTextNode("Select which semester you would like to change to."));
	else option.appendChild(document.createTextNode("Select the last session you lived in residence hall."));
	obj.appendChild(option);
}

function refreshPeriod() {
	var URL = "../../src/graduate/re_json.php?type=deposit";
	createXMLHttpRequest();
	xmlHttp.open("GET", URL, false);
	xmlHttp.onreadystatechange = handlePeriod;
	xmlHttp.send(null);
}

function handlePeriod() {
	if (xmlHttp.readyState == 4 && xmlHttp.status == 200) updatePeriod();
}

function updatePeriod() {
	var obj_old = document.getElementById("old_period");
	var obj_new = document.getElementById("new_period");
	var option = null;
	clearPeriod(obj_old, "old");
	clearPeriod(obj_new, "new");
	var jsonData = xmlHttp.responseText;
	var jsonObject = eval('(' + jsonData + ')');
	for (var i = 0; i < jsonObject.period.length; i++) {
		option = document.createElement("option");
		option.setAttribute("value", jsonObject.period[i].code);
		option.appendChild(document.createTextNode(jsonObject.period[i].name + ": " + jsonObject.period[i].sdate + " - " + jsonObject.period[i].edate));
		obj_old.appendChild(option);
		option = document.createElement("option");
		option.setAttribute("value", jsonObject.period[i].code);
		option.appendChild(document.createTextNode(jsonObject.period[i].name + ": " + jsonObject.period[i].sdate + " - " + jsonObject.period[i].edate));
		obj_new.appendChild(option);
	}
}

function sortList(val) {
	var dir = "ASC";
	if (document.RefundForm.sort2.value == "ASC") dir = "DESC";
	document.RefundForm.sort1.value = val;
	document.RefundForm.sort2.value = dir;
	document.RefundForm.action = "../../src/graduate/re_list.php";
	document.RefundForm.submit();
}

function gotoList() {
	document.RefundForm.action = "../../src/graduate/re_list.php";
	document.RefundForm.submit();
}

function gotoPage(page) {
	if (page != "") {
		document.RefundForm.page.value = page;
		document.RefundForm.action = "../../src/graduate/re_list.php";
		document.RefundForm.submit();
	}
}

function viewList() {
	document.RefundForm.s_type.value = "";
	document.RefundForm.s_text.value = "";
	document.RefundForm.action = "../../src/graduate/re_list.php";
	document.RefundForm.submit();
}

function viewRefund(no) {
	if (no != "") {
		document.RefundForm.no.value = no;
		document.RefundForm.action = "../../src/graduate/re_view.php";
		document.RefundForm.submit();
	}
}

function checkSearchRefund(Form) {
	var sdate, edate;
	Form.s_period.value = getSelectedValue(Form.list_period);
	if (Form.s_year1.value && Form.s_month1.value && Form.s_day1.value) sdate = Form.s_year1.value + Form.s_month1.value + Form.s_day1.value;
	if (Form.s_year2.value && Form.s_month2.value && Form.s_day2.value) edate = Form.s_year2.value + Form.s_month2.value + Form.s_day2.value;
	if (!(Form.s_period.value || (Form.s_year1.value && Form.s_month1.value && Form.s_day1.value) || (Form.s_year2.value && Form.s_month2.value && Form.s_day2.value) || Form.s_text.value)) {
		alert("검색기간이나 검색어를 입력해 주십시오.");
		return false;
	}
	if (sdate && edate && sdate > edate) {
		alert("검색기간이 올바르지 않습니다.");
		return false;
	}
	return true;
}

function searchRefund(Form) {
	if (checkSearchRefund(Form)) {
		document.RefundForm.action = "../../src/graduate/re_list.php";
		document.RefundForm.submit();
	}
}

function postRefund(mode) {
	document.RefundForm.mode.value = mode;
	document.RefundForm.action = "../../src/graduate/re_post.php";
	document.RefundForm.submit();
}

function checkRefundInfo(Form) {
	if (Form.student.value == "") {
		alert("학번을 입력하세요.");
		Form.student.focus();
		return false;
	}
	if (Form.student.value.length != 10) {
		alert("학번은 반드시 10자리이여야 합니다.");
		Form.student.focus();
		return false;
	}
	if (Form.fname.value == "" || Form.lname.value == "") {
		alert("이름을 입력하세요.");
		Form.fname.focus();
		return false;
	}
	if (Form.dob_yy.value == "" || Form.dob_mm.value == "" || Form.dob_dd.value == "") {
		alert("생년월일을 입력하세요.");
		Form.dob_yy.focus();
		return false;
	}
	if (!checkEmail(Form.email)) return false;
	if (Form.vacate_flag[1].checked && (Form.vacate_yy.value == "" || Form.vacate_mm.value == "" || Form.vacate_dd.value == "")) {
		alert("퇴실일을 입력하세요.");
		Form.vacate_yy.focus();
		return false;
	}
	if (Form.room.value == "") {
		alert("룸번호를 입력하세요.");
		Form.room.focus();
		return false;
	}
	if (Form.old_period.value == "") {
		alert("최근 거주한 세션을 선택하세요.");
		Form.old_period.focus();
		return false;
	}
	if (Form.refund_flag[1].checked && Form.new_period.value == "") {
		alert("새로 거주할 세션을 선택하세요.");
		Form.new_period.focus();
		return false;
	}
	if (Form.refund_flag[0].checked) {
		if (Form.method_type[0].checked) {
			if (Form.method_info1.value == "") {
				alert("환불 정보를 입력하세요.");
				Form.method_info1.focus();
				return false;
			}
			if (Form.method_info2.value == "") {
				alert("환불 정보를 입력하세요.");
				Form.method_info2.focus();
				return false;
			}
			if (Form.method_info3.value == "") {
				alert("환불 정보를 입력하세요.");
				Form.method_info3.focus();
				return false;
			}
			if (Form.photo.value && !checkPhoto(Form.photo)) return false;
			calculateFileSize(Form.photo, document.getElementById('photo_size'), Form.total_photo);
			if (Form.total_photo.value >= total_attach) {
				alert("첨부할 수 있는 용량은 최대 " + Math.round(total_attach / 1024) + " KB(" + Math.round(total_attach / 1024 / 1024) + " MB)까지 가능합니다.");
				Form.photo.focus();
				return false;
			}
			if (Form.mode.value == "edit" && Form.pht_del.checked) {
				var flag = confirm("선택하신 통장사진을 삭제 하시겠습니까?");
				if (!flag) return false;
			}
		} else if (Form.method_type[1].checked) {
			if (Form.method_info4.value == "") {
				alert("환불 정보를 입력하세요.");
				Form.method_info4.focus();
				return false;
			}
			if (Form.method_info6.value == "") {
				alert("우편물수령자를 입력하세요.");
				Form.method_info6.focus();
				return false;
			}
			if (Form.method_info5.value == "") {
				alert("주소를 입력하세요.");
				Form.method_info5.focus();
				return false;
			}
			if (Form.addr_city.value == "") {
				alert("시/도/군을 입력하세요.");
				Form.addr_city.focus();
				return false;
			}
			if (Form.addr_country.value == "") {
				alert("국가를 선택하세요.");
				Form.addr_country.focus();
				return false;
			}
		} else if (Form.method_type[2].checked) {
			if (Form.method_info7.value == "") {
				alert("은행명을 입력하세요.");
				Form.method_info7.focus();
				return false;
			}
			if (Form.method_info8.value == "") {
				alert("은행코드를 입력하세요.");
				Form.method_info8.focus();
				return false;
			}
			if (Form.addr_line4.value == "") {
				alert("은행 주소를 입력하세요.");
				Form.addr_line4.focus();
				return false;
			}
			if (Form.method_info9.value == "") {
				alert("계좌번호를 입력하세요.");
				Form.method_info9.focus();
				return false;
			}
			if (Form.method_info10.value == "") {
				alert("수익자 이름을 입력하세요.");
				Form.method_info10.focus();
				return false;
			}
			if (Form.method_info11.value == "") {
				alert("수익자 여권번호를 입력하세요.");
				Form.method_info11.focus();
				return false;
			}
			if (Form.addr_line5.value == "") {
				alert("수익자 주소를 입력하세요.");
				Form.addr_line5.focus();
				return false;
			}
			if (Form.method_info12.value == "") {
				alert("수익자 전화번호를 입력하세요.");
				Form.method_info12.focus();
				return false;
			}
			if (Form.addr_country1.value == "") {
				alert("국가를 선택하세요.");
				Form.addr_country1.focus();
				return false;
			}
			Form.method_info1.value = Form.method_info7.value;
			Form.method_info2.value = Form.method_info8.value;
			Form.method_info3.value = Form.method_info9.value;
			Form.method_info4.value = Form.method_info10.value;
			Form.method_info5.value = Form.method_info11.value;
			Form.method_info6.value = Form.method_info12.value;
			Form.addr_line2.value = Form.addr_line4.value;
			Form.addr_line3.value = Form.addr_line5.value;
			Form.addr_country.value = Form.addr_country1.value;
		}
	}
	return true;
}

function submitRefund(Form) {
	if (checkRefundInfo(Form)) Form.submit();
}

function deleteRefund(no) {
	if (no == "") no = getSelectedValue(document.RefundForm.list_no);
	if (no == "") alert("선택하신 보증금이 없습니다.");
	else {
		var flag = confirm("선택하신 보증금을 삭제 하시겠습니까?");
		if (flag) {
			document.RefundForm.mode.value = "del";
			document.RefundForm.no.value = no;
			document.RefundForm.method = "post";
			document.RefundForm.action = "../../src/graduate/re_action.php";
			document.RefundForm.submit();
		}
	}
}

function approveRefundList() {
	if (document.RefundForm.app_yy.value == "" || document.RefundForm.app_mm.value == "" || document.RefundForm.app_dd.value == "") {
		alert("승인일을 선택하세요.");
		document.RefundForm.app_yy.focus();
		return;
	}
	var no = getSelectedValue(document.RefundForm.list_no);
	if (no == "") alert("선택하신 보증금이 없습니다.");
	else {
		var flag = confirm("선택하신 보증금을 승인 하시겠습니까?");
		if (flag) {
			document.RefundForm.mode.value = "app_list";
			document.RefundForm.no.value = no;
			document.RefundForm.method = "post";
			document.RefundForm.action = "../../src/graduate/re_action.php";
			document.RefundForm.submit();
		}
	}
}

function approveRefund(val) {
	if (val == "Y") {
		if (document.RefundForm.price.value == "") {
			alert("금액을 입력하세요.");
			document.RefundForm.price.focus();
			return;
		} else if (!checkNumber(document.RefundForm.price.value)) {
			alert("금액은 숫자만 입력가능합니다.");
			document.RefundForm.price.focus();
			return;
		}
		if (document.RefundForm.price1.value == "") {
			alert("금액을 입력하세요.");
			document.RefundForm.price1.focus();
			return;
		} else if (!checkNumber(document.RefundForm.price1.value)) {
			alert("금액은 숫자만 입력가능합니다.");
			document.RefundForm.price1.focus();
			return;
		}
		if (document.RefundForm.price2.value == "") {
			alert("금액을 입력하세요.");
			document.RefundForm.price2.focus();
			return;
		} else if (!checkNumber(document.RefundForm.price2.value)) {
			alert("금액은 숫자만 입력가능합니다.");
			document.RefundForm.price2.focus();
			return;
		}
		if (document.RefundForm.app_yy.value == "" || document.RefundForm.app_mm.value == "" || document.RefundForm.app_dd.value == "") {
			alert("승인일을 선택하세요.");
			document.RefundForm.app_yy.focus();
			return;
		}
	}
	if (document.RefundForm.no.value) {
		var temp = "미승인";
		if (val == "Y") temp = "승인";
		else if (val == "C") temp = "취소";
		var flag = confirm("선택하신 보증금을 " + temp + " 하시겠습니까?");
		if (flag) {
			document.RefundForm.approve.value = val;
			document.RefundForm.mode.value = "app";
			document.RefundForm.method = "post";
			document.RefundForm.action = "../../src/graduate/re_action.php";
			document.RefundForm.submit();
		}
	}
}

function downloadExcel() {
	if (!document.RefundForm.purpose.value) {
		alert("사용목적을 입력하세요.");
		document.RefundForm.purpose.focus();
		return;
	} else {
		document.RefundForm.action = "../../src/graduate/re_excel.php";
		document.RefundForm.submit();
	}
}

function showPhotoList() {
	if (!document.RefundForm.purpose.value) {
		alert("사용목적을 입력하세요.");
		document.RefundForm.purpose.focus();
		return;
	} else {
		PHOTO_LIST = window.open('', 'PHOTO_LIST','resizable=no,scrollbars=yes,status=no,width=900,height=600');
		PHOTO_LIST.focus();
		document.RefundForm.target = "PHOTO_LIST";
		document.RefundForm.action = "../../src/popup/grad_re_photo.php";
		document.RefundForm.submit();
	}
}