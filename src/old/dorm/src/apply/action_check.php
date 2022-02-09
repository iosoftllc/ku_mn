<?
	include_once("../../lib/conf.common.php");
	include_once("../../src/common/student_tpl.php");
	$student->closeDatabase();
	unset($student);

	// ���� ����
	$year = trim($_GET["year"]);
	$term = trim($_GET["term"]);
	$id = trim($_GET["id"]);
	if ($year == "") $year = trim($_POST["year"]);
	if ($term == "") $term = trim($_POST["term"]);
	if ($id == "") $id = trim($_POST["id"]);
	$id = strtoupper($id);

	// ��ū ����
	$url = "https://openapi.korea.ac.kr/oauth/token?client_id=ku_dorm_service&client_secret=kudorm1234&grant_type=client_credentials";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url); //������ URL �ּ�
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // ������ üũ������ true �� �ȵǴ� ��찡 ����.
	curl_setopt($ch, CURLOPT_SSLVERSION, 1); // SSL ���� (https ���ӽÿ� �ʿ�)
	curl_setopt($ch, CURLOPT_HEADER, 0); // ��� ��� ����
	curl_setopt($ch, CURLOPT_TIMEOUT, 30); // TimeOut ��
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ������� ����������
	$result = curl_exec($ch);
	curl_close($ch);
	$data = json_decode($result);
	$token = trim($data->{"access_token"});

	// ��ȿ�� �˻�
	$url = "https://openapi.korea.ac.kr/api/dorm?format=json&access_token=$token&ex_no=$id&term=$term&year=$year";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url); //������ URL �ּ�
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // ������ üũ������ true �� �ȵǴ� ��찡 ����.
	curl_setopt($ch, CURLOPT_SSLVERSION, 1); // SSL ���� (https ���ӽÿ� �ʿ�)
	curl_setopt($ch, CURLOPT_HEADER, 0); // ��� ��� ����
	curl_setopt($ch, CURLOPT_TIMEOUT, 30); // TimeOut ��
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ������� ����������
	$result = curl_exec($ch);
	curl_close($ch);
	$data = json_decode($result);
	$effectiveness = trim($data->{"response"}->{"data"}[0]->{"effectiveness"});
	$pass = trim($data->{"response"}->{"data"}[0]->{"pass"});

	// ��� ǥ��
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