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
	curl_setopt($ch, CURLOPT_URL, $url); //접속할 URL 주소
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 인증서 체크같은데 true 시 안되는 경우가 많다.
	curl_setopt($ch, CURLOPT_SSLVERSION, 1); // SSL 버젼 (https 접속시에 필요)
	curl_setopt($ch, CURLOPT_HEADER, 0); // 헤더 출력 여부
	curl_setopt($ch, CURLOPT_TIMEOUT, 30); // TimeOut 값
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 결과값을 받을것인지
	$result = curl_exec($ch);
	curl_close($ch);
	$data = json_decode($result);
	$token = trim($data->{"access_token"});

	// 유효성 검사
	$url = "https://openapi.korea.ac.kr/api/dorm?format=json&access_token=$token&ex_no=$id&term=$term&year=$year";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url); //접속할 URL 주소
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 인증서 체크같은데 true 시 안되는 경우가 많다.
	curl_setopt($ch, CURLOPT_SSLVERSION, 1); // SSL 버젼 (https 접속시에 필요)
	curl_setopt($ch, CURLOPT_HEADER, 0); // 헤더 출력 여부
	curl_setopt($ch, CURLOPT_TIMEOUT, 30); // TimeOut 값
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 결과값을 받을것인지
	$result = curl_exec($ch);
	curl_close($ch);
	$data = json_decode($result);
	$effectiveness = trim($data->{"response"}->{"data"}[0]->{"effectiveness"});
	$pass = trim($data->{"response"}->{"data"}[0]->{"pass"});

	// 결과 표시
	if ($effectiveness == "Y") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"The student number you input is valid.\");";
		echo "self.close();";
		echo "</script>";
	} else {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Sorry. The student number you input is not valid.\");";
		echo "self.close();";
		echo "</script>";
	}
?>