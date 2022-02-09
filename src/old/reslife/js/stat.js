function gotoPage(page) {
	if (page != "") {
		document.CounterForm.page.value = page;
		document.CounterForm.action = "../../src/stat/counter.php";
		document.CounterForm.submit();
	}
}

function ViewCounterStat(type) {
	if (type != "") {
		document.CounterForm.ct_type.value = type;
		if (document.CounterForm.ct_year != null) document.CounterForm.ct_year.value = "";
		if (document.CounterForm.ct_month != null) document.CounterForm.ct_month.value = "";
		if (document.CounterForm.ct_day != null) document.CounterForm.ct_day.value = "";
		document.CounterForm.action = "../../src/stat/counter.php";
		document.CounterForm.submit();
	}
}

function gotoCounterStat() {
	if (document.CounterForm.ct_type.value == "info") document.CounterForm.page.value = "1";
	document.CounterForm.action = "../../src/stat/counter.php";
	document.CounterForm.submit();
}