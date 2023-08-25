<?php

namespace App\Http\Controllers\Frontend;

use App\Helper\Helpers;
use App\Http\Controllers\Controller;
use App\Mail\SendEmail;
use App\Models\EmailTemplate;
use App\Models\Package;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderItem;
use App\Models\Setting;
use App\Models\Transaction as ModelsTransaction;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use Stripe;
use Razorpay\Api\Api;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use League\CommonMark\Node\Query\OrExpr;
use Mollie\Laravel\Facades\Mollie;
use Illuminate\Support\Facades\Config;
use App\Library\SslCommerz\SslCommerzNotification;

class PaymentController extends Controller
{

    public function stripe(Request $request)
    {



        $cart = json_decode(base64_decode($request->cart));
        $cents = $request->total * 100;
        Stripe\Stripe::setApiKey(PaymentGateway('stripe_api_secret_key'));
        $response = Stripe\Charge::create([
            "amount" => $cents,
            "currency" => GetSetting('site_currency'),
            "source" => $request->stripeToken,
            "description" => env('APP_NAME')
        ]);
        $responseJson = $response->jsonSerialize();
        $transaction_id = $responseJson['balance_transaction'];

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->status = 'pending';
        $order->total_amount = round($request->total / PaymentGateway('stripe_rate') , 2);
        $order->tax = $request->tax;
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
        $transaction->payment_method = 'Stripe';
        $transaction->transaction_id = $transaction_id;
        $transaction->user_id = Auth::user()->id;
        $transaction->amount = round($request->total / PaymentGateway('stripe_rate') , 2);
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
    }
    public function razorpay(Request $request)
    {
        $cart = json_decode(base64_decode($request->cart));
        $input = $request->except(['total', 'cart']);
        $api = new Api(PaymentGateway('razorpay_key_id'), PaymentGateway('razorpay_key_secret'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if (count($input) && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment
                    ->fetch($input['razorpay_payment_id'])
                    ->capture(array('amount' => $payment['amount']));
                $payId = $response->id;
                $order = new Order();
                $order->user_id = Auth::user()->id;
                $order->status = 'pending';
                $order->total_amount = round($request->total / PaymentGateway('razorpay_rate') , 2) / 100;
                $order->tax = $request->tax;
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
                $transaction->payment_method = 'Razorpay';
                $transaction->transaction_id = $payId;
                $transaction->user_id = Auth::user()->id;
                $transaction->amount = round($request->total / PaymentGateway('razorpay_rate') , 2) / 100;
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
            } catch (Exception $e) {
                dd($e);
                toast(trans('frontend.Payment Error!'), 'error')->width('350px');
                return Redirect()->back();
            }
        }
    }
    public function flutterwave(Request $request)
    {

        $cart = json_decode(base64_decode($request->cart));
        $curl = curl_init();

        $tnx_id = $request->transaction_id;

        $url = "https://api.flutterwave.com/v3/transactions/$tnx_id/verify";
        $token = PaymentGateway('flutterwave_secret_key');
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer $token"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);


        $response = json_decode($response);
        if ($response->status == 'success') {
            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->status = 'pending';
            $order->total_amount = round($request->get('amp;total') / PaymentGateway('flutterwave_rate') , 2);
            $order->tax = $request->get('amp;tax');
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
            $transaction->payment_method = 'Flutterwave';
            $transaction->transaction_id = $tnx_id;
            $transaction->user_id = Auth::user()->id;
            $transaction->amount = round($request->get('amp;total') / PaymentGateway('flutterwave_rate') , 2);
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
    public function mollie(Request $request)
    {
        Mollie::api()->setApiKey(PaymentGateway('mollie_api_key'));
        $mollie_price = round($request->total, 2);
        $payment = Mollie::api()->payments()->create([
            'amount' => [
                'currency' => GetSetting('site_currency'),
                'value' => '' . sprintf('%0.2f', $mollie_price) . '',
            ],
            'description' => env('APP_NAME'),
            'redirectUrl' => route('user.mollie-notify'),
        ]);
        $payment = Mollie::api()->payments()->get($payment->id);
        session()->put('payment_id', $payment->id);
        session()->put('cart', $request->cart);
        session()->put('total', $request->total);
        session()->put('tax', $request->tax);
        return redirect($payment->getCheckoutUrl(), 303);
    }
    public function mollie_notify(Request $request)
    {
        $cart = json_decode(base64_decode(session()->get('cart')));
        Mollie::api()->setApiKey(PaymentGateway('mollie_api_key'));
        $payment = Mollie::api()->payments->get(session()->get('payment_id'));
        if ($payment->isPaid()) {
            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->status = 'pending';
            $order->total_amount = round(session()->get('total') / PaymentGateway('mollie_rate') , 2);
            $order->tax = session()->get('tax');
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
            $transaction->payment_method = 'Mollie';
            $transaction->transaction_id = session()->get('payment_id');
            $transaction->user_id = Auth::user()->id;
            $transaction->amount = round(session()->get('total') / PaymentGateway('mollie_rate') , 2);
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
        }
    }
    public function instamojo(Request $request)
    {



        $price = round($request->total, 2);
        $api_key = PaymentGateway('instamojo_api_key');
        $auth_token = PaymentGateway('instamojo_auth_token');
        $url = 'https://test.instamojo.com/api/1.1/';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . 'payment-requests/');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                "X-Api-Key:$api_key",
                "X-Auth-Token:$auth_token"
            )
        );
        $payload = array(
            'purpose' => env("APP_NAME"),
            'amount' => $price,
            'phone' => Auth::user()->phone,
            'buyer_name' => Auth::user()->name,
            'redirect_url' => route('user.instamojo-verify', ['cart' => $request->cart, 'total' => $request->total, 'tax' => $request->tax]),
            'send_email' => true,
            'webhook' => 'http://www.example.com/webhook/',
            'send_sms' => true,
            'email' => Auth::user()->email,
            'allow_repeated_payments' => false
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);
        if ($response->success == false) {
            if (isset($response->message->phone)) {
                toast($response->message->phone, 'error')->width('350px');
            }
            if (isset($response->message->amount)) {
                toast($response->message->amount, 'error')->width('350px');
            }
            return Redirect()->back();
        }
        return redirect($response->payment_request->longurl);
    }
    public function instamojo_verify(Request $request)
    {

        $cart = json_decode(base64_decode($request->cart));
        $api_key = PaymentGateway('instamojo_api_key');
        $auth_token = PaymentGateway('instamojo_auth_token');
        $url = 'https://test.instamojo.com/api/1.1/';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . 'payments/' . $request->get('payment_id'));
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                "X-Api-Key:$api_key",
                "X-Auth-Token:$auth_token"
            )
        );
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if ($err) {
            toast(trans('frontend.Payment Failed!'), 'error')->width('350px');
            return redirect()->back();
        } else {
            $data = json_decode($response);
        }
        if ($data->success == true) {
            if ($data->payment->status == 'Credit') {
                $order = new Order();
                $order->user_id = Auth::user()->id;
                $order->status = 'pending';
                $order->total_amount = round($request->total / PaymentGateway('instamojo_rate') , 2);
                $order->tax = $request->tax;
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
                $transaction->payment_method = 'Instamojo';
                $transaction->transaction_id = $request->get('payment_id');
                $transaction->user_id = Auth::user()->id;
                $transaction->amount = round($request->total / PaymentGateway('instamojo_rate') , 2);
                $transaction->currency = PaymentGateway('instamojo_currency');
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
                return redirect()->back();
            }
        } else {
            toast(trans('frontend.Payment Failed!'), 'error')->width('350px');
            return redirect()->back();
        }
    }
    public function paystack(Request $request)
    {


        $reference = $request->reference;
        $secret_key = PaymentGateway('paystack_secret_key');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/$reference",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $secret_key",
                "Cache-Control: no-cache",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $final_data = json_decode($response);
        if ($final_data->status == true) {
            $cart = json_decode(base64_decode($request->cart));
            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->status = 'pending';
            $order->total_amount = round($request->get('amp;total') / PaymentGateway('paystack_rate') , 2);
            $order->tax = $request->get('amp;tax');
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
            $transaction->payment_method = 'PayStack';
            $transaction->transaction_id = $request->trx_id;
            $transaction->user_id = Auth::user()->id;
            $transaction->amount = round($request->get('amp;total') / PaymentGateway('paystack_rate') , 2);
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
            return redirect()->route('user.dashboard');
        }
    }
    public function bank(Request $request)
    {
        $cart = json_decode(base64_decode($request->cart));
        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->status = 'pending';
        $order->bank_info = $request->bank_transaction_info;
        $order->total_amount = $request->total;
        $order->tax = $request->tax;
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
        $transaction->payment_method = 'Bank';
        $transaction->transaction_id = 'N/A';
        $transaction->user_id = Auth::user()->id;
        $transaction->amount = $request->total;
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
    }
}
