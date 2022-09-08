<?php
namespace App\Restrict\Auth\Application;

use App\Restrict\Users\Domain\Enums\UserPolicyType;
use App\Shared\Infrastructure\Factories\Specific\SessionFactory as SF;
use App\Shared\Infrastructure\Factories\RepositoryFactory as RF;
use App\Restrict\Users\Domain\UserRepository;
use App\Shared\Domain\Enums\SessionType;
use App\Restrict\Users\Domain\Enums\UserProfileType;

final class AuthService
{
    private static ?AuthService $authService = null;
    private static ?array $authuser = null;

    private function __construct() {}

    private function __clone() {}

    public static function getme(): self
    {
        if (!self::$authService)
            self::$authService = new AuthService();
        return self::$authService;
    }

    public function get_user(): ?array
    {
        if (!self::$authuser)
            self::$authuser = SF::get()->get(SessionType::AUTH_USER) ?? [];
        return self::$authuser;
    }

    public function is_user_allowed(string $action): bool
    {
        if(!self::$authuser) return false;
        if($this->is_root()) return true;

        $permissions = self::$authuser[SessionType::AUTH_USER_PERMISSIONS];
        return in_array($action, $permissions);
    }

    public function get_module_permissions(string $module, ?string $type=null): array
    {
        switch ($module) {
            case UserPolicyType::MODULE_USERS:
                $permission = [
                    "write" => $this->is_user_allowed(UserPolicyType::USERS_WRITE),
                    "read" => $this->is_user_allowed(UserPolicyType::USERS_READ),
                ];
            break;
            case UserPolicyType::MODULE_USER_PERMISSIONS:
                $permission = [
                    "write" => $this->is_user_allowed(UserPolicyType::USER_PERMISSIONS_WRITE),
                    "read" => $this->is_user_allowed(UserPolicyType::USER_PERMISSIONS_READ),
                ];
            break;
            case UserPolicyType::MODULE_USER_PREFERENCES:
                $permission = [
                    "write" => $this->is_user_allowed(UserPolicyType::USER_PREFERENCES_WRITE),
                    "read" => $this->is_user_allowed(UserPolicyType::USER_PREFERENCES_READ),
                ];
            break;
            case UserPolicyType::MODULE_BUSINESSDATA:
                $permission = [
                    "write" => $this->is_user_allowed(UserPolicyType::BUSINESSDATA_WRITE),
                    "read" => $this->is_user_allowed(UserPolicyType::BUSINESSDATA_READ),
                ];
            break;
            case UserPolicyType::MODULE_PROMOTIONS:
                $permission = [
                    "write" => $this->is_user_allowed(UserPolicyType::PROMOTIONS_WRITE),
                    "read" => $this->is_user_allowed(UserPolicyType::PROMOTIONS_READ),
                ];
            break;
            case UserPolicyType::MODULE_PROMOTIONS_UI:
                $permission = [
                    "write" => $this->is_user_allowed(UserPolicyType::PROMOTIONS_UI_WRITE),
                    "read" => $this->is_user_allowed(UserPolicyType::PROMOTIONS_UI_READ),
                ];
            break;
            case UserPolicyType::MODULE_SUBSCRIPTIONS:
                $permission = [
                    "write" => $this->is_user_allowed(UserPolicyType::SUBSCRIPTIONS_WRITE),
                    "read" => $this->is_user_allowed(UserPolicyType::SUBSCRIPTIONS_READ),
                ];
                break;
            default:
                $permission = [
                    "write" => false,
                    "read" => false,
                ];
            break;
        }

        if (!in_array($type, [UserPolicyType::READ, UserPolicyType::WRITE]))
            return $permission;

        if ($type===UserPolicyType::READ)
            return [$permission["write"] || $permission["read"]];

        return [$permission["write"]];
    }

    public function is_root(?string $idprofile=null): bool
    {
        return $idprofile
            ? ($idprofile === UserProfileType::ROOT)
            : (self::$authuser["id_profile"] ?? "") === UserProfileType::ROOT;
    }

    public function is_root_super(): bool
    {
        if (!self::$authuser) return false;
        return (
            self::$authuser["uuid"] === UserProfileType::ROOT_SUPER_UUID &&
            ((int) self::$authuser["id"])=== UserProfileType::ROOT_SUPER_ID
        );
    }

    public function is_sysadmin(?string $idprofile=null): bool
    {
        return $idprofile
            ? ($idprofile === UserProfileType::SYS_ADMIN)
            : (self::$authuser["id_profile"] ?? "") === UserProfileType::SYS_ADMIN;
    }

    public function is_business_owner(?string $idprofile=null): bool
    {
        return $idprofile
            ? ($idprofile === UserProfileType::BUSINESS_OWNER)
            : (self::$authuser["id_profile"] ?? "") === UserProfileType::BUSINESS_OWNER;
    }

    public function is_business_manager(?string $idprofile=null): bool
    {
        return $idprofile
            ? ($idprofile === UserProfileType::BUSINESS_MANAGER)
            : (self::$authuser["id_profile"] ?? "") === UserProfileType::BUSINESS_MANAGER;
    }

    public function is_business(?string $idprofile=null): bool
    {
        $business = [UserProfileType::BUSINESS_OWNER, UserProfileType::BUSINESS_MANAGER];
        return $idprofile
            ? in_array($idprofile, $business)
            : in_array(self::$authuser["id_profile"] ?? "", $business);
    }

    public function is_system(?string $idprofile=null): bool
    {
        $system = [UserProfileType::ROOT, UserProfileType::SYS_ADMIN];
        return $idprofile
            ? in_array($idprofile, $system)
            : in_array(self::$authuser["id_profile"] ?? "", $system);
    }

    public function have_sameowner(string $idowner): bool
    {
        return $idowner === (string) $this->get_idowner();
    }

    public function get_idowner(): ?int
    {
        if ($this->is_root() || $this->is_sysadmin())
            return null;
        if ($this->is_business_owner())
            return self::$authuser["id"];

        return RF::get(UserRepository::class)->get_idowner(self::$authuser["id"]);
    }

    public function get_tz(): string
    {
        //return "Europe/Madrid";
        return $this->get_user()[SessionType::AUTH_USER_TZ] ?? "";
    }

    public static function reset(): void
    {
        self::$authService = null;
        self::$authuser = null;
    }
}