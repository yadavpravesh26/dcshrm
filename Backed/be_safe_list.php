<?php 
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
require_once('inc/img_resize.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);

	$mainCats = $_POST['catIDs'];
	$subCateIDs = $_POST['subCateIDs'];
	$pageIDs = $_POST['pageIDs']; 
	$keyword = $_POST['keyword'];
	$departID = $_POST['departID'];
	$empID = $_POST['empID'];
	if($departID != '')
	{
		$depart_val = $prop->get("GROUP_CONCAT( DISTINCT catID ORDER BY catID SEPARATOR ',') as catIDs , GROUP_CONCAT( DISTINCT subCatID ORDER BY subCatID SEPARATOR ',') as subCatIDs , GROUP_CONCAT( DISTINCT programID ORDER BY programID SEPARATOR ',') as programIDs","assign_depart", array('depart_id'=>$departID,'status'=>0));
		
		$departMainCats = $depart_val['catIDs'];
		$departSubCateIDs = $depart_val['subCatIDs'];
		$departPageIDs = $depart_val['programIDs'];
		
	}
	
	if($empID != '')
	{
		$emp_val = $prop->get("GROUP_CONCAT( DISTINCT catID ORDER BY catID SEPARATOR ',') as catIDs , GROUP_CONCAT( DISTINCT subCatID ORDER BY subCatID SEPARATOR ',') as subCatIDs , GROUP_CONCAT( DISTINCT programID ORDER BY programID SEPARATOR ',') as programIDs","assign_emp", array('emp_id'=>$empID,'status'=>0));
		$empMainCats = $emp_val['catIDs'];
		$empSubCateIDs = $emp_val['subCatIDs'];
		$empPageIDs = $emp_val['programIDs'];
	}
	
	if($departMainCats != '' and $empMainCats != '')
	{
		$arr1 = explode(',',$departMainCats);
		$arr2 = explode(',',$empMainCats);
		$result = array_intersect($arr1, $arr2);
		$mainCats = implode(',', $result);
		
		$arr1 = explode(',',$departSubCateIDs);
		$arr2 = explode(',',$empSubCateIDs);
		$result = array_intersect($arr1, $arr2);
		$subCateIDs = implode(',', $result);
		
		$arr1 = explode(',',$departPageIDs);
		$arr2 = explode(',',$empPageIDs);
		$result = array_intersect($arr1, $arr2);
		$pageIDs = implode(',', $result);
	}
	else if($departMainCats != '')
	{
		$mainCats = $departMainCats;
		$subCateIDs = $departSubCateIDs;
		$pageIDs = $departPageIDs;
	}
	else if($empMainCats != '')
	{
		$mainCats = $empMainCats;
		$subCateIDs = $empSubCateIDs;
		$pageIDs = $empPageIDs;
	}
	else if($keyMainCats != '')
	{
		$mainCats = $keyMainCats;
		$subCateIDs = $keySubCateIDs;
		$pageIDs = $keyPageIDs;
	}
	if($keyword != '')
	{
		$keysql = 'SELECT GROUP_CONCAT( DISTINCT c.c_id ORDER BY c.c_id SEPARATOR ",") as catIDs,
GROUP_CONCAT( DISTINCT s.c_id ORDER BY s.c_id SEPARATOR ",") as subCatIDs,
GROUP_CONCAT( DISTINCT p.p_id ORDER BY p.p_id SEPARATOR ",") as programIDs from cats c inner join cat_sub s on c.c_id = s.c_name inner join pages p on s.c_id = p.category WHERE ( c.status!=2 and c.c_id IN ('.$mainCats.') and c.c_name like "%'.$keyword.'%" ) or ( s.status!=2 and s.c_name IN ('.$mainCats.') and s.c_id IN ('.$subCateIDs.') and s.sc_name like "%'.$keyword.'%" ) or ( p.page_status!=2 and p.category IN ('.$subCateIDs.') and p.p_id IN ('.$pageIDs.') and p.title like "%'.$keyword.'%" ) order by c.c_name ASC';
		$key_val = $prop->get_Disp($keysql);
		$mainCats = $key_val['catIDs'];
		$subCateIDs = $key_val['subCatIDs'];
		$pageIDs = $key_val['programIDs'];
	}
	
	if($mainCats !='')
	{
		
		$catSql = "select * from ".MAIN_CATEGORY." WHERE status!=2 and `c_id` IN (".$mainCats.") order by c_name ASC";
		
		$row_cat=$prop->getAll_Disp($catSql);
		$count_cat = count($row_cat);
		for($i=0; $i<$count_cat; $i++){
		$mainCatID = $row_cat[$i]['c_id'];
		$countDepartCat = $prop->getName('count(DISTINCT depart_id)', 'assign_depart', "status!=2 AND catID=".$mainCatID);
		$countEmpCat = $prop->getName('count(DISTINCT emp_id)', 'assign_emp', "status!=2 AND catID=".$mainCatID);
		?>
		<ul class="cd-accordion cd-accordion--animated margin-top-lg margin-bottom-lg">
			<li class="cd-accordion__item cd-accordion__item--has-children">
			  <div class="checkbox checkbox-success main_cate_checkbox" id="main_cate_checkbox<?php echo $row_cat[$i]['c_id'];?>">
				  <input id="main_cate_<?php echo $row_cat[$i]['c_id'];?>" class="main_cat" name="main_cat[]" type="checkbox" value="<?php echo $row_cat[$i]['c_id'];?>" >
				  <label class="category-label" for="main_cate_<?php echo $row_cat[$i]['c_id'];?>"></label>
			  </div>
			  <input class="cd-accordion__input" type="checkbox" name="group-<?php echo $row_cat[$i]['c_id'];?>" id="group-<?php echo $row_cat[$i]['c_id'];?>">
			  <label class="cd-accordion__label cd-accordion__label--icon-folder" for="group-<?php echo $row_cat[$i]['c_id'];?>"><span class="span1"><?php echo $row_cat[$i]['c_name'];?></span><span class="span2"><a><?php echo $countDepartCat;?></a>
			  <a class="addDepartment" data-id="main_cate_<?php echo $row_cat[$i]['c_id'];?>" data-toggle="modal" data-target="#myModalDepartment" style="font-size:16px;">
				<i class="fa fa-plus-circle" aria-hidden="true"></i>
			  </a>
			  </span><span class="span2"><a><?php echo $countEmpCat;?></a>
			  <a class="addEmp" data-id="main_cate_<?php echo $row_cat[$i]['c_id'];?>" data-toggle="modal" data-target="#myModalEMP" style="font-size:16px;">
				<i class="fa fa-plus-circle" aria-hidden="true"></i>
			  </a>
			  </span></label>
		
			<?php 
			
			$subCatSql = "select * from ".SUB_CATEGORY." WHERE status!=2 and c_name = ".$mainCatID." and  `c_id` IN (".$subCateIDs.") order by c_name ASC";
			//echo $subCatSql;
			$row_subCat =$prop->getAll_Disp($subCatSql);
			$count_subCat = count($row_subCat);
			for($j = 0; $j<$count_subCat; $j++)
			{
			$subCatID = $row_subCat[$j]['c_id'];
			$countSubCat = $prop->getName('count(DISTINCT depart_id)', 'assign_depart', "status!=2 AND catID=".$mainCatID." AND subCatID=".$subCatID);
			$countEmpSubCat = $prop->getName('count(DISTINCT emp_id)', 'assign_emp', "status!=2 AND catID=".$mainCatID." AND subCatID=".$subCatID);
			?>
			  <ul class="cd-accordion__sub cd-accordion__sub--l1 main_cate_checkbox<?php echo $mainCatID;?>">
				<li class="cd-accordion__item cd-accordion__item--has-children">
				  <div class="checkbox checkbox-success sub_cate_checkbox" id="sub_cate_checkbox<?php echo $mainCatID.$subCatID;?>">
					  <input id="sub_cate_<?php echo $mainCatID.$subCatID;?>" data-class="main<?php echo $mainCatID;?>" class="sub_cate" type="checkbox" value="<?php echo $subCatID;?>" name="sub_cat[<?php echo $mainCatID;?>][]" >
					  <label class="category-label" for="sub_cate_<?php echo $mainCatID.$subCatID;?>"></label>
				  </div>
				  <input class="cd-accordion__input" type="checkbox" name ="sub-group-<?php echo $mainCatID.$subCatID;?>" id="sub-group-<?php echo $mainCatID.$subCatID;?>">
				  <label class="cd-accordion__label cd-accordion__label--icon-folder" for="sub-group-<?php echo $mainCatID.$subCatID;?>"><span class="span1"><?php echo $row_subCat[$j]['sc_name'];?></span><span class="span2"><a><?php echo $countSubCat;?></a>
				  <a class="addDepartment" data-id="sub_cate_<?php echo $mainCatID.$subCatID;?>" data-toggle="modal" data-target="#myModalDepartment" style="font-size:16px;">
					<i class="fa fa-plus-circle" aria-hidden="true"></i>
				  </a>
				  </span><span class="span2"><a><?php echo $countEmpSubCat;?></a>
				  <a class="addEmp" data-id="sub_cate_<?php echo $mainCatID.$subCatID;?>" data-toggle="modal" data-target="#myModalEMP" style="font-size:16px;">
					<i class="fa fa-plus-circle" aria-hidden="true"></i>
				  </a>
				  </span></label>
		
				  <ul class="cd-accordion__sub cd-accordion__sub--l2 sub_cate_checkbox<?php echo $mainCatID.$subCatID;?>">
					<?php 
					$programsSql = "select * from ".PAGES." WHERE page_status!=2 and category = ".$subCatID." and  `p_id` IN (".$pageIDs.") order by title ASC";
					$row_programs =$prop->getAll_Disp($programsSql);
					$count_programs = count($row_programs);
					for($k = 0; $k<$count_programs; $k++)
					{
					$pID = $row_programs[$k]['p_id'];
					$countProgram = $prop->getName('count(DISTINCT depart_id)', 'assign_depart', "status!=2 AND catID=".$mainCatID." AND subCatID=".$subCatID." AND programID=".$pID);
					$countEmpProgram = $prop->getName('count(DISTINCT emp_id)', 'assign_emp', "status!=2 AND catID=".$mainCatID." AND subCatID=".$subCatID." AND programID=".$pID);
					?>
					<li class="cd-accordion__item">
						<div class="checkbox checkbox-success porgram_checkbox">
						  <input id="porgram_<?php echo $mainCatID.$subCatID.$pID;?>" data-class="subcate<?php echo $subCatID;?>" class="program_check" type="checkbox" value="<?php echo $mainCatID;?>-<?php echo $subCatID;?>-<?php echo $pID;?>" name="BeSafePorgram[]">
						  <label class="category-label" for="porgram_<?php echo $mainCatID.$subCatID.$pID;?>"></label>
						</div>
						<div class="cd-accordion__label cd-accordion__label--icon-img" href="add-training-design.php"><span class="span1"><a href="add-training-design.php?programID=<?php echo $pID;?>"><?php echo $row_programs[$k]['title'];?></a></span><span class="span2"><a href="add-training-design.php?programID=<?php echo $pID;?>"><?php echo $countProgram;?></a>
						<a class="addDepartment" data-id="porgram_<?php echo $mainCatID.$subCatID.$pID;?>" data-toggle="modal" data-target="#myModalDepartment" style="font-size:16px;">
						<i class="fa fa-plus-circle" aria-hidden="true"></i>
					  </a>
						</span><span class="span2"><a href="add-training-design.php?programID=<?php echo $pID;?>"><?php echo $countEmpProgram;?></a>
						<a class="addEmp" data-id="porgram_<?php echo $mainCatID.$subCatID.$pID;?>" data-toggle="modal" data-target="#myModalEMP" style="font-size:16px;">
						<i class="fa fa-plus-circle" aria-hidden="true"></i>
					  </a>
						</span>
						</div>
					</li>
					<?php
					} 
					?>
				  </ul>
				</li>
			  </ul>
			<?php
			} 
			?>
			</li>
		</ul>
		<?php
		} 
	}
	else
	echo '<p style="border: 1px solid #ccc;padding: 10px;text-align: center;">No record found</p>';	
?>
<script>
jQuery(document).ready(function() {
	$('#assignDepart').attr("disabled", true);
	/*Checkbox part start*/
	$('.checkbox input[type="checkbox"]').click(function(e){
		var classname = $(this).attr('class');
		var prev_classname = $(this).parent().attr('id');
		console.log(classname+prev_classname);
		if($(this).prop("checked") == true)
		{
			$( "ul." + prev_classname + " li .checkbox input[type='checkbox']").each(function( index ) {
			  $( this ).prop('checked', true);
			});
		}
		else
		{
			$( "ul." + prev_classname + " .checkbox input[type='checkbox']").each(function( index ) {
			  $( this ).prop('checked', false);
			});					
		}
		
		var btnDisable = true;
		$( ".program_check").each(function( index ) {
			  if($(this).prop("checked") == true)
			  btnDisable = false;
		});
		$('#assignDepart').attr("disabled", btnDisable);
		
	});
	/*Checkbox part End*/
	/*Assign Department start*/
	$('#btnPopDepart').click(function(e){
		var departID = $('#popup_depart').children("option:selected").val();
		if(departID != 0)
		{
			$('#departID').val(departID);
			$('#submitType').val('assignDepart');
			$('#formBeSafe').submit();
		}
		else
		{
			$('.errorDepart').html('Department is required');
			$('.errorDepart').css('color','red');
		}
	});
	$('#popup_depart').change(function(e){
		var departID = $('#popup_depart').children("option:selected").val();
		if(departID != 0)
		{
			$('.errorDepart').html('');
		}
	});
	/*Assign Department end*/
	/*Depart Model ancher Click */
	$( ".addDepartment" ).click(function(){
		var checkboxID = $(this).attr('data-id');
		$('.checkbox input[type="checkbox"]').each(function( index ) {
			if($(this).prop("checked") == true)
			$(this).click();
		});	
		$('#'+checkboxID).click();
	});
	$("#myModalDepartment").on('hidden.bs.modal', function () {
		$('.checkbox input[type="checkbox"]').each(function( index ) {
			if($(this).prop("checked") == true)
			$(this).click();
		});			  
	});
	/*Depart Model ancher Click END*/
	/*Assign EMPLOYEE start*/
	$('#btnPopEmp').click(function(e){
		var empID = $('#popup_emp').children("option:selected"). val();
		if(empID != 0)
		{
			$('#empID').val(empID);
			$('#submitType').val('assignEMP');
			$('#formBeSafe').submit();
		}
		else
		{
			$('.errorEMP').html('Employee is required');
			$('.errorEMP').css('color','red');
		}
	});
	$('#popup_emp').change(function(e){
		var EmpID = $(this).children("option:selected").val();
		if(EmpID != 0)
		{
			$('.errorEMP').html('');
		}
	});
	/*Assign EMPLOYEE end*/
	/*EMPLOYEE Model ancher Click */
	$( ".addEmp" ).click(function(){
		var checkboxID = $(this).attr('data-id');
		$('.checkbox input[type="checkbox"]').each(function( index ) {
			if($(this).prop("checked") == true)
			$(this).click();
		});	
		$('#'+checkboxID).click();
	});
	$("#myModalEMP").on('hidden.bs.modal', function () {
		$('.checkbox input[type="checkbox"]').each(function( index ) {
			if($(this).prop("checked") == true)
			$(this).click();
		});			  
	});
	/*EMPLOYEE Model ancher Click END*/
	/*Filter Code Start */
	$('#filterKey').keyup(function(e){
		var keyword = $(this).val();
		var departID = $('#filterDep').children("option:selected").val();
		var empID = $('#filterEmp').children("option:selected").val();				
		call_filter_data(keyword,departID,empID);
	});
	$('#filterDep').change(function(e){
		var keyword = $('#filterKey').val();
		var departID = $(this).children("option:selected").val();
		var empID = $('#filterEmp').children("option:selected").val();				
		call_filter_data(keyword,departID,empID);
	});
	$('#filterEmp').change(function(e){
		var keyword = $('#filterKey').val();
		var departID = $('#filterDep').children("option:selected").val();
		var empID = $(this).children("option:selected").val();				
		call_filter_data(keyword,departID,empID);
	});
	/*Filter Code End */
});		
</script>