<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\AuthController;
use App\Models\Application;
use App\PaymentGateway\Pay;
use App\PaymentGateway\Zarinpal;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Stripe\Stripe;

class PaymentController extends Controller
{

    public function payToMultipleUsers(Request $request)
    {
        $applicationIds = $request->selected_applications;

        $applications = Application::whereIn('id',$applicationIds)->with('user')->get();

        foreach ($applications as $application){
            $this->payToEachUser($application);
        }

    }

    public function payTOEachUser($application)
    {

        $user = Auth::user();
        $token = $user->createToken('YourAppName')->plainTextToken;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '. $token,
            'Accept' => 'application/json',
        ])->post('https://pay.ir/api/v2/cashouts', [
            'amount' => $application->price,
            'name' => $user->name,
            'iban' => $user->sheba_number,
        ]);

        if ($response->successful()) {

            $responseData = $response->json();

        } else {
            // Handle errors
            $errorCode = $response->status();
            $errorMessage = $response['message']; // Assuming the error message is returned in the response
            // Handle error based on $errorCode and $errorMessage
        }
    }

    public function payment(Request $request, $application)
    {
        $amount = $application->price;
        if (array_key_exists('error', $amount)) {
            alert()->error($amount['error'], 'دقت کنید');
            return redirect()->route('home.index');
        }

        if ($request->payment_method == 'pay') {
            $payGateway = new Pay();
            $payGatewayResult = $payGateway->send($amount);
            if (array_key_exists('error', $payGatewayResult)) {
                alert()->error($payGatewayResult['error'], 'دقت کنید')->persistent('حله');
                return redirect()->back();
            } else {
                return redirect()->to($payGatewayResult['success']);
            }
        }

        if ($request->payment_method == 'zarinpal') {
            $zarinpalGateway = new Zarinpal();
            $zarinpalGatewayResult = $zarinpalGateway->send($amount);
            if (array_key_exists('error', $zarinpalGatewayResult)) {
                alert()->error($zarinpalGatewayResult['error'], 'دقت کنید')->persistent('حله');
                return redirect()->back();
            } else {
                return redirect()->to($zarinpalGatewayResult['success']);
            }
        }

        alert()->error('درگاه پرداخت انتخابی اشتباه میباشد', 'دقت کنید');
        return redirect()->back();
    }

    public function paymentVerify(Request $request, $gatewayName)
    {
        if ($gatewayName == 'pay') {
            $payGateway = new Pay();
            $payGatewayResult = $payGateway->verify($request->token, $request->status);

            if (array_key_exists('error', $payGatewayResult)) {
                alert()->error($payGatewayResult['error'], 'دقت کنید')->persistent('حله');
                return redirect()->back();
            } else {
                alert()->success($payGatewayResult['success'], 'با تشکر');
                return redirect()->route('home.index');
            }
        }


        alert()->error('مسیر بازگشت از درگاه پرداخت اشتباه می باشد', 'دقت کنید');
        return redirect()->route('home.orders.checkout');
    }

}
