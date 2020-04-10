<div class="col-md-3 white-box-m">
				<!--<div class="form-img-bk" style="background: url(../sadmin/uploads/docimages/regular/<?php echo $catfet[0]['doc_image']; ?>) no-repeat center center;"><p><?php if(isset($_REQUEST[id])) { echo $catfet[0]['document_name']; } else { echo $catfet[0]['form_name']; } ?></p></div>*/ ?>
					<!--<div class="find-form">
						<h3>Search Documents / Forms</h3>
						<div class="form-group">
                                            <label for="exampleInputEmail1">Keyword</label>
                                           <div class="select2-wrapper">
                                            <input type="text" name="search" class="typeahead form-control">
											</div>
						</div>
					</div>-->
					<?php
				
					if(isset($_REQUEST[id])) {
					$id =  $_REQUEST['id'];
 $codeform = "SELECT scat_id FROM dynamic_form WHERE d_form_id='$id'";
 $catfetfdetform=$prop->getAll_Disp($codeform);
 $scatid = $catfetfdetform[0]['scat_id'];
}
if(isset($_REQUEST[ids])) {
$id =  base64_decode($_REQUEST['ids']);
$codeform = "SELECT doc_cat FROM docs WHERE doc_id='$id'";
$catfetfdetform=$prop->getAll_Disp($codeform);
$scatid = $catfetfdetform[0]['doc_cat'];
$sql = " AND doc_id !=$id";
}
 $codeform = "SELECT * FROM docs WHERE `doc_cat` IN($scatid) AND doc_status=0 $sql order by doc_id DESC limit 0,5";
 $catfetfdet=$prop->getAll_Disp($codeform);
	if(count($catfetfdet)>0)
	{
	?>
					<div class="recent-form">
						<h3>Related Documents</h3>
						<div>
						 <?php
	for($i=0; $i<count($catfetfdet); $i++)
					                    {
									?>
						<p><a href="document-page.php?ids=<?php echo base64_encode($catfetfdet[$i]['doc_id']);?>"><img src="img/doc.png"><?php echo $catfetfdet[$i]['doc_name']; ?></a></p>
										<?php } ?>
						</div>
					</div>
					<?php }   ?>
					<?php
					$cid =  $_SESSION['US']['user_id'];

 $codes = "SELECT * FROM `form_fields` f JOIN dynamic_form d ON d.d_form_id=f.form_id  WHERE  f.`created_by`='$cid' AND f.`is_deleted`=0 ORDER BY `id` DESC  limit 0,5";
	$catfetfdets=$prop->getAll_Disp($codes);
	if(count($catfetfdets)>0)
	{
	?>

					<div class="recent-form">
						<h3>Recently Filled Forms</h3>
						<div>
						<?php
	for($idd=0; $idd<count($catfetfdets); $idd++)
					                    {
									?>
									<p><a href="form-page.php?id=<?php echo $catfetfdets[$idd]['form_id']?>&row_id=<?php echo $catfetfdets[$idd]['id']?>"><img src="img/notepad12.png"><?php echo $catfetfdets[$idd]['d_template_name']; ?></a></p>
									<?php } ?>
						</div>

					</div>
					<?php }   ?>
				</div>
