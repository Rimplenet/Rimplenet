<?php

use Emails\Base;
use Traits\Email\RimplenetEmailTrait;

class RimplenetPasswordResetMail extends Base
{
    use RimplenetEmailTrait;
   public function __construct()
   {
    # code...
   }

   public function send($email, $sendmail=false)
   {

     $user_id=$this->getUserId('email', $email);

     if (!$user_id) {
      return $this->error(401, "User not found");
     }



     $sent['token_to_reset_password']=$this->generateToken();
     $this->storeResetToken($user_id, $sent['token_to_reset_password']);
    //  token_to_reset_password
        
        if ($sendmail=="true") {
          $sent['mail']=$this->sendResetPasswordMail($email,  $sent['token_to_reset_password']);
          $message=$sent['mail'] ? 'Email Sent' : 'Password Reset Email Not Sent';

          unset($sent['token_to_verify_email']);
          $sent['mail'] ? $this->success($sent, $message) : $this->error($sent, $message);
          return $this->response;
        }

        $sent['mail']=false;
        $message=$sent['token_to_reset_password'] ? 'Token Generated' : 'Token Not Generated';
        $sent['token_to_reset_password'] ? $this->success($sent, $message) : $this->error($sent, $message);
          return $this->response;
   }
}