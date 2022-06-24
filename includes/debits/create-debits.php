<?php

use Debits\Debits;

class RimplenetCreateDebits extends Debits
{
    public function createDebits(array $param = [])
    {

        $prop = empty($param) ? $this->req : $param;
        extract($prop);

        if($this->checkEmpty($prop)) return;

        if(!$this->getWalletById($wallet_id)) return;

        # Set transaction id
        $txn_id = $user_id . '_' . $request_id;
        # Set transient key
        $recent_txn_transient_key = "recent_txn_" . $txn_id;


        # Chech transient key
        if ($GLOBALS[$recent_txn_transient_key] == "executing") return;
        if (get_transient($recent_txn_transient_key)) return;

        # check if transaction already exist
        if($this->debitsExists($txn_id)) return;

        $key = 'user_withdrawable_bal_' . $wallet_id;
        $user_balance = get_user_meta($user_id, $key, true);

        # check if user balance is a valid int>float>double
        if (!is_numeric($user_balance) && !is_int($user_balance) || !$user_balance) $user_balance = 0;

        # set user balance before time
        $bal_before = $user_balance;
        // return $user_balance_total;

        $RimplenetWallet = new Rimplenet_Wallets;
        $user_balance_total = $RimplenetWallet->get_total_wallet_bal($user_id, $wallet_id);

        $new_balance  = $user_balance + $amount;
        $new_balance  = $new_balance;

        $update_bal = update_user_meta($user_id, $key, $new_balance);

        if ($update_bal) :
            if ($amount > 0) :
                $tnx_type = self::CREDIT;
            else :
                $tnx_type = self::DEBIT;
                $amount = $amount * -1;
            endif;

            $txn_add_bal_id = $RimplenetWallet->record_Txn($user_id, $amount, $wallet_id, $tnx_type, 'publish');

            # add note if not empty
            if (!empty($note))  add_post_meta($txn_add_bal_id, 'note', $note);

            add_post_meta($txn_add_bal_id, 'request_id', $request_id);
            add_post_meta($txn_add_bal_id, 'txn_request_id', $txn_id);
            update_post_meta($txn_add_bal_id, 'balance_before', $bal_before);
            update_post_meta($txn_add_bal_id, 'balance_after', $new_balance);

            update_post_meta($txn_add_bal_id, 'total_balance_before', $user_balance_total);
            update_post_meta($txn_add_bal_id, 'total_balance_after', $RimplenetWallet->get_total_wallet_bal($user_id, $wallet_id));
            update_post_meta($txn_add_bal_id, 'funds_type', $key);
        else :
            return $this->error('Unknown Error', "unknown error", 400);
        endif;

        if ($txn_add_bal_id > 0) {
            $result = $txn_add_bal_id;
            return $this->success(['id' => $result], "Transaction Completed", 200);
        } else {
            return $this->error('Transaction Already Executed', 'Transaction Already Executed', 409);
        }
        return;
    }


    /**
     * Check Transaction Exists
     * @return
     */
    protected function debitsExists($value, string $type = '')
    {
        global $wpdb;
        $row = $wpdb->get_row("SELECT * FROM $wpdb->postmeta WHERE meta_key='txn_request_id' AND meta_value='$value'");
        if ($row) :
            $this->error([
                'txn_id' => $row->post_id,
                'exist' => "Transaction already executed"
            ], "Transaction already exists", 409);
            return true;
        endif;
        return false;
    }
}
