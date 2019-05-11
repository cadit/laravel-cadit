<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CardService;
use App\Http\Requests\CardStoreRequest;

class CardController extends Controller
{
    /*
     * @var CardService
     */
    protected $cs;

    /**
     * CardController constructor.
     * @param CardService $cs
     */
    public function __construct(CardService $cs) {
        $this->cs = $cs;
    }

    /**
     * 이용자가 카드를 등록합니다.
     *
     * @param CardStoreRequest $request
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @endpoint https://noodlio-pay.p.rapidapi.com/tokens/create
     *
     * @SWG\Post(
     *     path="/users/card",
     *     description="이용자가 카드를 등록합니다.",
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
     *          name="card_no",
     *          in="query",
     *          description="User Card Number",
     *          required=true,
     *          type="string"
     *      ),
     *      @SWG\Parameter(
     *         name="card_valid_month",
     *         in="query",
     *         description="User Card Valid Month",
     *         required=true,
     *         type="integer"
     *      ),
     *      @SWG\Parameter(
     *         name="card_valid_year",
     *         in="query",
     *         description="User Card Valid Year",
     *         required=true,
     *         type="integer"
     *      ),
     *      @SWG\Parameter(
     *         name="card_valid_cvc",
     *         in="query",
     *         description="User Card Valid CVC",
     *         required=true,
     *         type="integer"
     *      ),
     *      @SWG\Response(
     *         response=201,
     *         description="Successful Card Verify"
     *     ),
     * )
     */
    public function store(CardStoreRequest $request) {
        return $this->cs->validation($request->only('card_no', 'card_valid_month', 'card_valid_year', 'card_valid_cvc'));
    }
}
