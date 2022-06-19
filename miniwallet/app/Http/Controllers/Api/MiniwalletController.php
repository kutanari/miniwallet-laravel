<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MiniwalletController extends Controller
{
    public function init(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'customer_xid' => 'required|uuid|unique:accounts',
        ], [
            'customer_xid.required' => 'The customer XID is required',
            'customer_xid.uuid' => 'The customer XID must be a valid UUID',
            'customer_xid.unique' => 'The customer XID already registered',
        ]);

        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors(),
                'status' => 'fail'
            ];
            return response()->json($response);
        }

        $customer_xid = $request->input('customer_xid');
        // $account = Account::where('customer_xid', $customer_xid)->first();
        // if ($account) {
        //     $response = [
        //         'data' => [
        //             'token' => $account->token,
        //         ],
        //         'status' => 'success'
        //     ];
        //     return response()->json($response);
        // }

        $token = sha1($customer_xid . '-' . Str::random(32));
        $account = new Account;
        $account->customer_xid = $customer_xid;
        $account->token = $token;

        if ($account->save()) {
            $wallet = new Wallet;
            $wallet->id = Str::uuid();
            $wallet->owned_by = $customer_xid;

            if ($wallet->save()) {
                $response = [
                    'status' => 'success',
                    'data' => [
                        'token' => $token
                    ]
                ];
            } else {
                $response = [
                    'status' => 'fail',
                    'message' => 'Failed to create wallet'
                ];
            }

            return response()->json($response);
        } else {
            $response = [
                'message' => 'Account creation failed',
                'status' => 'error'
            ];
            return response()->json($response);
        }
    }

    public function enableWallet(Request $request)
    {
        $account = $request->get('account');
        $wallet = Wallet::where('owned_by', $account->customer_xid)->first();

        if ($wallet->status === Wallet::STATUS_ENABLED) {
            $response = [
                'message' => 'Wallet already enabled',
                'status' => 'fail'
            ];
            return response()->json($response);
        }

        $wallet->status = Wallet::STATUS_ENABLED;
        $wallet->enabled_at = now();

        if ($wallet->save()) {
            $response = [
                'status' => 'success',
                'data' => [
                    'wallet' => [
                        'id' => $wallet->id,
                        'owned_by' => $wallet->owned_by,
                        'status' => $wallet->status,
                        'enabled_at' => $wallet->enabled_at,
                        'balance' => 0, //TODO:: get balance from transaction
                    ]
                ]
            ];
        } else {
            $response = [
                'status' => 'fail',
                'message' => 'Failed to enable wallet'
            ];
        }
        return response()->json($response);
    }

    public function getWallet(Request $request)
    {
        $account = $request->get('account');
        $wallet = Wallet::where('owned_by', $account->customer_xid)->first();
        $response = [
            'status' => 'success',
            'data' => [
                'wallet' => [
                    'id' => $wallet->id,
                    'owned_by' => $wallet->owned_by,
                    'status' => $wallet->status,
                    'enabled_at' => $wallet->enabled_at,
                    'balance' => 0, //TODO:: get balance from transaction
                ]
            ]
        ];
        return response()->json($response);
    }
}
