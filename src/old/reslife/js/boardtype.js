function viewInfo(Form) {
	document.location.href = "../../src/board/setting.php?no=" + Form.no.value;
}

function checkSettingInfo(Form) {
	if (Form.name.value == "") {
		alert("�Խ��� �̸��� �Է��ϼ���.");
		Form.name.focus();
		Form.name.select();
		return false;
	}
	if (Form.notice_no.value == "") {
		alert("������ �ִ� ������ �Է��ϼ���.");
		Form.notice_no.focus();
		Form.notice_no.select();
		return false;
	}
	if (!checkNumber(Form.notice_no.value)) {
		alert("������ �ִ� ������ ���ڸ� �Է°����մϴ�.");
		Form.notice_no.focus();
		Form.notice_no.select();
		return false;
	}
	if (Form.list_no.value == "") {
		alert("����Ʈ�� ��Ÿ�� �ټ��� �Է��ϼ���.");
		Form.list_no.focus();
		Form.list_no.select();
		return false;
	}
	if (!checkNumber(Form.list_no.value)) {
		alert("����Ʈ�� ��Ÿ�� �ټ��� ���ڸ� �Է°����մϴ�.");
		Form.list_no.focus();
		Form.list_no.select();
		return false;
	}
	if (Form.new_no.value == "") {
		alert("NEW ǥ�ø� �� �� �Ⱓ�� �Է��ϼ���.");
		Form.new_no.focus();
		Form.new_no.select();
		return false;
	}
	if (!checkNumber(Form.new_no.value)) {
		alert("NEW ǥ�ø� �� �� �Ⱓ�� ���ڸ� �Է°����մϴ�.");
		Form.new_no.focus();
		Form.new_no.select();
		return false;
	}
	if (Form.hot_no.value == "") {
		alert("HOT ǥ�ø� �� �� ��ȸ���� �Է��ϼ���.");
		Form.hot_no.focus();
		Form.hot_no.select();
		return false;
	}
	if (!checkNumber(Form.hot_no.value)) {
		alert("HOT ǥ�ø� �� �� ��ȸ���� ���ڸ� �Է°����մϴ�.");
		Form.hot_no.focus();
		Form.hot_no.select();
		return false;
	}
	if (Form.att_size.value == "") {
		alert("÷�ΰ����� �ִ� ��������ũ�⸦ �Է��ϼ���.");
		Form.att_size.focus();
		Form.att_size.select();
		return false;
	}
	if (!checkNumber(Form.att_size.value)) {
		alert("÷�ΰ����� �ִ� ��������ũ��� ���ڸ� �Է°����մϴ�.");
		Form.att_size.focus();
		Form.att_size.select();
		return false;
	}
	return true;
}

function saveSetting(Form) {
	if (checkSettingInfo(Form)) Form.submit();
}