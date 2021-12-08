<?php

namespace App\Services;
use Paynow\Payments\Paynow;

class PaynowService
{
    protected $paynow;
    protected $payment;
    protected $use_rate = false;
    protected $rate = 1;
    protected $grand_total = 0;
    protected $invoice_name;

    protected $email;
    protected $phone;
    protected $wallet_name = "econet";

    function constructor($email, $phone, $use_rate=false){
        $this->email = $email;
        $this->phone = $phone;

        $this->initPaynow();
        $this->detectWalletName();
        $this->createPayment();

        if ($use_rate){
            $this->use_rate = true;
            $this->rate = cg_get_setting("PAYNOW_RATE"); // TODO: Get rate here
        }
    }

    protected function initPaynow()
    {
        $this->paynow = new \Paynow\Payments\Paynow(
            cg_get_setting("PAYNOW_INTEGRATION_ID"),
            cg_get_setting("PAYNOW_INTEGRATION_KEY"),
            cg_get_setting("PAYNOW_UPDATE_URL"),
            cg_get_setting("PAYNOW_RETURN_URL"),
        );
    }


    function detectWalletName(){
        if (strpos($this->phone, "073") === 0 || strpos($this->phone, "26373") === 0) {
            $this->wallet_name = "telecash";
        }

        if (strpos($this->phone, "071") === 0 || strpos($this->phone, "26372") === 0) {
            $this->wallet_name = "onemoney";
        }
    }



    protected function createPayment(){
        $this->invoice_name = "Invoice " . time();
        $this->payment = $this->paynow->createPayment($this->invoice_name, $this->user_email);
    }

    public function addItems($items){
        foreach ($items as $item) {

            $total_price = $item['price'] * $item['quantity'];

            // Apply rate if needed
            if ($this->use_rate){
                $total_price = $total_price * $this->rate;
            }

            $this->grand_total += $total_price;
            $this->payment->addItem(
                $item['name'],
                $total_price
            );
        }

    }

    public function makePayment()
    {
        $response = $this->paynow->sendMobile($this->payment, $this->phone_number, $this->wallet_name);

        // Check transaction success
        if ($response->success()) {


            $timeout = 9;
            $count = 0;

            while (true) {
                sleep(3);
                // Get the status of the transaction
                // Get transaction poll URL
                $pollUrl = $response->pollUrl();
                $status = $this->paynow->pollTransaction($pollUrl);
                //Check if paid
                if ($status->paid()) {
                    return [
                        'status' => true,
                        'message' => "Payment was successful",
                        'data' => [
                            'invoice_id' => $this->invoice_name,
                            'gateway' => 'paynow',
                            'other_details' => $this->wallet_name,
                            'grand_total' => $this->grand_total
                        ]
                    ];
                }



                $count++;
                if ($count > $timeout) {
                    return [
                        'status' => false,
                        'message' => 'Timeout reached'
                    ];
                }
            }
        }


        return [
            'status' => false,
            'message' => 'Payment Failed'
        ];

    }

}
