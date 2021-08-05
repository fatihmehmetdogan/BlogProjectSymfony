<?php


namespace App\Validation;


class AdminLoginValidator
{
    protected $data;
    public $errors = [];
    public $email;
    public $password;
    private static $fields = ['email', 'password'];

    public function __construct($postData)
    {
        $this->data = $postData;
    }

    public function validateForLogin()
    {
////        var_dump($this->data);exit();
//        foreach (self::$fields as $field) {
//            if (!array_key_exists($field, $this->data)) {
////                var_dump($field);exit();
//                trigger_error("$field data yok");
//                return;
//            }
//            $methodName = 'validate';
//            $this->{$methodName . ucfirst($field)}();
//        }
//
//    }

        foreach (self::$fields as $field) {
            if (!array_key_exists($field, $this->data)) {
                $this->addError($field, "$field data yok");
                return;
        }
        $methodName = 'validate';
        $this->{$methodName . ucfirst($field)}();
            }
        }
    private function validateEmail()
    {
        $email = trim($this->data['email']);

        if (empty($email)) {
            $this->addError('email', 'email boş olamaz');
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->addError('email', 'Geçerli bir email giriniz');
            }
        }
        $this->email = $email;
    }

    private function validatePassword()
    {
        $password = trim($this->data['password']);
        if (empty($password)) {
            $this->addError('password', 'password boş olamaz');
        }
        $this->password = $password;
    }

    /**
     * @param $key
     * @param $value
     */
    private function addError($key, $value)
    {
        $this->errors[$key] = $value;
    }
}