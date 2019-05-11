<?php

namespace App\Http\Controllers;

use App\Goal;
use Illuminate\Http\Request;
use App\Services\GoalService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\GoalFormRequest;

class GoalController extends Controller
{
    /**
     * @var GoalService
     */
    protected $gs;

    /**
     * GoalController constructor.
     * @param GoalService $gs
     */
    public function __construct(GoalService $gs) {
        $this->gs = $gs;
    }

    /**
     * 이용자의 목표를 조회합니다.
     *
     * @return mixed
     *
     * @SWG\Get(
     *     path="/users/goals",
     *     description="이용자의 목표를 조회합니다.",
     *     produces={"application/json"},
     *     tags={"Goal"},
     *      @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="Authorization Token",
     *         required=true,
     *         type="string"
     *      ),
     *      @SWG\Response(
     *         response=200,
     *         description="Successful User Goal Lists"
     *     ),
     * )
     */
    public function show() {
        return Goal::where('user_id', Auth::User()->id)->get();
    }

    /**
     * 이용자가 목표를 추가합니다.
     *
     * @param GoalFormRequest $request
     * @return mixed
     *
     * @SWG\Post(
     *     path="/users/goals",
     *     description="이용자가 목표를 추가합니다.",
     *     produces={"application/json"},
     *     tags={"Goal"},
     *      @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="Authorization Token",
     *         required=true,
     *         type="string"
     *      ),
     *      @SWG\Parameter(
     *          name="title",
     *          in="query",
     *          description="Goal Title",
     *          required=true,
     *          type="string"
     *      ),
     *      @SWG\Parameter(
     *         name="goal_price",
     *         in="query",
     *         description="Goal Price",
     *         required=true,
     *         type="integer"
     *      ),
     *      @SWG\Response(
     *         response=201,
     *         description="Successful User Goal"
     *     ),
     * )
     */
    public function store(GoalFormRequest $request) {
        return Goal::create([
            'user_id' => Auth::User()->id,
            'title' => $request->title,
            'image_url' => $this->gs->imageSearch($request->title),
            'goal_price' => $request->goal_price,
            'current_price' => 0,
        ]);
    }

}
