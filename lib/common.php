<?php

function debug($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}

function images($dir) {

    // Sort in descending order
    $b = scandir($dir, 1);
    $total = count($b);

    unset($b[$total - 1]);
    unset($b[$total - 2]);

    return $b;
}

function getTemplate($name, $data = []) {
    extract($data);
    require_once './templates/' . $name . '.php';
}

function redirect($url) {
    header("Location: " . $url . "");
    exit;
}

function computeResult($data, $type) {

    switch ($type) {
        case "json":
            echo json_encode($data);
            die();
        case "css":
            header("Content-type: text/css", true);
            echo $data;
            die();
        case "js":
            header("Content-type: text/javascript", true);
            echo $data;
            die();
        case "xml":
            return "Please code me";
        case "html":
            return $data;
        case "string":
            return $data;
    }

    return $data;
}

/**
 * check if string are the same
 * 
 * @param String $str E.G 'home' or 'home.page,business'
 * convert to array if the is a comma.
 * @param String $reference only 'home'
 * 
 * @return boolean
 * 
 */
function compare($str, $reference) {
    $arr = preg_split('/[,]/', $str);

    foreach ($arr as $name) {
        if ($name == $reference) {
            return true;
        }
    }
    return false;
}

/**
 * check if string are the same
 * 
 * @param String $str E.G 'home' or 'home.page,business'
 * convert to array if the is a comma.
 * @param String $reference only 'home'
 * 
 * @return boolean
 * 
 */
function contain($str, $reference) {
    if (strpos($str, $reference) !== false) {
        return true;
    }
    return false;
}

/**
 * 
 * @param object or array $obj [0]=>array(1)=>['value'] 
 * @param String $var the index
 * @return datatype any.
 * 
 */
function getObjectValue($obj, $var) {
    foreach ($obj as $o1) {
        $array = (array) $o1;
        if (!empty($array[$var])) {
            return $array[$var];
        }
    }
    return null;
}

function getData($obj, $name) {
    if (isset($obj[$name]) || !empty($obj[$name])) {
        return $obj[$name];
    }
    return [];
}

function request($name = "rel") {
    if (isset($_POST[$name])) {
        return $_POST[$name];
    } else if (isset($_GET[$name])) {
        return $_GET[$name];
    } else if (isset($_FILES[$name])) {
        return $_FILES[$name];
    }

    return null;
}

/**
 * check if string session
 * 
 * @param String $str session name

 * 
 * @return string
 * 
 */
function session() {
    if (isset($_COOKIE["session"])) {
        return $_COOKIE["session"];
    }
    $key = uniqid("s.is.is", true);
    setcookie("session", $key, time() + (10 * 365 * 24 * 60 * 60));
    return $key;
}

// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function get_content($filename) {
    if (file_exists($filename)) {
        return file_get_contents($filename);
    }

    return $filename;
}

function strip_tags_content($text, $tags = '', $invert = FALSE) {

    $text = preg_replace('/<(.+?)[\s]*\/?[\s]*>/si', "", trim($text));

    return $text;
}

function set_boolean_output($boolean, $arr) {
    if (is_bool($boolean)) {
        if ($boolean) {
            return $arr[0];
        }
        return $arr[1];
    } else if (is_int($boolean)) {
        if ($boolean == 1) {
            return $arr[0];
        }
        return $arr[1];
    }

    return $boolean;
}

function setPrefix($prefix) {
    $GLOBALS["PREFIX"] = $prefix;
}

function set_db_type($type) {
    $GLOBALS["db_type"] = $type;
}

function db_type() {
    return isset($GLOBALS["db_type"]) ? $GLOBALS["db_type"] : "";
}

function prefix() {
    return isset($GLOBALS["PREFIX"]) ? $GLOBALS["PREFIX"] : "";
}

function filtre($name) {
    return empty($name) ? "" : $name;
}

function upload($file) {

    $FileType = pathinfo(basename($file["name"]), PATHINFO_EXTENSION);
    $target_file = upload_path . md5(uniqid("ss-s-")) . "." . $FileType;

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $target_file;
    }

    return "";
}

function uploadBase64($file, $type) {

    $target_file = upload_path . md5(uniqid("ss-s-")) . time() . $type;
    if (file_put_contents($target_file, base64_decode($file))) {
        return $target_file;
    }
    return "";
}

function paragraph_resize($str, $length) {
    if ($length < strlen($str)) {
        $str_word = "";
        for ($x = 0; $x < $length; $x++) {
            $str_word .= $str[$x];
        }

        return $str_word . "...";
    }
    return $str;
}

function printThis($str) {
    if (is_null($str)) {
        return 'No Data';
    }
    return $str;
}

function flash($name) {
    $message = isset($_SESSION["flash"][$name]) ? $_SESSION["flash"][$name] : "";
    unset($_SESSION["flash"][$name]);
    return $message;
}

function setFlash($name, $message) {
    $_SESSION["flash"][$name] = $message;
}

function isMobile() {
    $useragent = $_SERVER['HTTP_USER_AGENT'];

    if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))){
        return true;
    }
    
    return false;
}


function get_fcontent( $url,  $javascript_loop = 0, $timeout = 5 ) {
    $url = str_replace( "&amp;", "&", urldecode(trim($url)) );

    $cookie = tempnam ("/tmp", "CURLCOOKIE");
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie );
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt( $ch, CURLOPT_ENCODING, "" );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );    # required for https urls
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
    curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
    curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
    $content = curl_exec( $ch );
    $response = curl_getinfo( $ch );
    curl_close ( $ch );

    if ($response['http_code'] == 301 || $response['http_code'] == 302) {
        ini_set("user_agent", "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");

        if ( $headers = get_headers($response['url']) ) {
            foreach( $headers as $value ) {
                if ( substr( strtolower($value), 0, 9 ) == "location:" )
                    return get_url( trim( substr( $value, 9, strlen($value) ) ) );
            }
        }
    }

    if (    ( preg_match("/>[[:space:]]+window\.location\.replace\('(.*)'\)/i", $content, $value) || preg_match("/>[[:space:]]+window\.location\=\"(.*)\"/i", $content, $value) ) && $javascript_loop < 5) {
        return get_url( $value[1], $javascript_loop+1 );
    } else {
        return array( $content, $response );
    }
}