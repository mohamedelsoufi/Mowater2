<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\AvailablePaymentMethodRequest;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class OrgAvailablePaymentMethodController extends Controller
{
    private $paymentMethod;

    public function __construct(PaymentMethod $method)
    {
        $this->middleware(['HasOrgPaymentMethod:read'])->only(['index', 'show']);
        $this->middleware(['HasOrgPaymentMethod:update'])->only('edit');
        $this->middleware(['HasOrgPaymentMethod:create'])->only('create');
        $this->middleware(['HasOrgPaymentMethod:delete'])->only('destroy');

        $this->paymentMethod = $method;
    }

    public function index()
    {
        try {
            $record = getModelData();
            $payment_methods = $record->payment_methods;
            return view('organization.AvailablePaymentMethods.index', compact('record', 'payment_methods'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $record = getModelData();
            $payment_method = $record->payment_methods()->find($id);
            return view('organization.AvailablePaymentMethods.show', compact('record', 'payment_method'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit()
    {
        try {
            $record = getModelData();
            $payment_methods = $this->paymentMethod->latest('id')->get();
            $available_payment_methods = $record->payment_methods->pluck('id')->toArray();
            return view('organization.AvailablePaymentMethods.edit', compact('record', 'payment_methods','available_payment_methods'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function update(AvailablePaymentMethodRequest $request)
    {
        try {
            $organization = getModelData();

            $organization->payment_methods()->sync($request->available_payment);

            return redirect()->route('organization.available-payment-methods.index')->with('success', __('message.updated_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
