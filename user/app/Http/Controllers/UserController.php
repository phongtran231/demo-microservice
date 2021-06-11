<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'username' => 'required|unique:users',
                'password' => 'required|min:5',
            ]);
            $this->user->username = $request->input('username');
            $this->user->password = Hash::make($request->input('password'));
            $this->user->save();
            return response()->json([
                'data' => $this->user,
                'status' => Response::HTTP_OK,
            ]);
        } catch (ValidationException $e) {
            return response()->json($e->validator->getMessageBag(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function login(Request $request)
    {
        try {
            $this->validate($request, [
                'username' => 'required',
                'password' => 'required',
            ]);
            $loginData = $request->only(['username', 'password']);
            if (!$token = auth()->attempt($loginData)) {
                return response()->json([
                    'data' => null,
                    'status' => Response::HTTP_UNAUTHORIZED,
                ], Response::HTTP_UNAUTHORIZED);
            }
            return response()->json([
                'data' => $token,
                'status' => Response::HTTP_OK,
            ]);
        } catch (ValidationException $e) {
            return response()->json($e->validator->getMessageBag(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function verifyToken()
    {
        if (auth()->user()) {
            return response()->json([
                'data' => Response::HTTP_OK,
                'status' => Response::HTTP_OK,
            ]);
        }
    }
}
