<?
	include_once("lib/conf.common.php");
	include_once("lib/class.cApplication.php");

	$student = array();
	$student[] = "701207049";
	$student[] = "2003110300";
	$student[] = "2004140363";
	$student[] = "2006010112";
	$student[] = "2006010517";
	$student[] = "2006010583";
	$student[] = "2006021062";
	$student[] = "2006950107";
	$student[] = "2006950108";
	$student[] = "2006950119";
	$student[] = "2006950127";
	$student[] = "2006950135";
	$student[] = "2006950147";
	$student[] = "2006950148";
	$student[] = "2006950149";
	$student[] = "2006950212";
	$student[] = "2006950216";
	$student[] = "2006950224";
	$student[] = "2006950225";
	$student[] = "2006950226";
	$student[] = "2006950227";
	$student[] = "2006950228";
	$student[] = "2006950229";
	$student[] = "2006950230";
	$student[] = "2006950232";
	$student[] = "2006950234";
	$student[] = "2006950312";
	$student[] = "2006950318";
	$student[] = "2006950319";
	$student[] = "2006950320";
	$student[] = "2006950321";
	$student[] = "2006950322";
	$student[] = "2007020161";
	$student[] = "2007029001";
	$student[] = "2007029002";
	$student[] = "2007029003";
	$student[] = "2007029006";
	$student[] = "2007029007";
	$student[] = "2007029011";
	$student[] = "2007029012";
	$student[] = "2007029013";
	$student[] = "2007029016";
	$student[] = "2007029018";
	$student[] = "2007029020";
	$student[] = "2007029022";
	$student[] = "2007950001";
	$student[] = "2007950002";
	$student[] = "2007950004";
	$student[] = "2007950005";
	$student[] = "2007950007";
	$student[] = "2007950008";
	$student[] = "2007950010";
	$student[] = "2007950012";
	$student[] = "2007950014";
	$student[] = "2007950016";
	$student[] = "2007950017";
	$student[] = "2007950018";
	$student[] = "2007950023";
	$student[] = "2007950025";
	$student[] = "2007950028";
	$student[] = "2007950029";
	$student[] = "2007950030";
	$student[] = "2007950031";
	$student[] = "2007950032";
	$student[] = "2007950033";
	$student[] = "2007950034";
	$student[] = "2007950037";
	$student[] = "2007950038";
	$student[] = "2007950039";
	$student[] = "2007950049";
	$student[] = "2007950051";
	$student[] = "2007950054";
	$student[] = "2007950056";
	$student[] = "2007950058";
	$student[] = "2007950060";
	$student[] = "2007950061";
	$student[] = "2007950062";
	$student[] = "2007950063";
	$student[] = "2007950064";
	$student[] = "2007950065";
	$student[] = "2007950066";
	$student[] = "2007950068";
	$student[] = "2007950069";
	$student[] = "2007950070";
	$student[] = "2007950071";
	$student[] = "2007950072";
	$student[] = "2007950074";
	$student[] = "2007950075";
	$student[] = "2007950077";
	$student[] = "2007950078";
	$student[] = "2007950080";
	$student[] = "2007950081";
	$student[] = "2007950083";
	$student[] = "2007950086";
	$student[] = "2007950091";
	$student[] = "2007950092";
	$student[] = "2007950093";
	$student[] = "2007950099";
	$student[] = "2007950100";
	$student[] = "2007950101";
	$student[] = "2007950102";
	$student[] = "2007950103";
	$student[] = "2007950104";
	$student[] = "2007950105";
	$student[] = "2007950106";
	$student[] = "2007950107";
	$student[] = "2007950108";
	$student[] = "2007950109";
	$student[] = "2007950110";
	$student[] = "2007950111";
	$student[] = "2007950112";
	$student[] = "2007950113";
	$student[] = "2007950114";
	$student[] = "2007950116";
	$student[] = "2007950117";
	$student[] = "2007950118";
	$student[] = "2007950121";
	$student[] = "2007950122";
	$student[] = "2007950123";
	$student[] = "2007950124";
	$student[] = "2007950142";
	$student[] = "2007950144";
	$student[] = "2007950145";
	$student[] = "2007950146";

	$nation = array();
	$nation[] = "Mongolia";
	$nation[] = "United States";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "Brazil";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "United Kingdom";
	$nation[] = "Austrian";
	$nation[] = "Singapore";
	$nation[] = "German";
	$nation[] = "Japan";
	$nation[] = "United States";
	$nation[] = "Germany";
	$nation[] = "Germany";
	$nation[] = "United State";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "Taiwan";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "Mongolia";
	$nation[] = "United States";
	$nation[] = "Russia";
	$nation[] = "Russia";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "Russia";
	$nation[] = "Iran";
	$nation[] = "Iran";
	$nation[] = "Japan";
	$nation[] = "China";
	$nation[] = "Japan";
	$nation[] = "Japan";
	$nation[] = "Sweden";
	$nation[] = "China";
	$nation[] = "Australia";
	$nation[] = "United States";
	$nation[] = "China";
	$nation[] = "Ethiopia";
	$nation[] = "Spain";
	$nation[] = "United States";
	$nation[] = "Japan";
	$nation[] = "Japan";
	$nation[] = "Japan";
	$nation[] = "Japan";
	$nation[] = "Japan";
	$nation[] = "Japan";
	$nation[] = "Japan";
	$nation[] = "Japan";
	$nation[] = "Netherlands";
	$nation[] = "Austria";
	$nation[] = "Austria";
	$nation[] = "Austria";
	$nation[] = "German";
	$nation[] = "Japan";
	$nation[] = "China";
	$nation[] = "Japan";
	$nation[] = "Japan";
	$nation[] = "France";
	$nation[] = "United States";
	$nation[] = "China";
	$nation[] = "United States";
	$nation[] = "Singapore";
	$nation[] = "France";
	$nation[] = "France";
	$nation[] = "France";
	$nation[] = "Netherlands";
	$nation[] = "Netherlands";
	$nation[] = "Netherlands";
	$nation[] = "Netherlands";
	$nation[] = "United Kingdom";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "Singapore";
	$nation[] = "Singapore";
	$nation[] = "Singapore";
	$nation[] = "Thailand";
	$nation[] = "Australia";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "Austria";
	$nation[] = "China";
	$nation[] = "China";
	$nation[] = "Australia";
	$nation[] = "United States";
	$nation[] = "Japan";
	$nation[] = "Japan";
	$nation[] = "United States";
	$nation[] = "Australia";

	$application = new cApplication($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $studentTable, $applicantTable, $rateTable, $periodTable, $roomTable, $priceTable, $preferenceTable, $paymentTable, $accountTable);
	$application->connectDatabase();

	for ($i = 0; $i < count($student); $i++) {
		if ($student[$i] && $nation[$i]) {
			$flag = $application->updateNationality1($student[$i], $nation[$i]);
			echo "" . ($i + 1) . " - " . $flag . "<br>";
		}
	}

	$application->closeDatabase();
	unset($application);
?>

































































































