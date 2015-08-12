<?php

defined('_SECURE_') or die('Forbidden');

/*
function telek_checkavailablekeyword($keyword){
	$ok = true;
        $db_query = "SELECT subscribe_id FROM " . _DB_PREF_ . "_featureSubscribe WHERE subscribe_keyword='$keyword'";
        if ($db_result = dba_num_rows($db_query)) {
                $ok = false;
        }
        return $ok;
}
*/

/*
 * intercept incoming sms and remove keyword
 *
 * @param $sms_datetime
 *   incoming SMS date/time
 * @param $sms_sender
 *   incoming SMS sender
 * @message
 *   incoming SMS message before interepted
 * @param $sms_receiver
 *   receiver number that is receiving incoming SMS
 * @return
 *   array $ret
 */


function telek_hook_setsmsincomingaction($sms_datetime, $sms_sender, $message, $sms_receiver) {
        $ok = false;
       	//$uid = user_mobile2uid($sms_sender);
	

	// $db_query = "SELECT * FROM " . _DB_PREF_ . "_featureSubscribe WHERE subscribe_keyword='$subscribe_keyword'";
       // $db_result = dba_query($db_query);
        //if ($db_row = dba_fetch_array($db_result)) {
                //if ($db_row['uid'] && $db_row['subscribe_enable']) {
                  if ($sms_sender && $message) {
		        _log('begin s:' . $sms_sender . ' m:' . $message, 2, 'telek');
                  //      if (sms_subscribe_handle($db_row, $sms_datetime, $sms_sender, $subscribe_keyword, $subscribe_param, $sms_receiver, $smsc, $raw_message)) {
                                $ok = true;
                    //    }
                        $status = ($ok ? 'handled' : 'unhandled');
                        _log('end s:' . $sms_sender . ' m:' . $message . ' s:' . $status, 2, 'telek');
                }
        //}
        //$ret['uid'] = user_mobile2uid($sms_sender);
        $ret['status'] = $ok;
        return $ret;
}


function telek_hook_recvsms_intercept($sms_datetime, $sms_sender, $message, $sms_receiver){
	
	//$ret = array();
	
	$ps= explode(" ", $message,2);
	$kk = strtoupper($ps[0]);
	//$pesan = '';
	$hooked = false;	
	
	if ( $kk == 'DAFTAR' ){
		$pecah= preg_split("/#/", $ps[1], null, PREG_SPLIT_NO_EMPTY );
		

		$c_uid = user_mobile2uid($sms_sender);	
		
		$data = array();
		$data['name'] = trim($pecah[0]);
		$data['username'] = trim($pecah[1]);
		$data['mobile'] = trim($pecah[2]);
		$data['email'] = "user@noreply.org";
		$data['parent_uid'] = 0;
		$data['status'] = 4;
		
	} elseif ( $kk == 'GABUNG' ){ //-- masukin ke grup
	
		$list = 	
		
	}

	if($nama && $nohp && $pengguna){
		logger_print("*******", 3, "telek");
        	logger_print("sms_sender " . $sms_sender, 3, "telek");
        	logger_print("message " . $message, 3, "telek");
        	logger_print("new message " . $nama, 3, "telek");
        	logger_print("sms target user" . $sms_receiver, 3, "telek");
        	logger_print("*******", 3, "telek");
        
		if (($uid = user_mobile2uid($sms_sender)) && $nama) {
               		 _log("save in inbox u:" . $username . " uid:" . $uid . " dt:" . $sms_datetime . " s:" . $sms_sender . " r:" . $sms_receiver . " m:[" . $nohp . "]", 3, 'telek');
                	//recvsms_inbox_add($sms_datetime, $sms_sender, $username, $nama, $sms_receiver);
        		//$hooked = true;
			//$status = ($ok ? 'handled' : 'unhandled');
		}
	}
////	$ret['uid'] = user_mobile2uid($sms_sender);
////	$ret['status'] = TRUE;	
//	$ret['param']['message'] = $ikut . ' ' . $nama .' '. $nohp . ' ' . $pengguna;
//       $ret['modified'] = TRUE;
//        $ret['hooked'] = TRUE;


	$ret = user_add($data);
	$ok = ($ret['status'] ? TRUE : FALSE );
	if ($ok){		
		echo "okee";
		$items = array(
			'uid' => 1,
                        'name' => $data['name'],
                        'mobile' => $data['mobile'],
                        'email' => $data['email'],
                        'tags' => $tags			
			);
		if ($c_pid = dba_add(_DB_PREF_ . '_featurePhonebook', $items)) {
                          $save_to_group = TRUE;
                   } else {
                          logger_print('fail to add contact pid:' . $c_pid . ' m:' . $data['mobile'] . ' n:' . $data['name'] . ' e:' . $data['email'] . ' tags:[' . $data['tags'] . ']', 3, 'telek_phonebook_add');
                   }		
	}else{
		echo "gagal";
	}
	return $ret; 
}
/*
function telek_handle(){

}*/	
