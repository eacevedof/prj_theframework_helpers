<?php
namespace App\Restrict\Auth\Application;

use App\Shared\Infrastructure\Services\AppService;
use App\Shared\Infrastructure\Factories\ServiceFactory as SF;
use TheFramework\Components\Formatter\ComponentMoment;
use TheFramework\Components\Session\ComponentEncdecrypt;

final class CsrfService extends AppService
{
    private ?array $autuser;
    private ComponentEncdecrypt $encdec;
    private const VALID_TIME_IN_MINS = 180;

    public function __construct()
    {
        $this->encdec = $this->_get_encdec();
        $this->autuser = SF::get_auth()->get_user();
    }

    private function _get_domain(): string {return $_SERVER["REMOTE_HOST"] ?? "";}

    private function _get_remote_ip(): string {return $_SERVER["REMOTE_ADDR"] ?? "127.0.0.1";}

    private function _get_user_agent(): string {return $_SERVER["HTTP_USER_AGENT"] ?? ":)"; }

    private function _validate_package(array $arpackage): void
    {
        if(count($arpackage)!==12) $this->_exception(__("Invalid or expired CSRF. Reload this page please. c{0}",1));

        list($s0,$domain,$s1,$remoteip,$s2,$useragent,$s3,$username,$s4,$password,$s5,$date) = $arpackage;

        if($domain!==$this->_get_domain()) $this->_exception(__("Invalid or expired CSRF. Reload this page please. c{0}",2));

        //hago validacion en local por peticiones entre las ips de docker y mi maquina host
        //que usan distitntas ips
        if ($remoteip !== $this->_get_remote_ip())
            $this->_exception(__("Invalid or expired CSRF. Reload this page please. c{0}",3));

        if($useragent !== md5($this->_get_user_agent())) $this->_exception(__("Invalid or expired CSRF. Reload this page please. c{0}",4));

        $md5pass = $this->autuser["secret"] ?? "";
        $md5pass = md5($md5pass);
        if($md5pass!==$password) $this->_exception(__("Invalid or expired CSRF. Reload this page please. c{0}",5));

        $moment = new ComponentMoment($date);
        $now = date("Y-m-d H:i:s");
        $mins = (int) $moment->get_nmins($now);
        if($mins > self::VALID_TIME_IN_MINS) $this->_exception(__("Expired CSRF {0}",6));
    }

    public function get_token(): string
    {
        $arpackage = [
            "salt0"    => date("Y-m-d H:i:s"),
            "domain"   => $this->_get_domain(),
            "salt1"    => rand(0,3),
            "remoteip" => $this->_get_remote_ip(),
            "salt2"    => rand(3,7),
            "useragent" => md5($this->_get_user_agent()),
            "salt3"    => rand(7,11),
            "username" => $this->autuser["email"] ?? "",
            "salt4"    => rand(11,15),
            "password" => md5($this->autuser["secret"] ?? ""),
            "salt5"    => rand(15,19),
            "today"    => date("Y-m-d H:i:s"),
        ];

        $instring = implode("|",$arpackage);
        $token = $this->encdec->get_sslencrypted($instring);
        return $token;
    }

    public function is_valid(?string $token): bool
    {
        if(!$token) return false;

        $instring = $this->encdec->get_ssldecrypted($token);
        $arpackage = explode("|", $instring);
        $this->_validate_package($arpackage);
        return true;
    }
}