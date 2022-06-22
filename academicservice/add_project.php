<?php 
session_start();

include("../admin/compcode/include/config.php"); 
include "../admin/compcode/include/connect_db.php";
require_once("../admin/compcode/include/function.php");

$dev_id=maxid($db_eform.'.develop','dev_id');
$dev_trackid=date('YmdHis').random_ID("6","0");
$dev_setid = date('Y').'-'.random_ID("6","0");

if(isset($_POST['action']) and $_POST["action"] == 'save')
{
		//insert table develop
		$dev_bookfrom=$_POST['dev_bookfrom_01'].'+'.$_POST['dev_bookfrom_02'].'+'.$_POST['dev_bookfrom_03'].'+'.$_POST['dev_bookfrom_04'];
		
		if($_POST['dev_country'] == '223' or $_POST['dev_country']=='TH'){ $dev_local='1'; }else{ $dev_local='2'; }
		$dev_training_hour=GettrainingHour($_POST['dev_stdate'], $_POST['dev_enddate'], $_POST['dev_timebegin'], $_POST['dev_timeend']);
		
		//insert tb develop
				$sql1="insert into $db_eform.develop (dev_id, 
					dp_id,
					dev_orddate, 
					dev_bookfrom, 
					dev_onus, 
					dev_stdate, 
					dev_enddate, 
					dev_timebegin,
					dev_timeend,
					act_id, 
					dev_place, 
					lt_id, 
					dev_org,
					dev_training_hour,
					le_id,
					dev_payfrom,
					dev_fundname,
					ss_id,
					sf_id,
					dev_remark,
					dev_formstatus,
					dev_formstatus_comment,
					dev_perid,
					dev_maintype,
					dev_modify,
					dev_trackid,
					dev_year,
					dev_country,
					dev_local,
					dev_create,
					dev_setid,
					dev_type,
					dev_typeother,
					dev_createby,
					dev_nopay) 
					values ('$dev_id',
					'$_POST[dp_id]',
					'".date('Y-m-d')."',
					'$dev_bookfrom',
					'$_POST[title_pic]', 
					'$_POST[dev_stdate]',
					'$_POST[dev_enddate]',
					'$_POST[dev_timebegin]',
					'$_POST[dev_timeend]', 
					'$_POST[sec_id]', 
					'$_POST[dev_place]', 
					'$_POST[lt_id]', 
					'$_POST[dev_org]',
					'$dev_training_hour',
					'$_POST[le_id]',
					'$_POST[dev_payfrom]',
					'$_POST[dev_fundname]',
					'$_POST[ss_id]',
					'$_POST[sf_id]',
					'$_POST[dev_remark]',
					'$_POST[dev_formstatus]',
					'$_POST[dev_formstatus_comment]',
					'$_SESSION[ses_per_id]',
					'2',
					'$date_create',
					'$dev_trackid',
					'".budgetyear_02($_POST['dev_stdate'])."',
					'$_POST[dev_country]',
					'$dev_local',
					'$date_create',
					'$dev_setid',
					'$_POST[typ_id]',
					'$_POST[dev_typeother]',
					'$_SESSION[ses_per_id]',
					'$_POST[dev_nopay]')";
		$exec1=mysql_query($sql1);
				
		//insert table develop_form_budget
		if(isset($_POST['bt_id'])){
			foreach($_POST['bt_id'] as $value){
				$sql02=mysql_query("insert into $db_eform.develop_form_budget (dev_id, bt_id, dev_pay01) values ('$dev_id', '$value', '".$_POST["bt_dev_pay01".$value]."')");
				$budget_pay01+=$_POST['bt_dev_pay01'.$value];
			}
		}
		
		//insert table develop_form_cost
		if(isset($_POST['ct_id'])){
			foreach($_POST['ct_id'] as $value){
				$sql03=mysql_query("insert into $db_eform.develop_form_cost (dev_id, ct_id, dev_pay01) values ('$dev_id', '$value', '".$_POST["ct_dev_pay01".$value]."')");
				$cost_pay01+=$_POST['ct_dev_pay01'.$value];
			}
		}
		
				//insert table develop, develop_course_personel
		if(isset($_POST['per_id'])){
			
			foreach($_POST['per_id'] as $value){
				$cp_id=maxid($db_eform.'.develop_course_personel','cp_id');		
				$sql04=mysql_query("insert into $db_eform.develop_course_personel (cp_id,
							dev_id,
							per_id,
							budget_pay01,
							cost_pay01)
							values ('$cp_id', 
							'$dev_id', 
							'$value', 
							'$budget_pay01', 
							'$cost_pay01')");
			}
		
		}
		//insert table develop, develop_course_personel
				
		header("location: confirm-form-1.php?getDevid=".$dev_id);
}
 ?>
