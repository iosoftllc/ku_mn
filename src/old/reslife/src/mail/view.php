<?
	include_once("../common/login_tpl.php");

	$main_index = 0;
	$sub_index = 0;
	$on_load = "";
	$page_name = "관리자 상세정보 보기";

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 9) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/admin_tpl.php");

			if ($id) $admin->getAdminInfo($id);
			if ($admin->adminID) {
				include_once("../common/header_tpl.php");

				$tpl->assign(array(SEL_PAGE         => $page,
				                   SEARCH_TYPE      => $s_type,
				                   SEARCH_TEXT      => $s_text,
				                   SEARCH_GRADE     => $s_grade,
				                   SORT1_VALUE      => $sort1,
				                   SORT2_VALUE      => $sort2,
				                   ADMIN_ID         => $id,
				                   ADMIN_GRADE      => getMemberGrade($admin->adminGrade),
				                   ADMIN_NAME       => stripslashes($admin->adminName),
				                   ADMIN_DEPARTMENT => stripslashes($admin->adminDepartment),
				                   ADMIN_EMAIL      => $admin->adminEmail,
				                   ADMIN_DATE       => getFullDate($admin->adminDate),
				                   ADMIN_LOGIN      => getFullDate($admin->loginTime),
				                   ADMIN_LOGOUT     => getFullDate($admin->logoutTime),
				                   ADMIN_LOGIP      => $admin->logIP,
				                   ADMIN_COUNT      => number_format($admin->logCount)));

				$admin->closeDatabase();
				unset($admin);

				include_once("../common/footer_tpl.php");
			} else {
				$admin->closeDatabase();
				unset($admin);
				echo "<script language=\"javascript\">";
				echo "alert(\"해당하는 관리자 정보가 없습니다.\");";
				echo "history.go(-1);";
				echo "</script>";
			}
		}
	}
?>