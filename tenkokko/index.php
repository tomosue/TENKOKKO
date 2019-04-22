<?php

// Composerでインストールしたライブラリを一括読み込み
require_once __DIR__ . '/vendor/autoload.php';

// アクセストークンを使いCurlHTTPClientをインスタンス化
$httpClient = new \LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));

// CurlHTTPClientとシークレットを使いLINEBotをインスタンス化
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);

// LINE Messaging APIがリクエストに付与した著名を取得
$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

//著名が正しいかチェック。正しければリクエストをパースし配列へ                            
$events = $bot->parseEventRequest(file_get_contents('php://input'),$signature);

//ループ            
foreach ($events as $event){
    //テキストを返信
    $bot->replyText($event->getReplyToken(), 'TextMessage');
}

?>