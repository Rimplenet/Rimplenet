<?php

class RetrieveWallets
{
    public function __construct()
    {
        add_action('rest_api_init', array($this, 'register_api_routes'));
    }

    public function register_api_routes()
    {
        register_rest_route('rimplenet/v1', '/get-wallet', array([
            'methods' => 'GET',
            'callback' => [$this, 'api_retrieve_wallet']
        ]));
    }

    public function api_retrieve_wallet(WP_REST_Request $request)
    {

        $dummy = [
            'wallet 1' =>  'Data from wallet 1',
            'wallet 2' =>  'Data from wallet 2',
            'wallet 3' =>  'Data from wallet3',
            
        ];

        $dt = [
            'status_code' => 200,
            'status' => 'Success',
            'response_message' => 'Wallet Retrieved'
        ];

        extract($dt);

        return new WP_REST_Response(
            array(
                'status_code' => $status_code,
                'status' => $status,
                'message' => $response_message,
                'data' => $dummy
            )
        );
    }
}

$RetrieveWallets = new RetrieveWallets();
