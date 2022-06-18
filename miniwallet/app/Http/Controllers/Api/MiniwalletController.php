<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
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
        $isSaved = $account->save();

        if ($isSaved) {
            $response = [
                'status' => 'success',
                'data' => [
                    'token' => $token
                ]
            ];
            return response()->json($response);
        } else {
            $response = [
                'message' => 'Account creation failed',
                'status' => 'error'
            ];
            return response()->json($response);
        }
    }
}
