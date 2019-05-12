<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\DepositService;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    /**
     * @var DepositService
     */
    protected $ds;

    /**
     * DepositController constructor.
     * @param DepositService $ds
     */
    public function __construct(DepositService $ds) {
        $this->ds = $ds;
    }

    /**
     * @return mixed
     */
    public function sync() {
        return $this->ds->syncDeposit();
    }

    /**
     * 이용자의 트랜잭션을 조회합니다.
     *
     * @return mixed
     *
     * @SWG\Get(
     *     path="/users/deposits",
     *     description="이용자의 트랜잭션을 조회합니다.",
     *     produces={"application/json"},
     *     tags={"Deposit"},
     *      @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="Authorization Token",
     *         required=true,
     *         type="string"
     *      ),
     *      @SWG\Response(
     *         response=201,
     *         description="Successful User Deposit Lists"
     *     ),
     * )
     */
    public function index() {
        return $this->ds->index();
    }

    /**
     * 이용자의 아이디로 트랜잭션을 조회후 PDF 로 랜더링합니다.
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @SWG\Get(
     *     path="/users/deposits/pdf",
     *     description="이용자의 아이디로 트랜잭션을 조회후 PDF 로 랜더링합니다.",
     *     produces={"application/json"},
     *     tags={"Deposit"},
     *      @SWG\Response(
     *         response=201,
     *         description="Successful User Deposit PDF Render"
     *     ),
     * )
     */
    public function pdfRenderFromDepositList() {
        return $this->ds->renderPDF();
    }
}
