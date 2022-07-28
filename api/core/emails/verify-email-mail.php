<?php

$getCredits = new class extends RimplenetVerifyEmailMail
{
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register_api_routes']);
    }

    public function register_api_routes()
    {
        register_rest_route('rimplenet/v1', 'verify-email-address', [
            'methods' => 'GET',
            'callback' => [$this, 'send_verify_email_mail']
        ]);
    }

    public function send_verify_email_mail(WP_REST_Request $req)
    {
        # ================= set fields ============
        $email  = sanitize_text_field($req['email_address']);
        $fire_email  = sanitize_text_field($req['fire_email']);

        // if ($wlt_id !== '') :
            $this->send($email, $fire_email);
            return new WP_REST_Response($this->response, $this->response['status_code']);
    }
};
