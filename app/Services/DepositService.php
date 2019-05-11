<?php
/**
 * Created by PhpStorm.
 * User: solaris
 * Date: 2019-05-12
 * Time: 02:30
 */

namespace App\Services;

use App\Goal;
use App\User;
use App\Deposit;
use App\Transaction;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DepositService
{
    /**
     * @var Command
     */
    protected $command;

    /**
     * @var Client
     */
    protected $client;

    /**
     * DepositService constructor.
     * @param Client $client
     */
    public function __construct(Client $client) {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function index() {
        return Deposit::where('user_id', Auth::User()->id)->get();
    }

    /**
     * 트랜잭션에 대해 싱크를 맞춥니다.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncDeposit() {
        $transactionDatas = Transaction::whereNull('deposit_id')->get();

        try {
            DB::beginTransaction();

            foreach ($transactionDatas as $transaction) {
                $deposit = Deposit::insertGetId([
                    'user_id' => $transaction->user_id,
                    'goal_id' => Goal::where('user_id', $transaction->user_id)->where('valid', 1)->orderBy('created_at', 'desc')->value('id'),
                    'transaction_id' => $transaction->id,
                    'price' => $transaction->amount / User::where('id', $transaction->user_id)->value('interest_rate'),
                    'cost_price' => $transaction->amount
                ]);

                Transaction::find($transaction->id)->update([
                    'deposit_id' => $deposit,
                ]);
            }

            $this->print('Transaction Data => Deposit Data All Success');
        } catch (Exception $exception) {
            DB::rollback();
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * @param int $id
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function renderPDF(int $id) {
        $url = 'https://forte.team-crescendo.me:8000/users/' . $id . '/deposits';

        $response = $this->client->request('GET', 'https://restpack-restpack-html-to-pdf-v2.p.rapidapi.com/convert', [
            'headers' => [
                'X-RapidAPI-Host' => 'restpack-restpack-html-to-pdf-v2.p.rapidapi.com',
                'X-RapidAPI-Key' => env('RAKUTEN_RAPID_API_KEY'),
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'query' => [
                'access_token' => env('PDF_RENDER_TOKEN'),
                'url' => 'https://naver.com',
                'json' => 'true'
            ],
        ]);

        return response()->json([
            'message' => 'Create PDF Render',
            'url' => json_decode($response->getBody(), true)['image']
        ], 201);

    }

    private function print(string $message) {
        if ($this->command) {
            $this->command->info($message);
        } else {
            dump($message);
        }
    }
}
