<?php

namespace Cmendoza\ApiCdc\models;

use Exception;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;
use Cmendoza\ApiCdc\database\DataBaseNoSQL;
use Cmendoza\ApiCdc\controllers\TokenController as TokensConn;

class ModelSendNotifications
{

    private $collection;
    private $db;

    public function __construct($cool)
    {
        $this->db = new DataBaseNoSQL();
        $this->collection = $this->db->connect()->notificacion->$cool;
    }

    public function sendNotify()
    {
        try {

            $tokens = TokensConn::index();
            $defaultRecipients = [
                /**'ExponentPushToken[unrk3pOs6j8hxnIG61JpKA]', 'ExponentPushToken[oLQ-_bHfYjRCiLoK34D3Lp]'*/
            ];
            $messages = [
                /* new ExpoMessage([
                    'title' => 'Super promoción',
                    'body' => 'Chuleta de cerdo 50% de descuento',
                    'data' => ['color' => 'blue']
                ]),*/];
            foreach ($tokens as $value) {
                array_push($defaultRecipients, $value['token']);
            }
            //error_log(json_encode($defaultRecipients));

            $result = $this->collection->find()->toArray();
            foreach ($result as $value) {
                if (!$value['isSend']) {

                    $message = (new ExpoMessage())
                        ->setTitle($value['title'])
                        ->setBody($value['body'])
                        ->setData(['_id' => $value['_id']])
                        ->setChannelId('default')
                        ->setBadge(0)
                        ->playSound();

                    array_push($messages, $message);
                    $result = $this->collection->updateOne(['_id' => $value['_id']], ['$set' => ['isSend' => true]]);
                    $result = $this->collection->updateOne(['_id' => $value['_id']], ['$set' => ["limitedTime" =>  date("Y-m-d H:i:s")]]);
                }
            }

            if (count($messages) < 1) {
                return ['message' => 'No hay notificaciones pendientes'];
            }

            (new Expo)->send($messages)->to($defaultRecipients)->push();
            return ['message' => 'notificaciones enviadas'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }
}
