var xmlHttp;
var total_attach = 1024 * 1024 * 1;

function createXMLHttpRequest() {
	if (window.ActiveXObject) xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	else if (window.XMLHttpRequest) xmlHttp = new XMLHttpRequest();
}

function clearObject(name) {
	var obj = document.getElementById(name);
	while (obj.childNodes.length > 0) {
		obj.removeChild(obj.childNodes[0]);
	}
}

function refreshPeriodList(code) {
	var urlValue = "../../src/apply/app_select.php?type=rate&code=" + code;
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = handlePeriodList;
	xmlHttp.open("GET", urlValue, false);
	xmlHttp.send(null);
}

function handlePeriodList() {
	if (xmlHttp.readyState == 4 && xmlHttp.status == 200) updatePeriodList();
}

function updatePeriodList() {
	var optionObj, period = xmlHttp.responseXML.getElementsByTagName("district");
	optionObj = null;
	if (document.getElementById("rate1") != null) {
		clearObject("rate1");
		optionObj = document.createElement("option");
		optionObj.setAttribute("value", "");
		optionObj.appendChild(document.createTextNode("::::::: Choose Type of Room and Rates :::::::"));
		document.getElementById("rate1").appendChild(optionObj);
		for (var i = 0; i < period.length; i++) {
			optionObj = document.createElement("option");
			optionObj.setAttribute("value", period[i].getElementsByTagName("code")[0].childNodes[0].nodeValue);
			if (period[i].getElementsByTagName("dorm")[0].childNodes[0] == null) optionObj.appendChild(document.createTextNode(period[i].getElementsByTagName("name")[0].childNodes[0].nodeValue + " " + period[i].getElementsByTagName("price")[0].childNodes[0].nodeValue));
			else optionObj.appendChild(document.createTextNode(period[i].getElementsByTagName("dorm")[0].childNodes[0].nodeValue + " - " + period[i].getElementsByTagName("name")[0].childNodes[0].nodeValue + " " + period[i].getElementsByTagName("price")[0].childNodes[0].nodeValue));
			document.getElementById("rate1").appendChild(optionObj);
		}
	}
	optionObj = null;
	if (document.getElementById("rate2") != null) {
		clearObject("rate2");
		optionObj = document.createElement("option");
		optionObj.setAttribute("value", "");
		optionObj.appendChild(document.createTextNode("::::::: Choose Type of Room and Rates :::::::"));
		document.getElementById("rate2").appendChild(optionObj);
		for (var i = 0; i < period.length; i++) {
			optionObj = document.createElement("option");
			optionObj.setAttribute("value", period[i].getElementsByTagName("code")[0].childNodes[0].nodeValue);
			if (period[i].getElementsByTagName("dorm")[0].childNodes[0] == null) optionObj.appendChild(document.createTextNode(period[i].getElementsByTagName("name")[0].childNodes[0].nodeValue + " " + period[i].getElementsByTagName("price")[0].childNodes[0].nodeValue));
			else optionObj.appendChild(document.createTextNode(period[i].getElementsByTagName("dorm")[0].childNodes[0].nodeValue + " - " + period[i].getElementsByTagName("name")[0].childNodes[0].nodeValue + " " + period[i].getElementsByTagName("price")[0].childNodes[0].nodeValue));
			document.getElementById("rate2").appendChild(optionObj);
		}
	}
	optionObj = null;
	if (document.getElementById("rate3") != null) {
		clearObject("rate3");
		optionObj = document.createElement("option");
		optionObj.setAttribute("value", "");
		optionObj.appendChild(document.createTextNode("::::::: Choose Type of Room and Rates :::::::"));
		document.getElementById("rate3").appendChild(optionObj);
		for (var i = 0; i < period.length; i++) {
			optionObj = document.createElement("option");
			optionObj.setAttribute("value", period[i].getElementsByTagName("code")[0].childNodes[0].nodeValue);
			if (period[i].getElementsByTagName("dorm")[0].childNodes[0] == null) optionObj.appendChild(document.createTextNode(period[i].getElementsByTagName("name")[0].childNodes[0].nodeValue + " " + period[i].getElementsByTagName("price")[0].childNodes[0].nodeValue));
			else optionObj.appendChild(document.createTextNode(period[i].getElementsByTagName("dorm")[0].childNodes[0].nodeValue + " - " + period[i].getElementsByTagName("name")[0].childNodes[0].nodeValue + " " + period[i].getElementsByTagName("price")[0].childNodes[0].nodeValue));
			document.getElementById("rate3").appendChild(optionObj);
		}
	}
	optionObj = null;
	if (document.getElementById("rate4") != null) {
		clearObject("rate4");
		optionObj = document.createElement("option");
		optionObj.setAttribute("value", "");
		optionObj.appendChild(document.createTextNode("::::::: Choose Type of Room and Rates :::::::"));
		document.getElementById("rate4").appendChild(optionObj);
		for (var i = 0; i < period.length; i++) {
			optionObj = document.createElement("option");
			optionObj.setAttribute("value", period[i].getElementsByTagName("code")[0].childNodes[0].nodeValue);
			if (period[i].getElementsByTagName("dorm")[0].childNodes[0] == null) optionObj.appendChild(document.createTextNode(period[i].getElementsByTagName("name")[0].childNodes[0].nodeValue + " " + period[i].getElementsByTagName("price")[0].childNodes[0].nodeValue));
			else optionObj.appendChild(document.createTextNode(period[i].getElementsByTagName("dorm")[0].childNodes[0].nodeValue + " - " + period[i].getElementsByTagName("name")[0].childNodes[0].nodeValue + " " + period[i].getElementsByTagName("price")[0].childNodes[0].nodeValue));
			document.getElementById("rate4").appendChild(optionObj);
		}
	}
	optionObj = null;
	if (document.getElementById("rate5") != null) {
		clearObject("rate5");
		optionObj = document.createElement("option");
		optionObj.setAttribute("value", "");
		optionObj.appendChild(document.createTextNode("::::::: Choose Type of Room and Rates :::::::"));
		document.getElementById("rate5").appendChild(optionObj);
		for (var i = 0; i < period.length; i++) {
			optionObj = document.createElement("option");
			optionObj.setAttribute("value", period[i].getElementsByTagName("code")[0].childNodes[0].nodeValue);
			if (period[i].getElementsByTagName("dorm")[0].childNodes[0] == null) optionObj.appendChild(document.createTextNode(period[i].getElementsByTagName("name")[0].childNodes[0].nodeValue + " " + period[i].getElementsByTagName("price")[0].childNodes[0].nodeValue));
			else optionObj.appendChild(document.createTextNode(period[i].getElementsByTagName("dorm")[0].childNodes[0].nodeValue + " - " + period[i].getElementsByTagName("name")[0].childNodes[0].nodeValue + " " + period[i].getElementsByTagName("price")[0].childNodes[0].nodeValue));
			document.getElementById("rate5").appendChild(optionObj);
		}
	}
	optionObj = null;
	if (document.getElementById("rate6") != null) {
		clearObject("rate6");
		optionObj = document.createElement("option");
		optionObj.setAttribute("value", "");
		optionObj.appendChild(document.createTextNode("::::::: Choose Type of Room and Rates :::::::"));
		document.getElementById("rate6").appendChild(optionObj);
		for (var i = 0; i < period.length; i++) {
			optionObj = document.createElement("option");
			optionObj.setAttribute("value", period[i].getElementsByTagName("code")[0].childNodes[0].nodeValue);
			if (period[i].getElementsByTagName("dorm")[0].childNodes[0] == null) optionObj.appendChild(document.createTextNode(period[i].getElementsByTagName("name")[0].childNodes[0].nodeValue + " " + period[i].getElementsByTagName("price")[0].childNodes[0].nodeValue));
			else optionObj.appendChild(document.createTextNode(period[i].getElementsByTagName("dorm")[0].childNodes[0].nodeValue + " - " + period[i].getElementsByTagName("name")[0].childNodes[0].nodeValue + " " + period[i].getElementsByTagName("price")[0].childNodes[0].nodeValue));
			document.getElementById("rate6").appendChild(optionObj);
		}
	}
	optionObj = null;
	if (document.getElementById("rate7") != null) {
		clearObject("rate7");
		optionObj = document.createElement("option");
		optionObj.setAttribute("value", "");
		optionObj.appendChild(document.createTextNode("::::::: Choose Type of Room and Rates :::::::"));
		document.getElementById("rate7").appendChild(optionObj);
		for (var i = 0; i < period.length; i++) {
			optionObj = document.createElement("option");
			optionObj.setAttribute("value", period[i].getElementsByTagName("code")[0].childNodes[0].nodeValue);
			if (period[i].getElementsByTagName("dorm")[0].childNodes[0] == null) optionObj.appendChild(document.createTextNode(period[i].getElementsByTagName("name")[0].childNodes[0].nodeValue + " " + period[i].getElementsByTagName("price")[0].childNodes[0].nodeValue));
			else optionObj.appendChild(document.createTextNode(period[i].getElementsByTagName("dorm")[0].childNodes[0].nodeValue + " - " + period[i].getElementsByTagName("name")[0].childNodes[0].nodeValue + " " + period[i].getElementsByTagName("price")[0].childNodes[0].nodeValue));
			document.getElementById("rate7").appendChild(optionObj);
		}
	}
	optionObj = null;
	if (document.getElementById("rate8") != null) {
		clearObject("rate8");
		optionObj = document.createElement("option");
		optionObj.setAttribute("value", "");
		optionObj.appendChild(document.createTextNode("::::::: Choose Type of Room and Rates :::::::"));
		document.getElementById("rate8").appendChild(optionObj);
		for (var i = 0; i < period.length; i++) {
			optionObj = document.createElement("option");
			optionObj.setAttribute("value", period[i].getElementsByTagName("code")[0].childNodes[0].nodeValue);
			if (period[i].getElementsByTagName("dorm")[0].childNodes[0] == null) optionObj.appendChild(document.createTextNode(period[i].getElementsByTagName("name")[0].childNodes[0].nodeValue + " " + period[i].getElementsByTagName("price")[0].childNodes[0].nodeValue));
			else optionObj.appendChild(document.createTextNode(period[i].getElementsByTagName("dorm")[0].childNodes[0].nodeValue + " - " + period[i].getElementsByTagName("name")[0].childNodes[0].nodeValue + " " + period[i].getElementsByTagName("price")[0].childNodes[0].nodeValue));
			document.getElementById("rate8").appendChild(optionObj);
		}
	}
}

function sortList(val) {
	var dir = "ASC";
	if (document.ApplicationForm.sort2.value == "ASC") dir = "DESC";
	document.ApplicationForm.sort1.value = val;
	document.ApplicationForm.sort2.value = dir;
	document.ApplicationForm.action = "../../src/apply/app_list.php";
	document.ApplicationForm.submit();
}

function gotoList() {
	document.ApplicationForm.action = "../../src/apply/app_list.php";
	document.ApplicationForm.submit();
}

function gotoPage(page) {
	if (page != "") {
		document.ApplicationForm.page.value = page;
		document.ApplicationForm.action = "../../src/apply/app_list.php";
		document.ApplicationForm.submit();
	}
}

function viewList() {
	document.ApplicationForm.s_type.value = "";
	document.ApplicationForm.s_text.value = "";
	document.ApplicationForm.action = "../../src/apply/app_list.php";
	document.ApplicationForm.submit();
}

function viewApplication(no) {
	if (no != "") {
		document.ApplicationForm.no.value = no;
		document.ApplicationForm.action = "../../src/apply/app_view.php";
		document.ApplicationForm.submit();
	}
}

function viewFaculty(no) {
	if (no) document.location.href = "../../src/faculty/room_view.php?no=" + no;
}

function checkSearchApplication(Form) {
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

function searchApplication(Form) {
	if (checkSearchApplication(Form)) {
		document.ApplicationForm.action = "../../src/apply/app_list.php";
		document.ApplicationForm.submit();
	}
}

function postApplication(mode) {
	document.ApplicationForm.mode.value = mode;
	document.ApplicationForm.action = "../../src/apply/app_post.php";
	document.ApplicationForm.submit();
}

function checkApplicationInfo(Form) {
	/*
	var checkin, checkout;
	var checkin = Form.checkin.value;
	var checkout = Form.checkout.value;
	if (!(checkin.length == 10 && checkout.length == 10)) {
		alert("거주기간을 선택해 주십시오.");
		return false;
	}
	if (checkin > checkout) {
		alert("거주기간이 올바르지 않습니다.");
		return false;
	}
	*/
	if (Form.email.value == "") {
		alert("이메일 주소를 입력하세요.");
		Form.email.focus();
		return false;
	}
	if (Form.fee_transfer.value && !checkPhoto(Form.fee_transfer)) return false;
	calculateFileSize(Form.fee_transfer, document.getElementById('fee_transfer_size'), Form.total_photo);
	if (Form.total_photo.value >= total_attach) {
		alert("첨부할 수 있는 용량은 최대 " + Math.round(total_attach / 1024) + " KB(" + Math.round(total_attach / 1024 / 1024) + " MB)까지 가능합니다.");
		Form.fee_transfer.focus();
		return false;
	}
	if (Form.mode.value == "edit" && Form.fee_transfer_del.checked) {
		var flag = confirm("선택하신 첨부사진을 삭제 하시겠습니까?");
		if (!flag) return false;
	}
	if (Form.fee_support.value && !checkPhoto(Form.fee_support)) return false;
	calculateFileSize(Form.fee_support, document.getElementById('fee_support_size'), Form.total_photo);
	if (Form.total_photo.value >= total_attach) {
		alert("첨부할 수 있는 용량은 최대 " + Math.round(total_attach / 1024) + " KB(" + Math.round(total_attach / 1024 / 1024) + " MB)까지 가능합니다.");
		Form.fee_support.focus();
		return false;
	}
	if (Form.mode.value == "edit" && Form.fee_support_del.checked) {
		var flag = confirm("선택하신 첨부사진을 삭제 하시겠습니까?");
		if (!flag) return false;
	}
	if (Form.tb_test.value && !checkPhoto(Form.tb_test)) return false;
	calculateFileSize(Form.tb_test, document.getElementById('tb_test_size'), Form.total_photo);
	if (Form.total_photo.value >= total_attach) {
		alert("첨부할 수 있는 용량은 최대 " + Math.round(total_attach / 1024) + " KB(" + Math.round(total_attach / 1024 / 1024) + " MB)까지 가능합니다.");
		Form.tb_test.focus();
		return false;
	}
	if (Form.mode.value == "edit" && Form.tb_test_del.checked) {
		var flag = confirm("선택하신 첨부사진을 삭제 하시겠습니까?");
		if (!flag) return false;
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
	Form.rate1_code.value = document.getElementById("rate1").value
	Form.rate2_code.value = document.getElementById("rate2").value
	Form.rate3_code.value = document.getElementById("rate3").value
	Form.rate4_code.value = document.getElementById("rate4").value
	Form.rate5_code.value = document.getElementById("rate5").value
	Form.rate6_code.value = document.getElementById("rate6").value
	Form.rate7_code.value = document.getElementById("rate7").value
	Form.rate8_code.value = document.getElementById("rate8").value
	return true;
}

function submitApplication(Form) {
	if (checkApplicationInfo(Form)) Form.submit();
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
		Form.action = "../../src/apply/app_action.php";
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
		Form.action = "../../src/apply/app_action.php";
		Form.submit();
	}
}

function cancelRoom(Form) {
	var flag = confirm("룸배정을 취소하시겠습니까?");
	if (flag) {
		Form.mode.value = "cancel";
		Form.method = "post";
		Form.action = "../../src/apply/app_action.php";
		Form.submit();
	}
}

function deleteApplication(no) {
	if (no == "") no = getSelectedValue(document.ApplicationForm.list_no);
	if (no == "") alert("선택하신 페이지가 없습니다.");
	else {
		var flag = confirm("선택하신 페이지를 삭제 하시겠습니까?");
		if (flag) {
			document.ApplicationForm.mode.value = "del";
			document.ApplicationForm.no.value = no;
			document.ApplicationForm.method = "post";
			document.ApplicationForm.action = "../../src/apply/app_action.php";
			document.ApplicationForm.submit();
		}
	}
}

function approveApplication(Form, flag) {
	if (Form.no.value) {
		var answer = false;
		if (flag == "Y") answer = confirm("결재를 승인 하시겠습니까?");
		else if (flag == "N") answer = confirm("결재를 취소 하시겠습니까?");
		if (answer) {
			if (flag == "Y") Form.mode.value = "approval_y";
			else if (flag == "N") Form.mode.value = "approval_n";
			Form.method = "post";
			Form.action = "../../src/apply/app_action1.php";
			Form.submit();
		}
	}
}

function sendRoomMail(rate, room) {
	if (!rate) alert("아직 룸타입이 설정되어 있지 않습니다.");
	else if (!room) alert("아직 룸배정이 되어 있지 않습니다.");
	else if (rate && room) {
		if (document.ApplicationForm.no.value) {
			document.ApplicationForm.mode.value = "room";
			document.ApplicationForm.method = "post";
			document.ApplicationForm.action = "../../src/apply/app_action.php";
			document.ApplicationForm.submit();
		}
	}
}

function downloadExcel() {
	if (!document.ApplicationForm.purpose.value) {
		alert("사용목적을 입력하세요.");
		document.ApplicationForm.purpose.focus();
		return;
	} else {
		document.ApplicationForm.action = "../../src/apply/app_excel.php";
		document.ApplicationForm.submit();
	}
}

function downloadExcel1() {
	document.ApplicationForm.action = "../../src/apply/app_excel1.php";
	document.ApplicationForm.submit();
}

function checkPaymentInfo() {
	if (document.ApplicationForm.pay_yy.value == "") {
		alert("년도를 선택하세요.");
		document.ApplicationForm.pay_yy.focus();
		return false;
	}
	if (document.ApplicationForm.pay_mm.value == "") {
		alert("월을 선택하세요.");
		document.ApplicationForm.pay_mm.focus();
		return false;
	}
	if (document.ApplicationForm.pay_dd.value == "") {
		alert("일을 선택하세요.");
		document.ApplicationForm.pay_dd.focus();
		return false;
	}
	if (document.ApplicationForm.pay_type.value == "") {
		alert("종류을 선택하세요.");
		document.ApplicationForm.pay_type.focus();
		return false;
	}
	if (document.ApplicationForm.detail.value == "") {
		alert("내용를 입력하세요.");
		document.ApplicationForm.detail.focus();
		return false;
	}
	if (document.ApplicationForm.price.value == "") {
		alert("금액을 입력하세요.");
		document.ApplicationForm.price.focus();
		return false;
	} else if (!checkNumber(document.ApplicationForm.price.value)) {
		alert("금액은 숫자만 입력가능합니다.");
		document.ApplicationForm.price.focus();
		return false;
	}
	return true;
}

function submitPayment() {
	if (checkPaymentInfo()) {
		document.ApplicationForm.mode.value = "pay_new";
		document.ApplicationForm.method = "post";
		document.ApplicationForm.action = "../../src/apply/app_action.php";
		document.ApplicationForm.submit();
	}
}

function deletePayment() {
	var no = getSelectedValue(document.ApplicationForm.list_no);
	if (no == "") alert("선택하신 입금내역이 없습니다.");
	else {
		var flag = confirm("선택하신 입금내역을 삭제 하시겠습니까?");
		if (flag) {
			document.ApplicationForm.mode.value = "pay_del";
			document.ApplicationForm.pay_no.value = no;
			document.ApplicationForm.method = "post";
			document.ApplicationForm.action = "../../src/apply/app_action.php";
			document.ApplicationForm.submit();
		}
	}
}

function updatePayment() {
	var no = getOneValue(document.ApplicationForm.update_no);
	if (no == "" || no == "over") alert("선택하신 입금내역이 없습니다.");
	else if (checkPaymentInfo()) {
		var flag = confirm("선택하신 입금내역을 수정 하시겠습니까?");
		if (flag) {
			document.ApplicationForm.mode.value = "pay_edit";
			document.ApplicationForm.pay_no.value = no;
			document.ApplicationForm.method = "post";
			document.ApplicationForm.action = "../../src/apply/app_action.php";
			document.ApplicationForm.submit();
		}
	}
}

function showUpdateInfo(radio, yy, mm, dd, detail, price) {
	if (radio.checked) {
		setSelected(document.ApplicationForm.pay_yy, yy);
		setSelected(document.ApplicationForm.pay_mm, mm);
		setSelected(document.ApplicationForm.pay_dd, dd);
		setSelected(document.ApplicationForm.detail, detail);
		document.ApplicationForm.price.value = Math.abs(parseInt(price));
		if (parseInt(price) < 0) setSelected(document.ApplicationForm.pay_type, "-");
		else setSelected(document.ApplicationForm.pay_type, "+");
	}
}

function printDepositReceipt(no) {
	if (no) {
		if (popup != null && !popup.closed) popup.close();
		var URL = "../../src/popup/receipt_app_d.php?no=" + no;
		popup = window.open(URL, '_receipt','resizable=no,scrollbars=yes,status=no,width=650,height=650');
	}
}

function printHallReceipt(no) {
	if (no) {
		if (popup != null && !popup.closed) popup.close();
		var URL = "../../src/popup/receipt_app_h.php?no=" + no;
		popup = window.open(URL, '_receipt','resizable=no,scrollbars=yes,status=no,width=650,height=650');
	}
}

function printInvoice(no) {
	if (no) {
		if (popup != null && !popup.closed) popup.close();
		var URL = "../../../v1/src/popup/invoice_stu.php?no=" + no;
		popup = window.open(URL, '_zipcode','resizable=no,scrollbars=yes,status=no,width=650,height=650');
	}
}

function showPhotoList() {
	if (!document.ApplicationForm.purpose.value) {
		alert("사용목적을 입력하세요.");
		document.ApplicationForm.purpose.focus();
		return;
	} else {
		PHOTO_LIST = window.open('', 'PHOTO_LIST','resizable=no,scrollbars=yes,status=no,width=600,height=600');
		PHOTO_LIST.focus();
		document.ApplicationForm.target = "PHOTO_LIST";
		document.ApplicationForm.action = "../../src/popup/app_photo.php";
		document.ApplicationForm.submit();
	}
}

function checkEmailInfo(Form) {
	if (Form.email.value && !checkEmail(Form.email)) return;
	if (popup != null && !popup.closed) popup.close();
	var URL = "../../src/popup/email_info.php?email=" + Form.email.value;
	popup = window.open(URL, '_info','resizable=no,scrollbars=no,status=no,width=600,height=150');
}

function gotoMonth(Form, yr, mth) {
	if (yr && mth) {
		Form.year.value = yr;
		Form.month.value = mth;
		Form.action = "../../src/apply/app_calendar.php";
		Form.submit();
	}
}

function gotoMonthOld(Form, yr, mth) {
	if (yr && mth) {
		Form.year.value = yr;
		Form.month.value = mth;
		Form.action = "../../src/apply/app_calendar_old.php";
		Form.submit();
	}
}

function viewContract(no) {
	if (no) {
		if (popup != null && !popup.closed) popup.close();
		var URL = "../../../v1/src/popup/contract.php?no=" + no;
		popup = window.open(URL, '_contract','resizable=no,scrollbars=yes,status=no,width=650,height=650');
	}
}

function carryForwardDeposit(Form) {
	if (Form.cf_no.value == "") {
		alert("이월할 세션을 선택하세요.");
		Form.cf_no.focus();
		return;
	}
	Form.mode.value = "force";
	Form.method = "post";
	Form.action = "../../src/apply/app_action.php";
	Form.submit();
}