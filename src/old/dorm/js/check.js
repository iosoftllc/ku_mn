function checkName(name) {
	if (name.value == "") {
		alert("Please input your name.");
		name.focus();
		return false;
	}
	return true;
}

function checkPassword(pw, repw) {
	if (pw.value == "") {
		alert("Please input your password.");
		pw.focus();
		pw.select();
		return false;
	}
	if (pw.value.length < 4 || pw.value.length > 15) {
		alert("Your password should be between 4 and 15 characters.");
		pw.focus();
		pw.select();
		return false;
	}
	if (checkSpace(pw.value)) {
		alert ("The space is not allowed in your password.");
		pw.focus();
		pw.select();
		return false;
	}
	if (checkSpace(repw.value)) {
		alert ("The space is not allowed in your password.");
		repw.focus();
		repw.select();
		return false;
	}
	if (pw.value != repw.value) {
		alert("The password does not match.");
		pw.value = repw.value = "";
		pw.focus();
		pw.select();
		return false;
	}
	return true;
}

function checkEmail(email) {
	if (email.value == "") {
		alert("Please input your email.");
		email.focus();
		email.select();
		return false;
	}
	if (email.value.indexOf(" ") != -1) {
		alert("The space is not allowed in your email.");
		email.focus();
		email.select();
		return false;
	}
	if (email.value.indexOf("+") > -1) {
		alert("'+' is not allowed in your email.");
		email.focus();
		email.select();
		return false;
	}
	if (email.value.indexOf("/") > -1) {
		alert("'/' is not allowed in your email.");
		email.focus();
		email.select();
		return false;
	}
	if (email.value.indexOf(":") > -1) {
		alert("':' is not allowed in your email."); 
		email.focus();
		email.select();
		return false;
	}
	if (email.value.indexOf("@") < 1) {
		alert("'@' should be in your email.");
		email.focus();
		email.select();
		return false;
	}
	if (email.value.indexOf(".") == -1) {
		alert("'.' should be in your email.");
		email.focus();
		email.select();
		return false;
	}
	if (email.value.indexOf(".") - email.value.indexOf("@") == 1) {
		alert("'.' is not allowed next to '@' in your email.");
		email.focus();
		email.select();
		return false;
	}
	if (email.value.charAt(email.value.length-1) == '.') {
		alert("'.' is not allowed at the end of your email.");
		email.focus();
		email.select();
		return false;
	}
	if (email.value.toLowerCase().match("hanmail.net") || email.value.toLowerCase().match("daum.net") || email.value.toLowerCase().match("yahoo.co.jp") || email.value.toLowerCase().match("rambler.ru")) {
		alert("We are not able to reach your e-mail address ending with ...@hanmail.net / ...@yahoo.co.jp / ...@rambler.ru. Please use a different email account.");
		email.focus();
		email.select();
		return false;
	}
	return true;
}

function checkAddress(addr) {
	if (addr.value == "") {
		alert("Please input your address.");
		addr.focus();
		addr.select();
		return false;
	}
	return true;
}

function checkPhone(ph) {
	if (ph.value == "") {
		alert("Please input your phone number.");
		ph.focus();
		ph.select();
		return false;
	}
	if (!checkNumber(ph.value)) {
		alert("There should be numeric and '-' characters  in your phone number.");
		ph.focus();
		ph.select();
		return false;
	}
	return true;
}

function checkFax(fax) {
	if (fax.value == "") {
		alert("Please input your phone number.");
		fax.focus();
		fax.select();
		return false;
	}
	if (!checkNumber(fax.value)) {
		alert("There should be numeric and '-' characters  in your fax number.");
		fax.focus();
		fax.select();
		return false;
	}
	return true;
}

function checkPhoto(attach) {
	if (attach.value == "") {
		alert("Please select an image file.");
		attach.focus();
		return false;
	} else {
		if (!(attach.value.toLowerCase().match("\.jpg") || attach.value.toLowerCase().match("\.gif"))) {
			alert("Only JPG and GIF format is allowed.\nPlease try again later.");
			attach.focus();
			return false;
		}
	}
	return true;
}