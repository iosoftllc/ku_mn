var total_attach = 1024 * 1024 * 1;

function checkViewInfo(Form) {
	if (Form.email.value == "") {
		alert("Please input your email address.");
		Form.email.focus();
		return false;
	}
	if (Form.pw.value == "") {
		alert("Please input a password.");
		Form.pw.focus();
		return false;
	}
	return true;
}

function sortList(Form, val) {
	var dir = "ASC";
	if (Form.sort2.value == "ASC") dir = "DESC";
	Form.sort1.value = val;
	Form.sort2.value = dir;
	Form.action = "https://reslife.korea.ac.kr:5008/v1/src/apply/list_app.php";
	Form.submit();
}

function gotoList(Form) {
	Form.action = "https://reslife.korea.ac.kr:5008/v1/src/apply/list_app.php";
	Form.submit();
}

function viewList(Form) {
	if (Form.s_state.value == "") {
		alert("Please select Your Term.");
		Form.s_state.focus();
		return;
	}
	Form.action = "https://reslife.korea.ac.kr:5008/v1/src/apply/list_app.php";
	Form.submit();
}

function viewListInfo(Form) {
	if (Form.s_state.value == "") {
		alert("Please select Your Term.");
		Form.s_state.focus();
		return;
	}
	Form.no.value = Form.s_state.value;
	Form.action = "https://reslife.korea.ac.kr:5008/v1/src/apply/view_app.php";
	Form.submit();
}

function viewApplication(Form, no) {
	if (no != "") {
		Form.no.value = no;
		Form.action = "https://reslife.korea.ac.kr:5008/v1/src/apply/view_app.php";
		Form.submit();
	}
}

function viewPersonalInfo(Form, no) {
	if (no != "") {
		Form.no.value = no;
		Form.mode.value = "edit";
		Form.action = "https://reslife.korea.ac.kr:5008/v1/src/apply/view_stu.php";
		Form.submit();
	}
}

function gotoApplication(Form, nation, student, cla, no) {
	//alert("The online application is now closed for summer 2007.\n\nIf you want residence for this semester, please email us at reslife@korea.ac.kr.");
	//if (Form.email.value != "heeryun@korea.ac.kr" && Form.email.value != "chris59@korea.ac.kr" && Form.email.value != "webmaster@intia.co.kr" && Form.email.value != "ksh@intia.co.kr") {
		if (no != "") {
			//var today = getToday();
			//if (today < "2007-10-31") alert("The online application for the Winter 2008 term will be from October 31 to November 7.");
			//else if (today > "2007-11-07") alert("The online application for the Winter 2008 term is now closed. If you want residence for this term, please send an email to us at reslife@korea.ac.kr.");
			//else {
				//if (nation.toLowerCase().match("korea") || nation.toLowerCase().match("rok") || nation.match("한국")) {
					//if (!(student.substr(0, 6) == "200695" || student.substr(0, 6) == "200795" || cla.toLowerCase().match("m") || cla.toLowerCase().match("d"))) {
						//alert("Sorry. Local Korean Undergrads cannot apply for the summer 2007 term. Thank you.");
						//return;
					//}
				//}
				Form.no.value = no;
				Form.mode.value = "app";
				//Form.action = "https://reslife.korea.ac.kr:5008/v1/src/apply/form_stu.php";
				Form.action = "https://reslife.korea.ac.kr:5008/v1/src/apply/contract_app.php";
				Form.submit();
			//}
		}
	//} else {
		//Form.no.value = no;
		//Form.mode.value = "app";
		//Form.action = "https://reslife.korea.ac.kr:5008/v1/src/apply/form_stu.php";
		//Form.submit();
	//}
}

function gotoPayment(Form) {
	Form.action = "https://reslife.korea.ac.kr:5008/v1/src/apply/payment.php";
	Form.submit();
}

function changePassword(Form, no) {
	if (no != "") {
		Form.no.value = no;
		Form.action = "https://reslife.korea.ac.kr:5008/v1/src/apply/change_pw.php";
		Form.submit();
	}
}

function postApplication(Form, mode) {
	Form.mode.value = mode;
	Form.action = "https://reslife.korea.ac.kr:5008/v1/src/apply/app_post.php";
	Form.submit();
}

function checkApplicationInfo(Form) {
	/*
	if (Form.period && Form.rate) {
		if (!getOneValue(Form.period)) {
			alert("Please choose one of sessions applying.");
			return false;
		}
		if (!getOneValue(Form.rate)) {
			alert("Please choose one of types of room and rates.");
			return false;
		}
		//if (!checkRoomRateInfo(Form)) return false;
	}
	*/
	if (Form.period.value == "") {
		alert("Please select session applying.");
		Form.period.focus();
		return false;
	}
	if (Form.rate1.value == "") {
		alert("Please select at least two type of rooms.");
		Form.rate1.focus();
		return false;
	}
	// 여기 주석 없애서 원래대로 복귀해야 함
	if (Form.rate2.value == "") {
		alert("Please select at least two type of rooms.");
		Form.rate2.focus();
		return false;
	}
	if (Form.rate1.value == Form.rate2.value) {
		alert("You cannot select a same type of rooms.");
		Form.rate2.focus();
		return false;
	}
	/*
	if (Form.gender[1].checked) {
		if (Form.rate1.value == "3BSS" || Form.rate1.value == "3BSD") {
			alert("Single in Quint & Double in Quint are not available for male students.\n\nPlease choose other room type.");
			Form.rate1.focus();
			return false;
		}
	}
	if (Form.nation.value.toLowerCase().match("korea") || Form.nation.value.match("rok") || Form.nation.value.match("한국")) {
		if (!(Form.student.value.length == 10 && (Form.student.value.substr(4, 2) == "95" || Form.student.value.substr(4, 2) == "96"))) {
			if (Form.rate1.value == "SDTP") {
				alert("Only international students can apply for Anam 2 residence hall.\n\nPlease choose other room types.");
				Form.rate1.focus();
				return false;
			}
			if (Form.rate2.value == "SDTP") {
				alert("Only international students can apply for Anam 2 residence hall.\n\nPlease choose other room types.");
				Form.rate2.focus();
				return false;
			}
			if (Form.rate3.value == "SDTP") {
				alert("Only international students can apply for Anam 2 residence hall.\n\nPlease choose other room types.");
				Form.rate3.focus();
				return false;
			}
			if (Form.rate4.value == "SDTP") {
				alert("Only international students can apply for Anam 2 residence hall.\n\nPlease choose other room types.");
				Form.rate4.focus();
				return false;
			}
			if (Form.rate5.value == "SDTP") {
				alert("Only international students can apply for Anam 2 residence hall.\n\nPlease choose other room types.");
				Form.rate5.focus();
				return false;
			}
			if (Form.rate6.value == "SDTP") {
				alert("Only international students can apply for Anam 2 residence hall.\n\nPlease choose other room types.");
				Form.rate6.focus();
				return false;
			}
			if (Form.rate7.value == "SDTP") {
				alert("Only international students can apply for Anam 2 residence hall.\n\nPlease choose other room types.");
				Form.rate7.focus();
				return false;
			}
			if (Form.rate8.value == "SDTP") {
				alert("Only international students can apply for Anam 2 residence hall.\n\nPlease choose other room types.");
				Form.rate8.focus();
				return false;
			}
		}
	}
	if (!Form.agree_flag.checked) {
		alert("In order to apply, you should agree to comply with the University Residence regulations.");
		Form.agree_flag.focus();
		return false;
	}
	*/
	//return false;
	return true;
}

function checkUploadInfo(Form) {
	if (Form.fee_transfer.value != "" && !checkPhoto(Form.fee_transfer)) return false;
	if (Form.fee_support.value != "" && !checkPhoto(Form.fee_support)) return false;
	if (Form.tb_test.value != "" && !checkPhoto(Form.tb_test)) return false;
	return true;
}

function checkContractInfo(Form) {
	if (!Form.agree_flag.checked) {
		alert("Please agree to International House Regulations Contract.");
		return false;
	}
	/*
	if (!Form.agree_flag1[0].checked) {
		alert("You did not complete the residence application.");
		document.location.href = "#agree1";
		return false;
	}
	if (!Form.agree_flag2[0].checked) {
		alert("You did not complete the residence application.");
		document.location.href = "#agree2";
		return false;
	}
	if (!Form.agree_flag3[0].checked) {
		alert("You did not complete the residence application.");
		document.location.href = "#agree3";
		return false;
	}
	if (!Form.agree_flag4[0].checked) {
		alert("You did not complete the residence application.");
		document.location.href = "#agree4";
		return false;
	}
	if (!Form.agree_flag5[0].checked) {
		alert("You did not complete the residence application.");
		document.location.href = "#agree5";
		return false;
	}
	if (!Form.agree_flag6[0].checked) {
		alert("You did not complete the residence application.");
		document.location.href = "#agree6";
		return false;
	}
	if (!Form.agree_flag7[0].checked) {
		alert("You did not complete the residence application.");
		document.location.href = "#agree7";
		return false;
	}
	*/
	return true;
}

function checkRoomRateInfo(Form) {
	if (Form.rate) {
		if (Form.period[0].checked) {
			var flag = false;
			for (i = 0; i < 7; i++) {
				if (Form.rate[i].checked) {
					flag = true;
					break;
				}
			}
			if (flag) {
				alert("The selected room and rate is only for Summer B Session.\n\nPlease choose again.");
				for (i = 0; i < 7; i++) {
					Form.rate[i].checked = false;
				}
				return false;
			}
			if (Form.rate[8].checked) {
				alert("The selected room and rate is only for Summer B Session.\n\nPlease choose again.");
				Form.rate[8].checked = false;
				return false;
			}
		} else if (Form.period[1].checked) {
			if (Form.rate[7].checked) {
				alert("The selected room and rate is only for Summer A Session.\n\nPlease choose again.");
				Form.rate[7].checked = false;
				return false;
			}
		}
	}
	return true;
}

function printApplication(Form) {
	if (Form.no.value) {
		if (popup != null && !popup.closed) popup.close();
		var URL = "https://reslife.korea.ac.kr:5008/v1/src/popup/application_stu.php?no=" + Form.no.value;
		popup = window.open(URL, '_zipcode','resizable=no,scrollbars=yes,status=no,width=700,height=500');
	}
}

function printInvoice(Form) {
	//var today = getToday();
	//if (today < "2006-06-08") alert("Your billing statement for summer session will be available on June 8, 2006.");
	if (Form.no.value) {
		if (popup != null && !popup.closed) popup.close();
		var URL = "https://reslife.korea.ac.kr:5008/v1/src/popup/invoice_stu.php?no=" + Form.no.value;
		popup = window.open(URL, '_zipcode','resizable=no,scrollbars=yes,status=no,width=650,height=650');
	}
}

function submitRefund(Form, flag) {
	if (Form.no.value) {
		if (flag == "N") alert("Deposit refund is not available for you.\n\nYou have financial obligations left or your deposit was already carried refunded.");
		else {
			Form.action = "https://reslife.korea.ac.kr:5008/v1/src/apply/refund_stu.php";
			Form.submit();
		}
	}
}

function submitCarryForward(Form) {
	if (Form.no.value) {
		Form.action = "https://reslife.korea.ac.kr:5008/v1/src/apply/action_app.php";
		Form.submit();
	} else alert("Please select the application number that you want to carry forward from.");
}

function changeApplication(Form) {
	//alert("The online application is now closed for spring 2007.\n\nIf you want residence for this semester, please email us at reslife@korea.ac.kr.");
	if (Form.no.value) {
		Form.action = "https://reslife.korea.ac.kr:5008/v1/src/apply/form_app.php?mode=edit";
		Form.submit();
	}
}

function applyDeferral(Form) {
	//alert("The application period for the residence hall fee deferral is now closed.\n\nRefer to the Important Dates.");
	if (Form.no.value) {
		Form.action = "https://reslife.korea.ac.kr:5008/v1/src/apply/defer_app.php";
		Form.submit();
	}
}