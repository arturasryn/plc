<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function users(Request $request): JsonResponse
    {
        $data = User::all();
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function user(Request $request)
    {
        return $request->user();
    }
}