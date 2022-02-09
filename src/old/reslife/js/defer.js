function sortList(val) {
	var dir = "ASC";
	if (document.DeferForm.sort2.value == "ASC") dir = "DESC";
	document.DeferForm.sort1.value = val;
	document.DeferForm.sort2.value = dir;
	document.DeferForm.action = "../../src/apply/defer_list.php";
	document.DeferForm.submit();
}

function gotoList() {
	document.DeferForm.action = "../../src/apply/defer_list.php";
	document.DeferForm.submit();
}

function gotoPage(page) {
	if (page != "") {
		document.DeferForm.page.value = page;
		document.DeferForm.action = "../../src/apply/defer_list.php";
		document.DeferForm.submit();
	}
}

function viewList() {
	document.DeferForm.s_type.value = "";
	document.DeferForm.s_text.value = "";
	document.DeferForm.action = "../../src/apply/defer_list.php";
	document.DeferForm.submit();
}

function viewDefer(no) {
	if (no != "") {
		document.DeferForm.no.value = no;
		document.DeferForm.action = "../../src/apply/defer_view.php";
		document.DeferForm.submit();
	}
}

function viewApplication(no) {
	if (no != "") document.location.href = "../../src/apply/app_view.php?no=" + no;
}

function checkSearchDefer(Form) {
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

function searchDefer(Form) {
	if (checkSearchDefer(Form)) {
		document.DeferForm.action = "../../src/apply/defer_list.php";
		document.DeferForm.submit();
	}
}

function approveDefer(Form) {
	var no = getSelectedValue(Form.list_no);
	if (no == "") alert("�����Ͻ� �׸��� �����ϴ�.");
	else if (Form.grant.value == "") {
		alert("���γ�¥�� ������ �ּ���.");
		Form.grant.focus();
	} else {
		Form.mode.value = "approve";
		Form.no.value = no;
		Form.method = "post";
		Form.action = "../../src/apply/defer_action.php";
		Form.submit();
	}
}

function postDefer(mode) {
	document.DeferForm.mode.value = mode;
	document.DeferForm.action = "../../src/apply/defer_post.php";
	document.DeferForm.submit();
}

function checkDeferInfo(Form) {
	if (Form.apply_no.value == "") {
		alert("������ȣ�� �Է��ϼ���.");
		Form.apply_no.focus();
		return false;
	} else if (!checkNumber(Form.apply_no.value)) {
		alert("������ȣ�� ���ڸ� �Է°����մϴ�.");
		Form.apply_no.focus();
		return false;
	}
	return true;
}

function submitDefer(Form) {
	if (checkDeferInfo(Form)) Form.submit();
}

function deleteDefer(no) {
	if (no == "") no = getSelectedValue(document.DeferForm.list_no);
	if (no == "") alert("�����Ͻ� �׸��� �����ϴ�.");
	else {
		var flag = confirm("�����Ͻ� �׸��� ���� �Ͻðڽ��ϱ�?");
		if (flag) {
			document.DeferForm.mode.value = "del";
			document.DeferForm.no.value = no;
			document.DeferForm.method = "post";
			document.DeferForm.action = "../../src/apply/defer_action.php";
			document.DeferForm.submit();
		}
	}
}

function downloadExcel() {
	if (!document.DeferForm.purpose.value) {
		alert("�������� �Է��ϼ���.");
		document.DeferForm.purpose.focus();
		return;
	} else {
		document.DeferForm.action = "../../src/apply/defer_excel.php";
		document.DeferForm.submit();
	}
}

function checkStudentInfo(Form) {
	if (popup != null && !popup.closed) popup.close();
	var URL = "../../src/popup/student_info.php?apply_no=" + Form.apply_no.value;
	popup = window.open(URL, '_info','resizable=no,scrollbars=no,status=no,width=600,height=150');
}