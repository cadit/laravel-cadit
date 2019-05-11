<?php

namespace App\Http\Controllers;

use App\Finance;
use Illuminate\Http\Request;
use App\Services\BankService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FinanceFormRequest;

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
     * @param FinanceFormRequest $request
     * @return mixed
     *'user_id', 'bank_code', 'bank_name', 'account_order_name', 'account_type', 'account_status', 'account_order_birthday'
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
     *         name="account_order_name",
     *         in="query",
     *         description="User Name",
     *         required=true,
     *         type="string"
     *      ),
     *      @SWG\Parameter(
     *         name="account_order_birthday",
     *         in="query",
     *         description="User Birthday",
     *         required=true,
     *         type="integer"
     *      ),
     *      @SWG\Parameter(
     *         name="account_type",
     *         in="query",
     *         description="User Bank Account Type 1: 개인, 2: 법인",
     *         required=true,
     *         type="integer"
     *      ),
     *      @SWG\Parameter(
     *         name="bank_account_number",
     *         in="query",
     *         description="User Bank Account Number",
     *         required=true,
     *         type="string"
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
    public function store(FinanceFormRequest $request) {
        switch ($request->bank_name) {
            case '국민은행':
                $request->bank_code = '04';
                break;
            case 'IBK 기업은행':
                $request->bank_code = '03';
                break;
            case '우리은행':
                $request->bank_code = '20';
                break;
            case '우체국':
                $request->bank_code = '71';
                break;
            case '한국은행':
                $request->bank_code = '01';
                break;
        }

        // 금융결제원 계좌실명조회 API 우선 생략
        return Finance::create([
            'user_id' => Auth::User()->id,
            'bank_code' => $request->bank_code,
            'bank_name' => $request->bank_name,
            'account_order_name' => $request->account_order_name,
            'account_type' => $request->account_type,
            'account_status' => 1,
            'account_order_birthday' => $request->account_order_birthday,
            'bank_account_number' => preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", '', $request->bank_account_number),
            'bank_account_password' => $this->bs->accountDecryptPasswordSalt($request->bank_account_password)
        ]);
    }

    /**
     * 금융결제원 API 테스트베드 기반 json
     * 실제로 신청 단계를 거쳐야하므로 더미데이터로 진행
     */
    public function testDummyCase() {

    }
}
