<?php

namespace App\Http\Controllers;

use App\User;
use App\Verify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterFormRequest;

class JWTAuthController extends Controller
{

    /**
     * 이용자를 추가(회원가입) 합니다.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     *
     * @SWG\Post(
     *     path="/auth/register",
     *     description="이용자를 추가(회원가입) 합니다.",
     *     produces={"application/json"},
     *     tags={"User"},
     *      @SWG\Parameter(
     *          name="name",
     *          in="query",
     *          description="User Name",
     *          required=true,
     *          type="string"
     *      ),
     *      @SWG\Parameter(
     *          name="email",
     *          in="query",
     *          description="User Email",
     *          required=true,
     *          type="string"
     *      ),
     *      @SWG\Parameter(
     *          name="phone",
     *          in="query",
     *          description="User Phone NUmber",
     *          required=true,
     *          type="integer"
     *      ),
     *      @SWG\Parameter(
     *          name="code",
     *          in="query",
     *          description="Verify Phone Code",
     *          required=true,
     *          type="integer"
     *      ),
     *      @SWG\Parameter(
     *          name="password",
     *          in="query",
     *          description="User Password",
     *          required=true,
     *          type="string"
     *      ),
     *     @SWG\Response(
     *         response=201,
     *         description="Successful Register User"
     *     ),
     * )
     */
    public function register(RegisterFormRequest $request) {
        $find = Verify::where('email', $request->email)
            ->where('verify', Verify::PHONE_UNVERIFY)
            ->orderBy('created_at', 'desc')
            ->where('code', $request->code)
            ->where('created_at', '>', Carbon::now()->parse('-3 minutes')->toDateTimeString())
            ->first();

        if (! $find) {
            return response()->json([
               'message' => 'Unknown Verify Code'
            ], 500);
        }

        $find->verify = Verify::PHONE_VERIFY;
        $find->save();

        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
        $user->save();

        return response([
            'status' => 'success',
            'data' => $user
        ], 201);
    }

    /**
     * 이용자가 로그인합니다.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     *
     * @SWG\Post(
     *     path="/auth/login",
     *     description="이용자가 로그인합니다.",
     *     produces={"application/json"},
     *     tags={"User"},
     *      @SWG\Parameter(
     *          name="email",
     *          in="query",
     *          description="User Email",
     *          required=true,
     *          type="string"
     *      ),
     *      @SWG\Parameter(
     *          name="password",
     *          in="query",
     *          description="User Password",
     *          required=true,
     *          type="string"
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful Login User"
     *     ),
     * )
     */
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        if (! $token = JWTAuth::attempt($credentials)) {
            return response([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.'
            ], 400);
        } else {
            return response([
                'status' => 'success',
                'token' => $token
            ]);
        }
    }

    /**
     * 이용자의 상세정보를 조회합니다.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     *
     * @SWG\Get(
     *     path="/auth/user",
     *     description="이용자의 상세정보를 조회합니다.",
     *     produces={"application/json"},
     *     tags={"User"},
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="Authorization Token",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful User Information"
     *     ),
     * )
     */
    public function user(Request $request) {
        $user = User::find(Auth::user()->id);
        return response([
            'status' => 'success',
            'data' => $user
        ]);
    }

    /**
     * 이용자의 인증 토큰을 재발급(갱신) 합니다.
     *
     * @return \Illuminate\Http\Response
     *
     * @SWG\Get(
     *     path="/auth/token/refresh",
     *     description="이용자의 인증 토큰을 재발급(갱신) 합니다.",
     *     produces={"application/json"},
     *     tags={"User"},
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="Authorization Token",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful User Refresh JWT Token"
     *     ),
     * )
     */
    public function refresh() {
        return response([
            'status' => 'success'
        ]);
    }

    /**
     * 이용자를 로그아웃 처리합니다.
     *
     * @return \Illuminate\Http\Response
     *
     * @SWG\Get(
     *     path="/auth/logout",
     *     description="이용자를 로그아웃 처리합니다.",
     *     produces={"application/json"},
     *     tags={"User"},
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="Authorization Token",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful User Logout"
     *     ),
     * )
     */
    public function logout() {
        JWTAuth::invalidate();
        return response([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }
    
}
