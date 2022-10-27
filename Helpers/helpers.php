<?php


/**
 * @param $data
 * @return array|string
 */
function post($data = null)
{
    if ($data) {
        if (isset($_POST[$data]) && is_array($_POST[$data])) {
            foreach ($_POST[$data] as $key => $value) {
                if (is_bool($value)) {
                    $_POST[$data][$key] = $value;
                } else {
                    $_POST[$data][$key] = dataClear($value);
                }
            }
            return $_POST;
        } else {
            return isset($_POST[$data]) ? dataClear($_POST[$data]) : "";
        }
    } else {
        if (isset($_POST) && is_array($_POST)) {
            foreach ($_POST as $key => $value) {
                if (is_bool($value)) {
                    $_POST[$key] = $value;
                } else {
                    $_POST[$key] = dataClear($value);
                }
            }
            return $_POST;
        } else {
            return $_POST ? dataClear($_POST) : "";
        }
    }
}

/**
 * @param $data
 * @return array|string
 */
function get($data)
{
    if (!isset($_GET[$data])) {
        return null;
    }
    if (is_array($_GET[$data])) {
        foreach ($_GET[$data] as $key => $value) {
            $_GET[$data][$key] = $value ? htmlspecialchars(trim(strip_tags($value))) : null;
        }
        return $_GET[$data];
    } else {
        return $_GET[$data] ? htmlspecialchars(trim(strip_tags($_GET[$data]))) : null;
    }
}


/**
 * @param $data
 * @return array|string
 */
function dataClear($data)
{
    if (isset($data) && is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = dataClear($value);
        }
        return $data;
    } else {
        return isset($data) ? is_bool($data) ? ($data ? true : false) : htmlspecialchars(trim(strip_tags($data))) : "";
    }
}

/**
 * @param $data
 * @return string|null
 */
function operators($data)
{
    $operators = [
        "eq" => "=",
        "neq" => "!=",
        "gt" => ">",
        "gte" => ">=",
        "lt" => "<",
        "lte" => "<=",
        "like" => "LIKE",
        "nlike" => "NOT LIKE",
        "in" => "IN",
        "nin" => "NOT IN",
        "between" => "BETWEEN",
        "nbetween" => "NOT BETWEEN",
        "null" => "IS NULL",
        "nnull" => "IS NOT NULL",
    ];

    if (isset($operators[$data])) {
        return $operators[$data];
    } else {
        return null;
    }

}

/**
 * @param $key
 * @param null $default
 * @return mixed|null
 */
function config($key, $default = null)
{
    return \Arrilot\DotEnv\DotEnv::get($key, $default);
}

/**
 * @param $pass
 * @return string
 */
function standartPass($pass)
{
    return sha1(md5($pass));
}

/**
 * @param $pass
 * @return bool|false|string|null
 */
function passwordHash($pass)
{
    $pass = standartPass($pass);
    return password_hash($pass, PASSWORD_BCRYPT);
}

/**
 * @param $pass
 * @param $hash
 * @return bool
 */
function passwodVerify($pass, $hash)
{
    $pass = standartPass($pass);
    return password_verify($pass, $hash);
}


/**
 * @return \Core\Auth
 */
function sesion()
{
    return \Core\Auth::getInstance();
}

/**
 * @param $url
 * @return string
 */
function base_url($url = "")
{
    return config("BASE_URL") . $url;
}

/**
 * @param $url
 * @return string
 */
function store_url($url = "")
{
    return config("STORE_URL");
}

/**
 * @param $path
 * @return string
 */
function assets($path = "")
{
    return base_url("public/views/assets/" . $path);
}


/**
 * @param array $content
 * @param int $status_code
 */
function response($data = [], $status_code = 200)
{
    $response = new \Symfony\Component\HttpFoundation\Response();
    $response->headers->set('Access-Control-Allow-Origin', '*');
    $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    $response->headers->set('Access-Control-Allow-Credentials', 'true');
    $response->setStatusCode($status_code);
    $response
        ->headers
        ->set('Content-type', 'application/json');
    $response->setContent(json_encode($data));
    $response->send();
}

/**
 * @param $data
 * @param int $status_code
 */
function responseHtml($content, $status_code = 200)
{
    $response = new \Symfony\Component\HttpFoundation\Response();
    $response->headers->set('Access-Control-Allow-Origin', '*');
    $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    $response->headers->set('Access-Control-Allow-Credentials', 'true');
    $response->setStatusCode($status_code);
    $response
        ->headers
        ->set('Content-type', 'text/html');
    $response->setContent($content);
    $response->send();
}


/**
 * @param $string
 * @return string[]
 */
function stringToArray($string)
{
    $string = str_replace(" ", "", $string);
    $string = str_replace("[", "", $string);
    $string = str_replace("]", "", $string);
    $string = str_replace('"', "", $string);
    $string = str_replace("'", "", $string);
    $string = explode(",", $string);
    return $string;
}


/**
 * @param $msg
 * @param string $type
 */
function message($msg, $type = 'error')
{
    $data = json_encode(['message' => $msg, 'type' => $type]);
    $time = time() + 2;
    setcookie("message", $data, $time, "/");
}


function getMessage()
{
    return isset($_COOKIE['message']) ? json_decode($_COOKIE['message'], true) : null;
}

/**
 * @param $name
 * @return bool|mixed
 */

function cookie($name)
{
    if (isset($_COOKIE[$name])) {
        return json_decode($_COOKIE[$name]);
    }
    return false;
}

function token()
{
    return \Core\Token::getInstance();
}


function createToken($payload = [])
{
    return token()->generate($payload);
}

function decodeToken($token)
{
    return token()->decode($token);
}

/**
 * @param $text
 * @param string $prefix
 * @return string
 */

function slug($text, $prefix = "-")
{
    $slug = new Cocur\Slugify\Slugify();
    return $slug->slugify($text, $prefix);
}


function textToShort($text, $limit = 100, $end = '...')
{
    $text = slug($text, "");


    if (strlen($text) > $limit) {
        $text = substr($text, 0, $limit);
        $text = $text . $end;
    } else {
        $text = $text . $end;
    }
    return $text;


}

/**
 * @param $date
 * @param string $format
 * @return string
 */
function format_date($date, $format = 'd/F/Y H:i')
{
    $date_formatter = new \Jenssegers\Date\Date();
    $date_formatter->setLocale('tr');
    return $date_formatter->parse($date)->format($format);
}


/**
 * @param $money
 * @return string
 */
function money($money)
{
    return number_format($money, 2, ",", ".");
}

/**
 * @param $url
 * @return void
 */
function redirect($url): void
{
    $redirect = new \Symfony\Component\HttpFoundation\RedirectResponse($url);
    $redirect->send();
}

/**
 * @param $data
 * @return string|void
 * @throws Exception
 */
function guid($data = null)
{
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}


function controllerResponse($headers, $message = "", $data = null, $status = true, $status_code = 200)
{
    $requestURL = $_SERVER['REQUEST_URI'];
    $referer = isset($headers['referer'][0]) ? $headers['referer'][0] : (isset($headers['Referer'][0]) ? $headers['Referer'][0] : base_url(''));
    $returnType = isset($headers['Return-Type'][0]) ? $headers['Return-Type'][0] : (isset($headers['return-type'][0]) ? $headers['return-type'][0] : (strpos($requestURL, 'api') ? "json" : "message"));
    $htmlTemplate = isset($headers['Html-Template'][0]) ? $headers['Html-Template'][0] : (isset($headers['html-template'][0]) ? $headers['html-template'][0] : null);
    $returnType = strtolower($returnType);


    if ($returnType == "json") {
        response(["message" => $message, 'status' => $status, 'data' => $data], $status_code);
    } else if ($returnType == "message") {
        message($message, is_bool($status) ? ($status && ($status_code == 200 || $status_code == 201) ? "success" : "danger") : $status);
        redirect($referer);
    } else if ($returnType == "html") {
        if (!empty($htmlTemplate)) {
            $m = new Mustache_Engine(array('entity_flags' => ENT_QUOTES));
            $data = isset($data['data']) ? $data['data'] : $data;
            $html = $m->render($htmlTemplate, $data);
            responseHtml($html, $status_code);
        } else {
            response(["message" => "'Html-Template' not empty ", 'status' => false, 'data' => null], 500);
        }


    }
}


function toPlural($word)
{
    $inflect = new \Core\Inflect();
    return $inflect->pluralize($word);
}

function toSingular($word)
{
    $inflect = new \Core\Inflect();
    return $inflect->singularize($word);
}


function toCamelCase($word)
{
    $inflect = new \Core\Inflect();
    return $inflect->camelize($word);
}

function toEnglish($word)
{
    $inflect = new \Core\Inflect();
    return $inflect->converLetterTRToEN($word);
}

/**
 * @param $word
 * @return false|int
 */
function hasNumber($word)
{
    return preg_match('/[0-9]/', $word);
}

/**
 * @param $tableName
 * @return \Illuminate\Database\Query\Builder
 */
function table($tableName)
{
    return \Illuminate\Database\Capsule\Manager::table($tableName);
}


/**
 * @param $tableName
 * @return \Illuminate\Database\Query\Builder
 */
function sql($sql)
{
    return \Illuminate\Database\Capsule\Manager::select($sql);
}


?>
