<?php

use Emails\Base;
use Traits\Email\RimplenetEmailTrait;

class RimplenetPostPasswordResetMail extends Base
{

    public $prop;
    use RimplenetEmailTrait;
    public function __construct()
    {
        # code...
    }

    public function validate(array $param = [])
    {

        $this->prop = empty($param) ? $this->req : $param;
        extract($this->prop);

        $this->prop['user_id'] = $this->getUserId('email', $email);

        if (!$this->prop['user_id']) {
            return $this->error(401, "User not found");
           }

        if ($this->checkToken()) {
            if ($this->checkPasswordMatch()) {
                $passwordchange=wp_set_password($password, $this->prop['user_id']);
                delete_user_meta($this->prop['user_id'], 'token_to_reset_password', $this->prop['token']);
                $message="Password Changed Successfully";

                $data['action']="change_password_successful";
                $data['user_id']=$this->prop['user_id'];
                $data['user_email_address']=$email;
                $this->success($data, $message);
                return $this->response;
            }
            $message="Passwords do not match";
            $this->error(false, $message);
            return $this->response;
        }
        $message="Invalid token";
        $this->error(false, $message);
        return $this->response;
    }

    public function checkToken()
    {
        $user = get_user_meta($this->prop['user_id'] ?? 1, 'token_to_reset_password', false);

        // var_dump(end($user),$this->prop['token']);
        // die;

        // if ($this->prop['token']==$user[0]) {
            if ($this->prop['token']==end($user)) {
            // die("omor");
            return true;
        }

        return false;
    }

    public function checkPasswordMatch()
    {
        if ($this->prop['password']==$this->prop['confirm_password']) {
            return true;
        }

        return false;
    }
}
