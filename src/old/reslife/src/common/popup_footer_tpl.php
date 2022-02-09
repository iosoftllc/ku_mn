<?
	$tpl->parse(FINAL, "body");
	$body = $tpl->GetTemplate(FINAL);
	unset($tpl);

	$tpl = new rFastTemplate("../../tpl/popup");
	$tpl->define(array(main => "popup_main.html"));

	$tpl->define_dynamic(email_row, "main");
	
	$tpl->assign(array(ON_LOAD    => $on_load,
	                   PAGE_TITLE => $page_title,
	                   SUB_TITLE  => $sub_title,
	                   BODY       => $body));

	if ($email_src) {
		$tpl->assign(array(EMAIL_SRC  => $email_src,
		                   EMAIL_MODE => $email_mode,
		                   EMAIL_NO   => $email_no));
		$tpl->parse(EMAIL_ROWS, ".email_row");
	}

	$tpl->parse(FINAL, "main");
	$tpl->FastPrint(FINAL);
?>