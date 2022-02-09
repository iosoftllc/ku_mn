function sortList(Form, val) {
	var dir = "ASC";
	if (Form.sort2.value == "ASC") dir = "DESC";
	Form.sort1.value = val;
	Form.sort2.value = dir;
	Form.action = "../../src/faculty/fac_list.php";
	Form.submit();
}

function gotoList(Form) {
	Form.action = "../../src/faculty/fac_list.php";
	Form.submit();
}

function gotoPage(Form, page) {
	if (page) {
		Form.page.value = page;
		Form.action = "../../src/faculty/fac_list.php";
		Form.submit();
	}
}

function viewList(Form) {
	Form.s_type.value = "";
	Form.s_text.value = "";
	Form.action = "../../src/faculty/fac_list.php";
	Form.submit();
}

function viewFacility(Form, no) {
	if (no) {
		Form.no.value = no;
		Form.action = "../../src/faculty/fac_view.php";
		Form.submit();
	}
}

function checkSearchFacility(Form) {
	var sdate, edate;
	Form.s_room.value = getSelectedValue(Form.list_room);
	if (Form.s_year1.value && Form.s_month1.value && Form.s_day1.value) sdate = Form.s_year1.value + Form.s_month1.value + Form.s_day1.value;
	if (Form.s_year2.value && Form.s_month2.value && Form.s_day2.value) edate = Form.s_year2.value + Form.s_month2.value + Form.s_day2.value;
	if (!(Form.s_room.value || (Form.s_year1.value && Form.s_month1.value && Form.s_day1.value) || (Form.s_year2.value && Form.s_month2.value && Form.s_day2.value) || Form.s_text.value)) {
		alert("�˻��Ⱓ�̳� �˻�� �Է��� �ֽʽÿ�.");
		return false;
	}
	if (sdate && edate && sdate > edate) {
		alert("�˻��Ⱓ�� �ùٸ��� �ʽ��ϴ�.");
		return false;
	}
	return true;
}

function searchFacility(Form) {
	if (checkSearchFacility(Form)) {
		Form.action = "../../src/faculty/fac_list.php";
		Form.submit();
	}
}

function postFacility(Form, mode) {
	Form.mode.value = mode;
	Form.action = "../../src/faculty/fac_post.php";
	Form.submit();
}

function checkFacilityInfo(Form) {
	if (Form.event.value == "") {
		alert("�̺�Ʈ���� �Է��ϼ���.");
		Form.event.focus();
		return false;
	}
	if (Form.applicant.value == "") {
		alert("��û�ڸ� �Է��ϼ���.");
		Form.applicant.focus();
		return false;
	}
	if (Form.department.value == "") {
		alert("���μ��� �Է��ϼ���.");
		Form.department.focus();
		return false;
	}
	if (Form.position.value == "") {
		alert("�����å�� �Է��ϼ���.");
		Form.position.focus();
		return false;
	}
	if (!checkEmail(Form.email)) return false;
	if (Form.phone.value == "") {
		alert("��ȭ��ȣ�� �Է��ϼ���.");
		Form.phone.focus();
		return false;
	}
	if (Form.event_dt.value == "") {
		alert("�̺�Ʈ���� ������ �ֽʽÿ�.");
		Form.event_dt.focus();
		return false;
	}
	if (Form.event_h1.value == "" || Form.event_m1.value == "" || Form.event_h2.value == "" || Form.event_m2.value == "") {
		alert("�̺�Ʈ�ð��� ������ �ֽʽÿ�.");
		Form.event_h1.focus();
		return false;
	}
	/*
	if (Form.event_h1.value > Form.event_h2.value) {
		alert("�̺�Ʈ�ð��� �ùٸ��� �ʽ��ϴ�.");
		Form.event_h1.focus();
		return false;
	}
	if (Form.event_h1.value == Form.event_h2.value && Form.event_m1.value >= Form.event_m2.value) {
		alert("�̺�Ʈ�ð��� �ùٸ��� �ʽ��ϴ�.");
		Form.event_h1.focus();
		return false;
	}
	*/
	if (Form.attendee.value == "") {
		alert("�����ڼ��� �Է��ϼ���.");
		Form.attendee.focus();
		return false;
	} else if (!checkNumber(Form.attendee.value)) {
		alert("�����ڼ��� ���ڸ� �Է°����մϴ�.");
		Form.attendee.focus();
		return false;
	}
	if (!Form.request1.checked && !Form.request2.checked && !Form.request3.checked && !Form.request4.checked && !Form.request5.checked) {
		alert("�ּ��� �Ѱ� �̻��� �ü��� �����ϼ���.");
		return false;
	}
	return true;
}

function submitFacility(Form) {
	if (checkFacilityInfo(Form)) Form.submit();
}

function deleteFacility(Form, no) {
	if (!no) no = getSelectedValue(Form.list_no);
	if (!no) alert("�����Ͻ� �ü������� �����ϴ�.");
	else {
		var flag = confirm("�����Ͻ� �ü������� ���� �Ͻðڽ��ϱ�?");
		if (flag) {
			Form.mode.value = "del";
			Form.no.value = no;
			Form.method = "post";
			Form.action = "../../src/faculty/fac_action.php";
			Form.submit();
		}
	}
}

function approveFacility(Form, flag) {
	if (Form.no.value) {
		var answer = false;
		if (flag == "Y") answer = confirm("���縦 ���� �Ͻðڽ��ϱ�?");
		else if (flag == "N") answer = confirm("���縦 ��� �Ͻðڽ��ϱ�?");
		if (answer) {
			if (flag == "Y") Form.mode.value = "approval_y";
			else if (flag == "N") Form.mode.value = "approval_n";
			Form.method = "post";
			Form.action = "../../src/faculty/fac_action1.php";
			Form.submit();
		}
	}
}

function updateFee(Form) {
	if (Form.no.value) {
		Form.mode.value = "fee";
		Form.method = "post";
		Form.action = "../../src/faculty/fac_action.php";
		Form.submit();
	}
}

function downloadExcel(Form) {
	if (!Form.purpose.value) {
		alert("�������� �Է��ϼ���.");
		Form.purpose.focus();
		return;
	} else {
		Form.action = "../../src/faculty/fac_excel.php";
		Form.submit();
	}
}

function printReceipt(Form, state) {
	if (state != "PR") alert("������°� Paid�� �ƴմϴ�.");
	else {
		if (Form.no.value) {
			//var item = getSelectedValue(Form.item);
			//if (!item) alert("�����Ͻ� �׸��� �����ϴ�.");
			//else {
				if (popup != null && !popup.closed) popup.close();
				var URL = "../../src/popup/receipt_h.php?no=" + Form.no.value + "&item=";// + item;
				popup = window.open(URL, '_receipt','resizable=no,scrollbars=yes,status=no,width=1150,height=800');
			//}
		}
	}
}

function printInvoice(Form, state) {
	if (state != "CF") alert("������°� Confirmed�� �ƴմϴ�.");
	else {
		if (Form.no.value) {
			if (popup != null && !popup.closed) popup.close();
			var URL = "../../src/popup/invoice_h.php?no=" + Form.no.value;
			popup = window.open(URL, '_invoice','resizable=no,scrollbars=yes,status=no,width=550,height=800');
		}
	}
}

function viewRoomMail(Form, state) {
	//if (state != "AS") alert("������°� Assigned�� �ƴմϴ�.");
	//else {
		if (Form.no.value) {
			if (popup != null && !popup.closed) popup.close();
			var URL = "../../src/popup/room_mail_h.php?no=" + Form.no.value;
			popup = window.open(URL, '_roommail','resizable=no,scrollbars=yes,status=no,width=600,height=600');
		}
	//}
}

function copyFacility(Form) {
	if (Form.no.value) {
		var flag = confirm("�ü������� �����Ͻðڽ��ϱ�?");
		if (flag) {
			Form.mode.value = "copy";
			Form.method = "post";
			Form.action = "../../src/faculty/fac_action.php";
			Form.submit();
		}
	}
}

function gotoMonth(Form, yr, mth) {
	if (yr && mth) {
		Form.year.value = yr;
		Form.month.value = mth;
		Form.action = "../../src/faculty/fac_calendar.php";
		Form.submit();
	}
}