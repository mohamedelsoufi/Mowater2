<?php

namespace App\Http\Controllers\Dashboard\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentMethodRequest;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PaymentMethodController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-payment_methods'])->only('index');
        $this->middleware(['permission:create-payment_methods'])->only('create');
        $this->middleware(['permission:update-payment_methods'])->only('edit');
        $this->middleware(['permission:delete-payment_methods'])->only('delete');
    }

    public function index()
    {
        try {
            $payment_methods = PaymentMethod::latest('id')->get();
            return view('admin.general.payment_methods.index', compact('payment_methods'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function show($id)
    {
        try {
            $payment_method = PaymentMethod::find($id);
            return view('admin.general.payment_methods.show', compact('payment_method'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function create()
    {
        return view('admin.general.payment_methods.create');
    }

    public function store(PaymentMethodRequest $request)
    {
        try {
            $request_data = $request->except(['_token', 'symbol']);
            if ($request->has('symbol')) {
                $image = $request->symbol->store('payment_methods/symbol');
                $request_data['symbol'] = $image;
            }
            PaymentMethod::create($request_data);
            return redirect()->route('payment-methods.index')->with(['success' => __('message.created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function edit($id)
    {
        try {
            $payment_method = PaymentMethod::find($id);
            return view('admin.general.payment_methods.edit', compact('payment_method'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }

    public function update(PaymentMethodRequest $request, $id)
    {
        try {
            $payment_method = PaymentMethod::find($id);
            $request_data = $request->except(['_token', 'symbol']);
            if ($request->has('symbol')) {
                $image_path = public_path('uploads/');

                if (File::exists($image_path . $payment_method->getRawOriginal('symbol'))) {
                    File::delete($image_path . $payment_method->getRawOriginal('symbol'));
                }

                $image = $request->symbol->store('payment_methods/symbol');
                $request_data['symbol'] = $image;
            }
            $payment_method->update($request_data);
            return redirect()->route('payment-methods.index')->with(['success' => __('message.updated_successfully')]);

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }


    public function destroy($id)
    {
        try {
            $payment_method = PaymentMethod::find($id);
            $image_path = public_path('uploads/');
            if (File::exists($image_path . $payment_method->getRawOriginal('symbol'))) {
                File::delete($image_path . $payment_method->getRawOriginal('symbol'));
            }
            $payment_method->delete();
            return redirect()->route('payment-methods.index')->with(['success' => __('message.deleted_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('message.something_wrong')]);
        }
    }
}
