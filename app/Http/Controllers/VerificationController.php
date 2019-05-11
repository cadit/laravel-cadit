<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\VerificationService;

class VerificationController extends Controller
{
    protected $vs;
    public function __construct(VerificationService $vs) {
        $this->vs = $vs;
    }

    /**
     * 이용자가 회원가입 시 휴대폰 인증 번호를 전송합니다.
     *
     * @param Request $request
     * @return mixed
     *
     * @SWG\Post(
     *     path="/auth/phone",
     *     description="이용자가 회원가입 시 휴대폰 인증 번호를 전송합니다.",
     *     produces={"application/json"},
     *     tags={"Verify"},
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
     *          description="User Phone Number",
     *          required=true,
     *          type="integer"
     *      ),
     *     @SWG\Response(
     *         response=201,
     *         description="Successful Phone Verify Send"
     *     ),
     * )
     */
    public function send(Request $request) {
        if (empty($request->email) || empty($request->phone)) {
            return response()->json([
                'message' => 'Notfound Email or Phone Number Parameters',
            ], 404);
        }

        $verify = $this->vs->send($request->only('email', 'phone'));
        return $verify;
    }
}
