<?php
session_start(); 

include('../admin/compcode/include/config.php');
include('../admin/compcode/check_login.php');
include('../admin/compcode/include/connect_db.php');
include('../admin/compcode/include/function.php');
?>
<!doctype html>
<?php
include('../lib/css-inc.php'); 
//include"load_changepw.php";

//================================================================
/*$sql_b= "SELECT * FROM $db_eform.personel_muerp as t1 
			inner join $db_eform.education as t2 on (t1.per_id = t2.ed_perid)
			where t1.per_id='$_SESSION[ses_per_id]'";*/
$sql_b= "SELECT * FROM $db_eform.personel_muerp
			where per_id='$_SESSION[ses_per_id]'";
$exec_b= mysql_query($sql_b);
$rs_b=mysql_fetch_array($exec_b);
?>
<body bgcolor="#5c7094" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php include('../inc/navbar02-inc.php');?>

<div class="container-fluid">

	<!--<div class="page-header-02 font-30 text-uppercase"><a href="profile.php"><i class="fa fa-arrow-left"></i> Profile</a></div>-->

	<div class="row">
    
    	<?php //include('../admin/menu_user.php');?>
    
    	<div class="col-lg-6">
        	
            <FORM method="post" action="load_changepw.php" id="formProfile">
			<div class="panel panel-default">
            	<div class="panel-heading clearfix">
                	<h3 class="panel-title pull-left"><a href="profile.php"><i class="fa fa-arrow-left"></i> ข้อมูลส่วนตัว</a></h3>
                    <div class="pull-right"><button type="submit" class="btn btn-link btn-lg"><i class="fa fa-check"></i> Save</button></div>
                </div>
            	<div class="table-responsive">
	<!--<fieldset>
    	<legend>ข้อมูลส่วนตัว</legend> -->
  <TABLE class="table table-striped table-bordered">
  	<tbody>
    	<tr>
        	<td>เลขบัตรประชาชน หรือเลขหนังสือเดินทาง:</td>
            <td>
            	<div class="form-group">
                	<input type="text" class="form-control" name="per_no" value="<?php echo base64_decode($rs_b['per_no']);?>" required>
                    <span class="help-block">สำหรับยืนยันตัวตน</span>
                </div>
            </td>
        </tr>
    <TR>
      <TD background="../admin/compcode/compcode/picture/bar07.jpg">คำนำหน้าชื่อ:</TD>
      <TD  background="../admin/compcode/compcode/picture/bar07.jpg">
      	<div class="form-group">
        	<input type="text" name="per_pname" class="form-control" value="<?php print $rs_b['per_pname'];?>" required id="per_pname">
        </div>
      </TD>
    </TR>
    <!--<tr>
    	<td>ยศ:</td>
        <td>
        	<div class="form-group">
            	<input type="text" name="per_pname3" class="form-control" value="<?php //print $rs_b['per_pname3'];?>">
            </div>
        </td>
    </tr>-->
    <TR>
      <TD background="../admin/compcode/compcode/picture/bar07.jpg" class="tdpadding">ชื่อ:</TD>
      <TD  background="../admin/compcode/compcode/picture/bar07.jpg" class="tdpadding">
      <div class="form-group">
      <input name="per_fnamet" type="text" id="name" size="50" maxlength="50" value="<?php echo $rs_b["per_fnamet"]; ?>" class="form-control" required>
      </div>
      </TD>
    </TR>
    <TR   background="../admin/compcode/compcode/picture/bar07.jpg">
      <TD background="../admin/compcode/compcode/picture/bar07.jpg" class="tdpadding">นามสกุล:</TD>
      <TD background="../admin/compcode/compcode/picture/bar07.jpg" class="tdpadding"><div class="form-group"><input name="per_lnamet" type="text" id="name" size="50" maxlength="50" value="<?php echo $rs_b["per_lnamet"]; ?>" class="form-control" required></div></TD>
    </TR>
    <tr>
    	<td>Titlename:</td>
        <td>
        	<div class="form-group">
              <input name="per_pname2" type="text" id="per_pname2" size="50" value="<?php echo $rs_b["per_pname2"]; ?>" class="form-control">
              </div>
        </td>
    </tr>
    <TR>
      <TD background="../admin/compcode/compcode/picture/bar07.jpg" class="tdpadding">Name:</TD>
      <TD  background="../admin/compcode/compcode/picture/bar07.jpg" class="tdpadding">
      <div class="form-group">
      <input name="per_fnamee" type="text" id="name" size="50" maxlength="50" value="<?php echo $rs_b["per_fnamee"]; ?>" class="form-control" required>
      </div>
      </TD>
    </TR>
    <TR   background="../admin/compcode/compcode/picture/bar07.jpg">
      <TD background="../admin/compcode/compcode/picture/bar07.jpg" class="tdpadding">Surname:</TD>
      <TD background="../admin/compcode/compcode/picture/bar07.jpg" class="tdpadding"><div class="form-group"><input name="per_lnamee" type="text" id="name" size="50" maxlength="50" value="<?php echo $rs_b["per_lnamee"]; ?>" class="form-control" required></div></TD>
    </TR>
    <TR   background="../admin/compcode/compcode/picture/bar07.jpg">
      <TD background="../admin/compcode/compcode/picture/bar07.jpg" class="tdpadding">ส่วนงาน:</TD>
      <TD background="../admin/compcode/compcode/picture/bar07.jpg" class="tdpadding">
      	<div class="form-group">
      	<select name="per_dept" class="form-control select select-inverse" data-toggle="select" required>
      	<?php
		$rs_org=mysql_query("select * from $db_eform.department_type as t1
						inner join $db_eform.tb_orgnew as t2 on (t1.typ_id = t2.typ_id)
						order by convert (t1.typ_name using tis620) asc,
						convert (t2.dp_name using tis620) asc");
		while($ob_org=mysql_fetch_array($rs_org))
		{
			if($ob_org['dp_id']==$rs_b['per_dept'])
			{
				print "<option value=".$ob_org['dp_id']." selected>- ".$ob_org['typ_name'].' &raquo; '.$ob_org['dp_name']." -</option>";
			}
			else
			{
				print "<option value=".$ob_org['dp_id'].">- ".$ob_org['typ_name'].' &raquo; '.$ob_org['dp_name']." -</option>";
			}
		}
		?>
        </select>
        </div>
      </TD>
    </TR>
    <!--<tr>
      <td>ตำแหน่งงาน:</td>
      <td>
      	<div class="form-group">
            <select name="job_id" class="form-control select select-primary" data-toggle="select" required>
            	<?php
				/*$sql_job = mysql_query("select * from $db_eform.job
					where job_status = '1'
					order by convert (job_name using tis620) asc");
				while($ob_job = mysql_fetch_assoc($sql_job)){
					if($rs_b['job_id'] == $ob_job['job_id']){
						echo '<option value="'.$ob_job['job_id'].'" selected>&raquo; '.$ob_job['job_name'].'</option>';
					}else{
						echo '<option value="'.$ob_job['job_id'].'">&raquo; '.$ob_job['job_name'].'</option>';
					}
				}*/
				?>
            </select>
        </div>
      </td>
    </tr>-->
    <!--<tr>
      <td>ตำแหน่งวิชาการ:</td>
      <td>
      	<div class="form-group">
        	<select name="ja_id" class="form-control select select-primary" data-toggle="select">
            	<?php
				/*$sql_ja = mysql_query("SELECT * FROM $db_phonebook.job_academic
								where ja_use = 'yes'
								order by ja_id asc");
				while($ob_ja = mysql_fetch_assoc($sql_ja)){
					if($rs_b['ja_id'] == $ob_ja['ja_id']){
						print '<option value="'.$ob_ja['ja_id'].'" selected>&raquo; '.$ob_ja['ja_name'].'</option>';
					}else{
						print '<option value="'.$ob_ja['ja_id'].'">&raquo; '.$ob_ja['ja_name'].'</option>';
					}
				}*/
				?>
            </select>
        </div>
      </td>
    </tr>-->
    <!--<tr>
      <td>ตำแหน่งด้านบริหารงาน:</td>
      <td>
      	<div class="form-group">
        	<select name="jobs_id" class="form-control select select-primary" data-toggle="select">
				<?php
				/*$sql_jobs = mysql_query("SELECT * FROM $db_eform.job_special
								where jobs_status = '1'
								order by convert (jobs_name using tis620) asc");
				while($ob_jobs = mysql_fetch_assoc($sql_jobs)){
					if($rs_b['jobs_id'] == $ob_jobs['jobs_id']){
						print '<option value="'.$ob_jobs['jobs_id'].'" selected>&raquo; '.$ob_jobs['jobs_name'].'</option>';
					}else{
						print '<option value="'.$ob_jobs['jobs_id'].'">&raquo; '.$ob_jobs['jobs_name'].'</option>';
					}
				}*/
				?>
            </select>
        </div>
      </td>
    </tr>-->
    <tr>
    	<td>เบอร์โทรฯ ตรง:</td>
        <td>
        	<div class="form-group">
            	<input name="per_tel" type="text" class="form-control" value="<?php echo $rs_b['per_tel'];?>">
            </div>
        </td>
    </tr>
    <tr>
    	<td>เบอร์โทรฯ ภายใน:</td>
        <td>
        	<div class="form-group">
            	<input name="per_telin" type="text" id="name" size="50" class="form-control" value="<?php print $rs_b['per_telin'];?>" required>
            </div>
        </td>
    </tr>
    <TR   background="../admin/compcode/compcode/picture/bar07.jpg">
      <TD background="../admin/compcode/compcode/picture/bar07.jpg" class="tdpadding" valign="top">MU Mail:</TD>
      <TD background="../admin/compcode/compcode/picture/bar07.jpg" class="tdpadding"><div class="form-group"><input name="mumail" type="email" id="email" size="50" value="<?php echo $rs_b["per_email"]; ?>" class="form-control" required><span class="help-block regRed_12">กรุณาใช้ Email ของมหาวิทยาลัย</span></div>
      </TD>
    </TR>
    <!--<tr>
    	<td>Second Email:</td>
        <td>
        	<div class="form-group">
            	<input name="per_second_email" type="email" id="email" size="50" class="form-control" value="<?php //print $rs_b['per_second_email'];?>">
            </div>
        </td>
    </tr>-->
    <!--<TR   background="../admin/compcode/compcode/picture/bar07.jpg">
      <TD background="../admin/compcode/compcode/picture/bar07.jpg">กลุ่ม:</TD>
      <TD background="../admin/compcode/compcode/picture/bar07.jpg">
      	<div class="form-group">
            <select name="per_group" class="form-control select select-primary" data-toggle="select" required>
            	<?php
				/*$sql_group = mysql_query("SELECT * FROM $db_phonebook.personel_group
										where gr_use = 'yes'
										order by gr_order asc");
				while($ob_group = mysql_fetch_assoc($sql_group)){
					if($rs_b['per_group'] == $ob_group['gr_id']){
						print '<option value="'.$ob_group['gr_id'].'" selected>&raquo; '.$ob_group['gr_title'].'</option>';
					}else{
						print '<option value="'.$ob_group['gr_id'].'">&raquo; '.$ob_group['gr_title'].'</option>';
					}
				}*/
				?>
            </select>
        </div>
      </TD>
    </TR>-->
    <!--<tr>
    	<td>ระดับการศึกษาสูงสุด:</td>
        <td>
        	<div class="form-group">
            	<select name="ed_dgid" class="form-control select select-primary" data-toggle="select">
                	<?php
					/*$sql=mysql_query("select * from $db_eform.degree where dg_status='1' order by convert (dg_name using tis620) asc");
					while($ob=mysql_fetch_assoc($sql)){
						if($rs_b['ed_dgid'] == $ob['dg_id']){
							echo '<option value="'.$ob['dg_id'].'" selected>&raquo; '.$ob['dg_name'].'</option>';
						}else{
							echo '<option value="'.$ob['dg_id'].'">&raquo; '.$ob['dg_name'].'</option>';
						}
					}*/
					?>
                </select>
            </div>
        </td>
    </tr>-->
    <!--<tr>
    	<td>วุฒิการศึกษา:</td>
        <td>
        	<div class="form-group">
            	<input type="text" name="ed_edu" class="form-control" value="<?php //echo $rs_b['ed_edu'];?>" id="ed_edu">
             </div>
        </td>
    </tr>-->
    <!--<tr>
    	<td>สาขาวิชา:</td>
        <td>
        	<div class="form-group">
            	<input type="text" name="ed_major" class="form-control" value="<?php //echo $rs_b['ed_major'];?>">
             </div>
        </td>
    </tr>-->
    <!--<tr>
    	<td>สถาบัน:</td>
        <td>
        	<div class="form-group">
            	<input type="text" name="ed_institute" class="form-control" value="<?php //echo $rs_b['ed_institute'];?>" id="ed_institute">
             </div>
        </td>
    </tr>-->
    <!--<tr>
    	<td>ณ ประเทศ:</td>
        <td>
        	<div class="form-group">
            	<select name="ed_country" class="form-control select select-primary" data-toggle="select">
                	<option value="">&raquo; เลือกรายการ</option>
                	<?php
					/*$sql=mysql_query("select * from $db_eform.country order by convert (ct_name using tis620) asc");
					while($ob=mysql_fetch_assoc($sql)){
						if($rs_b['ed_country'] == $ob['ct_id']){
							echo '<option value="'.$ob['ct_id'].'" selected>&raquo; '.$ob['ct_name'].'</option>';
						}else{
							echo '<option value="'.$ob['ct_id'].'">&raquo; '.$ob['ct_name'].'</option>';
						}
					}*/
					?>
                </select>
            </div>
        </td>
    </tr>-->    
    <!--<TR   background="../admin/compcode/compcode/picture/bar07.jpg">
      <TD background="../admin/compcode/compcode/picture/bar07.jpg">Personel ID (MU-ERP)</TD>
      <TD background="../admin/compcode/compcode/picture/bar07.jpg">
          <div class="form-group">
            <p class="form-control-static"><?php //print $rs_b['per_erpid'];?></p>
    	</div>
      </TD>
    </TR>-->
    <!--<TR   background="../admin/compcode/compcode/picture/bar07.jpg">
      <TD background="../admin/compcode/compcode/picture/bar07.jpg">Record NO.</TD>
      <TD background="../admin/compcode/compcode/picture/bar07.jpg">
      	<div class="form-group">
        	<p class="form-control-static"><?php //print $rs_b['per_id'];?></p>
        </div>
      </TD>
    </TR>-->
    <!--<TR   background="compcode/picture/bar07.jpg">
      <TD colspan="2" background="compcode/picture/bar07.jpg" class="regWhite_13">&nbsp;</TD>
    </TR>
    <TR   background="compcode/picture/bar07.jpg">
      <TD colspan="2" background="compcode/picture/bar07.jpg" class="tdpadding"><span class="regRed_14"><?php #echo $msg2; ?></span></TD>
    </TR>
    <TR   background="compcode/picture/bar07.jpg"> 
      <TD background="compcode/picture/bar07.jpg" class="tdpadding">รหัสผ่านเดิม:</TD>
      <TD background="compcode/picture/bar07.jpg" class="tdpadding"><input name="oldpass" type="password" size="50" maxlength="10">      </TD>
    </TR>
    <TR> 
      <TD background="compcode/picture/bar07.jpg" class="tdpadding"><span>รหัสผ่านใหม่: </span></TD>
      <TD background="compcode/picture/bar07.jpg" class="tdpadding"><INPUT name="newpass" type="password" size="50" maxlength="10"></TD>
    </TR>
    <TR > 
      <TD background="compcode/picture/bar07.jpg" class="tdpadding">ยืนยันรหัสผ่านใหม่:</TD>
      <TD background="compcode/picture/bar07.jpg" class="tdpadding"><INPUT name="newpass2" type="password" size="50" maxlength="10"></TD>
    </TR>
    <tr>
            <td  background="compcode/picture/bar07.jpg" class="tdpadding">
            	
                <!--<input class=button type="reset" name="submit2" value="������"> -->             <!--</td>
            <td  background="compcode/picture/bar07.jpg" class="tdpadding">
            	<input type="hidden" name="username" value="<?php #echo $rs_b["username"]; ?>" />
                <input class=button type="submit" name="changepw" value="เปลี่ยนรหัสผ่าน" id="changepw">
            </td>
          </tr>-->
          	</tbody>
		   </TABLE>
           <!--</fieldset> -->
				</div><!--table-->
                <div class="panel-footer">
                	<input type="hidden" name="per_id" value="<?php echo $rs_b["per_id"]; ?>">
                    <input type="hidden" name="ed_id" value="<?php echo $rs_b["ed_id"]; ?>">
                    <input type="hidden" name="action" value="update">
                  <input class="btn btn-block button text-uppercase" type="submit" value="Update" id="editprofile">
                </div><!--footer-->
			</div><!--panel-->
            </FORM>

		</div><!--col-->
        
        <div class="col-lg-6">
        	<div class="panel panel-warning">
            	<div class="panel-heading">
                	<h3 class="panel-title">เปลี่ยนรหัสผ่าน</h3>
                </div>
                <div class="panel-body">
                	<form method="post" action="load_changepw.php" id="formChangepass">
                    	<div class="form-group">
                        	<label class="control-label">Username:</label>
                            <p class="form-control-static"><?php echo $rs_b['per_username'];?></p>
                        </div>
                    	<div class="form-group">
                        	<label class="control-label">รหัสผ่านใหม่:</label>
                            <input type="password" class="form-control" name="newPass">
                        </div>
                        <input type="hidden" name="action" value="changepass">
                        <button type="submit" class="btn btn-warning btn-wide"><i class="fa fa-check"></i> Save</button>
                    </form>
                </div>
            </div>
        </div><!--col-->
        
	</div><!--row-->

</div><!--container-->
<?php include('../lib/js-inc.php');?>
<script>
$(document).ready(function(e) {
	
	//autocomplete
	/*var jobid = new Bloodhound({
	  datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.label); },
	  queryTokenizer: Bloodhound.tokenizers.whitespace,
	  limit: 20,
	  prefetch: '../personel/job-json.php'
	});

	jobid.initialize();
	
	 $('#job_id').typeahead(null,{
		 name: 'jobid',
		  displayKey: 'label',
		  source: jobid.ttAdapter()
      });*/
	  
	  var pname = new Bloodhound({
	  datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.label); },
	  queryTokenizer: Bloodhound.tokenizers.whitespace,
	  limit: 20,
	  prefetch: '../json/nametitle-json.php'
	});
	pname.initialize();
	 $('#per_pname').typeahead(null,{
		 name: 'pname',
		  displayKey: 'label',
		  source: pname.ttAdapter()
      });
	  
	  var pname2 = new Bloodhound({
	  datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.label); },
	  queryTokenizer: Bloodhound.tokenizers.whitespace,
	  limit: 20,
	  prefetch: '../json/nametitle_en.php'
	});
	pname2.initialize();
	 $('#per_pname2').typeahead(null,{
		 name: 'pname2',
		  displayKey: 'label',
		  source: pname2.ttAdapter()
      });
	  
	  var ededu = new Bloodhound({
	  datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.label); },
	  queryTokenizer: Bloodhound.tokenizers.whitespace,
	  limit: 20,
	  prefetch: '../json/edu-json.php'
	});
	ededu.initialize();
	 $('#ed_edu').typeahead(null,{
		 name: 'ededu',
		  displayKey: 'label',
		  source: ededu.ttAdapter()
      });
	  
	  var institute = new Bloodhound({
	  datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.label); },
	  queryTokenizer: Bloodhound.tokenizers.whitespace,
	  limit: 20,
	  prefetch: '../json/institute-json.php'
	});
	institute.initialize();
	 $('#ed_institute').typeahead(null,{
		 name: 'institute',
		  displayKey: 'label',
		  source: institute.ttAdapter()
      });
	  //autocomplete
    
	$('#formProfile').bootstrapValidator({
		message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		 fields: {
			 per_pname: {
                validators: {
                    notEmpty: {
                        //message: 'The first name is required and cannot be empty'
                    }
                }
            },
			per_fnamet: {
                validators: {
                    notEmpty: {
                        //message: 'The first name is required and cannot be empty'
                    }
                }
            },
			per_lnamet: {
                validators: {
                    notEmpty: {
                        //message: 'The first name is required and cannot be empty'
                    }
                }
            },
			per_dept: {
                validators: {
                    notEmpty: {
                        //message: 'The first name is required and cannot be empty'
                    }
                }
            },
			job_id: {
                validators: {
                    notEmpty: {
                        //message: 'The first name is required and cannot be empty'
                    }
                }
            },
			per_telin: {
                validators: {
                    notEmpty: {
                        //message: 'The first name is required and cannot be empty'
                    }
                }
            },
			mumail: {
                validators: {
                    notEmpty: {
                        //message: 'The email address is required and can\'t be empty'
                    },
                    emailAddress: {
                        //message: 'The input is not a valid email address'
                    },
                    remote: {
						type: 'POST',
                        url: '../lib/bootstrapvalidator/mu-emailformat.php',
                        //message: 'The email is not available'
                    }
                }
            },
			per_second_email: {
                validators: {
                    emailAddress: {
                        //message: 'The input is not a valid email address'
                    }
                }
            },
			per_group: {
                validators: {
                    notEmpty: {
                        //message: 'The first name is required and cannot be empty'
                    }
                }
            },
			ed_dgid:{
				validators:{
					notEmpty:{
					}
				}
			},
		 }
	});
	
	$('#formChangepass').bootstrapValidator({
		feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		fields: {
			 newPass: {
                validators: {
                    notEmpty: {
                        //message: 'The first name is required and cannot be empty'
                    },
					stringLength: {
                        min: 4,
                        //max: 30,
                        //message: 'The username must be more than 6 and less than 30 characters long'
                    },
                }
            },
		}
	});
	
	$('select').select2({dropdownCssClass: 'show-select-search'});

});
</script>