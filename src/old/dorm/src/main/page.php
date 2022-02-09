<?
if(!function_exists('scandir')) {
   function scandir($dir, $sortorder = 0) {
       if(is_dir($dir))        {
           $dirlist = opendir($dir);
           while( ($file = readdir($dirlist)) !== false) {
               if(!is_dir($file)) {
                   $files[] = $file;
               }
           }
           ($sortorder == 0) ? asort($files) : rsort($files);
           return $files;
       } else {
       return FALSE;
       break;
       }
   }
}

	$code = $_GET["code"];
	if (!$code) $code = $_POST["code"];
	$html_dir = "page";
	$html_file = $code;

	if ($code == "procedure_n") $html_file = "procedure_un";
	else if ($code == "procedure_c") $html_file = "procedure_uy";
	else if ($code == "procedure_l") $html_file = "procedure_l";

	if ($code == "intro") {
		$main_menu_index = 1;
		$page_menu_index = 1;
		$etc_menu_index = 0;
	} else if ($code == "rate") {
		$main_menu_index = 1;
		$page_menu_index = 2;
		$etc_menu_index = 0;
	} else if ($code == "important") {
		$main_menu_index = 1;
		$page_menu_index = 3;
		$etc_menu_index = 0;
	} else if ($code == "procedure_stu") {
		$main_menu_index = 1;
		$page_menu_index = 4;
		$etc_menu_index = 0;
	} else if ($code == "contract") {
		$main_menu_index = 1;
		$page_menu_index = 5;
		$etc_menu_index = 0;
	} else if ($code == "assign") {
		$main_menu_index = 1;
		$page_menu_index = 6;
		$etc_menu_index = 0;
	} else if ($code == "check") {
		$main_menu_index = 1;
		$page_menu_index = 7;
		$etc_menu_index = 0;
	} else if ($code == "refund") {
		$main_menu_index = 1;
		$page_menu_index = 8;
		$etc_menu_index = 0;
	} else if ($code == "status_stu") {
		$main_menu_index = 1;
		$page_menu_index = 9;
		$etc_menu_index = 0;
	} else if ($code == "faq_under") {
		$main_menu_index = 1;
		$page_menu_index = 10;//11;
		$etc_menu_index = 0;
	} else if ($code == "intro_f") {
		$main_menu_index = 2;
		$page_menu_index = 1;
		$etc_menu_index = 0;
	} else if ($code == "rate_f") {
		$main_menu_index = 2;
		$page_menu_index = 2;
		$etc_menu_index = 0;
	} else if ($code == "procedure_fe") {
		$main_menu_index = 2;
		$page_menu_index = 3;
		$etc_menu_index = 0;
	} else if ($code == "procedure_fk") {
		$main_menu_index = 2;
		$page_menu_index = 4;
		$etc_menu_index = 0;
	} else if ($code == "contract_f1") {
		$main_menu_index = 2;
		$page_menu_index = 5;
		$etc_menu_index = 0;
	} else if ($code == "contract_f2") {
		$main_menu_index = 2;
		$page_menu_index = 6;
		$etc_menu_index = 0;
	} else if ($code == "faq") {
		$main_menu_index = 2;
		$page_menu_index = 7;
		$etc_menu_index = 0;
	} else if ($code == "facility") {
		$main_menu_index = 3;
		$page_menu_index = 0;
		$etc_menu_index = 0;
	} else if ($code == "grad_intro") {
		$main_menu_index = 4;
		$page_menu_index = 1;
		$etc_menu_index = 0;
	} else if ($code == "grad_rate") {
		$main_menu_index = 4;
		$page_menu_index = 2;
		$etc_menu_index = 0;
	} else if ($code == "grad_important") {
		$main_menu_index = 4;
		$page_menu_index = 3;
		$etc_menu_index = 0;
	} else if ($code == "grad_procedure") {
		$main_menu_index = 4;
		$page_menu_index = 4;
		$etc_menu_index = 0;
	} else if ($code == "grad_contract") {
		$main_menu_index = 4;
		$page_menu_index = 5;
		$etc_menu_index = 0;
	} else if ($code == "grad_criteria") {
		$main_menu_index = 4;
		$page_menu_index = 6;
		$etc_menu_index = 0;
	} else if ($code == "grad_assign") {
		$main_menu_index = 4;
		$page_menu_index = 7;
		$etc_menu_index = 0;
	} else if ($code == "grad_check") {
		$main_menu_index = 4;
		$page_menu_index = 8;
		$etc_menu_index = 0;
	} else if ($code == "grad_payment") {
		$main_menu_index = 4;
		$page_menu_index = 9;
		$etc_menu_index = 0;
	} else if ($code == "grad_account") {
		$main_menu_index = 4;
		$page_menu_index = 10;
		$etc_menu_index = 0;
	} else if ($code == "contact") {
		$main_menu_index = 5;
		$page_menu_index = 1;
		$etc_menu_index = 0;
	} else if ($code == "map") {
		$main_menu_index = 5;
		$page_menu_index = 2;
		$etc_menu_index = 0;
	} else if ($code == "direction") {
		$main_menu_index = 5;
		$page_menu_index = 3;
		$etc_menu_index = 0;
	} else if ($code == "gallery") {
		$main_menu_index = 6;
		$page_menu_index = 0;
		$etc_menu_index = 0;
	} else if ($code == "sitemap") {
		$main_menu_index = 0;
		$page_menu_index = 0;
		$etc_menu_index = 3;
	} else if ($code == "privacy") {
		$main_menu_index = 0;
		$page_menu_index = 0;
		$etc_menu_index = 4;
	}

	$cur_dt = date("Y-m-d");
	$cur_time = date("H");
	//$cur_time = 12;

	include_once("../common/tpl_header.php");

	$on_load = "";

	if ($code == "intro") {
		//$cur_dt = "2021-06-07";
		//$on_load = "openPopup('https://reslife.korea.ac.kr:5008/v1/tpl/popup/2020_covid_refund.html', '10', '10', '603', '805');openPopup1('https://reslife.korea.ac.kr:5008/v1/tpl/popup/2020_spring.html', '10', '350', '500', '450');";
		//$on_load = "openPopup('https://reslife.korea.ac.kr:5008/v1/tpl/popup/2020_1_foreign_checkin_1.html', '500', '0', '603', '805');";
		if ($cur_dt >= "2021-06-07" && $cur_dt <= "2021-07-02") $on_load = "openPopup('https://reslife.korea.ac.kr:5008/v1/tpl/popup/popup_20210108.html', '0', '0', '603', '803');openPopup1('https://reslife.korea.ac.kr:5008/v1/tpl/popup/2021_fall.html', '300', '0', '503', '453');";
		else $on_load = "openPopup('https://reslife.korea.ac.kr:5008/v1/tpl/popup/popup_20210108.html', '0', '0', '603', '803');";
		//$on_load = "openPopup('https://reslife.korea.ac.kr:5008/v1/tpl/popup/popup_20210108.html', '10', '10', '603', '803');";
		$thumbnail_cnt1 = 0;
		$thumbnail_html1 = "";
		$thumbnail_list1 = opendir("../../images/slide/ihouse/thumbnail/");
		while ($filename = readdir($thumbnail_list1)) {
			if ($filename == ".") continue;
			else if ($filename == "..") continue;
			else if (substr($filename, 0, 5) == "hide_") continue;
			else {
				$thumbnail_cnt1++;
				$thumbnail_html1 .= "<td><a href='javascript:viewPhoto1($thumbnail_cnt1);'><img src='../../images/slide/ihouse/thumbnail/" . $filename . "' width='109' height='73' border='0' class='border'></a></td>";
				$thumbnail_html1 .= "<td width='10'></td>";
			}
		}
		$thumbnail_width1 = 119 * $thumbnail_cnt1;
		if ($thumbnail_html1) $thumbnail_html1 = substr($thumbnail_html1, 0, strlen($thumbnail_html1) - 20);

		$thumbnail_cnt2 = 0;
		$thumbnail_html2 = "";
		$thumbnail_list2 = opendir("../../images/slide/anam_international/thumbnail/");
		while ($filename = readdir($thumbnail_list2)) {
			if ($filename == ".") continue;
			else if ($filename == "..") continue;
			else if (substr($filename, 0, 5) == "hide_") continue;
			else {
				$thumbnail_cnt2++;
				$thumbnail_html2 .= "<td><a href='javascript:viewPhoto2($thumbnail_cnt2);'><img src='../../images/slide/anam_international/thumbnail/" . $filename . "' width='109' height='73' border='0' class='border'></a></td>";
				$thumbnail_html2 .= "<td width='10'></td>";
			}
		}
		$thumbnail_width2 = 119 * $thumbnail_cnt2;
		if ($thumbnail_html2) $thumbnail_html2 = substr($thumbnail_html2, 0, strlen($thumbnail_html2) - 20);

		$first_photo1 = "";
		$first_desc1 = "";
		$photo_desc1 = "";
		$orginal_cnt1 = 0;
		$orginal_photo1 = "";
		$orginal_list1 = opendir("../../images/slide/ihouse/");
		while ($filename = readdir($orginal_list1)) {
			if ($filename == ".") continue;
			else if ($filename == "..") continue;
			else if ($filename == "thumbnail") continue;
			else if (substr($filename, 0, 5) == "hide_") continue;
			else {
				$tmp_desc = eregi_replace(".jpg", "", $filename);
				$tmp_desc = eregi_replace("_", " ", $tmp_desc);
				if ($orginal_cnt1 == 0) {
					$first_photo1 = $filename;
					$first_desc1 = $tmp_desc;
				}
				$orginal_photo1 .= "photo1[$orginal_cnt1] = \"../../images/slide/ihouse/" . $filename . "\";\n";
				$photo_desc1 .= "desc1[$orginal_cnt1] = \"$tmp_desc\";\n";
				$orginal_cnt1++;
			}
		}

		$first_photo2 = "";
		$first_desc2 = "";
		$photo_desc2 = "";
		$orginal_cnt2 = 0;
		$orginal_photo2 = "";
		$orginal_list2 = opendir("../../images/slide/anam_international/");
		while ($filename = readdir($orginal_list2)) {
			if ($filename == ".") continue;
			else if ($filename == "..") continue;
			else if ($filename == "thumbnail") continue;
			else if (substr($filename, 0, 5) == "hide_") continue;
			else {
				$tmp_desc = eregi_replace(".jpg", "", $filename);
				$tmp_desc = eregi_replace("_", " ", $tmp_desc);
				if ($orginal_cnt2 == 0) {
					$first_photo2 = $filename;
					$first_desc2 = $tmp_desc;
				}
				$orginal_photo2 .= "photo2[$orginal_cnt2] = \"../../images/slide/anam_international/" . $filename . "\";\n";
				$photo_desc2 .= "desc2[$orginal_cnt2] = \"$tmp_desc\";\n";
				$orginal_cnt2++;
			}
		}

		$tpl->assign(array(FIRST_PHOTO1     => $first_photo1,
		                   FIRST_DESC1      => $first_desc1,
		                   ORIGINAL_COUNT1  => $orginal_cnt1,
		                   ORIGINAL_PHOTO1  => $orginal_photo1,
		                   PHOTO_DESC1      => $photo_desc1,
		                   THUMBNAIL_WIDTH1 => $thumbnail_width1,
		                   THUMBNAIL_HTML1  => $thumbnail_html1,
		                   FIRST_PHOTO2     => $first_photo2,
		                   FIRST_DESC2      => $first_desc2,
		                   ORIGINAL_COUNT2  => $orginal_cnt2,
		                   ORIGINAL_PHOTO2  => $orginal_photo2,
		                   PHOTO_DESC2      => $photo_desc2,
		                   THUMBNAIL_WIDTH2 => $thumbnail_width2,
		                   THUMBNAIL_HTML2  => $thumbnail_html2));
	} else if ($code == "intro_f") {
		//$on_load = "openPopup2('https://reslife.korea.ac.kr:5008/v1/tpl/popup/faculty_close.html', '10', '10', '500', '324');";
		$thumbnail_cnt1 = 0;
		$thumbnail_html1 = "";
		$thumbnail_list1 = opendir("../../images/slide/cjf/thumbnail/");
		while ($filename = readdir($thumbnail_list1)) {
			if ($filename == ".") continue;
			else if ($filename == "..") continue;
			else if (substr($filename, 0, 5) == "hide_") continue;
			else {
				$thumbnail_cnt1++;
				$thumbnail_html1 .= "<td><a href='javascript:viewPhoto1($thumbnail_cnt1);'><img src='../../images/slide/cjf/thumbnail/" . $filename . "' width='109' height='73' border='0' class='border'></a></td>";
				$thumbnail_html1 .= "<td width='10'></td>";
			}
		}
		$thumbnail_width1 = 119 * $thumbnail_cnt1;
		if ($thumbnail_html1) $thumbnail_html1 = substr($thumbnail_html1, 0, strlen($thumbnail_html1) - 20);

		$thumbnail_cnt2 = 0;
		$thumbnail_html2 = "";
		$thumbnail_list2 = opendir("../../images/slide/ifh/thumbnail/");
		while ($filename = readdir($thumbnail_list2)) {
			if ($filename == ".") continue;
			else if ($filename == "..") continue;
			else if (substr($filename, 0, 5) == "hide_") continue;
			else {
				$thumbnail_cnt2++;
				$thumbnail_html2 .= "<td><a href='javascript:viewPhoto2($thumbnail_cnt2);'><img src='../../images/slide/ifh/thumbnail/" . $filename . "' width='109' height='73' border='0' class='border'></a></td>";
				$thumbnail_html2 .= "<td width='10'></td>";
			}
		}
		$thumbnail_width2 = 119 * $thumbnail_cnt2;
		if ($thumbnail_html2) $thumbnail_html2 = substr($thumbnail_html2, 0, strlen($thumbnail_html2) - 20);

		$first_photo1 = "";
		$first_desc1 = "";
		$photo_desc1 = "";
		$orginal_cnt1 = 0;
		$orginal_photo1 = "";
		$orginal_list1 = opendir("../../images/slide/cjf/");
		while ($filename = readdir($orginal_list1)) {
			if ($filename == ".") continue;
			else if ($filename == "..") continue;
			else if ($filename == "thumbnail") continue;
			else if (substr($filename, 0, 5) == "hide_") continue;
			else {
				$tmp_desc = eregi_replace(".jpg", "", $filename);
				$tmp_desc = eregi_replace("_", " ", $tmp_desc);
				if ($orginal_cnt1 == 0) {
					$first_photo1 = $filename;
					$first_desc1 = $tmp_desc;
				}
				$orginal_photo1 .= "photo1[$orginal_cnt1] = \"../../images/slide/cjf/" . $filename . "\";\n";
				$photo_desc1 .= "desc1[$orginal_cnt1] = \"$tmp_desc\";\n";
				$orginal_cnt1++;
			}
		}

		$first_photo2 = "";
		$first_desc2 = "";
		$photo_desc2 = "";
		$orginal_cnt2 = 0;
		$orginal_photo2 = "";
		$orginal_list2 = opendir("../../images/slide/ifh/");
		while ($filename = readdir($orginal_list2)) {
			if ($filename == ".") continue;
			else if ($filename == "..") continue;
			else if ($filename == "thumbnail") continue;
			else if (substr($filename, 0, 5) == "hide_") continue;
			else {
				$tmp_desc = eregi_replace(".jpg", "", $filename);
				$tmp_desc = eregi_replace("_", " ", $tmp_desc);
				if ($orginal_cnt2 == 0) {
					$first_photo2 = $filename;
					$first_desc2 = $tmp_desc;
				}
				$orginal_photo2 .= "photo2[$orginal_cnt2] = \"../../images/slide/ifh/" . $filename . "\";\n";
				$photo_desc2 .= "desc2[$orginal_cnt2] = \"$tmp_desc\";\n";
				$orginal_cnt2++;
			}
		}

		$tpl->assign(array(FIRST_PHOTO1     => $first_photo1,
		                   FIRST_DESC1      => $first_desc1,
		                   ORIGINAL_COUNT1  => $orginal_cnt1,
		                   ORIGINAL_PHOTO1  => $orginal_photo1,
		                   PHOTO_DESC1      => $photo_desc1,
		                   THUMBNAIL_WIDTH1 => $thumbnail_width1,
		                   THUMBNAIL_HTML1  => $thumbnail_html1,
		                   FIRST_PHOTO2     => $first_photo2,
		                   FIRST_DESC2      => $first_desc2,
		                   ORIGINAL_COUNT2  => $orginal_cnt2,
		                   ORIGINAL_PHOTO2  => $orginal_photo2,
		                   PHOTO_DESC2      => $photo_desc2,
		                   THUMBNAIL_WIDTH2 => $thumbnail_width2,
		                   THUMBNAIL_HTML2  => $thumbnail_html2));
	} else if ($code == "sitemap") {
		include_once("../../lib/func.common.php");
		$tpl->define_dynamic(map_row, "body");
		$map_html = array();
		$temp_count = 0;
		$col = 2;
		$row = ceil($main_menu_count / $col);
		for ($i = 0; $i < $row; $i++) {
			for ($j = 0; $j < $col; $j++) {
				$map_html[$j] = "";
				if ($temp_count < $main_menu_count) {
					$map_sub = "";
					for ($k = 0; $k < count($page_menu_name[$temp_count]); $k++) {
						$map_sub .= "<tr><td height=\"23\" style=\"text-align:center;\"><a href=\"" . $page_menu_url[$temp_count][$k] . "\">" . $page_menu_name[$temp_count][$k] . "</a></td></tr>";
						if ($k < count($page_menu_name[$temp_count]) - 1) $map_sub .= "<tr><td width=\"100%\" height=\"1\" background=\"../../images/sitemap/hdot.jpg\"></td></tr>";
					}
					if ($map_sub) $map_sub = "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">$map_sub</table>";
					$map_html[$j] = getSitemapFrame($main_menu_name[$temp_count], $main_menu_url[$temp_count], $map_sub);
				}
				$temp_count++;
			}
			if ($i == $row - 1 && $etc_count < 1) $divide = "";
			else $divide = "<tr><td colspan=\"3\" height=\"35\"></td></tr>";
			$tpl->assign(array(MAP_HTML1   => $map_html[0],
			                   MAP_HTML2   => $map_html[1],
			                   DIVIDE_LINE => $divide));
			$tpl->parse(MAP_ROWS, ".map_row");
		}
	} else if ($code == "grad_intro") {
		//$cur_dt = "2021-08-06";
		//$on_load = "openPopup('https://reslife.korea.ac.kr:5008/v1/tpl/popup/2020_1_grad_refund_kr.html', '0', '0', '603', '805');openPopup1('https://reslife.korea.ac.kr:5008/v1/tpl/popup/2020_1_grad_refund_en.html', '200', '0', '603', '805');openPopup2('https://reslife.korea.ac.kr:5008/v1/tpl/popup/2020_1_grad_refund_full.html', '400', '0', '603', '805');openPopup3('https://reslife.korea.ac.kr:5008/v1/tpl/popup/2020_1_foreign_checkin.html', '500', '0', '603', '805');";
		if ($cur_dt >= "2021-08-06" && $cur_dt <= "2021-08-12") $on_load = "openPopup('https://reslife.korea.ac.kr:5008/v1/tpl/popup/2020_1_foreign_checkin.html', '0', '0', '603', '805');openPopup1('https://reslife.korea.ac.kr:5008/v1/tpl/popup/popup_20210225.html', '200', '0', '803', '563');openPopup2('https://reslife.korea.ac.kr:5008/v1/tpl/popup/2021_1_grad_late_checkout.html', '400', '0', '503', '625');openPopup3('https://reslife.korea.ac.kr:5008/v1/tpl/popup/2021_2_graduate_more.html', '600', '0', '503', '353');";
		else if ($cur_dt <= "2021-08-05") $on_load = "openPopup('https://reslife.korea.ac.kr:5008/v1/tpl/popup/2020_1_foreign_checkin.html', '0', '0', '603', '805');openPopup1('https://reslife.korea.ac.kr:5008/v1/tpl/popup/popup_20210225.html', '200', '0', '803', '563');openPopup2('https://reslife.korea.ac.kr:5008/v1/tpl/popup/2021_1_grad_late_checkout.html', '400', '0', '503', '625');openPopup3('https://reslife.korea.ac.kr:5008/v1/tpl/popup/2021_2_grad_notice.html', '600', '0', '403', '173');";
		else $on_load = "openPopup('https://reslife.korea.ac.kr:5008/v1/tpl/popup/2020_1_foreign_checkin.html', '0', '0', '603', '805');openPopup1('https://reslife.korea.ac.kr:5008/v1/tpl/popup/popup_20210225.html', '200', '0', '803', '563');openPopup2('https://reslife.korea.ac.kr:5008/v1/tpl/popup/2021_1_grad_late_checkout.html', '400', '0', '503', '625');";
	} else if ($code == "grad_rate") {
		$thumbnail_cnt1 = 0;
		$thumbnail_html1 = "";
		$thumbnail_list1 = opendir("../../images/slide/g_single/thumbnail/");
		$filenames = scandir($_SERVER['DOCUMENT_ROOT']."/v1/images/slide/g_single/thumbnail/");
		foreach ($filenames as $filename) {
			if ($filename == ".") continue;
			else if ($filename == "..") continue;
			else if (substr($filename, 0, 5) == "hide_") continue;
			else {
				$thumbnail_cnt1++;
				$thumbnail_html1 .= "<td><a href='javascript:viewPhoto1($thumbnail_cnt1);'><img src='../../images/slide/g_single/thumbnail/" . $filename . "' width='109' height='73' border='0' class='border'></a></td>";
				$thumbnail_html1 .= "<td width='10'></td>";
			}
		}
		$thumbnail_width1 = 119 * $thumbnail_cnt1;
		if ($thumbnail_html1) $thumbnail_html1 = substr($thumbnail_html1, 0, strlen($thumbnail_html1) - 20);
		$thumbnail_cnt2 = 0;
		$thumbnail_html2 = "";
		$thumbnail_list2 = opendir("../../images/slide/g_double/thumbnail/");
		$filenames = scandir($_SERVER['DOCUMENT_ROOT']."/v1/images/slide/g_double/thumbnail/");
		foreach ($filenames as $filename) {
			if ($filename == ".") continue;
			else if ($filename == "..") continue;
			else if (substr($filename, 0, 5) == "hide_") continue;
			else {
				$thumbnail_cnt2++;
				$thumbnail_html2 .= "<td><a href='javascript:viewPhoto2($thumbnail_cnt2);'><img src='../../images/slide/g_double/thumbnail/" . $filename . "' width='109' height='73' border='0' class='border'></a></td>";
				$thumbnail_html2 .= "<td width='10'></td>";
			}
		}
		$thumbnail_width2 = 119 * $thumbnail_cnt2;
		if ($thumbnail_html2) $thumbnail_html2 = substr($thumbnail_html2, 0, strlen($thumbnail_html2) - 20);
		$thumbnail_cnt3 = 0;
		$thumbnail_html3 = "";
		$thumbnail_list3 = opendir("../../images/slide/g_triple/thumbnail/");
		$filenames = scandir($_SERVER['DOCUMENT_ROOT']."/v1/images/slide/g_triple/thumbnail/");
		foreach ($filenames as $filename) {
			if ($filename == ".") continue;
			else if ($filename == "..") continue;
			else if (substr($filename, 0, 5) == "hide_") continue;
			else {
				$thumbnail_cnt3++;
				$thumbnail_html3 .= "<td><a href='javascript:viewPhoto3($thumbnail_cnt3);'><img src='../../images/slide/g_triple/thumbnail/" . $filename . "' width='109' height='73' border='0' class='border'></a></td>";
				$thumbnail_html3 .= "<td width='10'></td>";
			}
		}
		$thumbnail_width3 = 119 * $thumbnail_cnt3;
		if ($thumbnail_html3) $thumbnail_html3 = substr($thumbnail_html3, 0, strlen($thumbnail_html3) - 20);
		$first_photo1 = "";
		$first_desc1 = "";
		$photo_desc1 = "";
		$orginal_cnt1 = 0;
		$orginal_photo1 = "";
		$orginal_list1 = opendir("../../images/slide/g_single/");
		$filenames = scandir($_SERVER['DOCUMENT_ROOT']."/v1/images/slide/g_single/");
		foreach ($filenames as $filename) {
			if ($filename == ".") continue;
			else if ($filename == "..") continue;
			else if ($filename == "thumbnail") continue;
			else if (substr($filename, 0, 5) == "hide_") continue;
			else {
				$tmp_desc = eregi_replace(".jpg", "", $filename);
				$tmp_desc = eregi_replace("_", " ", $tmp_desc);
				if ($orginal_cnt1 == 0) {
					$first_photo1 = $filename;
					$first_desc1 = $tmp_desc;
				}
				$orginal_photo1 .= "photo1[$orginal_cnt1] = \"../../images/slide/g_single/" . $filename . "\";\n";
				$photo_desc1 .= "desc1[$orginal_cnt1] = \"$tmp_desc\";\n";
				$orginal_cnt1++;
			}
		}
		$first_photo2 = "";
		$first_desc2 = "";
		$photo_desc2 = "";
		$orginal_cnt2 = 0;
		$orginal_photo2 = "";
		$orginal_list2 = opendir("../../images/slide/g_double/");
		$filenames = scandir($_SERVER['DOCUMENT_ROOT']."/v1/images/slide/g_double/");
		foreach ($filenames as $filename) {
			if ($filename == ".") continue;
			else if ($filename == "..") continue;
			else if ($filename == "thumbnail") continue;
			else if (substr($filename, 0, 5) == "hide_") continue;
			else {
				$tmp_desc = eregi_replace(".jpg", "", $filename);
				$tmp_desc = eregi_replace("_", " ", $tmp_desc);
				if ($orginal_cnt2 == 0) {
					$first_photo2 = $filename;
					$first_desc2 = $tmp_desc;
				}
				$orginal_photo2 .= "photo2[$orginal_cnt2] = \"../../images/slide/g_double/" . $filename . "\";\n";
				$photo_desc2 .= "desc2[$orginal_cnt2] = \"$tmp_desc\";\n";
				$orginal_cnt2++;
			}
		}
		$first_photo3 = "";
		$first_desc3 = "";
		$photo_desc3 = "";
		$orginal_cnt3 = 0;
		$orginal_photo3 = "";
		$orginal_list3 = opendir("../../images/slide/g_triple/");
		$filenames = scandir($_SERVER['DOCUMENT_ROOT']."/v1/images/slide/g_triple/");
		foreach ($filenames as $filename) {
			if ($filename == ".") continue;
			else if ($filename == "..") continue;
			else if ($filename == "thumbnail") continue;
			else if (substr($filename, 0, 5) == "hide_") continue;
			else {
				$tmp_desc = eregi_replace(".jpg", "", $filename);
				$tmp_desc = eregi_replace("_", " ", $tmp_desc);
				if ($orginal_cnt3 == 0) {
					$first_photo3 = $filename;
					$first_desc3 = $tmp_desc;
				}
				$orginal_photo3 .= "photo3[$orginal_cnt3] = \"../../images/slide/g_triple/" . $filename . "\";\n";
				$photo_desc3 .= "desc3[$orginal_cnt3] = \"$tmp_desc\";\n";
				$orginal_cnt3++;
			}
		}
		$tpl->assign(array(FIRST_PHOTO1     => $first_photo1,
		                   FIRST_DESC1      => $first_desc1,
		                   ORIGINAL_COUNT1  => $orginal_cnt1,
		                   ORIGINAL_PHOTO1  => $orginal_photo1,
		                   PHOTO_DESC1      => $photo_desc1,
		                   THUMBNAIL_WIDTH1 => $thumbnail_width1,
		                   THUMBNAIL_HTML1  => $thumbnail_html1,
		                   FIRST_PHOTO2     => $first_photo2,
		                   FIRST_DESC2      => $first_desc2,
		                   ORIGINAL_COUNT2  => $orginal_cnt2,
		                   ORIGINAL_PHOTO2  => $orginal_photo2,
		                   PHOTO_DESC2      => $photo_desc2,
		                   THUMBNAIL_WIDTH2 => $thumbnail_width2,
		                   THUMBNAIL_HTML2  => $thumbnail_html2,
		                   FIRST_PHOTO3     => $first_photo3,
		                   FIRST_DESC3      => $first_desc3,
		                   ORIGINAL_COUNT3  => $orginal_cnt3,
		                   ORIGINAL_PHOTO3  => $orginal_photo3,
		                   PHOTO_DESC3      => $photo_desc3,
		                   THUMBNAIL_WIDTH3 => $thumbnail_width3,
		                   THUMBNAIL_HTML3  => $thumbnail_html3));
	}//else if ($code == "procedure_fe") $on_load = "openPopup2('https://reslife.korea.ac.kr:5008/v1/tpl/popup/cafe_close.html', '10', '10', '400', '170');";

	include("../common/tpl_variables.php");

	include_once("../common/tpl_footer.php");
	include_once("../common/counter_tpl.php");
?>