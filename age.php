<?php 

ob_start();

$API_KEY = 'توكن';
define('API_KEY',$API_KEY);
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
$from_id = $message->from->id;
$chat_id = $message->chat->id;
$text = $message->text;
$chat_id2 = $update->callback_query->message->chat->id;
$message_id =  $update->callback_query->message->message_id;
$data = $update->callback_query->data;

if($text=="/start"){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"ترحيب",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"قناتنا📱", 'url'=>"t.me/EvilApi"]],
[['text'=>"قناتنا ٢ 📱 " , 'url'=>"t.me/botlua"]]
]])
]);
}
if($text!="/start"){
  $birthDate = explode("/", $text);
  $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
    ? ((date("Y") - $birthDate[2]) - 1)
    : (date("Y") - $birthDate[2]));
	bot('sendMessage', [
	'chat_id'=>$chat_id,
	'text'=>"عمرك هو :- $age",
	'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"تابع ☑", 'url'=>"@EvilApi"]],
]])
	]);
	}
	