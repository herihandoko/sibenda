<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\PaymentExecution;
use App\Models\Transaction as ModelsTransaction;
use Illuminate\Support\Facades\Mail;

class PaypalController extends Controller
{
    private $apiContext;
    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                PaymentGateway('paypal_api_client'),
                PaymentGateway('paypal_api_secret'),
            )
        );

        $setting = array(
            'mode' => PaymentGateway('paypal_api_mode') == 'sandbox' ? 'sandbox' : 'production',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path() . '/logs/paypal.log',
            'log.LogLevel' => 'ERROR'
        );
        $this->apiContext->setConfig($setting);
    }


    public function paypal_pay(Request $request)
    {


        $payableAmount = $request->total;

            if ($payableAmount > 60000) {

                toast(trans('frontend.Sorry! Maximum transaction amount is 60,000!'), 'warning')->width('400px');
                return redirect()->back();
            }

        // set payer
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        // set amount total
        $amount = new Amount();
        $amount->setCurrency(PaymentGateway('paypal_currency'))
            ->setTotal($payableAmount);

        // transaction
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription(env('APP_NAME'));

        // redirect url
        $redirectUrls = new RedirectUrls();

        $root_url = url('/');
        $redirectUrls->setReturnUrl($root_url . "/user/paypal-payment-success?cart=" . $request->cart . "&tax=" . $request->tax. "&total=" . $request->total)
            ->setCancelUrl($root_url . "/user/paypal-payment-cancled");
        // payment
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
        try {
            $payment->create($this->apiContext);
        } catch (\PayPal\Exception\PPConnectionException $ex) {

            toast(trans('frontend.Payment Failed!'), 'error')->width('350px');
            return Redirect()->route('home');

        }

        // get paymentlink
        $approvalUrl = $payment->getApprovalLink();

        return redirect($approvalUrl);
    }

    public function paypal_success(Request $request)
    {


        if (empty($request->get('PayerID')) || empty($request->get('token'))) {

            toast(trans('frontend.Payment Failed!'), 'error')->width('350px');
            return Redirect()->route('home');
        }

        $payment_id = $request->get('paymentId');
        $payment = Payment::get($payment_id, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->apiContext);

        if ($result->getState() == 'approved') {



            $cart = json_decode(base64_decode($request->cart));

            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->status = 'pending';
            $order->total_amount = round($request->total / PaymentGateway('paypal_rate'), 2);
            $order->tax = $request->get('tax');
            $order->shipping_fee = shippingFee();
            $order->save();

            foreach ($cart as $product) {
                $item = new OrderItem();
                $item->order_id = $order->id;
                $item->item_id = $product->id;
                $item->item_price = $product->price;
                $item->item_qty = $product->qty;
                $item->save();
            }

            $address = new OrderAddress();
            $address->order_id = $order->id;
            $address->user_id = Auth::user()->id;
            $address->country = Auth::user()->address->country;
            $address->city = Auth::user()->address->city;
            $address->post_code = Auth::user()->address->post_code;
            $address->address = Auth::user()->address->address;
            $address->save();
            $transaction = new ModelsTransaction();
            $transaction->order_id = $order->id;
            $transaction->payment_method = 'Paypal';
            $transaction->transaction_id = request('paymentId');
            $transaction->user_id = Auth::user()->id;
            $transaction->amount =  round($request->total / PaymentGateway('paypal_rate'), 2);
            $transaction->currency = GetSetting('site_currency');
            $transaction->save();
            cartDestroy();



            $template = EmailTemplate::find(2);
            $body = str_replace('{name}', Auth::user()->name, $template->description);
            Mail::send('frontend.emailHtml', ['body' =>html_entity_decode($body)], function ($message) use ($request, $template) {
                $message->to(Auth::user()->email);
                $message->subject($template->subject);
            });


            toast(trans('frontend.Payment Successful!'), 'success')->width('350px');
            return  redirect()->route('user.dashboard');
        } else {
            toast(trans('frontend.Payment Failed!'), 'error')->width('350px');
            return Redirect()->back();
        }
    }

    public function paypalPaymentCancled()
    {
        toast(trans('frontend.Payment Cancelled!'), 'warning')->width('350px');
        return  redirect()->route('user.dashboard');
    }
}
