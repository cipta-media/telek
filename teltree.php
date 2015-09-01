<?php

//defined('_SECURE_') or die('Forbidden');
/*
if(!auth_isvalid()){
auth_block();
}
*/
//echo "Halo duniahh";

switch(_OP_){
	case "mulai":
	echo "Daftar dong ah";
	break;
	case "daftar":
	echo "mulai dong ah";
	break;
	case "gabung":
	echo "gabung dong ah";
	break;	

}

$list /*$gpid*/ = dba_search(_DB_PREF_ . '_featurePhonebook_group', 'id', array(
                                                'uid' => 1, //---$uid
						'code' => 'IL'	//---$group_code
                                                ));

foreach($list as $kkk){
        foreach($kkk as $key => $val){
                echo $key." => ".$val. "<br />";
        }
}


$mobile = '+628568218424';
$uid = user_mobile2uid('08568218424');

$list01 = dba_search(_DB_PREF_ . '_featurePhonebook', 'id', array(
                                                'uid' => 1,
                                                'mobile' => $mobile
                                        ));

var_dump($list01[0]['id']);
logger_print($list[0]['id'], 4,'test');
echo '<br />'.$mobile;
//empty
