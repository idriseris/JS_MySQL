<?php
define("mysql", true);
include("../config.php");
include("../lib/class.mysql.php");
$type = $_GET["type"];
$arg = $_GET["arg"];
$table = $arg["table"];
$data = $arg["data"];
$where = $arg["where"];
$return = new stdClass();
$return->state = 0;
$return->msg = "Parametre gerekli";
if($type == "query"){
	$result = array();
	$sor = "SELECT * FROM $table".MySQL::where($where);
	$res = MySQL::query($sor);
	foreach ($res as $key => $value) {
		array_push($result,$value);
	}
	$return = $result;
}
if($type == "fetch"){
	$res = MySQL::fetch($table, $where);
	if(is_object($res)) {
		$return = $res;
	}
}
if($type == "add"){
	$res = MySQL::add($table,$data);
	if($res){
		$return->state = 1;
		$return->id = $res;
		unset($return->msg);
	} else {
		$return->msg = "add parametresi ile veri eklenemedi.";
	}
}
if($type == "update"){
	$res = MySQL::update($table,$data,$where);
	if($res){
		$return->state = 1;
		unset($return->msg);
	} else {
		$return->msg = "update parametresi ile veri guncellenemdi.";
	}
}
if($type == "delete"){
	$res = MySQL::delete($table,$where);
	if($res){
		$return->state = 1;
		unset($return->msg);
	} else {
		$return->msg = "delete parametresi ile veri silinemedi.";
	}
}
echo json_encode($return, JSON_UNESCAPED_UNICODE);
?>