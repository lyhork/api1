<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $req)
    {
        $this->validate(
            $req,
            ['username' => ['required'], 'password' => 'required|min:6|max:20'],
            [
                'username.required' => 'សូមបញ្ចូលអុីម៉ែលឬលេខទូរស័ព្ទ',
                'password.required' => 'សូមបញ្ចូលលេខសម្ងាត់',
                'password.min'      => 'លេខសម្ងាត់ត្រូវធំជាងឬស្មើ៦',
                'password.max'      => 'លេខសម្ងាត់ត្រូវតូចជាងឬស្មើ២០',
            ]
        );
        if (filter_var($req->post('username'), FILTER_VALIDATE_EMAIL)) {
            $credentials = array(
                'email' => $req->username,
                'password' => $req->password,
                'is_active' => 1,
            );
        } else {
            $credentials = array(
                'phone'             =>  $req->username,
                'password'          =>  $req->password,
                'is_active'         =>  1,
            );
        }

        try {

            JWTAuth::factory()->setTTL(1440); //1day = 1440min
            $token = JWTAuth::attempt($credentials);
            if (!$token) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'ឈ្មោះអ្នកប្រើឬពាក្យសម្ងាត់មិនត្រឹមត្រូវ។'
                ], Response::HTTP_UNAUTHORIZED);
            }
        } catch (JWTException $e) {
            return response()->json([
                'status'    => 'បរាជ័យ',
                'message'   => 'មិនអាចបង្កើតនិមិត្តសញ្ញាទេ',
                'error'     => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->respondWithToken($token);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out'], Response::HTTP_OK);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        JWTAuth::factory()->setTTL(1440); //1day = 1440 min
        return $this->respondWithToken(JWTAuth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = auth()->user();
        $dataUser = [
            'id'        => $user->id,
            'name'      => $user->name,
            'email'     => $user->email,
            'avatar'    => $user->avatar,
            'phone'     => $user->phone

        ];
        $role = '';
        if ($user->type_id == 2) { //
            $role = 'Staff';
        } else {
            $role = 'Admin';
        }

        return response()->json([
            'access_token'  => $token,
            'token_type'    => 'bearer',
            'expires_in'    => JWTAuth::factory()->getTTL() * 60 . ' seconds',
            'user'          => $dataUser,
            'role'          => $role
        ], Response::HTTP_OK);
    }
}
