<?php namespace App\Libraries\GoogleDirectory;

use Google_Service_Directory_User;

/**
 * Created By: Sugeng
 * Date: 11/2/17
 * Time: 11:47
 */
class PasswordReset
{
    public static function reset($password = null, $change_at_next_login = true, $random = false) {
        if (is_null($password)) $random = true;

        if ($random === true) {
            $password = self::generateRandomPassword(8);
        }

        return self::setPassword($password, $change_at_next_login);
    }

    protected static function setPassword($password, $change_at_next_login = false)
    {
        $user = new Google_Service_Directory_User();
        $user->password = $password;
        $user->changePasswordAtNextLogin = $change_at_next_login;

        return $user;
    }

    protected static function generateRandomPassword($chars)
    {
        $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';

        return substr(str_shuffle($data), 0, $chars);
    }
}