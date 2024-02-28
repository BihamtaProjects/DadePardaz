<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\AuthController;
use App\Models\Application;
use App\Notifications\applicationPayed;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{

    public function payToMultipleUsers(Request $request)
    {
        $applicationIds = $request->selected_applications;

        $applications = Application::whereIn('id', $applicationIds)->with('user')->get();

        foreach ($applications as $application) {
           $pay =  $this->payToEachUser($application);
        }

    }

    public function payTOEachUser($application)
    {
        $user = $application->user;
        $token = $user->createToken('YourAppName')->plainTextToken;

        $data = [
            'amount' => $application->price,
            'name' => $user->name,
            'iban' => $user->sheba_number,
            'uid' => \Str::random(40) //random and unique string(its just for test)
        ];

        $headers = [
            'Authorization: Bearer ' . $token,
            'Accept: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://pay.ir/api/v2/cashouts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $response = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpStatus == 200) {
            $responseData = json_decode($response, true);
//            $user->notify( new ApplicationPayed() );
        } else {
//error handling
            $responseData = json_decode($response, true);
            $errorMessage = $responseData['message'];
            dd($errorMessage);
        }

        curl_close($ch);
    }
}
