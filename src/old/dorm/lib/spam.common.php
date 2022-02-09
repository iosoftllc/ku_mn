<?
	function asc_hex($char) {
		$j = 0;
		$word_length = strlen($char); 
		for ($i = 0; $i < $word_length; $i++) {
			if ($j == 0) {
				if (ord(substr($char, $i, 1)) > 0xa1 && ord(substr($char, $i, 1)) <= 0xfe) {
					$j = 1;
					$t_char = $t_char.bin2hex(substr($char, $i, 1));
				} else $t_char = $t_char . "00" . bin2hex(substr($char, $i, 1)). " ";
			} else {
				$t_char = $t_char . bin2hex(substr($char, $i, 1)) . " ";
				$j = 0;
			}
		}
		return $t_char;
	}

	function isRejectedID($id, $txt) {
		$flag = false;
		$id_list = explode(";", $id);
		for ($i = 0; $i < count($id_list); $i++) {
			if (trim($id_list[$i]) == trim($txt)) {
				$flag = true;
				break;
			}
		}
		return $flag;
	}

	function isRejectedIP($ip, $txt) {
		$flag = false;
		$ip_list = explode(";", $ip);
		for ($i = 0; $i < count($ip_list); $i++) {
			if (trim($ip_list[$i]) == trim($txt)) {
				$flag = true;
				break;
			}
		}
		return $flag;
	}

	function isRejectedWord($word, $txt) {
		$flag = false;
		$word_list = explode(";", $word);
		for ($i = 0; $i < count($word_list); $i++) {
			if (@ereg(asc_hex(trim($word_list[$i])), asc_hex($txt))) {
				$flag = true;
				break;
			}
		}
		return $flag;
	}
?>