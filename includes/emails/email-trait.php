<?php

namespace Traits\Email;

trait RimplenetEmailTrait
{
  public function sendWelcomeMail($email)
  {
    # code...
  }

  public function sendVerifyEmailMail($email, $token)
  {
    $to = $email;
    include(plugin_dir_path( dirname( __FILE__ ) ) . 'emails/email-templates/verify-email-mail.php');

    if (wp_mail( $to, $subject, $message )) {
        return true;
    } else {
        return false;
    }
  }

  public function sendResetPasswordMail($email, $token)
  {
    $to = $email;
    include(plugin_dir_path( dirname( __FILE__ ) ) . 'emails/email-templates/password-reset.php');

    if (wp_mail( $to, $subject, $message )) {
        return true;
    } else {
        return false;
    }
  }

  public function sendPasswordChange($email, $token)
  {
    $to = $email;
    include(plugin_dir_path( dirname( __FILE__ ) ) . 'emails/email-templates/change-password.php');

    if (wp_mail($to, $subject, $message)) {
        return true;
    } else {
        return false;
    }
  }

  public function generateToken()
  {
    // return openssl_random_pseudo_bytes(16);
    //Generate a random string.
    $token = openssl_random_pseudo_bytes(3);

    //Convert the binary data into hexadecimal representation.
    $token = bin2hex($token);

    //Print it out for example purposes.
    return $token;
  }

  public function storeResetToken($user_id, $token)
  {
    return add_user_meta($user_id ?? 1, 'token_to_reset_password', $token);
  }

  public function storeChangeToken($user_id, $token)
  {
    return add_user_meta($user_id ?? 1, 'token_to_change_password', $token);
  }

  public function storeverifyToken($user_id, $token)
  {
    return add_user_meta($user_id ?? 1, 'token_to_verify_email', $token);
  }

  public function getResetToken()
  {
    # code...
  }
}
