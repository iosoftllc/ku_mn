function checkID(id) {
	if (id.value == "") {
		alert("���̵� �Է��ϼ���.");
		id.focus();
		id.select();
		return false;
	}
	if (id.value.length < 4 || id.value.length > 15) {
		alert("���̵�� 4�� �̻� 15�� ���ϸ� ����ϼž� �մϴ�.");
		id.focus();
		id.select();
		return false;
	}
	if (checkSpace(id.value)) {
		alert ("���̵𿡴� ��ĭ�� ������ �����ϴ�.");
		id.focus();
		id.select();
		return false;
	}
	if (checkLetter(id.value)) {
		alert("���̵�� ��� ���ڸ� ����ϼž� �մϴ�.");
		id.focus();
		id.select();
		return false;
	}
	return true;
}

function checkName(name) {
	if (name.value == "") {
		alert("�̸��� �Է��ϼ���.");
		name.focus();
		return false;
	}
	return true;
}

function checkPassword(pw, repw) {
	if (pw.value == "") {
		alert("��й�ȣ�� �Է��ϼ���.");
		pw.focus();
		pw.select();
		return false;
	}
	if (pw.value.length < 4 || pw.value.length > 15) {
		alert("��й�ȣ�� 4�� �̻� 15�� ���ϸ� ����ϼž� �մϴ�.");
		pw.focus();
		pw.select();
		return false;
	}
	if (checkSpace(pw.value)) {
		alert ("��й�ȣ���� ��ĭ�� ���� �� �����ϴ�.");
		pw.focus();
		pw.select();
		return false;
	}
	if (checkSpace(repw.value)) {
		alert ("��й�ȣ���� ��ĭ�� ���� �� �����ϴ�.");
		repw.focus();
		repw.select();
		return false;
	}
	if (pw.value != repw.value) {
		alert("��й�ȣ�� ��ġ���� �ʽ��ϴ�.");
		pw.value = repw.value = "";
		pw.focus();
		pw.select();
		return false;
	}
	return true;
}

function checkEmail(email) {
	if (email.value == "") {
		alert("�̸����� �Է����ּ���.");
		email.focus();
		email.select();
		return false;
	}
	if (email.value.indexOf(" ") != -1) {
		alert("�̸��Ͽ��� ������ ������ �ʽ��ϴ�.");
		email.focus();
		email.select();
		return false;
	}
	if (email.value.indexOf("+") > -1) {
		alert("'+' �� �̸��Ͽ� ���Ե� �� �����ϴ�.");
		email.focus();
		email.select();
		return false;
	}
	if (email.value.indexOf("/") > -1) {
		alert("'/' �� �̸��Ͽ� ���Ե� �� �����ϴ�.");
		email.focus();
		email.select();
		return false;
	}
	if (email.value.indexOf(":") > -1) {
		alert("':' �� �̸��Ͽ� ���Ե� �� �����ϴ�."); 
		email.focus();
		email.select();
		return false;
	}
	if (email.value.indexOf("@") < 1) {
		alert("�̸��Ͽ��� '@'�� �����Ǿ����ϴ�.");
		email.focus();
		email.select();
		return false;
	}
	if (email.value.indexOf(".") == -1) {
		alert("�̸��Ͽ��� '.'�� �����Ǿ����ϴ�.");
		email.focus();
		email.select();
		return false;
	}
	if (email.value.indexOf(".") - email.value.indexOf("@") == 1) {
		alert("�̸��Ͽ��� '@' ������ �ٷ� '.'�� �� �� �����ϴ�.");
		email.focus();
		email.select();
		return false;
	}
	if (email.value.charAt(email.value.length-1) == '.') {
		alert("'.'�� �̸��� ���� �� �� �����ϴ�.");
		email.focus();
		email.select();
		return false;
	}
	return true;
}

function checkAddress(addr1, addr2) {
	if (addr1.value == "") {
		alert("�����ȣ�˻� ��ư�� Ŭ���ؼ� �ּҸ� �Է����ּ���.");
		addr1.focus();
		addr1.select();
		return false;
	} else {
		if (addr2.value == "") {
			alert("���ּҸ� �Է����ּ���.");
			addr2.focus();
			addr2.select();
			return false;
		}
	}
	return true;
}

function checkPhone(ph1, ph2, ph3) {
	if (ph1.value == "" || ph2.value == "" || ph3.value == "") {
		alert("��ȭ��ȣ�� �Է��ϼ���.");
		ph1.focus();
		ph1.select();
		return false;
	}
	if (!checkNumber(ph1.value)) {
		alert("��ȭ��ȣ�� ���ڸ� �Է°����մϴ�.");
		ph1.focus();
		ph1.select();
		return false;
	}
	if (!checkNumber(ph2.value)) {
		alert("��ȭ��ȣ�� ���ڸ� �Է°����մϴ�.");
		ph2.focus();
		ph2.select();
		return false;
	}
	if (!checkNumber(ph3.value)) {
		alert("��ȭ��ȣ�� ���ڸ� �Է°����մϴ�.");
		ph3.focus();
		ph3.select();
		return false;
	}
	return true;
}

function checkMobile(mobile1, mobile2, mobile3) {
	if (!checkNumber(mobile1.value)) {
		alert("�޴�����ȣ�� ���ڸ� �Է°����մϴ�.");
		mobile1.focus();
		mobile1.select();
		return false;
	}
	if (!checkNumber(mobile2.value)) {
		alert("�޴�����ȣ�� ���ڸ� �Է°����մϴ�.");
		mobile2.focus();
		mobile2.select();
		return false;
	}
	if (!checkNumber(mobile3.value)) {
		alert("�޴�����ȣ�� ���ڸ� �Է°����մϴ�.");
		mobile3.focus();
		mobile3.select();
		return false;
	}
	return true;
}

function checkFax(fax1, fax2, fax3) {
	if (!checkNumber(fax1.value)) {
		alert("�ѽ���ȣ�� ���ڸ� �Է°����մϴ�.");
		fax1.focus();
		fax1.select();
		return false;
	}
	if (!checkNumber(fax2.value)) {
		alert("�ѽ���ȣ�� ���ڸ� �Է°����մϴ�.");
		fax2.focus();
		fax2.select();
		return false;
	}
	if (!checkNumber(fax3.value)) {
		alert("�ѽ���ȣ�� ���ڸ� �Է°����մϴ�.");
		fax3.focus();
		fax3.select();
		return false;
	}
	return true;
}

function checkSSN(ssn1, ssn2) {
	if (ssn1.value == "") {
		alert("�ֹε�Ϲ�ȣ ���ڸ��� �Է��ϼ���.");
		ssn1.focus();
		ssn1.select();
		return false;
	}
	if (ssn2.value == "") {
		alert("�ֹε�Ϲ�ȣ ���ڸ��� �Է��ϼ���.");
		ssn2.focus();
		ssn2.select();
		return false;
	}
	if (!checkNumber(ssn1.value)) {
		alert("�ֹε�Ϲ�ȣ�� ���ڸ� �Է°����մϴ�.");
		ssn1.focus();
		ssn1.select();
		return false; 
	}
	if (!checkNumber(ssn2.value)) {
		alert("�ֹε�Ϲ�ȣ�� ���ڸ� �Է°����մϴ�.");
		ssn2.focus();
		ssn2.select();
		return false;
	}
	if (ssn1.value.length > 0 && ssn1.value.length != 6) {
		alert("�ֹε�Ϲ�ȣ�� ������ �ֽ��ϴ�.");
		ssn1.focus();
		ssn1.select();
		return false;
	}
	if (ssn2.value.length > 0 && ssn2.value.length != 7) {
		alert("�ֹε�� ��ȣ�� ������ �ֽ��ϴ�.");
		ssn1.focus();
		ssn1.select();
		return false;
	}
	if (ssn1.value.length == 6 && ssn2.value.length == 7) {
		var temp = "" + ssn1.value + ssn2.value;
		if (!checkJuminNumber(temp) && !checkForeignNumber(temp)) {
			alert("�ֹε�Ϲ�ȣ�� �ٸ��� �ʽ��ϴ�.");
			ssn1.focus();
			ssn1.select();
			return false;
		}
	}
	return true;
}

function checkPhoto(attach) {
	if (attach.value == "") {
		alert("���������� ������ �ֽʽÿ�.");
		attach.focus();
		return false;
	} else {
		if (!(attach.value.toLowerCase().match("\.jpg") || attach.value.toLowerCase().match("\.gif"))) {
			alert("�̹��� ������ �ƴմϴ�.\n�ٽ� �����ϼ���.");
			attach.focus();
			return false;
		}
	}
	return true;
}

function checkAttachment(attach) {
	if (attach.value == "") {
		alert("������ ������ �ֽʽÿ�.");
		attach.focus();
		return false;
	} else {
		if (attach.value.toLowerCase().match("\.exe") || attach.value.toLowerCase().match("\.php") || attach.value.toLowerCase().match("\.cgi") || attach.value.toLowerCase().match("\.htm") || attach.value.toLowerCase().match("\.html")) {
			alert("���� ���� Ȥ�� ��ũ��Ʈ ������ ÷�ΰ� �Ұ����մϴ�.");
			attach.focus();
			return false;
		}
	}
	return true;
}

function checkUpload(attach) {
	if (!attach.value) {
		alert("���ε��� ������ ������ �ֽʽÿ�.");
		attach.focus();
		return false;
	} else {
		if (!(attach.value.toLowerCase().match("\.csv"))) {
			alert("CSV ������ �ƴմϴ�.\n\nCSV ������ ���� ���ϸ� �����մϴ�.");
			attach.focus();
			return false;
		}
	}
	return true;
}