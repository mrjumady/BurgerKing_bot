<?php

/** 
 * HARAM UNTUK DIJUAL LAGI
 * Created By: Jumady (https://web.facebook.com/dyvretz/)
**/


error_reporting(0);
date_default_timezone_set("Asia/Jakarta");

$colors = new Colors();
echo "------------------- ".$colors->getColoredString("SATSET BURGERKING", "green")." -------------------".PHP_EOL.PHP_EOL;
echo " >> ".$colors->getColoredString("CLICK URL IN FILE BurgerKing.txt FOR SHOW UR VOUCHERS CODE", "green")."".PHP_EOL;
echo " >> ".$colors->getColoredString('EXAMPLE "code":"102801820111" >> IS VOUCHERS CODE', "green")."".PHP_EOL;
echo " >> ".$colors->getColoredString("MADE 2022 WITH CUP AND LOVE", "green")."".PHP_EOL;
echo " >> ".$colors->getColoredString("BOT BY JUMADY", "green")."".PHP_EOL;
echo " >> ".$colors->getColoredString("DONATION: https://saweria.co/mrjumady", "green")."".PHP_EOL.PHP_EOL;

if(!file_exists("satset.txt")) {
    inputApikeyOTP:
    $updated = input("[ ".date("H:i:s")." ] -> ".$colors->getColoredString("Apakah Sudah edit data.json? (y/N)? ", "green"));
    if(strtolower($updated) == "y") {
        file_put_contents("satset.txt", "ok");
    } else if(strtolower($updated) == "n") {
        inputKey:
        $key = input("[ ".date("H:i:s")." ] -> ".$colors->getColoredString("Apikey Kamu? ", "green"));
        $durasi = input("[ ".date("H:i:s")." ] -> ".$colors->getColoredString("Waktu Tunggu OTP (detik)? ", "green"));
        file_put_contents("data.json", json_encode(["apikey" => $key, "durasiOTP" => $durasi]));
    } else {
        echo "[ ".date("H:i:s")." ] -> ".$colors->getColoredString("Pilihan Tidak Tersedia", "red").PHP_EOL;
        goto inputApikeyOTP;
    }
}
$readConfig  = json_decode(file_get_contents("data.json"), true);
$apikey = trim($readConfig["apikey"]);
$durasiOTP = trim($readConfig["durasiOTP"]);


if ($apikey) {
    echo "[ ".date("H:i:s")." ] -> ".$colors->getColoredString("Apikey Ditemukan:", "green")." $apikey".PHP_EOL;
} else {
    echo "[ ".date("H:i:s")." ] -> ".$colors->getColoredString("Apikey Tidak Ditemukan", "red").PHP_EOL;
    echo "[ ".date("H:i:s")." ] -> ".$colors->getColoredString("Silakan Input Data Apikey", "red").PHP_EOL;
    goto inputKey;
}

if ($durasiOTP) {
    echo "[ ".date("H:i:s")." ] -> ".$colors->getColoredString("Durasi Tunggu OTP:", "green")." $durasiOTP Detik".PHP_EOL;
} else {
    echo "[ ".date("H:i:s")." ] -> ".$colors->getColoredString("Silakan Input Waktu Durasi", "red").PHP_EOL;
    goto inputKey;
}


/** RANDOM NAMA  **/
$name = get_between(nama(), '{"name":"', '",');
$exNama = explode(' ', $name);
$nama = $exNama[0];
$username = get_between(nama(), '"username":"', '",');
$tglLahir = get_between(nama(), '"birth_data":"', '",');
/** END RANDOM NAMA  **/
        
/** CHECK SALDO SMSHUB **/
$url = "smshub.org";
$saldo = explode(":", GetBalance($url, $apikey));
$saldo = $saldo[1];
echo "[ ".date("H:i:s")." ] -> ".$colors->getColoredString("Sisa Saldo SMSHUB:", "green")." ".$saldo." RUB".PHP_EOL.PHP_EOL;
/** END CHECK SALDO SMSHUB **/


$totalReff = input("[ ".date("H:i:s")." ] -> ".$colors->getColoredString("Jumlah? ", "green"));
for ($ia=1; $ia <= $totalReff; $ia++) {
    echo "----------------------- ".$colors->getColoredString("AKUN KE $ia", "green")." -----------------------".PHP_EOL;
    ulangMintaNomor:
    $getNumber = getNumber($url, $apikey);
    if(preg_match("/ACCESS_NUMBER/", $getNumber)) {
        $exGet = explode(':', $getNumber);
        $idOrder = $exGet[1];
        $nomorHP = '+'.$exGet[2];
        echo "[ ".date("H:i:s")." ] -> ".$colors->getColoredString("Mendaftar Dengan Nomor", "green")." $nomorHP".PHP_EOL;
        $data = '{"mobile_number":"'.$nomorHP.'"}';
        $lenght = strlen($data);
        $headers = [
            "Host: bkdelivery.co.id", 
            "authorization: token Ad1257bJkalknd99alLLyzOdMKGPLoUpTjGjvDyjjLP6mIVrw6Kfnvej5LK2w3J2XGGBz", 
            "content-type: application/json; charset=utf-8",
            "content-length: ".$lenght, 
            "user-agent: okhttp/3.12.1",
        ];
        $reqOTP = curl("https://bkdelivery.co.id/api/auth/validate-phone", $data, $headers);
        $statusOTP = get_between($reqOTP[1], '{"status":"', '",');
        if ($statusOTP == "ok") {
            echo "[ ".date("H:i:s")." ] -> ".$colors->getColoredString("Berhasil Mengirim OTP", "green").PHP_EOL;
            $time = time();
            echo "[ ".date("H:i:s")." ] -> ".$colors->getColoredString("Menunggu OTP selama $durasiOTP Detik", "green").PHP_EOL;
            CheckUlangOTP:
            $funcOTPRegist = GetOtp($url, $apikey, $idOrder);
            $otp = explode(":", $funcOTPRegist);
            $otp = $otp[1];
            if ($otp) {
                $otp = get_between($otp, 'Your OTP is ', ' valid until');
                $otp = trim($otp);
                echo "[ ".date("H:i:s")." ] -> ".$colors->getColoredString("OTP:", "green")." $otp".PHP_EOL;
                $data = '{"otp":"'.$otp.'","mobile_number":"'.$nomorHP.'"}';
                $lenght = strlen($data);
                $headers = [
                    "Host: bkdelivery.co.id",
                    "authorization: token Ad1257bJkalknd99alLLyzOdMKGPLoUpTjGjvDyjjLP6mIVrw6Kfnvej5LK2w3J2XGGBz",
                    "content-type: application/json; charset=utf-8",
                    "content-length: ".$lenght, 
                    "user-agent: okhttp/3.12.1"
                ];
                $tryOTP = curl("https://bkdelivery.co.id/api/auth/validate-otp", $data, $headers);
                $statusTryOTP = get_between($tryOTP[1], '{"status":"', '",');
                if ($statusOTP == "ok") {
                    echo "[ ".date("H:i:s")." ] -> ".$colors->getColoredString("Berhasil Verifikasi OTP", "green").PHP_EOL;
                    $data = '{"mobile_number":"'.$nomorHP.'","name":"'.$nama.'","email":"'.$username.'@gmail.com","birthday":"'.$tglLahir.'","gender":1,"registration_method":9}';
                    $lenght = strlen($data);
                    $headers = [
                        "Host: bkdelivery.co.id",
                        "authorization: token Ad1257bJkalknd99alLLyzOdMKGPLoUpTjGjvDyjjLP6mIVrw6Kfnvej5LK2w3J2XGGBz",
                        "content-type: application/json; charset=utf-8",
                        "content-length: ".$lenght, 
                        "user-agent: okhttp/3.12.1"
                    ];
                    $tryRegister = curl("https://bkdelivery.co.id/api/auth/register", $data, $headers);
                    $dataRegister = get_between($tryRegister[1], '{"user":{"id":', ',"');
                    if ($dataRegister) {
                        echo "[ ".date("H:i:s")." ] -> ".$colors->getColoredString("Berhasil Mendaftar", "green").PHP_EOL;
                        $getSessionID = get_between($tryRegister[0], 'session_key: ', 'allow');
                        echo "[ ".date("H:i:s")." ] -> ".$colors->getColoredString("$namavoucher >> $getvoucher", "green").PHP_EOL;
                        file_put_contents("BurgerKing.txt", $nomorHP." - https://crm.bkdelivery.co.id/mobile-api/v2/vouchers/?use_html_terms_and_conditions=true&token=g48hke4d04vn96oj6rhsusp0wur0i43nzs36w3vdttgc90rajp&session_key=$getSessionID".PHP_EOL, FILE_APPEND);
                    } else {
                        echo "[ ".date("H:i:s")." ] -> ".$colors->getColoredString("Gagal Mendaftar", "red").PHP_EOL.PHP_EOL;
                        $funcDeleteOtp = ChangeCancel($url, $apikey, $idOrder);
                        goto ulangMintaNomor;
                    }   
                } else {
                    $ChangeCancel = ChangeCancel($url, $apikey, $idOrder);
                    echo "[ ".date("H:i:s")." ] -> ".$colors->getColoredString("Gagal Verifikasi OTP", "red").PHP_EOL.PHP_EOL;
                    goto ulangMintaNomor;
                }
            } else {
                if (time()-$time > $durasiOTP) {
                    echo "[ ".date("H:i:s")." ] -> ".$colors->getColoredString("Gagal Mendapatkan OTP", "red").PHP_EOL.PHP_EOL;
                    $funcDeleteOtp = ChangeCancel($url, $apikey, $idOrder);
                    goto ulangMintaNomor;
                } else {
                    goto CheckUlangOTP;
                }
            }
        } else {
            $ChangeCancel = ChangeCancel($url, $apikey, $idOrder);
            echo "[ ".date("H:i:s")." ] -> ".$colors->getColoredString("Gagal Mnegirim OTP", "red").PHP_EOL;
        }
    } else {
        echo "[ ".date("H:i:s")." ] -> ".$colors->getColoredString("Gagal Mendapatkan Nomor. Check saldo/stok OTP", "red").PHP_EOL;
    }

}

function GetBalance($url, $apikey) {
    $get = file_get_contents("https://".$url."/stubs/handler_api.php?api_key=".$apikey."&action=getBalance");
    return $get;
}

function getNumber($url, $apikey) {
    $get = file_get_contents("https://".$url."/stubs/handler_api.php?api_key=".$apikey."&action=getNumber&service=ot&operator=&country=6");
    return $get;
}

function ChangeConfirm($url, $apikey, $idOrder) {
    $get = file_get_contents("https://".$url."/stubs/handler_api.php?api_key=".$apikey."&action=setStatus&status=6&id=".$idOrder);
    return $get;
}

function RetrySMS($url, $apikey, $idOrder) {
    $get = file_get_contents("https://".$url."/stubs/handler_api.php?api_key=".$apikey."&action=setStatus&status=3&id=".$idOrder);
    return $get;
}

function ChangeCancel($url, $apikey, $idOrder) {
    $get = file_get_contents("https://".$url."/stubs/handler_api.php?api_key=".$apikey."&action=setStatus&status=8&id=".$idOrder);
    return $get;
}

function GetOtp($url, $apikey, $idOrder) {
    $get = file_get_contents("https://".$url."/stubs/handler_api.php?api_key=".$apikey."&action=getStatus&id=".$idOrder);
    return $get;
}

function input($text) {
    echo $text;
    $a = trim(fgets(STDIN));
    return $a;
}

function get_between($string, $start, $end) {
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
}

function randomToken($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstvwxyzABCDEFGHIJKLMNOPQRSTVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function nama() {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.namefake.com/indonesian-indonesia");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$ex = curl_exec($ch);
	return $ex;
}

function curl($url, $post = 0, $httpheader = 0, $proxy = 0){ // url, postdata, http headers, proxy, uagent
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        if($post){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if($httpheader){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
        }
        if($proxy){
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
            // curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        }
        curl_setopt($ch, CURLOPT_HEADER, true);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch);
        if(!$httpcode) return "Curl Error : ".curl_error($ch); else{
            $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
            $body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
            curl_close($ch);
            return array($header, $body);
        }
    }


function curlget($url,$post,$headers) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    $headers == null ? curl_setopt($ch, CURLOPT_POST, 1) : curl_setopt($ch, CURLOPT_HTTPGET, 1);
	if ($headers !== null) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	$result = curl_exec($ch);
	$header = substr($result, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	$body = substr($result, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	preg_match_all("/^Set-Cookie:\s*([^;]*)/mi", $result, $matches);
	$cookies = array()
;	foreach($matches[1] as $item) {
	  parse_str($item, $cookie);
	  $cookies = array_merge($cookies, $cookie);
	}
	return array (
	$header,
	$body,
	$cookies
	);
}

class Colors {
    private $foreground_colors = array();
    private $background_colors = array();

    public function __construct() {
        // Set up shell colors
        $this->foreground_colors["black"] = "0;30";
        $this->foreground_colors["dark_gray"] = "1;30";
        $this->foreground_colors["blue"] = "0;34";
        $this->foreground_colors["light_blue"] = "1;34";
        $this->foreground_colors["green"] = "0;32";
        $this->foreground_colors["light_green"] = "1;32";
        $this->foreground_colors["cyan"] = "0;36";
        $this->foreground_colors["light_cyan"] = "1;36";
        $this->foreground_colors["red"] = "0;31";
        $this->foreground_colors["light_red"] = "1;31";
        $this->foreground_colors["purple"] = "0;35";
        $this->foreground_colors["light_purple"] = "1;35";
        $this->foreground_colors["brown"] = "0;33";
        $this->foreground_colors["yellow"] = "1;33";
        $this->foreground_colors["light_gray"] = "0;37";
        $this->foreground_colors["white"] = "1;37";

        $this->background_colors["black"] = "40";
        $this->background_colors["red"] = "41";
        $this->background_colors["green"] = "42";
        $this->background_colors["yellow"] = "43";
        $this->background_colors["blue"] = "44";
        $this->background_colors["magenta"] = "45";
        $this->background_colors["cyan"] = "46";
        $this->background_colors["light_gray"] = "47";
    }

    // Returns colored string
    public function getColoredString($string, $foreground_color = null, $background_color = null) {
        $colored_string = "";

        // Check if given foreground color found
        if (isset($this->foreground_colors[$foreground_color])) {
            $colored_string .= "\033[" . $this->foreground_colors[$foreground_color] . "m";
        }
        // Check if given background color found
        if (isset($this->background_colors[$background_color])) {
            $colored_string .= "\033[" . $this->background_colors[$background_color] . "m";
        }

        // Add string and end coloring
        $colored_string .=  $string . "\033[0m";

        return $colored_string;
    }

    // Returns all foreground color names
    public function getForegroundColors() {
        return array_keys($this->foreground_colors);
    }

    // Returns all background color names
    public function getBackgroundColors() {
        return array_keys($this->background_colors);
    }
}
