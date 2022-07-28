<?php

use Emails\Base;
use Traits\Email\RimplenetEmailTrait;

class RimplenetPasswordChangeMail extends Base
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



     $sent['token_to_change_password']=$this->generateToken();
     $this->storeChangeToken($user_id, $sent['token_to_change_password']);
        
        if ($sendmail=="true") {
          $sent['mail']=$this->sendPasswordChange($email, $sent['token_to_change_password']);
          $message = $sent['mail'] ? 'Password Change Email Sent' : 'Password Change Email Not Sent';
          unset($sent['token_to_change_password']);
          $sent['mail'] ? $this->success($sent, $message) : $this->error($sent, $message);
          return $this->response;
        }

        $sent['mail']=false;
        $message=$sent['token_to_change_password'] ? 'Token Generated' : 'Token Not Generated';
        $sent['token_to_change_password'] ? $this->success($sent, $message) : $this->error($sent, $message);
          return $this->response;
   }
}