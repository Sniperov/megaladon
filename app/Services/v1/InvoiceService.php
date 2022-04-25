<?php

namespace App\Services\v1;

use App\Models\Invoice;
use App\Models\Subscription;
use App\Models\User;
use App\Repositories\InvoiceRepo;
use App\Services\BaseService;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Str;
use SimpleXMLElement;

class InvoiceService extends BaseService
{
    private array $config;

    public function __construct() {
        $this->config = config('paybox');
    }

    public function executorCreate(User $user, array $data)
    {
        $executor = $user->executor;
        if (!$executor) {
            return $this->errNotFound('Исполнитель не найден');
        }

        $subscription = Subscription::find($data['subscription_id']);
        if (!$subscription) {
            return $this->errNotFound('Подписка не найдена');
        }
        if ($subscription->type !== Subscription::EXECUTOR) {
            return $this->errValidate('Данная подписка не предназначена для исполнителя');
        }

        if ($subscription->price == 0) {
            $data['status'] = Invoice::STATUS_PAID;
            $data['expired_at'] = Carbon::now()->addMonths($subscription->validity);
        }

        $invoice = $executor->invoices()->create($data);

        return $this->result([
            'data' => [
                'invoice_id' => $invoice->id,
                'phone' => $user->phone,
                'user_id' => $user->id,
            ]
        ]);
    }

    public function storeCreate(User $user, array $data)
    {
        $store = $user->store;
        if (!$store) {
            return $this->errNotFound('Магазин не найден');
        }

        $subscription = Subscription::find($data['subscription_id']);
        if (!$subscription) {
            return $this->errNotFound('Подписка не найдена');
        }
        if ($subscription->type !== Subscription::STORE) {
            return $this->errValidate('Данная подписка не предназначена для магазина');
        }

        if ($subscription->price == 0) {
            $data['status'] = Invoice::STATUS_PAID;
            $data['expired_at'] = Carbon::now()->addMonths($subscription->validity);
        }

        $invoice = $store->invoices()->create($data);

        return $this->result([
            'data' => [
                'invoice_id' => $invoice->id,
                'phone' => $user->phone,
                'user_id' => $user->id,
            ]
        ]);
    }

    public function paid(int $invoiceId, array $data)
    {

        $invoice = Invoice::find($invoiceId);
        if (!$invoice) {
            return $this->errNotFound('Счет не найден');
        }

        $check = $this->checkTransaction($data['transaction_id']);
        if (!$this->isSuccess($check)) {
            return $check;
        }

        if ($invoice !== Invoice::STATUS_PAID) {
            if ($invoice->invoiceable->activeInvoice()) {
                (new InvoiceRepo())->update($invoice->id, [
                    'meta' => json_encode($data), 
                    'status' => Invoice::STATUS_PAID,
                    'expired_at' => Carbon::parse($invoice->invoiceable->activeInvoice()->expired_at)->addMonths($invoice->subscription->validity),
                ]);
            }
            else {
                (new InvoiceRepo())->update($invoice->id, [
                    'meta' => json_encode($data), 
                    'status' => Invoice::STATUS_PAID,
                    'expired_at' => Carbon::now()->addMonths($invoice->subscription->validity),
                ]);
            }
        }

        return $this->ok();
    }

    private function checkTransaction($transaction_id)
    {
        $request = new Request('POST', 'https://api.paybox.money/get_status2.php');

        $body = json_encode($this->generatePaymentParams($transaction_id));

        $client = new Client();
        $response = null;
        $response =  $client->send($request, [
            'body' => $body,
            'headers' => ['Content-Type' => 'application/json'],
            'connect_timeout' => 10,
            'verify' => false,
            'http_errors' => false,
        ]);

        $responseData = new SimpleXMLElement($response->getBody()->getContents());
        if ($responseData->pg_status == 'error') {
            return $this->error(500, 'Не удалось проверить транзакцию. Код ошибки: ' . $responseData->pg_error_code . ', текст ошибки: ' . $responseData->pg_error_description);
        }
        if ($responseData->pg_transaction_status == 'ok') {
            return $this->ok();
        }

        return $this->errNotAcceptable('Транзакция не была оплачена');
    }

    private function generatePaymentParams($transaction_id)
    {
        $pg_merchant_id = 543326;
        $secret_key ='yGLBIQphhMhc3Ekg';

        $request = [
            'pg_merchant_id'=> $this->config['merchant_id'],
            'pg_payment_id' => $transaction_id,
            'pg_salt' => Str::random(16),
        ];

        //generate a signature and add it to the array
        ksort($request); //sort alphabetically
        array_unshift($request, 'get_status2.php');
        array_push($request, $this->config['secret_key']); //add your secret key (you can take it in your personal cabinet on paybox system)

        $request['pg_sig'] = md5(implode(';', $request)); // signature

        unset($request[0], $request[1]);

        return $request;
    }
}