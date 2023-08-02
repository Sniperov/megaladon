<?php

namespace App\Services\v1;

use App\Models\User;
use App\Repositories\PhoneConfirmationRepo;
use App\Services\BaseService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PhoneConfirmationService extends BaseService
{
    private PhoneConfirmationRepo $pcRepo;
    private $smsConfig;

    public function __construct() {
        $this->pcRepo = new PhoneConfirmationRepo();
        $this->smsConfig = config('smsc');
    }

    public function sendCode(User $user, $phone)
    {
        $code = 101010;
        if ($this->smsConfig['no_send_sms'] == false) {
            $code = rand(100000, 999999);
        }
        $this->pcRepo->store($user, $phone, $code);

        if ($this->smsConfig['no_send_sms'] == false) {
            $url = 'https://smsc.kz/sys/send.php'; // $this->smsConfig['url']
            $params = [
                'login' => $this->smsConfig['login'],
                'psw' => $this->smsConfig['password'],
                'phones' => substr($phone, 1, 11),
                'mes' => 'Ваш код - ' . $code,
                'sender' => 'Manover',
                'translit' => 0,
                'time' => 0,
                'fmt' => 3,
            ];
    
            $client = new Client();
            $response = $client->request('POST', $url, [
                'form_params' => $params
            ]);
    
            $jsonResponse = json_decode($response->getBody()->getContents(), true);
            Log::info($jsonResponse);
            if (isset($jsonResponse['error'])) {
                return $this->errService('Не удалось отправить смс код');
            }
        }
        
        return $this->ok();
    }
}