var total_attach = 1024 * 1024 * 1;

function sortList(val) {
	var dir = "ASC";
	if (document.MailForm.sort2.value == "ASC") dir = "DESC";
	document.MailForm.sort1.value = val;
	document.MailForm.sort2.value = dir;
	document.MailForm.action = "../../src/mail/mailbox.php";
	document.MailForm.submit();
}

function gotoPage(page) {
	if (page != "") {
		document.MailForm.page.value = page;
		document.MailForm.action = "../../src/mail/mailbox.php";
		document.MailForm.submit();
	}
}

function viewMail(no) {
	document.MailForm.no.value = no;
	document.MailForm.action = "../../src/mail/mail.php";
	document.MailForm.submit();
}

function searchMail() {
	if (checkSearchInfo(document.MailForm.s_text, document.MailForm.page)) {
		document.MailForm.action = "../../src/mail/mailbox.php";
		document.MailForm.submit();
	}
}

function deleteMail() {
	var no = getSelectedValue(document.MailForm.list_no);
	if (no == "") alert("선택하신 발송메일이 없습니다.");
	else {
		var flag = confirm("선택하신 발송메일을 삭제 하시겠습니까?");
		if (flag) {
			document.MailForm.mode.value = "del";
			document.MailForm.no.value = no;
			document.MailForm.method = "post";
			document.MailForm.action = "../../src/mail/sendmail.php";
			document.MailForm.submit();
		}
	}
}

function checkMailInfo(Form) {
	if (Form.email.value != "grad_mem" && Form.email.value != "grad_app" && Form.email.value != "mem" && Form.email.value != "app" && Form.email.value != "stu" && Form.email.value != "lan" && Form.email.value != "fac" && Form.email.value != "hall" && Form.email.value != "defer" && !checkEmail(Form.to)) return false;
	if (Form.subject.value == "") {
		alert("제목을 입력해 주십시오.");
		Form.subject.focus();
		return false;
	}
	if (Form.attach.value != "" && !checkPhoto(Form.attach)) return false;
	calculateFileSize(Form.attach, document.getElementById('photo_size'), Form.total_photo);
	if (Form.total_photo.value >= total_attach) {
		alert("첨부할 수 있는 용량은 최대 " + Math.round(total_attach / 1024) + " KB(" + Math.round(total_attach / 1024 / 1024) + " MB)까지 가능합니다.");
		Form.attach.focus();
		return false;
	}
	return true;
}

function sendMail(Form) {
	if (checkMailInfo(Form)) {
		Form.target = "_top";
		Form.method = "post";
		Form.action = "../../src/mail/sendmail.php";
		Form.submit();
	}
}

function previewMail(Form) {
	if (checkMailInfo(document.MailForm)) {
		if (popup != null && !popup.closed) popup.close();
		popup = window.open('../../tpl/popup/blank.html', '_Mail', 'resizable=yes,scrollbars=yes,width=660,height=400');
		if (document.MailForm.attach.value) Form.attach.value = getImagePath(document.MailForm.attach.value);
		else if (document.MailForm.mail_no.value) Form.mail_no.value = document.MailForm.mail_no.value;
		Form.msg.value = document.MailForm.msg.value;
		Form.target = "_Mail";
		Form.action = "../../src/popup/mail.php";
		Form.submit();
	}
}