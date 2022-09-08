<?php
namespace Boot;

if (!is_file("../vendor/autoload.php"))
    throw new \Exception("Missing vendor/autoload.php");
include_once "../vendor/autoload.php";
include_once "../vendor/theframework/bootstrap.php";
include_once "../boot/appbootstrap.php";

use \BOOT;
use \ENV;
use TheFramework\Components\ComponentRouter;
use \Throwable;

final class IndexMain
{
    private const SESSION_TIME_SECONDS = 60 * 30;//30 min
    private array $routes;

    public function __construct()
    {
        $this->_load_session();
        $this->routes = include_once "../src/Shared/Infrastructure/routes/routes.php";
        $this->_load_cors_headers();
    }

    private function _load_session(): void
    {
        session_name(getenv("APP_COOKIEID") ?: "MARKETINGID");
        ini_set("session.save_path","/tmp");
        session_start();
        //setcookie(name, value, expire, path, domain, secure, httponly);
        setcookie(session_name(), session_id(), 2147483647, "/");

        if (!isset($_SESSION["last_activity"])) $_SESSION["last_activity"] = time();

        if (($_SESSION["last_activity"] + self::SESSION_TIME_SECONDS) < time()) {
            $_SESSION = ["last_activity" => time()];
            return;
        }

        $_SESSION["last_activity"] = time();
    }

    private function _load_cors_headers(): void
    {
        if (isset($_SERVER["HTTP_ORIGIN"])) {
            //No "Access-Control-Allow-Origin" header is present on the requested resource.
            //should do a check here to match $_SERVER["HTTP_ORIGIN"] to a
            //whitelist of safe domains
            header("Access-Control-Allow-Origin: {$_SERVER["HTTP_ORIGIN"]}");
            header("Access-Control-Allow-Credentials: true");
            header("Access-Control-Max-Age: 86400");    // cache for 1 day
            //header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token");
        }
// Access-Control headers are received during OPTIONS requests
        if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
            if(isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
                header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

            if(isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
                header("Access-Control-Allow-Headers: {$_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]}");
        }
//si se está en producción se desactivan los mensajes en el navegador
        if (($_ENV["APP_ENV"] ?? "")===ENV::PROD) {
            $today = date("Ymd");
            ini_set("display_errors",0);
            ini_set("log_errors",1);
            //Define where do you want the log to go, syslog or a file of your liking with
            ini_set("error_log",BOOT::PATH_LOGS."/error/sys_$today.log");
        }
    }

    private function _get_language(): string
    {
        return trim($_GET["lang"] ?? "")
                ?: trim($_COOKIE["lang"] ?? "")
                ?: trim($_SESSION["lang"] ?? "")
                ?: trim($_ENV["lang"] ?? "")
                ?: trim($_ENV["APP_DEFAULT_LANG"] ?? "")
                ?: "en";
    }

    private function _error_response(array $response): void
    {
        $jsonheader = array_filter(getallheaders(), function ($v, $k) {
            $k = strtolower(trim($k));
            $v = strtolower(trim($v));
            return ($k === "accept" && $v==="application/json");
        }, ARRAY_FILTER_USE_BOTH);

        http_response_code($response["code"]);
        if ($jsonheader) {
            echo json_encode($response);
            return;
        }

        $_SESSION["global_error"] = $response;
        header("Location:/error/bad-request-400");
        die;
    }
    
    public function exec(): void
    {
        $router = new ComponentRouter($this->routes);
        $arrundata = $router->get_rundata();
        $this->routes = []; unset($router);
        
        if($methods = ($arrundata["allowed"] ?? [])) {
            if(!in_array($method = strtolower($_SERVER["REQUEST_METHOD"]), $methods)) {
                $response = [
                    "code" => 400,
                    "status" => false,
                    "errors" => [
                        "request method {$method} not allowed",
                    ],
                    "data" => []
                ];
                self::_error_response($response);
            }
        }

        if(!$_POST && $json = file_get_contents("php://input")) 
            $_POST = json_decode($json, 1);

        $_REQUEST["APP_ACTION"] = $arrundata;
        $_REQUEST["lang"] = $this->_get_language();

        $oController = new $arrundata["controller"]();
        $oController->{$arrundata["method"]}(
            ...($arrundata["_args"] ?? [])
        );
    }

    public static function on_error(Throwable $ex): void
    {
        $uuid = uniqid();
        lgerr($_SERVER["REQUEST_URI"] ?? "", "index-exception REQUEST_URI", "error");
        if ($_POST) lgerr($_POST,"index-exception $uuid POST", "error");
        if ($_GET) lgerr($_GET,"index-exception $uuid GET", "error");
        if ($_SESSION) lgerr($_SESSION,"index-exception $uuid SESSION", "error");
        if ($_REQUEST) lgerr($_REQUEST,"index-exception $uuid REQUEST", "error");
        if ($_ENV) lgerr($_ENV,"index-exception $uuid ENV", "error");
        lgerr($ex->getMessage(), "index-exception $uuid message", "error");
        lgerr($ex->getTraceAsString(),"index-exception $uuid TRACE", "error");
        lgerr($ex->getFile()." : (line: {$ex->getLine()})", "file-line $uuid", "error");

        $code = $ex->getCode()!==0 ? $ex->getCode(): 500;
        $response = [
            "code" => $code,
            "status" => false,
            "errors" => [
                "Sorry! but some unexpected error occurred. 😞 ($uuid)",
                $uuid,
                date("Y-m-d H:i:s")
            ],
            "data" => []
        ];
        self::_error_response($response);
    }

    public static function debug(Throwable $ex): void
    {
        if (ENV::is_prod()) return;
        if (!ENV::is_debug()) return;

        $content = [];
        $content["Exception"] = $ex->getMessage();
        $content["File"] = $ex->getFile()."(".$ex->getLine().")";
        $code = $ex->getCode()!==0 ? $ex->getCode(): 500;
        $content["response"] = $code;

        if ($_POST) $content["POST"] = var_export($_POST, 1);
        if ($_GET) $content["GET"] = var_export($_GET, 1);
        if ($_SESSION) $content["SESSION"] = var_export($_SESSION, 1);
        if ($_REQUEST) $content["REQUEST"] = var_export($_REQUEST, 1);
        if ($_ENV) $content["ENV"] = var_export($_ENV, 1);

        echo "<pre>";
        print_r($content);
        //echo json_encode($content);
    }
}