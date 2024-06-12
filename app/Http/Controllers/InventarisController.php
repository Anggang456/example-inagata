<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventarisController extends Controller
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

    public function addInventaris(Request $request)
    {
        $inventory = Inventory::where('name', $request->name)->first();

        if ($inventory) {
            $inventory->quantity += $request->quantity;
        } else {
            $inventory = new Inventory($request->all());
            $inventory->user_id = $request->user()->id;
        }

        $inventory->save();

        return response()->json([
            'status' => true,
            'data' => ['id' => $inventory->id],
            'message' => 'Tambah inventaris sukses'
        ]);
    }

    public function updateInventaris(Request $request, $id)
    {
        $inventory = Inventory::find($id);

        if ($inventory) {
            $inventory->update($request->all());

            return response()->json([
                'status' => true,
                'data' => ['user_id' => $request->user()->id],
                'message' => 'Update inventaris sukses'
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => ['user_id' => $request->user()->id],
            'message' => 'Update inventaris gagal'
        ]);
    }

    public function deleteInventaris($id)
    {
        $inventory = Inventory::find($id);

        if ($inventory) {
            $inventory->delete();

            return response()->json([
                'status' => true,
                'data' => null,
                'message' => 'Hapus inventaris sukses'
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => null,
            'message' => 'Hapus inventaris gagal'
        ]);
    }

    public function listInventaris()
    {
        $inventories = Inventory::with('user')->get();

        return response()->json([
            'status' => true,
            'data' => $inventories,
            'message' => 'List inventaris sukses'
        ]);
    }

    public function inventarisById($id)
    {
        $inventory = Inventory::with('user')->find($id);

        if ($inventory) {
            return response()->json([
                'status' => true,
                'data' => $inventory,
                'message' => 'Get inventaris sukses'
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => null,
            'message' => 'Get inventaris gagal'
        ]);
    }
}
