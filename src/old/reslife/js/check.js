function checkID(id) {
	if (id.value == "") {
		alert("아이디를 입력하세요.");
		id.focus();
		id.select();
		return false;
	}
	if (id.value.length < 4 || id.value.length > 15) {
		alert("아이디는 4자 이상 15자 이하를 사용하셔야 합니다.");
		id.focus();
		id.select();
		return false;
	}
	if (checkSpace(id.value)) {
		alert ("아이디에는 빈칸이 있을수 없습니다.");
		id.focus();
		id.select();
		return false;
	}
	if (checkLetter(id.value)) {
		alert("아이디는 영어나 숫자만 사용하셔야 합니다.");
		id.focus();
		id.select();
		return false;
	}
	return true;
}

function checkName(name) {
	if (name.value == "") {
		alert("이름을 입력하세요.");
		name.focus();
		return false;
	}
	return true;
}

function checkPassword(pw, repw) {
	if (pw.value == "") {
		alert("비밀번호를 입력하세요.");
		pw.focus();
		pw.select();
		return false;
	}
	if (pw.value.length < 4 || pw.value.length > 15) {
		alert("비밀번호는 4자 이상 15자 이하를 사용하셔야 합니다.");
		pw.focus();
		pw.select();
		return false;
	}
	if (checkSpace(pw.value)) {
		alert ("비밀번호에는 빈칸이 있을 수 없습니다.");
		pw.focus();
		pw.select();
		return false;
	}
	if (checkSpace(repw.value)) {
		alert ("비밀번호에는 빈칸이 있을 수 없습니다.");
		repw.focus();
		repw.select();
		return false;
	}
	if (pw.value != repw.value) {
		alert("비밀번호가 일치하지 않습니다.");
		pw.value = repw.value = "";
		pw.focus();
		pw.select();
		return false;
	}
	return true;
}

function checkEmail(email) {
	if (email.value == "") {
		alert("이메일을 입력해주세요.");
		email.focus();
		email.select();
		return false;
	}
	if (email.value.indexOf(" ") != -1) {
		alert("이메일에는 공백이 허용되지 않습니다.");
		email.focus();
		email.select();
		return false;
	}
	if (email.value.indexOf("+") > -1) {
		alert("'+' 는 이메일에 포함될 수 없습니다.");
		email.focus();
		email.select();
		return false;
	}
	if (email.value.indexOf("/") > -1) {
		alert("'/' 는 이메일에 포함될 수 없습니다.");
		email.focus();
		email.select();
		return false;
	}
	if (email.value.indexOf(":") > -1) {
		alert("':' 는 이메일에 포함될 수 없습니다."); 
		email.focus();
		email.select();
		return false;
	}
	if (email.value.indexOf("@") < 1) {
		alert("이메일에는 '@'가 누락되었습니다.");
		email.focus();
		email.select();
		return false;
	}
	if (email.value.indexOf(".") == -1) {
		alert("이메일에서 '.'이 누락되었습니다.");
		email.focus();
		email.select();
		return false;
	}
	if (email.value.indexOf(".") - email.value.indexOf("@") == 1) {
		alert("이메일에는 '@' 다음에 바로 '.'이 올 수 없습니다.");
		email.focus();
		email.select();
		return false;
	}
	if (email.value.charAt(email.value.length-1) == '.') {
		alert("'.'은 이메일 끝에 올 수 없습니다.");
		email.focus();
		email.select();
		return false;
	}
	return true;
}

function checkAddress(addr1, addr2) {
	if (addr1.value == "") {
		alert("우편번호검색 버튼을 클릭해서 주소를 입력해주세요.");
		addr1.focus();
		addr1.select();
		return false;
	} else {
		if (addr2.value == "") {
			alert("상세주소를 입력해주세요.");
			addr2.focus();
			addr2.select();
			return false;
		}
	}
	return true;
}

function checkPhone(ph1, ph2, ph3) {
	if (ph1.value == "" || ph2.value == "" || ph3.value == "") {
		alert("전화번호를 입력하세요.");
		ph1.focus();
		ph1.select();
		return false;
	}
	if (!checkNumber(ph1.value)) {
		alert("전화번호는 숫자만 입력가능합니다.");
		ph1.focus();
		ph1.select();
		return false;
	}
	if (!checkNumber(ph2.value)) {
		alert("전화번호는 숫자만 입력가능합니다.");
		ph2.focus();
		ph2.select();
		return false;
	}
	if (!checkNumber(ph3.value)) {
		alert("전화번호는 숫자만 입력가능합니다.");
		ph3.focus();
		ph3.select();
		return false;
	}
	return true;
}

function checkMobile(mobile1, mobile2, mobile3) {
	if (!checkNumber(mobile1.value)) {
		alert("휴대폰번호는 숫자만 입력가능합니다.");
		mobile1.focus();
		mobile1.select();
		return false;
	}
	if (!checkNumber(mobile2.value)) {
		alert("휴대폰번호는 숫자만 입력가능합니다.");
		mobile2.focus();
		mobile2.select();
		return false;
	}
	if (!checkNumber(mobile3.value)) {
		alert("휴대폰번호는 숫자만 입력가능합니다.");
		mobile3.focus();
		mobile3.select();
		return false;
	}
	return true;
}

function checkFax(fax1, fax2, fax3) {
	if (!checkNumber(fax1.value)) {
		alert("팩스번호는 숫자만 입력가능합니다.");
		fax1.focus();
		fax1.select();
		return false;
	}
	if (!checkNumber(fax2.value)) {
		alert("팩스번호는 숫자만 입력가능합니다.");
		fax2.focus();
		fax2.select();
		return false;
	}
	if (!checkNumber(fax3.value)) {
		alert("팩스번호는 숫자만 입력가능합니다.");
		fax3.focus();
		fax3.select();
		return false;
	}
	return true;
}

function checkSSN(ssn1, ssn2) {
	if (ssn1.value == "") {
		alert("주민등록번호 앞자리를 입력하세요.");
		ssn1.focus();
		ssn1.select();
		return false;
	}
	if (ssn2.value == "") {
		alert("주민등록번호 뒷자리를 입력하세요.");
		ssn2.focus();
		ssn2.select();
		return false;
	}
	if (!checkNumber(ssn1.value)) {
		alert("주민등록번호는 숫자만 입력가능합니다.");
		ssn1.focus();
		ssn1.select();
		return false; 
	}
	if (!checkNumber(ssn2.value)) {
		alert("주민등록번호는 숫자만 입력가능합니다.");
		ssn2.focus();
		ssn2.select();
		return false;
	}
	if (ssn1.value.length > 0 && ssn1.value.length != 6) {
		alert("주민등록번호에 오류가 있습니다.");
		ssn1.focus();
		ssn1.select();
		return false;
	}
	if (ssn2.value.length > 0 && ssn2.value.length != 7) {
		alert("주민등록 번호에 오류가 있습니다.");
		ssn1.focus();
		ssn1.select();
		return false;
	}
	if (ssn1.value.length == 6 && ssn2.value.length == 7) {
		var temp = "" + ssn1.value + ssn2.value;
		if (!checkJuminNumber(temp) && !checkForeignNumber(temp)) {
			alert("주민등록번호가 바르지 않습니다.");
			ssn1.focus();
			ssn1.select();
			return false;
		}
	}
	return true;
}

function checkPhoto(attach) {
	if (attach.value == "") {
		alert("사진파일을 선택해 주십시오.");
		attach.focus();
		return false;
	} else {
		if (!(attach.value.toLowerCase().match("\.jpg") || attach.value.toLowerCase().match("\.gif"))) {
			alert("이미지 파일이 아닙니다.\n다시 선택하세요.");
			attach.focus();
			return false;
		}
	}
	return true;
}

function checkAttachment(attach) {
	if (attach.value == "") {
		alert("파일을 선택해 주십시오.");
		attach.focus();
		return false;
	} else {
		if (attach.value.toLowerCase().match("\.exe") || attach.value.toLowerCase().match("\.php") || attach.value.toLowerCase().match("\.cgi") || attach.value.toLowerCase().match("\.htm") || attach.value.toLowerCase().match("\.html")) {
			alert("실행 파일 혹은 스크립트 파일은 첨부가 불가능합니다.");
			attach.focus();
			return false;
		}
	}
	return true;
}

function checkUpload(attach) {
	if (!attach.value) {
		alert("업로드할 파일을 선택해 주십시오.");
		attach.focus();
		return false;
	} else {
		if (!(attach.value.toLowerCase().match("\.csv"))) {
			alert("CSV 파일이 아닙니다.\n\nCSV 형식의 엑셀 파일만 가능합니다.");
			attach.focus();
			return false;
		}
	}
	return true;
}