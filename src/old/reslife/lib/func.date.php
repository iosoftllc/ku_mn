<?
/*
+---------------------------------------------------------------------+
| Copyleft (L) 2005.1.9 by NiL |
+---------------------------------------------------------------------+
| 본 프로그램은 제작자와는 전혀 무관하게 맘대로 복사, 수정, 파손 |
| 또는, 대여, 판매할수 있습니다. |
| 수정된 소스는 제작자와 많은 사람들과 공유되기를 원합니다. |
+---------------------------------------------------------------------+
| Author: Park J. NiL <nils@jnils.net> |
+---------------------------------------------------------------------+
*/

function is_leaf_year($y) {
    if(($y % 400) == 0) return true;
    else if(($y % 100) == 0) return false;
    else if(($y % 4) == 0) return true;
    else return false;
}

function new_mktime($hour, $min, $sec, $month, $day, $year) {
    $hour = intval($hour);
    $min = intval($min);
    $sec = intval($sec);
    $month = intval($month);
    $day = intval($day);
    $year = intval($year);

    $month_arr[0] = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    $month_arr[1] = array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

    $_days = 0;
    $_secs = 0;

    $normal_year_days = 365;
    $leaf_year_days = 366;

    $_day_sec = 86400;
    $_hour_sec = 3600;
    $_min_sec = 60;

    $_day_min = 1440;
    $_hour_min = 60;

    $_day_hour = 24;

    $_timestamp = 0;

    // 초 더하기
    $secs = $sec;
    
    // 분을 초로
    $secs += $min * $_min_sec;

    // 시를 초로
    $secs += $hour * $_hour_sec;

    // 날 더하기
    $days = $day;
    
    // 월을 날짜로
    $_year_cnt = floor(($month - 1) / 12);
    $month = $month % 12;
    for($i = 0; $i < $month - 1; $i++)
    {
        $_month = ($i % 12) + 1;
        $leaf_flg = 0; // 기본값으로 윤달 아님

        if($_month == 2) // 2월이면 윤달 체크
        {
            if(is_leaf_year($year + $_year_cnt)) $leaf_flg = 1;
            else $leaf_flg = 0;
        }
        $days += $month_arr[$leaf_flg][$i];
    }

    // 년을 날짜로
    $year += $_year_cnt;
    for($i = 1; $i < $year; $i++)
    {
        $_year = $i;
        $days += is_leaf_year($_year) ? $leaf_year_days : $normal_year_days;
    }

    $_timestamp = ($days * $_day_sec) + $secs;
    return $_timestamp;
}

function get_days(&$t)
{
    $day_sec = 86400;
    $days = floor($t / $day_sec);
    $t = $t - (floor($t / $day_sec) * $day_sec);
    return $days;
}

function get_date($d)
{
    $leaf_year_days = 366;
    $normal_year_days = 365;
    
    $month_arr[0] = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    $month_arr[1] = array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    $year = 0;
    $month = 0;
    $day = 0;

    $flg = true;
    while($flg)
    {
        $year++;
        if(is_leaf_year($year))
        {
            if($d > $leaf_year_days) $d -= $leaf_year_days;
            else $flg = false;
            $leaf_flg = 1;
        }
        else
        {
            if($d > $normal_year_days) $d -= $normal_year_days;
            else $flg = false;
            $leaf_flg = 0;
        }
    }

    $month_cnt = 0;
    while($d > $month_arr[$leaf_flg][$month_cnt])
    {
        $d -= $month_arr[$leaf_flg][$month_cnt];
        $month_cnt++;
    }
    $month = $month_cnt + 1;
    $day = $d;
    return sprintf("%04d%02d%02d", $year, $month, $day);
}

function get_time($t)
{
    $hour_sec = 3600;
    $min_sec = 60;

    $hour = floor($t / $hour_sec);
    $min = floor(($t % $hour_sec) / $min_sec);
    $sec = $t % $min_sec;

    return sprintf("%02d%02d%02d", $hour, $min, $sec);
}

function cal_date($t)
{
    if($t == "")
    {
        return date("YmdHis");
    }
    else
    {
        $days = get_days(&$t);
        $date = get_date($days);
        $time = get_time($t);
        return $date.$time;
    }
}

function new_date($fmt, $ts=false) {
$gmt_diff = mktime() - gmmktime();
if(!is_int($ts)) $ts = time();
return gmdate($fmt, ($ts - $gmt_diff));
} 

/*
function new_date()
{
    if(func_num_args() != 1 && func_num_args() != 2) return false;
    $format = func_get_arg(0);
    $timestamp = func_get_arg(1);
    $date = cal_date($timestamp);

    $year = substr($date, 0, 4);
    $month = substr($date, 4, 2);
    $day = substr($date, 6, 2);
    $hour = substr($date, 8, 2);
    $min = substr($date, 10, 2);
    $sec = substr($date, 12, 2);

    $out_buf = "";
    for($i = 0; $i < strlen($format); $i++)
    {
        $c = substr($format, $i, 1);
        switch ($c)
        {
            case "a":
                $out_buf .= $hour < 12 ? "am" : "pm";
                break;
            case "A":
                $out_buf .= $hour < 12 ? "AM" : "PM";
                break;
            case "B":
                break;
            case "c":
                break;
            case "d":
                $out_buf .= sprintf("%02d", $day);
                break;
            case "D":
                break;
            case "F":
                break;
            case "g":
                $out_buf .= sprintf("%d", (($hour - 1) % 12) + 1);
                break;
            case "G":
                $out_buf .= sprintf("%d", $hour);
                break;
            case "h":
                $out_buf .= sprintf("%02d", (($hour - 1) % 12) + 1);
                break;
            case "H":
                $out_buf .= sprintf("%02d", $hour);
                break;
            case "i":
                $out_buf .= sprintf("%02d", $min);
                break;
            case "I":
                break;
            case "j":
                $out_buf .= sprintf("%d", $day);
                break;
            case "l":
                break;
            case "L":
                break;
            case "m":
                $out_buf .= sprintf("%02d", $month);
                break;
            case "M":
                break;
            case "n":
                $out_buf .= sprintf("%d", $month);
                break;
            case "O":
                break;
            case "r":
                break;
            case "s":
                $out_buf .= sprintf("%02d", $sec);
                break;
            case "S":
                break;
            case "t":
                break;
            case "T":
                break;
            case "U":
                break;
            case "w":
                break;
            case "W":
                break;
            case "Y":
                $out_buf .= sprintf("%04d", $year);
                break;
            case "y":
                $out_buf .= substr(sprintf("%04d", $year), 2, 2);
                break;
            case "z":
                break;
            case "Z":
                break;
            default :
                $out_buf .= $c;
        }
    }
    return $out_buf;
}
*/
?>