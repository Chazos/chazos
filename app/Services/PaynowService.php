<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;




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
    protected $wallet_name = "ecocash";

    function __construct($email, $phone)
    {
        $this->email = $email;
        $this->phone = $phone;



        $use_rate = cg_get_setting('PAYNOW_USE_RATE');

        if ($use_rate == "yes") {
            $this->use_rate = true;
            $this->rate = cg_get_setting('PAYNOW_RATE');
        }

        $this->initPaynow();
        $this->detectWalletName();
        $this->createPayment();
    }

    public function initPaynow()
    {
        $this->paynow = new \Paynow\Payments\Paynow(
            cg_get_setting("PAYNOW_INTERGRATION_ID"),
            cg_get_setting("PAYNOW_INTERGRATION_KEY"),
            cg_get_setting("PAYNOW_UPDATE_URL"),
            cg_get_setting("PAYNOW_RETURN_URL"),
        );
    }

    function detectWalletName()
    {
        if (strpos($this->phone, "073") === 0 || strpos($this->phone, "26373") === 0) {
            $this->wallet_name = "telecash";
        }

        if (strpos($this->phone, "071") === 0 || strpos($this->phone, "26372") === 0) {
            $this->wallet_name = "onemoney";
        }
    }

    protected function createPayment()
    {

        $this->invoice_name = "Invoice " . time();
        $this->payment = $this->paynow->createPayment($this->invoice_name, $this->email);
    }

    public function addItems($items)
    {

        if (gettype($items) == "object") {
            $items = json_decode(json_encode($items), true);
        }

        foreach ($items as $item) {

            $total_price = $item['price'] * $item['quantity'];

            // Apply rate if needed
            if ($this->use_rate) {
                $total_price = $total_price * $this->rate;
            }

            $this->grand_total += $total_price;

            $this->payment->add(
                $item['name'],
                $total_price
            );
        }
    }

    public function makePayment()
    {

        try {

            $response = $this->paynow->sendMobile($this->payment, $this->phone, $this->wallet_name);



            // Check transaction success
            if ($response->success()) {


                $timeout = 9;
                $count = 0;

                while (true) {
                    sleep(5);
                    // Get the status of the transaction
                    // Get transaction poll URL
                    $pollUrl = $response->pollUrl();
                    $status = $this->paynow->pollTransaction($pollUrl);

                    //Check if paid
                    if ($status->paid()) {
                        return [
                            'status' => 'success',
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
                            'status' => 'timeout_reached',
                            'message' => 'Timeout reached'
                        ];
                    }
                }
            }
        } catch (\Error $e) {

            Log::error($e->getMessage());
        }


        return [
            'status' => 'failed',
            'message' => 'Payment Failed'
        ];
    }
}
