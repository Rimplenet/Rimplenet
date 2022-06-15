<?php
/**
 * Create Transfers
 */

class CreateTransfers extends RimplenetCreateTransfer
{

    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register_api_routes']);
    }

    public function register_api_routes()
    {
        register_rest_route('/rimplenet/v1', 'transfers', [
            'methods' => 'POST',
            'callback' => [$this, 'api_create_transfers']
        ]);
    }

    public function api_create_transfers(WP_REST_Request $req)
    {
        $this->req = [
            'user_id' => sanitize_text_field($req['user_id']),
            'amount_to_transfer' => sanitize_text_field($req['amount_to_transfer']),
            'transfer_to_user' => sanitize_text_field($req['transfer_to_user']),
            'wallet_id' => sanitize_text_field($req['wallet_id']),
            'note' => sanitize_text_field($req['note'] ?? ''),
        ];

        $this->transfer();
        return new WP_REST_Response($this->response, $this->response['status_code']);
    }
}

$CreateTransfers = new CreateTransfers();