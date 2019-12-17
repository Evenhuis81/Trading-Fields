<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment()
    {
        $availablePlans = [
            'webdevmatics monthly' => "Monthly",
            'webdevmatics yearly' => "Yearly",
        ];
        $data = [
            'intent' => auth()->user()->createSetupIntent(),
            'plans' => $availablePlans
        ];
        return view('payment1')->with($data);
    }

    public function subscribe(Request $request)
    {
        $user = auth()->user();
        $paymentMethod = $request->payment_method;

        $planID = $request->plan;
        $user->newSubscription('main', 'premium')->create($paymentMethod);

        return response(['status' => 'success']);
    }
}
