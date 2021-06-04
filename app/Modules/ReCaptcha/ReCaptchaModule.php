<?php


namespace app\Modules\ReCaptcha;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

// TODO: Вынести работу с сетью

class ReCaptchaModule
{
    public function verify($user_key) : array {

        $client = new Client();
        try {
            $response = $client->post(ReCaptchaConstants::RECAPTCHA_CHECK_URL,  [
                'form_params' => [
                    'response' => $user_key,
                    'secret' => ReCaptchaConstants::GET_SECRET_KEY()
                ]
            ]);

        }
        catch (GuzzleException $e)
        {
            return ['status' => false, 'message' => 'Проблемы с запросом'];
        }
        $body = $response->getBody();
        $body->seek(0);
        $result = '';
        while ($newRes = $body->read(1024)) {
            $result .= $newRes;
        }

        $json = json_decode($result);
        if($json->success === true) {
            if($json->score >= ReCaptchaConstants::USER_LOW_LIMIT) {
                return ['status' => true];
            } else
                return ['status' => false, 'message' => 'Скорее всего вы бот'];
        } else {
            return ['status' => false, 'message' => 'Проблемы с запросом'];
        }
    }
}
