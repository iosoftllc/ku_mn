<?
	include_once("../../lib/class.rFastTemplate.php");  

	$mainmenu_name = array("�����ڰ���","�л�������","����������","���п�������","�Խ��ǰ���","������","��������ó��");
	$mainmenu_left = array("70","10","300","300","500","730","815");
	$mainmenu_width = array("220","900","500","500","350","60","200");

	$submenu_name[0] = array("�����ڰ���","���Ϻ�����","�߼۸�����");
	$submenu_name[1] = array("�����ڰ���","�¶�����������","�Ϲ���������","���д���������","�����ݰ���","���ο������","�������Ȳ","ȣ�ǰ���","[OLD]�������Ȳ","[OLD]ȣ�ǰ���");
	$submenu_name[2] = array("���ǿ������","�ü��������","������������Ȳ","��������ǹ�����Ȳ","ȸ�ǽǿ�����Ȳ");
	$submenu_name[3] = array("�����ڰ���","�¶�����������","�����ݰ���","��ǹ�����Ȳ","ȣ�ǰ���");
	$submenu_name[4] = array("���԰���","ȯ�漳��","News & Notice","Flea Market");
	$submenu_name[5] = array("�������");
	$submenu_name[6] = array("���ӳ���","��������");

	$submenu_url[0] = array("https://reslife.korea.ac.kr:5008/admin/src/mail/list.php","https://reslife.korea.ac.kr:5008/admin/src/mail/mail.php","https://reslife.korea.ac.kr:5008/admin/src/mail/mailbox.php");
	$submenu_url[1] = array("https://reslife.korea.ac.kr:5008/admin/src/apply/stu_list.php","https://reslife.korea.ac.kr:5008/admin/src/apply/app_list.php","https://reslife.korea.ac.kr:5008/admin/src/apply/list.php?s_kind=U","https://reslife.korea.ac.kr:5008/admin/src/apply/list.php?s_kind=L","https://reslife.korea.ac.kr:5008/admin/src/apply/re_list.php","https://reslife.korea.ac.kr:5008/admin/src/apply/defer_list.php","https://reslife.korea.ac.kr:5008/admin/src/apply/app_calendar.php","https://reslife.korea.ac.kr:5008/admin/src/apply/room_list.php","https://reslife.korea.ac.kr:5008/admin/src/apply/app_calendar_old.php","https://reslife.korea.ac.kr:5008/admin/src/apply/room_old_list.php");
	$submenu_url[2] = array("https://reslife.korea.ac.kr:5008/admin/src/faculty/room_list.php","https://reslife.korea.ac.kr:5008/admin/src/faculty/fac_list.php","https://reslife.korea.ac.kr:5008/admin/src/faculty/room_calendar.php?kind=1","https://reslife.korea.ac.kr:5008/admin/src/faculty/room_calendar.php?kind=2","https://reslife.korea.ac.kr:5008/admin/src/faculty/fac_calendar.php");
	$submenu_url[3] = array("https://reslife.korea.ac.kr:5008/admin/src/graduate/stu_list.php","https://reslife.korea.ac.kr:5008/admin/src/graduate/app_list.php","https://reslife.korea.ac.kr:5008/admin/src/graduate/re_list.php","https://reslife.korea.ac.kr:5008/admin/src/graduate/app_calendar.php","https://reslife.korea.ac.kr:5008/admin/src/graduate/room_list.php");
	$submenu_url[4] = array("https://reslife.korea.ac.kr:5008/admin/src/board/spam.php","https://reslife.korea.ac.kr:5008/admin/src/board/setting.php","https://reslife.korea.ac.kr:5008/admin/src/board/list.php?type=1","https://reslife.korea.ac.kr:5008/admin/src/board/list.php?type=2");
	$submenu_url[5] = array("https://reslife.korea.ac.kr:5008/admin/src/stat/counter.php");
	$submenu_url[6] = array("../../src/log/access_list.php","../../src/log/work_list.php");

	if ($html_dir == "stat") {
		$tpl = new rFastTemplate("../../tpl/$html_dir");
		$tpl->define(array(stat_menu    => "ct_menu.html",
		                   stat_submenu => $submenu,
		                   stat_result  => $result,
		                   body         => "stat_main.html"));
	} else {
		if (!file_exists("../../tpl/$html_dir/$html_file.html")) $html_file = "../main/not_found";
		$tpl = new rFastTemplate("../../tpl/$html_dir");
		$tpl->define(array(body => "$html_file.html"));
	}
?>