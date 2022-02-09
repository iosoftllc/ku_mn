function swapLayers(no, display) {
	var i, obj;
	for (i = 1; i <= main_count; i++) {
		obj = document.getElementById("Layer" + i);
		if (obj != null) {
			if (obj.style && i == no && obj.style.visibility != display) obj.style.visibility = display;
			else if (obj.style.visibility != "hidden") obj.style.visibility = "hidden";
		}
	}
	if (no != main_menu && display == "hidden") {
		obj = document.getElementById("Layer" + main_menu);
		if (obj != null) obj.style.visibility = "visible";
	} else if (no == main_menu) {
		obj = document.getElementById("Layer" + main_menu);
		if (obj != null) obj.style.visibility = "visible";
	}
}

function logout() {
	var ans = confirm("로그아웃 하시겠습니까?");
	if (ans == true) top.location = "../../src/main/logout.php";
	else return;
}

function sendEmail(Form, email) {
	if (email == "grad_mem" || email == "grad_app" || email == "mem" || email == "app" || email == "stu" || email == "lan" || email == "fac" || email == "hall" || email == "defer") {
		Form.email.value = email;
		Form.action = "../../src/mail/mail.php";
		Form.submit();
	} else if (email == "list") {
		//email = getMultipleValue(Form.list_no, Form.list_email);
		//if (!email) alert("선택한 이메일이 없습니다.");
		//else document.location.href = "../../src/mail/mail.php?email=" + email;
	} else document.location.href = "../../src/mail/mail.php?email=" + email;
}

function previewUpload(attach) {
	if (!checkPhoto(attach)) return;
	var img_url = getImagePath(attach.value);
	if (popup != null && !popup.closed) popup.close();
	var URL = "../../src/popup/preview.php?url=" + img_url;
  popup = window.open(URL, '_View', 'resizable=yes,scrollbars=yes,width=400,height=400');
}

function previewImage(img_url) {
	if (img_url != "") {
		if (popup != null && !popup.closed) popup.close();
		var URL = "../../src/popup/preview.php?url=" + img_url;
  	popup = window.open(URL, '_View', 'resizable=yes,scrollbars=yes,width=400,height=400');
  }
}

function viewStudent(no) {
	if (no != "") document.location.href = "../../src/apply/stu_view.php?no=" + no;
}