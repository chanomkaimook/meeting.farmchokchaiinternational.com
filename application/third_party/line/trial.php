<?
	session_start();
	include('../include/hrthaidrill.php');
	include('../include/admin.php');
	require('sendMessage.php');
	// $M = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฏาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
	// "SELECT DISTINCT `employee`.`Username`,`employee`.`UserID` FROM `employee`  WHERE `Trial_evaluation`.`1st_date` LIKE '%12/2022%' AND `Username` = '6502013'";SELECT DISTINCT `employee`.`Username`,`employee`.`UserID` FROM `employee`  WHERE `Username` = '6502013'

	$M = date("m/Y");
	$SQL = "SELECT DISTINCT `employee`.`Username`,`employee`.`UserID` FROM `Trial_evaluation` INNER JOIN `employee` ON `Trial_evaluation`.`ApproverID` = `employee`.`Username` WHERE `Trial_evaluation`.`1st_date` LIKE '%/".$M."%' AND `employee`.`UserID` != '' OR `Trial_evaluation`.`2nd_date` LIKE '%/".$M."%' AND `employee`.`UserID` != '' OR `Trial_evaluation`.`3rd_date` LIKE '%/".$M."%' AND `employee`.`UserID` != ''";
	$Query = mysqli_query($conn,$SQL);
	$JsonData =  '{
	  "type": "flex",
	  "altText": "ประเมินทดลองงาน",
	  "contents": {
	    "type": "carousel",
	    "contents": [
	      {
			  "type": "bubble",
			  "hero": {
				"type": "image",
				"url": "https://thaidrill-hr.com/Picture/probation.jpg",
				"size": "full",
				"aspectRatio": "20:13",
				"aspectMode": "cover",
				"action": {
				  "type": "uri",
				  "label": "Line",
				  "uri": "https://thaidrill-hr.com/keyman/forms/แบบประเมินผลพนักงานทดลองงาน/"
				}
			  },
			  "body": {
				"type": "box",
				"layout": "vertical",
				"contents": [
				  {
					"type": "text",
					"text": "ประเมินทดลองงาน",
					"weight": "bold",
					"size": "xl",
					"gravity": "center",
					"wrap": true,
					"contents": []
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
					  "label": "ประเมิน",
					  "uri": "https://thaidrill-hr.com/keyman/forms/แบบประเมินผลพนักงานทดลองงาน/"
					},
					"color": "#6aed54",
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
		echo $Line["UserID"]."<br>";
	}
	$messages['to'] = array_values($id);
	$messages['messages'][] = $decode;
	$encode = json_encode($messages);
	sentMessage($encode,$datas);

    $_SESSION["error"] = "สำเร็จ";
	echo $SQL;
	// header('Location: https://thaidrill-hr.com/admin/pages/demo_trial');
    exit;

?>