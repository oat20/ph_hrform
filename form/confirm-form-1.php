<?php
session_start();

include('../admin/compcode/include/config.php');
include('../admin/compcode/check_login.php');
require_once '../lib/mysqli.php';
include('../admin/compcode/include/connect_db.php');
include('../admin/compcode/include/function.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $titlebar['title'];?></title>
<?php include('../lib/css-inc.php');?>
</head>

<body>
<?php include('../inc/navbar02-inc.php');?>

<div class="container-fluid">

	<?php
	$sql=mysqli_query($condb, "select * from $db_eform.develop
			left join $db_eform.tb_orgnew on (develop.dp_id = tb_orgnew.dp_id)
			left join $db_eform.activity on (develop.act_id = activity.act_id)
			left join $db_eform.develop_location_type on (develop.lt_id = develop_location_type.lt_id)
			left join $db_eform.sub_strategic on (develop.ss_id = sub_strategic.id)
			left join $db_eform.strategic_faculty on (develop.sf_id = strategic_faculty.sf_id)
			left join $db_eform.personel_muerp on (develop.dev_perid = personel_muerp.per_id)
            left join develop_main_type on (develop.dev_maintype=develop_main_type.dm_id)
            left join develop_type on (develop.dev_type=develop_type.dvt_id)
			where develop.dev_id='$_GET[getDevid]'");
	$ob=mysqli_fetch_assoc($sql);
	$dev_bookfrom=explode('+',$ob['dev_bookfrom']);

    $sql_attach=mysqli_query($condb, "select dev_filename from develop_attachment where dev_id='$_GET[getDevid]' and dev_filecategory='Attachment'");
    $rs_attach=mysqli_fetch_assoc($sql_attach);
    $file_attachment=$livesite.'phpm/attachment/'.$rs_attach['dev_filename'];

    if($ob['dev_maintype'] == 1){
				$href_print = './print-form01-pdf.php?getTrackid='.$ob['dev_trackid'];
			}else if($ob['dev_maintype'] == 2){
				$href_print = '../academicservice/print-form01-pdf.php?getTrackid='.$ob['dev_trackid'];
			}

			if($ob['dev_nopay'] == 1){
				$print_disable = 'disabled';
			}else if($ob['dev_nopay'] != 1){
				$print_disable = '';
			}
	?>
                
	<div class="panel panel-default">
    	<div class="panel-heading">
        	<h3 class="panel-title clearfix">
            	<div class="pull-left"><a href="../profile/_showmyproject.php"><i class="fa fa-arrow-left fa-fw"></i> ยืนยันข้อมูล</a></div>
                <div class="pull-right">
                    <a href="editform_1.php?getTrackid=<?php echo $ob['dev_trackid'];?>" class="btn btn-link"><i class="fa fa-pencil"></i></a>
                    <a href="<?php echo $href_print;?>" target="_blank" class="btn btn-link <?php echo $print_disable;?>"><i class="fa fa-print"></i></a>
                </div>
            </h3>
        </div>
        <div class="panel-body">
        	<?php echo warning('success','<i class="fa fa-check"></i> Success','บันทึกข้อมูลเรียบร้อย');?>
            <div class="row">          	
            	<div class="col-sm-6">
                	<dl class="dl-horizontal">
                        <dt>หมวดหมู่</dt>
                        <dd><?php echo $ob['dm_title'];?></dd>
                      <dt>ส่วนงาน</dt>
                      <dd><?php echo $ob['dp_name'];?></dd>
                      <!--
                      <dt>ตามหนังสือ</dt>
                      <dd><?php //echo $dev_bookfrom['0'];?> <strong>ที่</strong> <?php //echo $dev_bookfrom['1'];?> <strong>ลงวันที่</strong> <?php //echo dateThai($dev_bookfrom['2']);?> <strong>เรื่อง</strong> <?php //echo $dev_bookfrom['3'];?></dd>
        -->
                      <dt>หลักสูตร/โครงการ</dt>
                      <dd><?php echo $ob['dev_onus'];?></dd>
                      <dt>ระหว่างวันที่</dt>
                      <dd><?php echo dateformat_03($ob['dev_stdate']).' ถึง '.dateformat_03($ob['dev_enddate']);?></dd>
                      <dt>เวลา</dt>
                      <dd><?php echo $ob['dev_timebegin'].' - '.$ob['dev_timeend'];?></dd>
                      <dt>ลักษณะงาน</dt>
                      <dd>
                        <?php echo $ob['dvt_name'];?>
                      </dd>
                      <dt>เกี่ยวข้องกับกิจกรรม</dt>
                      <dd><?php echo $ob['activity'];?></dd>
                      <dt>สถานที่จัด</dt>
                      <dd><?php echo $ob['dev_place'];?></dd>
                      <dt>ประเภทสถานที่</dt>
                      <dd><?php echo $ob['lt_title'];?></dd>
                      <dt>หน่วยงานผู้จัด</dt>
                      <dd><?php echo $ob['dev_org'];?></dd>
                      <!--<dt>ณ ประเทศ</dt>
                      <dd><?php //echo $ob['ct_name'];?></dd>-->
                      <dt>จำนวนชั่วโมงที่ใช้จริง</dt>
                      <dd><?php echo $ob['dev_training_hour'];?></dd>
                      <!--<dt>ระดับกิจกรรม</dt>
                      <dd><?php //echo $ob['le_title'];?></dd>-->
                      <!--<dt>แหล่งทุน</dt>
                      <dd><?php //echo $ob['pf_title'].'&nbsp;'.$ob['dev_fundname'];?></dd>-->
                      <?php
					  echo '<dt>รายละเอียดการขออนุมัติค่าใช้จ่าย</dt>
  							<dd><i class="fa fa-check"></i> '.$cf_devnopay[$ob['dev_nopay']].'</dd>';
					  
					  if($ob['dev_nopay']=='0'){
					  ?>
                      <dt>จากแหล่งเงิน</dt>
                      <dd>
                      	<ol>
                      	<?php
						$sql03=mysqli_query($condb, "select * from $db_eform.develop_form_budget
									inner join $db_eform.budtype on (develop_form_budget.bt_id=budtype.bt_id)
									inner join $db_eform.develop_payfrom as t3 on(budtype.pf_id=t3.pf_id)
									where develop_form_budget.dev_id='$ob[dev_id]'
									order by t3.pf_id asc, 
									budtype.bt_id asc");
						while($ob03=mysqli_fetch_assoc($sql03)){
							echo '<li>'.$ob03['pf_title'].' <i class="fa fa-angle-double-right"></i> '.$ob03['bt_name'].' '.number_format($ob03['dev_pay01']).' บาท</li>';
						}
						?>
                        </ol>
                      </dd>
                      <dt>โดยแบ่งเป็นค่าใช้จ่าย</dt>
                      <dd>
                      	<ol>
                      	<?php
						$sql04=mysqli_query($condb, "select * from $db_eform.develop_form_cost
									inner join $db_eform.develop_cost_type on (develop_form_cost.ct_id=develop_cost_type.ct_id)
									where develop_form_cost.dev_id='$ob[dev_id]'
									order by develop_cost_type.ct_id asc");
						while($ob04=mysqli_fetch_assoc($sql04)){
							echo '<li>'.$ob04['ct_title'].' '.number_format($ob04['dev_pay01']).' บาท</li>';
						}
						?>
                        </ol>
                      </dd>
                      <?php
					  }
					  ?>
                      
                      <dt>ยุทธศาสตร์มหาวิทยาลัยฯ</dt>
                      <dd><?php echo $ob['nameth'];?></dd>
                      <dt>ยุทธศาสตร์คณะฯ</dt>
                      <dd><?php echo $ob['sf_name'];?></dd>
                      <!--<dt>หมายเหตุ</dt>
                      <dd><?php //echo $ob['dev_remark'];?></dd>-->
                      <dt>เอกสารเกี่ยวกับโครงการ</dt>
                      <dd>
                        <a href="<?php echo $file_attachment;?>" target="_blank"><?php echo $file_attachment;?></a>
                      </dd>
                    </dl>
                </div><!--col-->
                
                <div class="col-sm-6">
                	<dl class="dl-horizontal">
                      <dt>บุคลากรผู้เข้าร่วม</dt>
                      <dd>
                      	<ol>
                      	<?php
						$sql05=mysqli_query($condb, "select * from $db_eform.develop_course_personel
									inner join $db_eform.personel_muerp on (develop_course_personel.per_id=personel_muerp.per_id)
									inner join $db_eform.job as t3 on(personel_muerp.job_id=t3.job_id)
									where develop_course_personel.dev_id='$ob[dev_id]' 
									order by convert(personel_muerp.per_fnamet using tis620) asc,
									convert (personel_muerp.per_lnamet using tis620) asc");
						while($ob05=mysqli_fetch_assoc($sql05)){
							echo '<li>'.$ob05['per_pname'].' '.$ob05['per_fnamet'].' '.$ob05['per_lnamet'].' ('.$ob05['job_name'].')</li>';
						}
						?>
                        </ol>
                      </dd>
                      <!--<dt>จึงเรียนมาเพื่อ</dt>
                      <dd><?php //echo $cf_devformstatus[$ob['dev_formstatus']]['label'].'&nbsp;'.$ob['dev_formstatus_comment'];?></dd>-->
                      <dt>ผู้บันทึกข้อมูล</dt>
                      <dd><?php echo $ob['per_pname'].' '.$ob['per_fnamet'].' '.$ob['per_lnamet'].' เมื่อ '.dateThai($ob['dev_orddate']);?></dd>
                    </dl>
                </div><!--col-->
            </div><!--row-->
        </div><!--body-->
        
        <div class="panel-footer">
        	<a href="editform_1.php?getTrackid=<?php echo $ob['dev_trackid'];?>" class="btn btn-link btn-wide"><i class="fa fa-angle-double-left"></i> กลับไปแก้ไข</a>
            <a href="<?php echo $href_print;?>" class="btn btn-link btn-wide <?php echo $print_disable;?>" target="_blank"><i class="fa fa-print"></i> พิมพ์แบบฟอร์ม</a>
        </div>
    </div><!--panel-->

</div><!--container-->

<?php include('../lib/js-inc.php');?>
</body>
</html>