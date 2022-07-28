<?php

use Emails\Base;
use Traits\Email\RimplenetEmailTrait;

class   VerifyEmailMail extends Base
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
        $this->prop['token']=$token;

        // var_dump($this->prop['user_id']);

        if ($this->prop['user_id'] ==false) {
            return $this->error(401, "User not found");
        }

        if ($this->checkToken()) {
            delete_user_meta( $this->prop['user_id'], 'token_to_verify_email');
            $message = "Email Verified Successfully";
            $data['action']="verify_email_verification_successful";
            $data['user_id']=$this->prop['user_id'];
            $data['user_email_address']=$email;
            $this->success($data, $message);
            return $this->response;
        }
           
            $message = "Invalid token";
            $this->error(false, $message);
            return $this->response;
    }

    public function checkToken()
    {
        $user = get_user_meta($this->prop['user_id'] ?? 1, 'token_to_verify_email');

        if (!$user) {
            return false;
        }

        if ($this->prop['token'] == end($user)) {
            add_user_meta($this->prop['user_id'] ?? 1, 'nll_user_email_address_verification_token', $this->prop['token']);
            add_user_meta($this->prop['user_id'] ?? 1, 'nll_user_email_address_verifed', 'yes');
            return true;
        }

        return false;
    }

    public function checkPasswordMatch()
    {
        if ($this->prop['new_password'] == $this->prop['confirm_password']) {
            return true;
        }

        return false;
    }

    public function verifyPassword()
    {
        $user = get_user_by('email', $this->prop['email']);
        if ($user && wp_check_password($this->prop['current_password'], $user->data->user_pass, $user->ID)) {
            return true;
        } else {
            return false;
        }
    }
}
