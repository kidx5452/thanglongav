<?php
namespace Webapp\Frontend\Utility;
class Helper
{

    public static function encryptpassword($pass)
    {
        return md5(md5($pass));
    }

    public static function post_to_array($param)
    {
        $param = explode(",", $param);
        $arr = array();
        foreach ($param as $item) $arr[$item] = Helper::xss_clean($_POST[$item]);
        return $arr;
    }

    public static function cpagerparm($para_need_remove='', $suffixctr = null)
    {
        $request = new \Phalcon\Http\Request();
        $pa = $request->getQuery();
        $controller = $pa['_url'];
        unset($pa['_url']);
        ##Remove Item
        $s = explode(',', $para_need_remove);
        foreach ($s as $item) unset($pa["$item"]);
        ## Append Querystring
        $str = '';
        foreach ($pa as $key => $val) {
            if (is_array($val)) {
                foreach ($val as $sitem) $hs .= $key . '[]=' . $sitem . '&';
                $str .= $hs;
            } else $str .= $key . '=' . $val . '&';
        }
        if ($suffixctr == null) $link = $controller . "?" . $str;
        else $link = $suffixctr . "?" . $str;
        $link = rtrim($link, "&");
        return $link;
    }

    public static function paginginfo($rowcount, $limit, $page, $pagelimit = 3)
    {
        if ($page <= 1) $page = 1;
        $totalpage = ceil($rowcount / $limit);
        $startpaging = $page - $pagelimit;
        if ($startpaging <= 1) $startpaging = 1;
        $endpaging = $page + $pagelimit;
        if ($endpaging >= $totalpage) $endpaging = $totalpage;
        if ($endpaging <= $startpaging) $endpaging = $startpaging = 1;
        $paginginfo = array("rowcount" => $rowcount, "rangepage" => range($startpaging, $endpaging), "totalpage" => $totalpage, "page" => $page, "currentlink" => Helper::cpagerparm("p"), "maxpage" => $pagelimit, "limit" => $limit);
        return $paginginfo;
    }

    public static function br2nl($input)
    {
        return preg_replace('/<br(\s+)?\/?>/i', "\n", $input);
    }

    public static function nl2br2($string)
    {
        $string = str_replace(array("\r\n", "\r", "\n"), "<br />", $string);
        return $string;
    }

    public static function xss_clean($data)
    {
        if (is_array($data)) $data = array_map(array(self, "xss_process"), $data);
        else $data = self::xss_process($data);
        return $data;
    }

    private static function xss_process($data)
    {
        // Fix &entity\n;
        $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        do {
            // Remove really unwanted tags
            $old_data = $data;
            $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        } while ($old_data !== $data);

        // we are done...
        return $data;
    }

    public static function Cleanurl($text)
    {

        $text = str_replace('-', ' ', $text);
        $text = str_replace(' -', ' ', $text);
        $text = str_replace(array('&apos;', '&quot;'), '', $text);

        $text = preg_replace('/[^a-zA-Z0-9_ -,.]/s', '', $text);
        $text = trim($text);

        $stripped = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $text);

        $text = strtolower($stripped);
        $text = str_replace(',', ' ', $text);

        $code_entities_match = array(' ', '--', '&quot;', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '{', '}', '|', ':', '"', '<', '>', '?', '[', ']', '\\', ';', "'", ',', '.', '/', '*', '+', '~', '`', '=');

        $code_entities_replace = array('-', '-', '', '', '', '', '', '', '', '', '', '', '', '-', '-', '', '', '', '', '', '', '', '', '', '', '');

        $text = str_replace($code_entities_match, $code_entities_replace, $text);
        return $text;
    }

    public static function khongdau($text)
    {
        $marTViet = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ",
            "è", "é", "ẹ", "ẻ", "ẽ", "ê", "�?", "ế", "ệ", "ể", "ễ",
            "ì", "í", "ị", "ỉ", "ĩ",
            "ò", "ó", "�?", "�?", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "�?", "ớ", "ợ", "ở", "ỡ",
            "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
            "ỳ", "ý", "ỵ", "ỷ", "ỹ",
            "đ",
            "À", "�?", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă"
        , "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
            "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
            "Ì", "�?", "Ị", "Ỉ", "Ĩ",
            "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "�?", "Ộ", "Ổ", "Ỗ", "Ơ"
        , "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
            "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
            "Ỳ", "�?", "Ỵ", "Ỷ", "Ỹ",
            "�?");

        $marKoDau = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a",
            "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
            "i", "i", "i", "i", "i",
            "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o",
            "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
            "y", "y", "y", "y", "y",
            "d",
            "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A"
        , "A", "A", "A", "A", "A",
            "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
            "I", "I", "I", "I", "I",
            "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O"
        , "O", "O", "O", "O", "O",
            "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
            "Y", "Y", "Y", "Y", "Y",
            "D");
        $str = str_replace($marTViet, $marKoDau, $text);
        return $str;
    }

    public static function mb_wordwrap($string, $limit)
    {
        $string = strip_tags($string); //Strip HTML tags off the text
        $string = html_entity_decode($string); //Convert HTML special chars into normal text
        $string = str_replace(array("\r", "\n"), "", $string); //Also cut line breaks
        if (mb_strlen($string, "UTF-8") <= $limit) return $string; //If input string's length is no more than cut length, return untouched
        $last_space = mb_strrpos(mb_substr($string, 0, $limit, "UTF-8"), " ", 0, "UTF-8"); //Find the last space symbol position
        return mb_substr($string, 0, $last_space, "UTF-8") . ' ...'; //Return the string's length substracted till the last space and add three points
    }
    public static function inttochar($int){
        $a[0] = "a";
        $a[1] = "a";
        $a[2] = "b";
        $a[3] = "c";
        $a[4] = "d";
        $a[5] = "e";
        $a[6] = "f";
        $a[7] = "g";
        return $a[$int];
    }
    public static function startsWith($haystack, $needle) // full String - param
    {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }

    public static function endsWith($haystack, $needle) //full String - param
    {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
    }

    public static function get_client_ip() {
        $ipaddress = '';
        if ($_SERVER['HTTP_CLIENT_IP'])
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if($_SERVER['HTTP_X_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if($_SERVER['HTTP_X_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if($_SERVER['HTTP_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if($_SERVER['HTTP_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if($_SERVER['REMOTE_ADDR'])
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public static function subWords($string,$start,$length){
        $arrstring=explode(" ",$string); //convert string to array
        if (count($arrstring) > $length) {
            $arrsubstring=array_slice($arrstring,$start,$length) ; //return array with start position and number of word
            $result=implode(" ",$arrsubstring)."...";// return n word after sub
        } else $result = $string;
        return $result;
    }

    public static function getday($datecreate){
        $thang = date("m",$datecreate);
        $ngay = date("d",$datecreate);
        $nam = date("Y",$datecreate);
        $jd=cal_to_jd(CAL_GREGORIAN,$thang,$ngay,$nam);
        $day=jddayofweek($jd,0);
        switch($day)
        {
            case 0: $thu="Chủ Nhật"; break;
            case 1: $thu="Thứ Hai"; break;
            case 2: $thu="Thứ Ba"; break;
            case 3: $thu="Thứ Tư"; break;
            case 4: $thu="Thứ Năm"; break;
            case 5: $thu="Thứ Sáu"; break;
            case 6: $thu="Thứ Bảy"; break;
        }
        return $thu;
    }
    public static function isMobile()
    {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

    public static function get_youtube_id($input) {
        $input = preg_match('~https?://(?:[0-9A-Z-]+\.)?(?:youtu\.be/|youtube(?:-nocookie)?\.com\S*[^\w\s-])([\w-]{11})(?=[^\w-]|$)(?![?=&+%\w.-]*(?:[\'"][^<>]*>|</a>))[?=&+%\w.-]*~ix', $input,$match);
        return $match;
    }

    public static function youtube_vimeo_thumb($url){
        $image_url = parse_url($url);
        if($image_url['host'] == 'www.youtube.com' ||
            $image_url['host'] == 'youtube.com'){
            $array = explode("&", $image_url['query']);
            return "http://img.youtube.com/vi/".substr($array[0], 2)."/0.jpg";
        }else if($image_url['host'] == 'www.youtu.be' ||
            $image_url['host'] == 'youtu.be'){
            $array = explode("/", $image_url['path']);
            return "http://img.youtube.com/vi/".$array[1]."/0.jpg";
        }else if($image_url['host'] == 'www.vimeo.com' ||
            $image_url['host'] == 'vimeo.com'){
            $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/".
                substr($image_url['path'], 1).".php"));
            return $hash[0]["thumbnail_medium"];
        }
    }

    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function sendMail($mailSubject,$mailContent,$mailAddress,$cc=false,$ccMail=''){
        require_once 'PHP-Mailer/PHPMailerAutoload.php';
        $mail = new PHPMailer;
        $mail->isSMTP();

        $mail->Debugoutput = "html";
        $mail->SMTPDebug  = 0;
        // Set mailer to use SMTP
        $mail->Host = "smtp.sendgrid.net";   // Specify main and backup server
        $mail->Port = 25;
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username   = "adonly";         // SMTP account username
        $mail->Password   = "Socson09";
        //$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
        $mail->SetFrom('support@wsi.vn','Woodstock English Institution');
        $mail->AddReplyTo('support@wsi.vn','Woodstock English Institution');
        /*$mail->From = $from;
        $mail->FromName = $fromName;
        */
        $mail->Subject = $mailSubject;
        $mail->addAddress($mailAddress);
        $mail->isHTML(true);
        if($cc) $mail->addCC($ccMail);

        $mail->WordWrap = 50;   // Set word wrap to 50 characters
        $mail->CharSet = "UTF-8";
        /*
        $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');
        */
        /*
        $mailHtml = file_get_contents('PHP-Mailer/template.html');
        $mailHtml = str_replace('[mailContent]',$mailContent,$mailHtml);
        $mailHtml = str_replace('[BASE_URL]','https://adonly.com/',$mailHtml);
        */
        $mailHtml = $mailContent;
        $mail->MsgHTML($mailHtml);
        if($mail->send()) {
            return true;
        }else return 'Mailer Error: ' . $mail->ErrorInfo;
    }
    public static function randomcolor()
    {
        return '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
    }
}