<?php
ob_start();
$API_KEY = '5939723781:AAFxONTS4xVGwfCQeHWg83GPUWQjRDvSDio'; ## التوكن
define('API_KEY',$API_KEY);
$link =  "https://".$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"];
echo file_get_contents("https://api.telegram.org/bot$API_KEY/setWebHook?url=$link");
function bot($method,$datas=[]){
$url = "https://api.telegram.org/bot".API_KEY."/".$method;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
$res = curl_exec($ch);
if(curl_error($ch)){
var_dump(curl_error($ch));
}else{
return json_decode($res);
}
}

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
$text = $message->text;

if ($text != "/start") {
$modified_string = str_replace(' ', '+', $text); ## لا تعبث فيها
$api = json_decode(file_get_contents("https://www.bot-sms.shop/api/youtube/v4/api.php?search=".$modified_string),1);
bot('sendvoice', [
'chat_id' => $chat_id,
'voice' =>$api["voice_tele_url"],
'caption' =>"* تم البرمجه بالكامل بواسطة : ".$api["by"]."
لقد بحثت عن : ".$api["search"]."
المدة : ".$api["duration"]."
المشاهدات : ".$api["views"]."
إسم القناه : ".$api["title"]."

• By @E_G_Y_0 .*",
'parse_mode'=>"markdown",
'disable_web_page_preview'=>true,
'reply_to_message_id' =>$message->message_id,
]);
bot('sendvideo', [
'chat_id' => $chat_id,
'video' =>$api["video_tele_url"],
'caption' =>"* تم البرمجه بالكامل بواسطة : ".$api["by"]."
لقد بحثت عن : ".$api["search"]."
المدة : ".$api["duration"]."
المشاهدات : ".$api["views"]."
إسم القناه : ".$api["title"]."

• By @E_D_0 .*",
'parse_mode'=>"markdown",
'disable_web_page_preview'=>true,
'reply_to_message_id' =>$message->message_id,
]);
} 

if ($text == "/start") {
bot('sendmessage', [
'chat_id' => $chat_id,
'text' =>"* • ارسل ما تريد البحث عنه في يوتيوب .*",
'parse_mode'=>"markdown",
'disable_web_page_preview'=>true,
'reply_to_message_id' =>$message->message_id,
]);
} 

