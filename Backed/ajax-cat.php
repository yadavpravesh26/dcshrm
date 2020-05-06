<?php
require_once('../config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$cdb = new DB();
$db = $cdb->getDb();
$prop = new PDOFUNCTION($db);
extract($_REQUEST);
if($meth=='RefonlyCat'){?>
	<select name="category_id" id="category_id" class="form-control" required>
        <option value="">Select Category</option>
        <?php
                $catfet=$prop->getAll_Disp("SELECT * FROM `".MAIN_CATEGORY."` WHERE `status`=0 order by c_name ASC");
                //echo  '<option value="">Select Category</option>';
                for($i=0; $i<count($catfet); $i++)
                                      {
                echo  '<option value="'.$catfet[$i]['c_id'].'" '.($catfet[$i]['c_id'] == $curr_val['c_name'] ? "selected":"").' >'.$catfet[$i]['c_name'].'</option>';
                }
                
                ?>
      </select>
<?php }
if($meth=='RefCat')
{?>
	                                                        <option value=''>Select Category</option>
															<?php
											// Perform queries
										$catfets =  "SELECT * FROM cats WHERE status=0 order by c_name ASC";
										$rowcat=$prop->getAll_Disp($catfets);
										for($i=0; $i<count($rowcat); $i++)
											 {
										?>
                                                                
                                                                <optgroup label="<?php echo $rowcat[$i]['c_name']; ?>">
                                                                    <?php
												$catfetsub =  "SELECT * FROM cat_sub WHERE c_name='". $rowcat[$i]['c_id']."' AND status=0 order by sc_name ASC";
												$rowcatub=$prop->getAll_Disp($catfetsub);
												for($di=0; $di<count($rowcatub); $di++)
												 {
												?>
                                                                        <option value="<?php echo $rowcatub[$di]['c_id']; ?>" <?php if ($rowcatub[$di][ 'c_id']==$curr_val[category]) { echo "selected"; } ?>>
                                                                            <?php echo $rowcatub[$di]['sc_name']; ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                </optgroup>
                                                                <?php } ?>

                                                        
<?php } ?>
