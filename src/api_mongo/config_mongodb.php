<?php

require '../vendor/autoload.php';

// Creo un alias del namespace
use Dotenv\Dotenv as Env;
use MongoDB\Client as Mongo;

$dotenv = Env::createImmutable(__DIR__ . '/../');
$dotenv->load();

$cliente = new Mongo("mongodb://{$_ENV['MDB_HOST']}");
$colección = $cliente->demo->beers;

//$resultado = $colección->insertOne(['name' => 'ÑÑ', 'brewery' => 'BrewDog']);
//$resultado = $colección->insertMany(['name' => 'Hin', 'brewery' => 'BrewDog']);
//echo "Inserted with Object ID '{$resultado->getInsertedId()}'  <br/> \n";

$result = $colección->find()->toArray();
//print_r($result);
foreach ($result as $value) {
    echo "ID: {$value['_id']} " . ' : ' . "ID: {$value['name']} <br/>" . PHP_EOL;
}

//$result = $colección->find(array('name' => 'Hin'))->toArray();
//print_r($result);
//echo '<br>';

//$colección->updateOne(['name' => 'Hin'], ['$set' => ['name' => 'in']]);
//$colección->updateMany(['name' => 'Hin'], ['$set' => ['name' => 'in']]);
//echo 'Se actualizo la colección <br>';

//$result = $colección->find(['name' => 'in'])->toArray();
//$result = $colección->findOne(['name' => 'in'])->toArray();
//$result = $colección->findMany(['name' => 'in'])->toArray();

/*foreach ($result as $value) {
    echo "ID: {$value['_id']} " . ' : ' . "ID: {$value['name']} <br/>" . PHP_EOL;
}*/

//$colección->deleteMany(['name' => 'Hinterland']);
//$colección->deleteOne(['name' => 'Hinterland']);



use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage ;

/**
 * Composed messages, see above
 * Can be an array of arrays, ExpoMessage instances will be made internally
 */
$messages = [
   /* [
        'title' => 'Test notification',
        'to' => 'ExponentPushToken[unrk3pOs6j8hxnIG61JpKA]',
    ],*/
    new ExpoMessage([
        'title' => 'Notification for default recipients',
        'body' => 'Because "to" property is not defined',
    ]),
];

/**
 * These recipients are used when ExpoMessage does not have "to" set
 */
$defaultRecipients = [
    'ExponentPushToken[unrk3pOs6j8hxnIG61JpKA]',
];

(new Expo)->send($messages)->to($defaultRecipients)->push();
//(new Expo)->send($messages)->push();