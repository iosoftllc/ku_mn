var total_attach = 1024 * 1024 * 1;

function generateSelectList(objParser, type) {
	var i = 0, strHTML = "", collDistricts = objParser.selectNodes( "//district" );
	switch (type) {
		case "rate1":
		case "rate2":
		case "rate3":
		case "rate4":
		case "rate5":
		case "rate6":
		case "rate7":
		case "rate8":
			strHTML += "<select id=\"" + type + "\" name=\"" + type + "\">\n";
			strHTML += "<option value=\"\">::::::: Choose Type of Room and Rates :::::::</option>\n";
			break;
	}
	for (i = 0; i < collDistricts.length; i++ ) {
		strHTML += "<option value=\"" + collDistricts.item(i).selectSingleNode("code").text + "\">";
		strHTML += collDistricts.item(i).selectSingleNode("dorm").text + " - " + collDistricts.item(i).selectSingleNode("name").text + " " + collDistricts.item(i).selectSingleNode("price").text;
		strHTML += "</option>\n";
	}
	strHTML += "</select>\n";
	return strHTML;
}

function changeSelect(element) {
	var objParser = new ActiveXObject("Microsoft.XMLDOM");
	var type = element.name;
	var code = element.value;
	objParser.async = false;
	switch (type) {
		case "period":
			objParser.load("../../src/apply/select.php?type=rate&code=" + code);
			for (i = 0; i < 8; i++ ) {
				document.getElementById("Level" + (i + 2)).innerHTML = generateSelectList(objParser, "rate" + (i + 1));
			}
			break;
	}
}

function setSelectList(element, val) {
	var i, lenlist = element.length;
	for (i = 0; i < lenlist; i++) {
		if (element.options[i].value == val) {
			element.options[i].selected = true;									
			break;
		}
	}
	if (element.name != "rate") changeSelect(element)
}

function sortList(val) {
	var dir = "ASC";
	if (document.ApplicantForm.sort2.value == "ASC") dir = "DESC";
	document.ApplicantForm.sort1.value = val;
	document.ApplicantForm.sort2.value = dir;
	document.ApplicantForm.action = "../../src/apply/list.php";
	document.ApplicantForm.submit();
}

function gotoList() {
	document.ApplicantForm.action = "../../src/apply/list.php";
	document.ApplicantForm.submit();
}

function gotoPage(page) {
	if (page != "") {
		document.ApplicantForm.page.value = page;
		document.ApplicantForm.action = "../../src/apply/list.php";
		document.ApplicantForm.submit();
	}
}

function viewList() {
	document.ApplicantForm.s_type.value = "";
	document.ApplicantForm.s_text.value = "";
	document.ApplicantForm.action = "../../src/apply/list.php";
	document.ApplicantForm.submit();
}

function viewApplicant(no) {
	if (no != "") {
		document.ApplicantForm.no.value = no;
		document.ApplicantForm.action = "../../src/apply/view.php";
		document.ApplicantForm.submit();
	}
}

function checkSearchApplicant(Form) {
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

function searchApplicant(Form) {
	if (checkSearchApplicant(Form)) {
		document.ApplicantForm.action = "../../src/apply/list.php";
		document.ApplicantForm.submit();
	}
}

function postApplicant(mode) {
	document.ApplicantForm.mode.value = mode;
	document.ApplicantForm.action = "../../src/apply/post.php";
	document.ApplicantForm.submit();
}

function checkApplicantInfo(Form) {
	if (Form.student.value == "") {
		alert("학번을 입력하세요.");
		Form.student.focus();
		return false;
	}
	if (Form.s_kind.value == "L") {
		if (Form.student.value.length != 8) {
			alert("학번은 반드시 8자리이여야 합니다.");
			Form.student.focus();
			return false;
		}
	} else {
		if (Form.student.value.length != 10) {
			alert("학번은 반드시 10자리이여야 합니다.");
			Form.student.focus();
			return false;
		}
	}
	if (Form.fname.value == "" || Form.lname.value == "") {
		alert("이름을 입력하세요.");
		Form.fname.focus();
		return false;
	}
	if (Form.period.value == "") {
		alert("체류기간을 선택하세요.");
		Form.period.focus();
		return false;
	}
	//if (Form.rate1.value == "") {
		//alert("1지망은 반드시 선택하세요.");
		//Form.rate1.focus();
		//return false;
	//}
	if (Form.photo.value && !checkPhoto(Form.photo)) return false;
	calculateFileSize(Form.photo, document.getElementById('photo_size'), Form.total_photo);
	if (Form.total_photo.value >= total_attach) {
		alert("첨부할 수 있는 용량은 최대 " + Math.round(total_attach / 1024) + " KB(" + Math.round(total_attach / 1024 / 1024) + " MB)까지 가능합니다.");
		Form.photo.focus();
		return false;
	}
	if (Form.mode.value == "edit" && Form.pht_del.checked) {
		var flag = confirm("선택하신 첨부사진을 삭제 하시겠습니까?");
		if (!flag) return false;
	}
	return true;
}

function submitApplicant(Form) {
	if (checkApplicantInfo(Form)) Form.submit();
}

function checkPeriodInfo(Form) {
	if (Form.period.value == "") {
		alert("세션을 입력하세요.");
		Form.period.focus();
		return false;
	}
	return true;
}

function submitPeriod(Form) {
	if (checkPeriodInfo(Form)) {
		Form.mode.value = "add";
		Form.method = "post";
		Form.action = "../../src/apply/action.php";
		Form.submit();
	}
}

function assignRoom(Form) {
	if (Form.room.value == "") {
		alert("룸배정할 호실을 입력하세요.");
		Form.room.focus();
		return;
	} else {
		Form.mode.value = "assign";
		Form.method = "post";
		Form.action = "../../src/apply/action.php";
		Form.submit();
	}
}

function deleteApplicant(no) {
	if (no == "") no = getSelectedValue(document.ApplicantForm.list_no);
	if (no == "") alert("선택하신 페이지가 없습니다.");
	else {
		var flag = confirm("선택하신 페이지를 삭제 하시겠습니까?");
		if (flag) {
			document.ApplicantForm.mode.value = "del";
			document.ApplicantForm.no.value = no;
			document.ApplicantForm.method = "post";
			document.ApplicantForm.action = "../../src/apply/action.php";
			document.ApplicantForm.submit();
		}
	}
}

function sendRoomMail(rate, room) {
	if (!rate) alert("아직 룸타입이 설정되어 있지 않습니다.");
	else if (!room) alert("아직 룸배정이 되어 있지 않습니다.");
	else if (rate && room) {
		if (document.ApplicantForm.no.value) {
			document.ApplicantForm.mode.value = "room";
			document.ApplicantForm.method = "post";
			document.ApplicantForm.action = "../../src/apply/action.php";
			document.ApplicantForm.submit();
		}
	}
}

function downloadExcel() {
	document.ApplicantForm.action = "../../src/apply/excel.php";
	document.ApplicantForm.submit();
}

function downloadExcel1() {
	document.ApplicantForm.action = "../../src/apply/excel1.php";
	document.ApplicantForm.submit();
}

function checkPaymentInfo() {
	if (document.ApplicantForm.pay_yy.value == "") {
		alert("년도를 선택하세요.");
		document.ApplicantForm.pay_yy.focus();
		return false;
	}
	if (document.ApplicantForm.pay_mm.value == "") {
		alert("월을 선택하세요.");
		document.ApplicantForm.pay_mm.focus();
		return false;
	}
	if (document.ApplicantForm.pay_dd.value == "") {
		alert("일을 선택하세요.");
		document.ApplicantForm.pay_dd.focus();
		return false;
	}
	if (document.ApplicantForm.pay_type.value == "") {
		alert("종류을 선택하세요.");
		document.ApplicantForm.pay_type.focus();
		return false;
	}
	if (document.ApplicantForm.detail.value == "") {
		alert("내용를 입력하세요.");
		document.ApplicantForm.detail.focus();
		return false;
	}
	if (document.ApplicantForm.price.value == "") {
		alert("금액을 입력하세요.");
		document.ApplicantForm.price.focus();
		return false;
	} else if (!checkNumber(document.ApplicantForm.price.value)) {
		alert("금액은 숫자만 입력가능합니다.");
		document.ApplicantForm.price.focus();
		return false;
	}
	return true;
}

function submitPayment() {
	if (checkPaymentInfo()) {
		document.ApplicantForm.mode.value = "pay_new";
		document.ApplicantForm.method = "post";
		document.ApplicantForm.action = "../../src/apply/action.php";
		document.ApplicantForm.submit();
	}
}

function deletePayment() {
	var no = getSelectedValue(document.ApplicantForm.list_no);
	if (no == "") alert("선택하신 입금내역이 없습니다.");
	else {
		var flag = confirm("선택하신 입금내역을 삭제 하시겠습니까?");
		if (flag) {
			document.ApplicantForm.mode.value = "pay_del";
			document.ApplicantForm.pay_no.value = no;
			document.ApplicantForm.method = "post";
			document.ApplicantForm.action = "../../src/apply/action.php";
			document.ApplicantForm.submit();
		}
	}
}

function updatePayment() {
	var no = getOneValue(document.ApplicantForm.update_no);
	if (no == "" || no == "over") alert("선택하신 입금내역이 없습니다.");
	else if (checkPaymentInfo()) {
		var flag = confirm("선택하신 입금내역을 수정 하시겠습니까?");
		if (flag) {
			document.ApplicantForm.mode.value = "pay_edit";
			document.ApplicantForm.pay_no.value = no;
			document.ApplicantForm.method = "post";
			document.ApplicantForm.action = "../../src/apply/action.php";
			document.ApplicantForm.submit();
		}
	}
}

function showUpdateInfo(radio, yy, mm, dd, detail, price) {
	if (radio.checked) {
		setSelected(document.ApplicantForm.pay_yy, yy);
		setSelected(document.ApplicantForm.pay_mm, mm);
		setSelected(document.ApplicantForm.pay_dd, dd);
		setSelected(document.ApplicantForm.detail, detail);
		document.ApplicantForm.price.value = Math.abs(parseInt(price));
		if (parseInt(price) < 0) setSelected(document.ApplicantForm.pay_type, "-");
		else setSelected(document.ApplicantForm.pay_type, "+");
	}
}

function printInvoice(no) {
	if (no) {
		if (popup != null && !popup.closed) popup.close();
		var URL = "../../../v1/src/popup/invoice.php?no=" + no;
		popup = window.open(URL, '_zipcode','resizable=no,scrollbars=yes,status=no,width=950,height=650');
	}
}

function showPhotoList() {
	PHOTO_LIST = window.open('', 'PHOTO_LIST','resizable=no,scrollbars=yes,status=no,width=600,height=600');
	PHOTO_LIST.focus();
	document.ApplicantForm.target = "PHOTO_LIST";
	document.ApplicantForm.action = "../../src/popup/photo.php";
	document.ApplicantForm.submit();
}