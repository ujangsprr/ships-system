<?php

require('vendor/autoload.php');

use \PhpMqtt\Client\MqttClient;
use \PhpMqtt\Client\ConnectionSettings;

$server   = 'e8b666776c3444dd9f8c8a29f9fb9d7d.s1.eu.hivemq.cloud';
$port     = 8883;
$clientId = "test";
$username = 'ujang';
$password = 'Ujang123';
$clean_session = false;

// $server   = 'broker-cn.emqx.io';
// $port     = 1883;
// $clientId = rand(5, 15);
// $username = 'emqx_user';
// $password = null;
// $clean_session = false;

$connectionSettings  = new ConnectionSettings();
$connectionSettings
  ->setUsername($username)
  ->setPassword($password)
  ->setKeepAliveInterval(60)
  ->setLastWillTopic('emqx/test/last-will')
  ->setLastWillMessage('client disconnect')
  ->setLastWillQualityOfService(1);


$mqtt = new MqttClient($server, $port, $clientId);

$mqtt->connect($connectionSettings, $clean_session);
echo "client connected\n";

// $mqtt->subscribe('emqx/test', function ($topic, $message) {
//     printf("Received message on topic [%s]: %s\n", $topic, $message);
// }, 0);

// for ($i = 0; $i< 10; $i++) {
//   $payload = array(
//     'protocol' => 'tcp',
//     'date' => date('Y-m-d H:i:s'),
//     'url' => 'https://github.com/emqx/MQTT-Client-Examples'
//   );
//   $mqtt->publish(
//     // topic
//     'emqx/test',
//     // payload
//     json_encode($payload),
//     // qos
//     0,
//     // retain
//     true
//   );
//   printf("msg $i send\n");
//   sleep(1);
// }

// $mqtt->loop(true);

?>