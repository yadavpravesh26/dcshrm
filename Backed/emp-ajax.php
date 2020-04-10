<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$dept_id = $_POST['dep_id'];
 ?>
<label class="control-label col-md-3">Employees</label>
<div class="col-md-9">
  <select class="form-control select2 select2-multiple" multiple="multiple" name="emp_id[]" required>
<?php
$catsql = "SELECT id,name,department_id from ".USERS." WHERE u_type=4 AND `department_id`=".$dept_id." AND `status`!=2 order by `name` ASC";
$catfet=$prop->getAll_Disp($catsql);
for($i=0; $i<count($catfet); $i++)
          { ?>
<option value="<?php echo $catfet[$i]['id']; ?>" <?php echo "selected"; ?>><?php echo $catfet[$i]['name']; ?></option>
<?php } ?>
  </select>
  <div class="help-block with-errors"></div>
</div>
