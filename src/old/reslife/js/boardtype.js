function viewInfo(Form) {
	document.location.href = "../../src/board/setting.php?no=" + Form.no.value;
}

function checkSettingInfo(Form) {
	if (Form.name.value == "") {
		alert("게시판 이름을 입력하세요.");
		Form.name.focus();
		Form.name.select();
		return false;
	}
	if (Form.notice_no.value == "") {
		alert("공지글 최대 개수를 입력하세요.");
		Form.notice_no.focus();
		Form.notice_no.select();
		return false;
	}
	if (!checkNumber(Form.notice_no.value)) {
		alert("공지글 최대 개수는 숫자만 입력가능합니다.");
		Form.notice_no.focus();
		Form.notice_no.select();
		return false;
	}
	if (Form.list_no.value == "") {
		alert("리스트에 나타낼 줄수를 입력하세요.");
		Form.list_no.focus();
		Form.list_no.select();
		return false;
	}
	if (!checkNumber(Form.list_no.value)) {
		alert("리스트에 나타낼 줄수는 숫자만 입력가능합니다.");
		Form.list_no.focus();
		Form.list_no.select();
		return false;
	}
	if (Form.new_no.value == "") {
		alert("NEW 표시를 해 줄 기간을 입력하세요.");
		Form.new_no.focus();
		Form.new_no.select();
		return false;
	}
	if (!checkNumber(Form.new_no.value)) {
		alert("NEW 표시를 해 줄 기간은 숫자만 입력가능합니다.");
		Form.new_no.focus();
		Form.new_no.select();
		return false;
	}
	if (Form.hot_no.value == "") {
		alert("HOT 표시를 해 줄 조회수를 입력하세요.");
		Form.hot_no.focus();
		Form.hot_no.select();
		return false;
	}
	if (!checkNumber(Form.hot_no.value)) {
		alert("HOT 표시를 해 줄 조회수는 숫자만 입력가능합니다.");
		Form.hot_no.focus();
		Form.hot_no.select();
		return false;
	}
	if (Form.att_size.value == "") {
		alert("첨부가능한 최대 사진파일크기를 입력하세요.");
		Form.att_size.focus();
		Form.att_size.select();
		return false;
	}
	if (!checkNumber(Form.att_size.value)) {
		alert("첨부가능한 최대 사진파일크기는 숫자만 입력가능합니다.");
		Form.att_size.focus();
		Form.att_size.select();
		return false;
	}
	return true;
}

function saveSetting(Form) {
	if (checkSettingInfo(Form)) Form.submit();
}