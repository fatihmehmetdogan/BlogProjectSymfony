<?php


namespace App\Validation;


class AdminRegisterValidator
{
    protected $data;
    public $errors = [];
    private static $fields = ['email', 'password', 'confirm_password'];

    public function __construct($postData)
    {
        $this->data = $postData;
    }
    public function validateForm()
    {
//        var_dump($this->data);exit();
        foreach (self::$fields as $field){
            if(!array_key_exists($field, $this->data)){
                trigger_error("$field data yok");
                return;
            }
        }
        $this->validateEmail();
        $this->validatePassword();
        $this->validateConfirmPassword();
    }
    private function validateEmail()
    {
        $val = trim($this->data['email']);
        if(empty($val)){
            $this->addError('email', 'email boş olamaz');
        }else {
            if(!filter_var($val, FILTER_VALIDATE_EMAIL)){
                $this->addError('email', 'Geçerli bir email giriniz');
            }
        }
    }
    private function validatePassword()
    {
        $pass = trim($this->data['password']);
        if(empty($pass)){
            $this->addError('password', 'password boş olamaz');
        } else {
            if(!preg_match('/^[a-zA-Z0-9]{8,12}$/', $pass)){
                    $this->addError('password', 'En az 8 karakterli bir şifre giriniz');
            }
        }
    }
    private function validateConfirmPassword()
    {
        $pass = trim($this->data['confirm_password']);
        if(empty($pass)){
            $this->addError('confirm_password', 'password boş olamaz');
        } else {
            if(!preg_match('/^[a-zA-Z0-9]{8,12}$/', $pass)){
                $this->addError('confirm_password', 'En az 8 karakterli bir şifre giriniz');
            }
        }
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