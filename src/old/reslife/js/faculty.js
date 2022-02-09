var total_attach = 1024 * 1024 * 1;

function sortList(Form, val) {
	var dir = "ASC";
	if (Form.sort2.value == "ASC") dir = "DESC";
	Form.sort1.value = val;
	Form.sort2.value = dir;
	Form.action = "../../src/faculty/room_list.php";
	Form.submit();
}

function gotoList(Form) {
	Form.action = "../../src/faculty/room_list.php";
	Form.submit();
}

function gotoPage(Form, page) {
	if (page) {
		Form.page.value = page;
		Form.action = "../../src/faculty/room_list.php";
		Form.submit();
	}
}

function viewList(Form) {
	Form.s_type.value = "";
	Form.s_text.value = "";
	Form.action = "../../src/faculty/room_list.php";
	Form.submit();
}

function viewFaculty(Form, no) {
	if (no) {
		Form.no.value = no;
		Form.action = "../../src/faculty/room_view.php";
		Form.submit();
	}
}

function checkSearchFaculty(Form) {
	var sdate, edate;
	Form.s_dorm.value = getSelectedValue(Form.list_dorm);
	if (Form.s_year1.value && Form.s_month1.value && Form.s_day1.value) sdate = Form.s_year1.value + Form.s_month1.value + Form.s_day1.value;
	if (Form.s_year2.value && Form.s_month2.value && Form.s_day2.value) edate = Form.s_year2.value + Form.s_month2.value + Form.s_day2.value;
	if (!(Form.s_dorm.value || (Form.s_year1.value && Form.s_month1.value && Form.s_day1.value) || (Form.s_year2.value && Form.s_month2.value && Form.s_day2.value) || Form.s_text.value)) {
		alert("�˻��Ⱓ�̳� �˻�� �Է��� �ֽʽÿ�.");
		return false;
	}
	if (sdate && edate && sdate > edate) {
		alert("�˻��Ⱓ�� �ùٸ��� �ʽ��ϴ�.");
		return false;
	}
	return true;
}

function searchFaculty(Form) {
	if (checkSearchFaculty(Form)) {
		Form.action = "../../src/faculty/room_list.php";
		Form.submit();
	}
}

function postFaculty(Form, mode) {
	Form.mode.value = mode;
	Form.action = "../../src/faculty/room_post.php";
	Form.submit();
}

function checkFacultyInfo(Form) {
	var arr_dt, det_dt;
	if (!Form.fname.value || !Form.lname.value) {
		alert("�̸��� �Է��ϼ���.");
		Form.lname.focus();
		return false;
	}
	if (Form.email.value && !checkEmail(Form.email)) return false;
	var arr_dt = Form.arr_dt.value;
	var det_dt = Form.det_dt.value;
	if (!(arr_dt.length == 10 && det_dt.length == 10)) {
		alert("���ֱⰣ�� ������ �ֽʽÿ�.");
		return false;
	}
	if (arr_dt > det_dt) {
		alert("���ֱⰣ�� �ùٸ��� �ʽ��ϴ�.");
		return false;
	}
	if (!Form.rate.value) {
		alert("�Խ����¸� ������ �ֽʽÿ�.");
		Form.rate.focus();
		return false;
	}
	if (!Form.no_room.value) {
		alert("�氳���� �Է��ϼ���.");
		Form.no_room.focus();
		return false;
	} else if (!checkNumber(Form.no_room.value)) {
		alert("�氳���� ���ڸ� �Է°����մϴ�.");
		Form.no_room.focus();
		return false;
	}
	return true;
}

function submitFaculty(Form) {
	if (checkFacultyInfo(Form)) Form.submit();
}

function deleteFaculty(Form, no) {
	if (!no) no = getSelectedValue(Form.list_no);
	if (!no) alert("�����Ͻ� �¶��������� �����ϴ�.");
	else {
		var flag = confirm("�����Ͻ� �¶��������� ���� �Ͻðڽ��ϱ�?");
		if (flag) {
			Form.mode.value = "del";
			Form.no.value = no;
			Form.method = "post";
			Form.action = "../../src/faculty/room_action.php";
			Form.submit();
		}
	}
}

function approveFaculty(Form, flag) {
	if (Form.no.value) {
		var answer = false;
		if (flag == "Y") answer = confirm("���縦 ���� �Ͻðڽ��ϱ�?");
		else if (flag == "N") answer = confirm("���縦 ��� �Ͻðڽ��ϱ�?");
		if (answer) {
			if (flag == "Y") Form.mode.value = "approval_y";
			else if (flag == "N") Form.mode.value = "approval_n";
			Form.method = "post";
			Form.action = "../../src/faculty/room_action1.php";
			Form.submit();
		}
	}
}

function setDiscount(Form, flag) {
	if (Form.no.value) {
		var answer = false;
		if (flag == "Y") answer = confirm("������ ������ �Ͻðڽ��ϱ�?");
		else if (flag == "N") answer = confirm("������ �������� �Ͻðڽ��ϱ�?");
		if (answer) {
			Form.mode.value = "discount";
			Form.discount.value = flag;
			Form.method = "post";
			Form.action = "../../src/faculty/room_action.php";
			Form.submit();
		}
	}
}

function updateFee(Form) {
	if (Form.no.value) {
		Form.mode.value = "fee";
		Form.method = "post";
		Form.action = "../../src/faculty/room_action.php";
		Form.submit();
	}
}

function setRoom(Form, mode) {
	var flag;
	if (mode == "rm_new") {
		if (!Form.room_new.value) {
			alert("ȣ���� ������ �ּ���.");
			Form.room_new.focus();
			return;
		}
		flag = confirm("ȣ���� �߰� �Ͻðڽ��ϱ�?");
	} else if (mode == "rm_del") {
		if (!Form.room_del.value) {
			alert("ȣ���� ������ �ּ���.");
			Form.room_del.focus();
			return;
		}
		flag = confirm("ȣ���� ���� �Ͻðڽ��ϱ�?");
	}
	if (flag) {
		Form.mode.value = mode;
		Form.method = "post";
		Form.action = "../../src/faculty/room_action.php";
		Form.submit();
	}
}

function downloadExcel(Form) {
	if (!Form.purpose.value) {
		alert("�������� �Է��ϼ���.");
		Form.purpose.focus();
		return;
	} else {
		Form.action = "../../src/faculty/room_excel.php";
		Form.submit();
	}
}

function downloadExcel1(Form) {
	Form.action = "../../src/faculty/room_excel1.php";
	Form.submit();
}

function checkPaymentInfo(Form) {
	if (!Form.pay_yy.value) {
		alert("�⵵�� �����ϼ���.");
		Form.pay_yy.focus();
		return false;
	}
	if (!Form.pay_mm.value) {
		alert("���� �����ϼ���.");
		Form.pay_mm.focus();
		return false;
	}
	if (!Form.pay_dd.value) {
		alert("���� �����ϼ���.");
		Form.pay_dd.focus();
		return false;
	}
	if (!Form.pay_type.value) {
		alert("������ �����ϼ���.");
		Form.pay_type.focus();
		return false;
	}
	if (!Form.detail.value) {
		alert("���븦 �Է��ϼ���.");
		Form.detail.focus();
		return false;
	}
	if (!Form.price.value) {
		alert("�ݾ��� �Է��ϼ���.");
		Form.price.focus();
		return false;
	} else if (!checkNumber(Form.price.value)) {
		alert("�ݾ��� ���ڸ� �Է°����մϴ�.");
		Form.price.focus();
		return false;
	}
	return true;
}

function submitPayment(Form) {
	if (checkPaymentInfo(Form)) {
		Form.mode.value = "pay_new";
		Form.method = "post";
		Form.action = "../../src/faculty/room_action.php";
		Form.submit();
	}
}

function deletePayment(Form) {
	var no = getSelectedValue(Form.list_no);
	if (!no) alert("�����Ͻ� �Աݳ����� �����ϴ�.");
	else {
		var flag = confirm("�����Ͻ� �Աݳ����� ���� �Ͻðڽ��ϱ�?");
		if (flag) {
			Form.mode.value = "pay_del";
			Form.pay_no.value = no;
			Form.method = "post";
			Form.action = "../../src/faculty/room_action.php";
			Form.submit();
		}
	}
}

function updatePayment(Form) {
	var no = getOneValue(Form.update_no);
	if (no == "" || no == "over") alert("�����Ͻ� �Աݳ����� �����ϴ�.");
	else if (checkPaymentInfo(Form)) {
		var flag = confirm("�����Ͻ� �Աݳ����� ���� �Ͻðڽ��ϱ�?");
		if (flag) {
			Form.mode.value = "pay_edit";
			Form.pay_no.value = no;
			Form.method = "post";
			Form.action = "../../src/faculty/room_action.php";
			Form.submit();
		}
	}
}

function showUpdateInfo(Form, radio, yy, mm, dd, detail, price) {
	if (radio.checked) {
		setSelected(Form.pay_yy, yy);
		setSelected(Form.pay_mm, mm);
		setSelected(Form.pay_dd, dd);
		setSelected(Form.detail, detail);
		Form.price.value = Math.abs(parseInt(price));
		if (parseInt(price) < 0) setSelected(Form.pay_type, "-");
		else setSelected(Form.pay_type, "+");
	}
}

function printReceipt(Form, no) {
	if (no) {
		var receipt_no = getSelectedValue(Form.list_receipt);
		if (!receipt_no) alert("�����Ͻ� �Աݳ����� �����ϴ�.");
		else {
			if (popup != null && !popup.closed) popup.close();
			var URL = "../../src/popup/receipt_f.php?no=" + no + "&receipt_no=" + receipt_no + "&dt=" + Form.invoice_dt.value;
			popup = window.open(URL, '_receipt','resizable=no,scrollbars=yes,status=no,width=1150,height=800');
		}
	}
}

function printInvoice(Form, no) {
	if (no) {
		var invoice_no = getSelectedValue(Form.list_invoice);
		if (!invoice_no) alert("�����Ͻ� �Աݳ����� �����ϴ�.");
		else {
			if (popup != null && !popup.closed) popup.close();
			var URL = "../../src/popup/invoice_f.php?no=" + no + "&invoice_no=" + invoice_no + "&dt=" + Form.invoice_dt.value;
			popup = window.open(URL, '_invoice','resizable=no,scrollbars=yes,status=no,width=550,height=800');
		}
	}
	/*
	if (no) {
		if (Form.invoice_dt.value == "") {
			alert("�κ��̽� ���� ������ �ּ���.");
			Form.invoice_dt.focus();
		} else {
			if (popup != null && !popup.closed) popup.close();
			var URL = "../../src/popup/invoice_f.php?no=" + no + "&dt=" + Form.invoice_dt.value;
			popup = window.open(URL, '_invoice','resizable=no,scrollbars=yes,status=no,width=550,height=800');
		}
	}
	*/
}

function viewRoomMail(Form, rate, room) {
	if (!rate) alert("���� ��Ÿ���� �����Ǿ� ���� �ʽ��ϴ�.");
	else if (!room) alert("���� ������� �Ǿ� ���� �ʽ��ϴ�.");
	else if (rate && room) {
		if (Form.no.value) {
			if (popup != null && !popup.closed) popup.close();
			var URL = "../../src/popup/room_mail_f.php?no=" + Form.no.value;
			popup = window.open(URL, '_roommail','resizable=no,scrollbars=yes,status=no,width=600,height=600');
		}
	}
}

function copyRoomRate(Form) {
	if (Form.no.value) {
		if (!Form.rate.value) {
			alert("�Խ����¸� ������ �ֽʽÿ�.");
			Form.rate.focus();
			return;
		}
		var flag = confirm("�����Ͻ� �Խ����·� ���ǿ����� �����Ͻðڽ��ϱ�?");
		if (flag) {
			Form.mode.value = "copy";
			Form.method = "post";
			Form.action = "../../src/faculty/room_action.php";
			Form.submit();
		}
	}
}

function gotoMonth(Form, yr, mth) {
	if (yr && mth) {
		Form.year.value = yr;
		Form.month.value = mth;
		Form.action = "../../src/faculty/room_calendar.php";
		Form.submit();
	}
}

function checkAttachmentInfo(Form) {
	if (!checkAttachment(Form.attach)) return false;
	return true
}

function submitAttachment(Form) {
	if (checkAttachmentInfo(Form)) {
		Form.mode.value = "att_new";
		Form.submit();
	}
}

function deleteAttachment(Form) {
	var no = getSelectedValue(Form.list_att);
	if (!no) alert("�����Ͻ� ������ �����ϴ�.");
	else {
		var flag = confirm("�����Ͻ� ������ ���� �Ͻðڽ��ϱ�?");
		if (flag) {
			Form.mode.value = "att_del";
			Form.att_no.value = no;
			Form.action = "../../src/faculty/room_action.php";
			Form.submit();
		}
	}
}