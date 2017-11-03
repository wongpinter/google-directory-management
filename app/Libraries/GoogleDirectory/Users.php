<?php namespace App\Libraries\GoogleDirectory;

use Google_Service_Exception;

/**
 * Created By: Sugeng
 * Date: 11/3/17
 * Time: 11:06
 */
class Users extends Directory
{
    protected $users;

    /**
     * Users constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->users = $this->directory->users;
    }

    /**
     * @param $email
     * @return array
     */
    public function get($email)
    {
        try {
            $user = $this->users->get($email);
        } catch (Google_Service_Exception $e) {
            $error = $this->parseErrorService($e->getMessage());

            return $this->errorResponse("{$error->message} $email", $error->reason);
        }

        return [
            'error' => false,
            'code' => 200,
            'message' => "Resource Found {$user->getName()->fullName}"
        ];
    }

    /**
     * @param array $applicant
     * @return array
     */
    public function store(array $applicant)
    {
        try {
            $user = $this->users->insert(RegisterNewUser::assign($applicant));
        } catch (Google_Service_Exception $e) {
            $error = $this->parseErrorService($e->getMessage());

            return $this->errorResponse($error->message, $error->reason);
        }

        return [
            'error' => false,
            'code' => 200,
            'message' => "Resource created",
            'payload' => [
                'fullname' => $user->getName()->fullName,
                'primaryEmail' => $user->getPrimaryEmail(),
                'id' => $user->getId()
                ]
        ];
    }

    /**
     * @param $email
     * @return array
     */
    public function delete($email)
    {
        try {
            $this->users->delete($email);
        } catch (Google_Service_Exception $e) {
            $error = $this->parseErrorService($e->getMessage());

            return $this->errorResponse("{$error->message} $email", $error->reason);
        }

        return [
            'error' => false,
            'code' => 200,
            'message' => "Resource deleted"
        ];
    }

    /**
     * @param $email
     * @param null $new_password
     * @param bool $change_at_next_login
     * @param bool $random
     * @return array
     */
    public function passwordReset($email, $new_password = null, $change_at_next_login = true, $random = false)
    {
        $password = PasswordReset::reset($new_password, $change_at_next_login, $random);

        try {
            $user = $this->users->update($email, $password);
        } catch (Google_Service_Exception $e) {
            $error = $this->parseErrorService($e->getMessage());

            return $this->errorResponse("{$error->message} $email", $error->reason);
        }

        return [
            'error' => false,
            'code' => 200,
            'message' => "Resource Password reset done.",
            'payload' => [
                'email' => $user->getPrimaryEmail(),
                'fullname' => $user->getName()->fullName,
                'password' => $password->password,
                'change_at_login' => $change_at_next_login
            ]
        ];
    }

    /**
     * @param $error
     * @return mixed
     */
    protected function parseErrorService($error)
    {
        $errorObject = json_decode($error);

        return $errorObject->error->errors[0];
    }

    /**
     * @param $error_message
     * @param $reason
     * @param int $code
     * @return array
     */
    protected function errorResponse($error_message, $reason, $code = 404)
    {
        return [
            'error' => true,
            'message' => $error_message,
            'reason' => $reason,
            'code' => $code
        ];
    }
}