<?php

function typing(){
	global $userid;
	return bot('sendChatAction', [
		'chat_id' => $userid,
		'action' => 'typing',
		]);
}

function upload_audio(){
	global $userid;
	return bot('sendChatAction', [
		'chat_id' => $userid,
		'action' => 'upload_audio',
		]);
}

function upload_photo(){
	global $userid;
	return bot('sendChatAction', [
		'chat_id' => $userid,
		'action' => 'upload_photo',
		]);
}

function upload_video(){
	global $userid;
	return bot('sendChatAction', [
		'chat_id' => $userid,
		'action' => 'upload_video',
		]);
}

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
    
function sm($text, $menu = 0, $userid = 0, $parse_mode = 'html')
{
    if($userid){
    } else {
        global $userid;
    }
    if ($menu){
        bot('sendMessage', [
            'chat_id'                  => $userid,
            'text'                     => $text,
            'parse_mode'               => $parse_mode,
            'reply_markup'             => $menu,
            'disable_web_page_preview' => true,
        ]);
    } else {
        bot('sendMessage', [
            'chat_id'    => $userid,
            'text'       => $text,
            'parse_mode' => $parse_mode
        ]);
    }
}

function sp($photo, $caption = null, $menu = null, $parse_mode = 'null')
{
    global $userid;
        bot('sendPhoto', [
            'chat_id'      => $userid,
            'photo'        => $photo,
            'caption'      => $caption,
            'parse_mode'   => $parse_mode,
            'reply_markup' => $menu,

        ]);
}

function sl($lat, $long, $menu = null, $parse_mode = null)
{
    global $userid;
        bot('sendLocation', [
            'chat_id'      => $userid,
            'latitude'     => $lat,
            'longitude'    => $long,
            'parse_mode'   => $parse_mode,
            'reply_markup' => $menu,

        ]);
}

function sa($audio, $caption = null, $menu = null, $parse_mode = 'markdown')
{
    global $userid;
        bot('sendaudio', [
            'chat_id'      => $userid,
            'audio'        => $audio,
            'caption'      => $caption,
            'parse_mode'   => $parse_mode,
            'reply_markup' => $menu,

        ]);
}

function sv($video, $caption = null, $menu = null, $parse_mode = 'markdown')
{
    global $userid;
        bot('sendVideo', [
            'chat_id'      => $userid,
            'video'        => $video,
            'caption'      => $caption,
            'parse_mode'   => $parse_mode,
            'reply_markup' => $menu

        ]);
}

function del()
{
    global $userid;
    global $msgid;
    bot('deleteMessage', [
        'chat_id'    => $userid,
        'message_id' => $msgid
    ]);
}

function emt($text, $menu = 0, $userid = 0, $parse_mode = 'markdown')
{
    global $msgid;
    if($userid){
    } else {
        global $userid;
    }
    if ($menu){
        bot('editMessageText', [
            'chat_id'                  => $userid,
            'text'                     => $text,
            'parse_mode'               => $parse_mode,
            'message_id'               => $msgid,
            'reply_markup'             => $menu,
            'disable_web_page_preview' => true,
        ]);
    } else {
        bot('editMessageText', [
            'chat_id'    => $userid,
            'message_id' => $msgid,
            'text'       => $text,
            'parse_mode' => $parse_mode
        ]);
    }
}

function show_alert($msg) {
    global $callid;
    bot('answerCallbackQuery',[
        'callback_query_id' => $callid,
        'text'              => $msg,
        'show_alert'        => true
        ]);
}

function acl($msg) {
    global $callid;
    bot('answerCallbackQuery',[
        'callback_query_id' => $callid,
        'text'              => $msg,
        'show_alert'        => false
        ]);
}

function emc($caption, $menu)
{
    global $userid;
    global $msgid;
    bot('editMessageCaption', [
        'chat_id'      => $userid,
        'message_id'   => $msgid,
        'caption'      => $caption,
        'reply_markup' => $menu,
        'parse_mode'   =>"markdown",
    ]);
}

function menu($text)
{
    global $menu;
    file_put_contents($menu, $text);
}
function pstep($text){
    global $userid;
    file_put_contents("step/$userid.step",$text);
    }

function put($fayl, $nima) {
file_put_contents($fayl, $nima);
}


$content = file_get_contents('php://input');
$update  = json_decode($content);

if ($update->message) {
    $chatid   = $update->message->chat->id;
    $userid   = $update->message->chat->id;
    $name     = $update->message->from->first_name;
    $lastname = $update->message->from->last_name;
    $username = $update->message->from->username;
    $msg      = $update->message->text;
    $reply    = $update->message->reply_to_message->text;
    $msgid    = $update->message->message_id;

    $document      = $update->message->document;
    $doc_id        = $update->message->document->file_id;
    if($update->message->contact){
        $c_number = $update->message->contact->phone_number;
        $c_name   = $update->message->contact->first_name;
        $c_id     = $update->message->contact->user_id;
    }

} else if($update->callback_query->data){
    $chatid     = $update->callback_query->message->chat->id;
    $userid     = $update->callback_query->from->id;
    $msgid      = $update->callback_query->message->message_id;
    $name       = $update->callback_query->from->first_name;
    $username   = $update->callback_query->from->username;
    $callid     = $update->callback_query->id;
    $data       = $update->callback_query->data;
}
 else if($update->inline_query->id){
    $msg      = $update->inline_query->query;
    $userid   = $update->inline_query->from->id;
    $username = $update->inline_query->from->username;
    $name     = $update->inline_query->from->first_name;
}


$step = file_get_contents("step/$userid.step");

$lang = file_get_contents("users/$userid/lang.txt");


mkdir("step");
mkdir("users");
mkdir("users/$userid");