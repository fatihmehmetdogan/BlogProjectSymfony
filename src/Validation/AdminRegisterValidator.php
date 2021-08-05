<?php


namespace App\Validation;


class AdminRegisterValidator
{
    protected $data;
    public $errors = [];
    public $email;
    public $password;
    public $confirmPassword;
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
        $this->email = trim($this->data['email']);
        if(empty($this->email)){
            $this->addError('email', 'email boş olamaz');
        }else {
            if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
                $this->addError('email', 'Geçerli bir email giriniz');
            }
        }
        return $this->email;
    }
    private function validatePassword()
    {
        $this->password = trim($this->data['password']);
        if(empty($this->password)){
            $this->addError('password', 'password boş olamaz');
        } else {
            if(!preg_match('/^[a-zA-Z0-9]{8,12}$/', $this->password)){
                    $this->addError('password', 'En az 8 karakterli bir şifre giriniz');
            }
        }
        return $this->password;
    }
    private function validateConfirmPassword()
    {
        $this->confirmPassword = trim($this->data['confirm_password']);
        if(empty($this->confirmPassword)){
            $this->addError('confirm_password', 'password boş olamaz');
        } else {
            if(!preg_match('/^[a-zA-Z0-9]{8,12}$/', $this->confirmPassword)){
                $this->addError('confirm_password', 'En az 8 karakterli bir şifre giriniz');
            }
        }
        return $this->confirmPassword;
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