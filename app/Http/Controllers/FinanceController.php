<?php

namespace App\Http\Controllers;

use App\Models\FinanceRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'logout success'
        ]);
    }

    public function getProfile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'status' => true,
            'data' => $user,
            'message' => 'Get sukses'
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $user->update($request->all());

        return response()->json([
            'status' => true,
            'data' => ['id' => $user->id],
            'message' => 'Update sukses'
        ]);
    }

    public function addFinance(Request $request)
    {
        $financeRecord = new FinanceRecord();
        $financeRecord->user_id = $request->user()->id;
        $financeRecord->type = $request->type;
        $financeRecord->amount = $request->amount;
        $financeRecord->description = $request->description;
        $financeRecord->save();

        return response()->json([
            'status' => true,
            'data' => ['id' => $financeRecord->id],
            'message' => 'Tambah pencatatan sukses'
        ]);
    }

    public function updateFinance(Request $request, $id)
    {
        $financeRecord = FinanceRecord::find($id);

        if ($financeRecord && $financeRecord->user_id == $request->user()->id) {
            $financeRecord->update($request->all());

            return response()->json([
                'status' => true,
                'data' => ['id' => $financeRecord->id],
                'message' => 'Update pencatatan sukses'
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => null,
            'message' => 'Update pencatatan gagal'
        ]);
    }

    public function listUser()
    {
        $users = User::with('financeRecords')->get();

        $data = $users->map(function ($user) {
            return [
                'user' => $user,
                'finance_records' => $user->financeRecords
            ];
        });

        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => 'List user sukses'
        ]);
    }
}
