<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BankService;
use Illuminate\Support\Facades\Log;

class BankController extends Controller
{
    /**
     * @var BankService
     */
    protected $bs;

    /**
     * BankController constructor.
     * @param BankService $bs
     */
    public function __construct(BankService $bs) {
        $this->bs = $bs;
    }

    // test callback method
    public function callback(Request $request) {
        Log::debug($request->all());
    }

    /**
     * 이용자가 은행 계좌를 등록합니다.
     *
     * @param Request $request
     * @return mixed
     *
     * @SWG\Post(
     *     path="/users/bank",
     *     description="이용자가 은행 계좌를 등록합니다.",
     *     produces={"application/json"},
     *     tags={"Payment"},
     *      @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="Authorization Token",
     *         required=true,
     *         type="string"
     *      ),
     *      @SWG\Parameter(
     *          name="bank_name",
     *          in="query",
     *          description="User Bank Name",
     *          required=true,
     *          type="string"
     *      ),
     *      @SWG\Parameter(
     *         name="name",
     *         in="query",
     *         description="User Name",
     *         required=true,
     *         type="string"
     *      ),
     *      @SWG\Parameter(
     *         name="birthday",
     *         in="query",
     *         description="User Birthday",
     *         required=true,
     *         type="string"
     *      ),
     *      @SWG\Parameter(
     *         name="bank_account_number",
     *         in="query",
     *         description="User Bank Account Number",
     *         required=true,
     *         type="integer"
     *      ),
     *      @SWG\Parameter(
     *         name="bank_account_password",
     *         in="query",
     *         description="User Bank Account Password first and second",
     *         required=true,
     *         type="integer"
     *      ),
     *      @SWG\Response(
     *         response=201,
     *         description="Successful User Bank Account"
     *     ),
     * )
     */
    public function store(Request $request) {

    }
}
