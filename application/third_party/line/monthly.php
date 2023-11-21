<?
	session_start();
	include('../include/hrthaidrill.php');
	include('../include/admin.php');
	require('sendMessage.php');
	$M = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฏาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
	$Y = date("Y")+543;
	$SQL = "SELECT DISTINCT `employee`.`Username`,`employee`.`UserID` FROM `Training_Monthly` INNER JOIN `employee` ON `Training_Monthly`.`Username` = `employee`.`Username` WHERE `Training_Monthly`.`Date` LIKE '%".$M[date('m')-0]." ".$Y."%' AND `employee`.`UserID` != '' ORDER BY `Training_Monthly`.`Username`";
	$Query = mysqli_query($conn,$SQL);
	$JsonData = 
	$JsonData =  '{
	  "type": "flex",
	  "altText": "หลักสูตรประจำเดือน '.$M[date('m')-0].'",
	  "contents": {
	    "type": "carousel",
	    "contents": [
	      {
			  "type": "bubble",
			  "body": {
				"type": "box",
				"layout": "vertical",
				"contents": [
				  {
					"type": "text",
					"text": "หลักสูตรประจำเดือน",
					"weight": "bold",
					"size": "xl",
					"gravity": "center",
					"wrap": true,
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
							"type": "text",
							"text": "เดือน",
							"size": "sm",
							"color": "#AAAAAA",
							"flex": 1,
							"contents": []
						  },
						  {
							"type": "text",
							"text": "'.$M[date('m')-0].'",
							"size": "sm",
							"color": "#666666",
							"flex": 4,
							"wrap": true,
							"contents": []
						  }
						]
					  }
					]
				  }
				]
			  },
			  "footer": {
				"type": "box",
				"layout": "horizontal",
				"flex": 1,
				"contents": [
				  {
					"type": "button",
					"action": {
					  "type": "uri",
					  "label": "เข้าอบรม",
					  "uri": "https://thaidrill-hr.com/training/monthly"
					},
					"color": "#E30614FF",
					"style": "primary"
				  }
				]
			  }
			}
	    ]
	  }
	}'; 
	$decode = json_decode($JsonData,true);
	$datas['url'] = "https://api.line.me/v2/bot/message/multicast";
	$datas['token'] = "02ejLbhxaoS4P7XL4JNk0jXGlVC3cXaBOGOGz4YGUahQs/87sipArCHt9AWUL+MsQBADAp4Lnn4kdT/xI8GdbpRf4msSrV85qGm/Sb3AlRrZdaDXAHMoTHa0Wb2bkQK5BpuXOIp8ZZJIiM/JYMnGZgdB04t89/1O/w1cDnyilFU=";
	$Row = mysqli_num_rows($Query);
	$i=0;
	while($Line = mysqli_fetch_array($Query)){
		$i++;	
		$id[$i] = $Line["UserID"];
	}
	$messages['to'] = array_values($id);
	$messages['messages'][] = $decode;
	$encode = json_encode($messages);
	sentMessage($encode,$datas);

    $_SESSION["error"] = "สำเร็จ";
	//echo $SQL;
	header('Location: https://thaidrill-hr.com/training/admin/monthly');
    exit;

?>