<?php

/**
 * 工具类
 *
 * @author gray code
 */
class Tool {

    /**
     * curl
     * @param type $url
     * @param type $data
     * @return type
     */
    public static function HttpCurl($url, $data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        return $result;
        curl_close($ch);
    }

    /**
     * 输出错误信息
     * @param type $smg
     */
    public static function printErrorMsg($smg) {
        //self::HttpCurl("http://120.55.243.27:8088", $smg."\n");
        $handle = @fopen("app_log/app.log", "a+");
        @fwrite($handle, date("Y-m-d H:i:s") . ": {$smg}\n");
        @fclose($handle);
    }

    /**
     * 过滤指定字符串
     * @param type $type
     * @return type
     */
    public static function strReplace($type) {
        $replace = array(",", ".", "[", "]", "<", ">", "?", "`", "~", "@", "#", "$", "%", "^", "&", "*", "(", ")", "-", "_", "=");
        foreach ($replace as $val) {
            $type = str_replace($val, "", $type);
        }
        return $type;
    }

    /**
     * 获取本周时间
     * @param type $type 1:周,2:月,3:季度，4：年
     * @return type
     */
    public static function getTimeSection($type = 1) {
        if ($type == 1) {
            $week = date("w");
            $tm = 0;
            switch ($week) {
                case 0:
                    $tm = 6;
                    break;
                case 1:
                    $tm = 0;
                    break;
                case 2:
                    $tm = 1;
                    break;
                case 3:
                    $tm = 2;
                    break;
                case 4:
                    $tm = 3;
                    break;
                case 5:
                    $tm = 4;
                    break;
                case 6:
                    $tm = 5;
                    break;
            }
            $nowTime = time();
            $pastTime = strtotime(date("Y-m-d", strtotime("-{$tm} day")));
        } else if ($type == 2) {
            $day = date("d");
            if ($day > 1) {
                $day = $day - 1;
            }
            $nowTime = time();
            $pastTime = strtotime(date("Y-m-d", strtotime("-{$day} day")));
        } else if ($type == 3) {
            $month = (int) date("m");
            if ($month >= 3) {
                $month = $month - 3;
            } else if ($month >= 6) {
                $month = $month - 6;
            } else if ($month >= 9) {
                $month = $month - 9;
            }
            $nowTime = time();
            $pastTime = strtotime(date("Y-m" . "-01", strtotime("-{$month} month")));
        } else {
            $pastTime = strtotime(date("Y" . "-01-01"));
            $nowTime = time();
        }
        return array("nowTime" => $nowTime, "pastTime" => $pastTime);
    }

    /**
     * 获取请求ip
     * @return ip地址
     */
    public static function ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $ips = explode(',', $ip);
        if (count($ips > 1)) {
            $ip = $ips[0];
        }
        return $ip;
    }

}
