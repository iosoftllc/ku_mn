<?
	include_once("../common/login_tpl.php");

	$main_index = 0;
	$sub_index = 0;
	$on_load = "";
	$page_name = "관리자";

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 9) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/admin_tpl.php");
			include_once("../common/header_tpl.php");

			$tpl->define_dynamic(array(button_row  => "body",
			                           new_pw_row  => "body",
			                           edit_pw_row => "body"));

			if ($mode == "edit") {
				$page_name .= " 수정";
				$on_load = "document.PasswordForm.pw.focus();";
				$admin->getAdminInfo($id);
				$grade = $admin->adminGrade;
				$name = $admin->adminName;
				$department = $admin->adminDepartment;
				$email = $admin->adminEmail;
			} else {
				$page_name .= " 추가";
				$on_load = "document.AdminForm.id.focus();";
				$id = "";
				$grade = "";
				$name = "";
				$department = "";
				$email = "";
			}

			$tpl->assign(array(MODE             => $mode,
			                   SEL_PAGE         => $page,
			                   SEARCH_TYPE      => $s_type,
			                   SEARCH_TEXT      => $s_text,
			                   SEARCH_GRADE     => $s_grade,
			                   SORT1_VALUE      => $sort1,
			                   SORT2_VALUE      => $sort2,
			                   ADMIN_ID         => $id,
			                   ADMIN_GRADE      => $grade,
			                   ADMIN_NAME       => stripslashes($name),
			                   ADMIN_DEPARTMENT => stripslashes($department),
			                   ADMIN_EMAIL      => $email));

			if ($mode == "edit") $tpl->parse(EDIT_PW_ROWS, ".edit_pw_row");
			else {
				$tpl->parse(BUTTON_ROWS, ".button_row");
				$tpl->parse(NEW_PW_ROWS, ".new_pw_row");
			}

			$admin->closeDatabase();
			unset($admin);

			include_once("../common/footer_tpl.php");
		}
	}
?>