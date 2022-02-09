<?
	include_once("../../lib/conf.common.php");
	include_once("../../src/common/student_tpl.php");
	$student->closeDatabase();
	unset($student);

	// 변수 설정
	$year = trim($_GET["year"]);
	$term = trim($_GET["term"]);
	$id = trim($_GET["id"]);
	if ($year == "") $year = trim($_POST["year"]);
	if ($term == "") $term = trim($_POST["term"]);
	if ($id == "") $id = trim($_POST["id"]);
	$id = strtoupper($id);

	// 토큰 생성
	$url = "https://openapi.korea.ac.kr/oauth/token?client_id=ku_dorm_service&client_secret=kudorm1234&grant_type=client_credentials";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//curl_setopt($ch, CURLOPT_SSLVERSION, 2);
	curl_setopt($ch, CURLOPT_TIMEOUT, false);
	$result = curl_exec($ch);
echo "Curl error: " . curl_error($ch);
echo "<br>";
print_r(curl_getinfo($ch));
	curl_close($ch);
	$data = json_decode($result);
	$token = trim($data->{"access_token"});
echo "<br><br>";
	// 유효성 검사
	$url = "https://openapi.korea.ac.kr/api/dorm?format=json&access_token=$token&ex_no=$id&term=$term&year=$year";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSLVERSION, 2);
	curl_setopt($ch, CURLOPT_TIMEOUT, 0);
	$result = curl_exec($ch);
echo "Curl error: " . curl_error($ch);
echo "<br>";
print_r(curl_getinfo($ch));
	curl_close($ch);
	$data = json_decode($result);
	$effectiveness = trim($data->{"response"}->{"data"}[0]->{"effectiveness"});
	$pass = trim($data->{"response"}->{"data"}[0]->{"pass"});

	// 결과 표시
	if ($effectiveness == "Y" && $pass == "Y") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"The student number you input is valid.\");";
		//echo "self.close();";
		echo "</script>";
	} else {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Sorry. The student number you input is not valid.\");";
		//echo "self.close();";
		echo "</script>";
	}
?>