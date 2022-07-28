<?php

// namespace Credits\CreateCredits;

// use Rimplenet_Wallets;
use WalletBalance\RimplenetBalance;
use Traits\Wallet\RimplenetWalletTrait;

class RimplenetGetWalletBalance extends RimplenetBalance
{
    use RimplenetWalletTrait;
    public function getWalletBalance(array $param = [])
    {

        $prop = empty($param) ? $this->req : $param;
        extract($prop);

        $data =array();
        foreach ($wallet_id as $key => $value) {
            $this->wallet_id=$value;
            if ($this->walletExists()) {
                $data[$value]=$this->get_withdrawable_wallet_bal($user_id, $value) + $this->get_nonwithdrawable_wallet_bal($user_id, $value);
            }else{
                continue;
            }
                // return Res::error($this->error, "Wallet Already Exists", 409);
            // $data[$value]=$this->get_withdrawable_wallet_bal($user_id, $value) + $this->get_nonwithdrawable_wallet_bal($user_id, $value);
        }

        return self::$response = [
                'status_code' => 200,
                'status' => true,
                'message' => 'Wallet Balance retrieved',
                'data' => $data
            ];

        // $balance = $this->get_withdrawable_wallet_bal($user_id, $wallet_id) + $this->get_nonwithdrawable_wallet_bal($user_id, $wallet_id);
       
    }
}
