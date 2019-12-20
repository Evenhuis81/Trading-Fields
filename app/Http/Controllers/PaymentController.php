<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment()
    {
        $availablePlans = [
            'webdevmatics_montly' => "Monthly",
            'webdevmatics_yearly' => "Yearly",
        ];
        $data = [
            'intent' => auth()->user()->createSetupIntent(),
            'plans' => $availablePlans,
        ];
        return view('payment1')->with($data);
    }

    public function subscribe(Request $request)
    {
        $user = auth()->user();
        $paymentMethod = $request->payment_method;

        $planId = $request->plan;
        $user->newSubscription('main', $planId)->create($paymentMethod);
        
        return response([
            // 'success_url' => redirect()->intended()->getTargetUrl(),
            'status' => 'success',
            ]);
    }
}
