<?
	include_once("lib/conf.common.php");
	include_once("lib/class.cApplication.php");

	$no = array();
	$no[] = "2007010068";
	$no[] = "2007010005";
	$no[] = "2007010038";
	$no[] = "2007010043";
	$no[] = "2007010060";
	$no[] = "2007010014";
	$no[] = "2007010082";
	$no[] = "2007010185";
	$no[] = "2007010026";
	$no[] = "2007010102";
	$no[] = "2007010111";
	$no[] = "2007010113";
	$no[] = "2007010155";
	$no[] = "2007010144";
	$no[] = "2007010010";
	$no[] = "2007010080";
	$no[] = "2007010009";
	$no[] = "2007010095";
	$no[] = "2007010198";
	$no[] = "2007010131";
	$no[] = "2007010087";
	$no[] = "2007010192";
	$no[] = "2007010044";
	$no[] = "2007010119";
	$no[] = "2007010116";
	$no[] = "2007010037";
	$no[] = "2007010016";
	$no[] = "2007010098";
	$no[] = "2007010216";
	$no[] = "2007010191";
	$no[] = "2007010046";
	$no[] = "2007010237";
	$no[] = "2007010178";
	$no[] = "2007010182";
	$no[] = "2007010255";
	$no[] = "2007010107";
	$no[] = "2007010173";
	$no[] = "2007010137";
	$no[] = "2007010071";
	$no[] = "2007010154";
	$no[] = "2007010174";
	$no[] = "2007010213";
	$no[] = "2007010221";
	$no[] = "2007010250";
	$no[] = "2007010057";
	$no[] = "2007010235";
	$no[] = "2007010151";
	$no[] = "2007010236";
	$no[] = "2007010230";
	$no[] = "2007010267";
	$no[] = "2007010129";
	$no[] = "2007010264";
	$no[] = "2007010130";
	$no[] = "2007010224";
	$no[] = "2007010223";
	$no[] = "2007010225";
	$no[] = "2007010128";
	$no[] = "2007010258";
	$no[] = "2007010150";
	$no[] = "2007010243";
	$no[] = "2007010227";
	$no[] = "2007010242";
	$no[] = "2007010127";
	$no[] = "2007010247";
	$no[] = "2007010240";
	$no[] = "2007010093";
	$no[] = "2007010188";
	$no[] = "2007010251";
	$no[] = "2007010254";
	$no[] = "2007010125";
	$no[] = "2007010263";
	$no[] = "2007010246";
	$no[] = "2007010138";
	$no[] = "2007010245";
	$no[] = "2007010148";
	$no[] = "2007010025";
	$no[] = "2007010041";
	$no[] = "2007010039";
	$no[] = "2007010083";
	$no[] = "2007010108";
	$no[] = "2007010100";
	$no[] = "2007010104";
	$no[] = "2007010076";
	$no[] = "2007010090";
	$no[] = "2007010035";
	$no[] = "2007010105";
	$no[] = "2007010157";
	$no[] = "2007010126";
	$no[] = "2007010101";
	$no[] = "2007010040";
	$no[] = "2007010036";
	$no[] = "2007010141";
	$no[] = "2007010121";
	$no[] = "2007010049";
	$no[] = "2007010081";
	$no[] = "2007010147";
	$no[] = "2007010164";
	$no[] = "2007010165";
	$no[] = "2007010096";
	$no[] = "2007010070";
	$no[] = "2007010012";
	$no[] = "2007010163";
	$no[] = "2007010032";
	$no[] = "2007010156";
	$no[] = "2007010008";
	$no[] = "2007010194";
	$no[] = "2007010181";
	$no[] = "2007010203";
	$no[] = "2007010099";
	$no[] = "2007010027";
	$no[] = "2007010086";
	$no[] = "2007010084";
	$no[] = "2007010048";
	$no[] = "2007010097";
	$no[] = "2007010202";
	$no[] = "2007010124";
	$no[] = "2007010143";
	$no[] = "2007010140";
	$no[] = "2007010212";
	$no[] = "2007010023";
	$no[] = "2007010132";
	$no[] = "2007010106";
	$no[] = "2007010180";
	$no[] = "2007010064";
	$no[] = "2007010117";
	$no[] = "2007010115";
	$no[] = "2007010184";
	$no[] = "2007010051";
	$no[] = "2007010110";
	$no[] = "2007010088";
	$no[] = "2007010210";
	$no[] = "2007010167";
	$no[] = "2007010169";
	$no[] = "2007010195";
	$no[] = "2007010172";
	$no[] = "2007010201";
	$no[] = "2007010232";
	$no[] = "2007010183";
	$no[] = "2007010067";
	$no[] = "2007010118";
	$no[] = "2007010069";
	$no[] = "2007010063";
	$no[] = "2007010065";
	$no[] = "2007010073";
	$no[] = "2007010219";
	$no[] = "2007010059";
	$no[] = "2007010211";
	$no[] = "2007010209";
	$no[] = "2007010162";
	$no[] = "2007010231";
	$no[] = "2007010196";
	$no[] = "2007010228";
	$no[] = "2007010234";
	$no[] = "2007010204";
	$no[] = "2007010091";
	$no[] = "2007010238";
	$no[] = "2007010215";
	$no[] = "2007010177";
	$no[] = "2007010261";
	$no[] = "2007010226";
	$no[] = "2007010109";
	$no[] = "2007010158";
	$no[] = "2007010092";
	$no[] = "2007010145";
	$no[] = "2007010253";
	$no[] = "2007010186";
	$no[] = "2007010239";
	$no[] = "2007010205";
	$no[] = "2007010112";
	$no[] = "2007010053";
	$no[] = "2007010015";

	$rate = array();
	$rate[] = "SSSS";
	$rate[] = "SSSS";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "SSSS";
	$rate[] = "SSSS";
	$rate[] = "TTTT";
	$rate[] = "DDDD";
	$rate[] = "SSSS";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "SSSS";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "SSSS";
	$rate[] = "TTTT";
	$rate[] = "SSSS";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "SSSS";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "SSSS";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "SSSS";
	$rate[] = "DDDD";
	$rate[] = "SSSS";
	$rate[] = "TTTT";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "SSSS";
	$rate[] = "TTTT";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "SSSS";
	$rate[] = "SSSS";
	$rate[] = "SSSS";
	$rate[] = "SSSS";
	$rate[] = "DDDD";
	$rate[] = "TTTT";
	$rate[] = "SSSS";
	$rate[] = "DDDD";
	$rate[] = "SSSS";
	$rate[] = "TTTT";
	$rate[] = "SSSS";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "SSSS";
	$rate[] = "DDDD";
	$rate[] = "SSSS";
	$rate[] = "SSSS";
	$rate[] = "SSSS";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "SSSS";
	$rate[] = "SSSS";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "SSSS";
	$rate[] = "TTTT";
	$rate[] = "SSSS";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "SSSS";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "SSSS";
	$rate[] = "TTTT";
	$rate[] = "SSSS";
	$rate[] = "SSSS";
	$rate[] = "SSSS";
	$rate[] = "TTTT";
	$rate[] = "SSSS";
	$rate[] = "TTTT";
	$rate[] = "DDDD";
	$rate[] = "TTTT";
	$rate[] = "DDDD";
	$rate[] = "SSSS";
	$rate[] = "SSSS";
	$rate[] = "DDDD";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "SSSS";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "SSSS";
	$rate[] = "SSSS";
	$rate[] = "SSSS";
	$rate[] = "SSSS";
	$rate[] = "TTTT";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "TTTT";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "SSSS";
	$rate[] = "TTTT";
	$rate[] = "DDDD";
	$rate[] = "SSSS";
	$rate[] = "SSSS";
	$rate[] = "SSSS";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "TTTT";
	$rate[] = "DDDD";
	$rate[] = "DDDD";
	$rate[] = "TTTT";
	$rate[] = "SSSS";
	$rate[] = "SSSS";
	$rate[] = "SSSS";
	$rate[] = "DDDD";
	$rate[] = "SSSS";
	$rate[] = "DDDD";
	$rate[] = "SSSS";
	$rate[] = "SSSS";
	$rate[] = "DDDD";
	$rate[] = "SSSS";
	$rate[] = "TTTT";
	$rate[] = "SSSS";
	$rate[] = "DDDD";

	$period = array();
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";
	$period[] = "2007SA";

	$application = new cApplication($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $studentTable, $applicantTable, $rateTable, $periodTable, $roomTable, $priceTable, $preferenceTable, $paymentTable, $accountTable);
	$application->connectDatabase();

	for ($i = 0; $i < count($no); $i++) {
		if ($no[$i] && $rate[$i] && $period[$i]) {
			$flag = $application->updateResidenceFee($no[$i], $rate[$i], $period[$i]);
			echo "" . ($i + 1) . " - " . $flag . "<br>";
		}
		//echo $no[$i] . " " . $rate[$i] . " " . $period[$i] . "<br>";
	}

	$application->closeDatabase();
	unset($application);
?>