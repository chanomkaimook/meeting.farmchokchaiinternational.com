<?php
 $LINEData = file_get_contents('php://input');
 $jsonData = json_decode($LINEData,true);
 $replyToken = $jsonData["events"][0]["replyToken"];
 $text = $jsonData["events"][0]["message"]["text"];
 
 function sendMessage($replyJson, $token){
         $ch = curl_init($token["URL"]);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLINFO_HEADER_OUT, true);
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
             'Content-Type: application/json',
             'Authorization: Bearer ' . $token["AccessToken"])
             );
         curl_setopt($ch, CURLOPT_POSTFIELDS, $replyJson);
         $result = curl_exec($ch);
         curl_close($ch);
   return $result;
 }
 
 if ($text == "s"){
     $message = '{
     "type" : "sticker",
     "packageId" : 11537,
     "stickerId" : 52002744
     }';
     $replymessage = json_decode($message);
 }
 else if ($text == "รูปภาพ"){
   $message = '{
     "type": "image",
     "originalContentUrl": "https://thaidrill-hr.com/Picture/HR%20ThaiDrill%20Logo.png",
     "previewImageUrl": "https://thaidrill-hr.com/Picture/HR%20ThaiDrill%20Logo.png"
     }';
     $replymessage = json_decode($message);
 }
 else if ($text == "ที่อยู่บริษัท"){
   $message = '{
     "type": "location",
     "title": "บริษัท รถเจาะไทย จำกัด",
     "address": "128/105-107 ตำบล ห้วยบง อำเภอเฉลิมพระเกียรติ สระบุรี 18000",
     "latitude": 14.63816,
     "longitude": 100.88688
     }';
     $replymessage = json_decode($message);
 }
 else if ($text == "ขั้นตอนการตรวจหาเชื้อด้วยตนเอง"){
   $message = '{
     "type" : "video",
     "originalContentUrl" : "https://thaidrill-hr.com/training/source/Covid-19/%E0%B8%82%E0%B8%B1%E0%B9%89%E0%B8%99%E0%B8%95%E0%B8%AD%E0%B8%99%E0%B8%81%E0%B8%B2%E0%B8%A3%E0%B8%95%E0%B8%A3%E0%B8%A7%E0%B8%88%E0%B8%AB%E0%B8%B2%E0%B9%80%E0%B8%8A%E0%B8%B7%E0%B9%89%E0%B8%AD%E0%B8%94%E0%B9%89%E0%B8%A7%E0%B8%A2%E0%B8%95%E0%B8%99%E0%B9%80%E0%B8%AD%E0%B8%87.mp4",
     "previewImageUrl" : "https://www.bangkokpattayahospital.com/images/stories/newsroom/CovidSeason2a.jpg"
     }';
     $replymessage = json_decode($message);
 }
 else if ($text == "สวัสดี"){
   $message = '{
     "type": "text",
     "text": "สวัสดีค่ะ",
     "quickReply": {
      "items": [
       {
        "type": "action",
        "action": {
         "type":"location",
         "label":"Location"
        }
       }
      ]
     } 
     }';
     $replymessage = json_decode($message);
 }
 else{
   $message = '{
       "type" : "text",
       "text" : "ไม่มีข้อมูลที่ต้องการ"
       }';
       $replymessage = json_decode($message);
 }
 
 $lineData['URL'] = "https://api.line.me/v2/bot/message/reply";
 $lineData['AccessToken'] = "NnjLReuNk+fVZywEQGu54r3z2N8exAOqIYbSQasxBxz6TzZ94gVA7HsvMJrAtxWuEvdiIZkq96TtcHlFX0ngjpD6A/cNwlNlDZ7ko2LksU9HOnphUDcWdbPG1RPG7NvEugi9PClejV6zQxCoOPPjpwdB04t89/1O/w1cDnyilFU=";
 $replyJson["replyToken"] = $replyToken;
 $replyJson["messages"][0] = $replymessage;
 
 $encodeJson = json_encode($replyJson);
 
 $results = sendMessage($encodeJson,$lineData);
 echo $results;
 http_response_code(200);
 

