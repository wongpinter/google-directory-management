<?php namespace App\Libraries\GoogleDirectory;

use Google_Service_Directory_User;
use Google_Service_Directory_UserName;

/**
 * Created By: Sugeng
 * Date: 11/3/17
 * Time: 13:10
 */
class RegisterNewUser
{
    public static function assign(array $applicant) {
        $user = new Google_Service_Directory_User();

        $user->setName(self::username($applicant));
        $user->primaryEmail = $applicant['email'];
        $user->password = $applicant['password'];
        $user->phones = $applicant['phone'];
        $user->gender = $applicant['gender'];

        return $user;
    }

    protected static function username(array $applicant) {
        $username = new Google_Service_Directory_UserName();
        $username->fullName = $applicant['fullname'];
        $username->givenName = $applicant['firstname'];
        $username->familyName = $applicant['lastname'];

        return $username;
    }
}