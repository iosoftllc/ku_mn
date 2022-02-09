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
		alert("�˻��Ⱓ�̳� �˻�� �Է��� �ֽʽÿ�.");
		return false;
	}
	if (sdate && edate && sdate > edate) {
		alert("�˻��Ⱓ�� �ùٸ��� �ʽ��ϴ�.");
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
		alert("�й��� �Է��ϼ���.");
		Form.student.focus();
		return false;
	}
	if (Form.s_kind.value == "L") {
		if (Form.student.value.length != 8) {
			alert("�й��� �ݵ�� 8�ڸ��̿��� �մϴ�.");
			Form.student.focus();
			return false;
		}
	} else {
		if (Form.student.value.length != 10) {
			alert("�й��� �ݵ�� 10�ڸ��̿��� �մϴ�.");
			Form.student.focus();
			return false;
		}
	}
	if (Form.fname.value == "" || Form.lname.value == "") {
		alert("�̸��� �Է��ϼ���.");
		Form.fname.focus();
		return false;
	}
	if (Form.period.value == "") {
		alert("ü���Ⱓ�� �����ϼ���.");
		Form.period.focus();
		return false;
	}
	//if (Form.rate1.value == "") {
		//alert("1������ �ݵ�� �����ϼ���.");
		//Form.rate1.focus();
		//return false;
	//}
	if (Form.photo.value && !checkPhoto(Form.photo)) return false;
	calculateFileSize(Form.photo, document.getElementById('photo_size'), Form.total_photo);
	if (Form.total_photo.value >= total_attach) {
		alert("÷���� �� �ִ� �뷮�� �ִ� " + Math.round(total_attach / 1024) + " KB(" + Math.round(total_attach / 1024 / 1024) + " MB)���� �����մϴ�.");
		Form.photo.focus();
		return false;
	}
	if (Form.mode.value == "edit" && Form.pht_del.checked) {
		var flag = confirm("�����Ͻ� ÷�λ����� ���� �Ͻðڽ��ϱ�?");
		if (!flag) return false;
	}
	return true;
}

function submitApplicant(Form) {
	if (checkApplicantInfo(Form)) Form.submit();
}

function checkPeriodInfo(Form) {
	if (Form.period.value == "") {
		alert("������ �Է��ϼ���.");
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
		alert("������� ȣ���� �Է��ϼ���.");
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
	if (no == "") alert("�����Ͻ� �������� �����ϴ�.");
	else {
		var flag = confirm("�����Ͻ� �������� ���� �Ͻðڽ��ϱ�?");
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
	if (!rate) alert("���� ��Ÿ���� �����Ǿ� ���� �ʽ��ϴ�.");
	else if (!room) alert("���� ������� �Ǿ� ���� �ʽ��ϴ�.");
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
		alert("�⵵�� �����ϼ���.");
		document.ApplicantForm.pay_yy.focus();
		return false;
	}
	if (document.ApplicantForm.pay_mm.value == "") {
		alert("���� �����ϼ���.");
		document.ApplicantForm.pay_mm.focus();
		return false;
	}
	if (document.ApplicantForm.pay_dd.value == "") {
		alert("���� �����ϼ���.");
		document.ApplicantForm.pay_dd.focus();
		return false;
	}
	if (document.ApplicantForm.pay_type.value == "") {
		alert("������ �����ϼ���.");
		document.ApplicantForm.pay_type.focus();
		return false;
	}
	if (document.ApplicantForm.detail.value == "") {
		alert("���븦 �Է��ϼ���.");
		document.ApplicantForm.detail.focus();
		return false;
	}
	if (document.ApplicantForm.price.value == "") {
		alert("�ݾ��� �Է��ϼ���.");
		document.ApplicantForm.price.focus();
		return false;
	} else if (!checkNumber(document.ApplicantForm.price.value)) {
		alert("�ݾ��� ���ڸ� �Է°����մϴ�.");
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
	if (no == "") alert("�����Ͻ� �Աݳ����� �����ϴ�.");
	else {
		var flag = confirm("�����Ͻ� �Աݳ����� ���� �Ͻðڽ��ϱ�?");
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
	if (no == "" || no == "over") alert("�����Ͻ� �Աݳ����� �����ϴ�.");
	else if (checkPaymentInfo()) {
		var flag = confirm("�����Ͻ� �Աݳ����� ���� �Ͻðڽ��ϱ�?");
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