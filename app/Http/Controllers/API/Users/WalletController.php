<?php

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\WalletRequest;
use App\Http\Resources\Users\ShowWalletResource;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function chargeWallet(WalletRequest $request)
    {
        try {
            $user = auth('api')->user();
            if (!$user)
                return responseJson(0, __('message.user_not_registered'));
            $wallet = $user->wallet;
            if (!$wallet) {
                $wallet = $user->wallet()->create([
                    'amount' => $request->amount
                ]);
            } else {
                $wallet->update([
                    'amount' => $wallet->amount + $request->amount
                ]);
            }
            return responseJson(1, 'success', new ShowWalletResource($wallet));

        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }

    public function show()
    {
        try {
            $user = auth('api')->user();
            if (!$user)
                return responseJson(0, __('message.user_not_registered'));
            $wallet = $user->wallet;
            if (!$wallet) {
                return responseJson(0, 'error', __('message.user_not_have_wallet'));
            }
            return responseJson(1, 'success', new ShowWalletResource($wallet));
        } catch (\Exception $e) {
            return responseJson(0, 'error', $e->getMessage());
        }
    }
}
