<?
	session_start();
	include('../include/hrthaidrill.php');
	require('sendMessage.php');
	//-- GET Message --//
	$id = $_GET["id"];
	$msg = $_GET["msg"];
	$uri = $_GET["url"];
	$page = $_GET["page"];
	if($_GET["pic"] != ""){$pic = $_GET["pic"];}else{$pic = "https://thaidrill-hr.com/Picture/HR%20ThaiDrill%20Logo.png";}
	$JsonData = '{
	  "type": "flex",
	  "altText": "'.$msg.'",
	  "contents": {
	    "type": "carousel",
	    "contents": [
	      {
			  "type": "bubble",
			  "hero": {
				"type": "image",
				"url": "'.$pic.'",
				"size": "full",
				"aspectRatio": "20:13",
				"aspectMode": "cover",
				"action": {
				  "type": "uri",
				  "label": "Line",
				  "uri": "'.$uri.'"
				}
			  },
			  "body": {
				"type": "box",
				"layout": "vertical",
				"contents": [
				  {
					"type": "text",
					"text": "'.$msg.'",
					"weight": "bold",
					"size": "md",
					"contents": []
				  },
				  {
					"type": "box",
					"layout": "vertical",
					"spacing": "sm",
					"margin": "lg",
					"contents": [
					  {
						"type": "box",
						"layout": "baseline",
						"spacing": "sm",
						"contents": [
						  {
							"type": "spacer"
						  }
						]
					  }
					]
				  }
				]
			  },
			  "footer": {
				"type": "box",
				"layout": "vertical",
				"flex": 0,
				"spacing": "sm",
				"contents": [
				  {
					"type": "button",
					"action": {
					  "type": "uri",
					  "label": "ดูข้อมูล",
					  "uri": "'.$uri.'"
					},
					"color": "#E30614",
					"height": "sm",
					"style": "primary"
				  }
				]
			  }
			}
	    ]
	  }
	}';
	$decode = json_decode($JsonData,true);
	$datas['url'] = "https://api.line.me/v2/bot/message/push";
	$datas['token'] = "02ejLbhxaoS4P7XL4JNk0jXGlVC3cXaBOGOGz4YGUahQs/87sipArCHt9AWUL+MsQBADAp4Lnn4kdT/xI8GdbpRf4msSrV85qGm/Sb3AlRrZdaDXAHMoTHa0Wb2bkQK5BpuXOIp8ZZJIiM/JYMnGZgdB04t89/1O/w1cDnyilFU=";
	$messages['to'] = $id;
	$messages['messages'][] = $decode;
	$encode = json_encode($messages);
	sentMessage($encode,$datas);
	
    $_SESSION["error"] = "สำเร็จ";
	header('Location: https://thaidrill-hr.com/'.$page);
    exit;

?>