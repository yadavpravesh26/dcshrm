<?php
require_once('config.php');
require_once(DOC_CONFIG.'inc/pdoconfig.php');
require_once(DOC_CONFIG.'inc/pdoFunctions.php');
$catfetdoc =  "SELECT * FROM dynamic_form WHERE d_form_id =".$_REQUEST['id']." AND d_detele_status=0";
$rowdoc=$prop->getAll_Disp($catfetdoc);
if(empty($rowdoc[0])){
	header('Location:'.LIVE_SITE); exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
    <title><?php echo $rowdoc[0]['d_template_name']; ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <link href="plugins/bower_components/custom-select/custom-select.css" rel="stylesheet" type="text/css" />
    <link href="plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
	 <link href="plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <link href="plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />

    <!-- animation CSS -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
	  <link href="css/style-own.css" rel="stylesheet">
    <link href="css/custom-style.css" rel="stylesheet">
    <!-- color CSS you can use different color css from css/colors folder -->
    <link href="css/colors/green-dark.css" id="theme" rel="stylesheet">
    <link href="plugins/bower_components/jquery-wizard-master/libs/formvalidation/formValidation.min.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<style>
.grid-stack-item.siseof.ui-draggable.ui-resizable.ui-resizable-autohide {
    width: 100% !important;
    display: block;
    clear: both;
}
span.twitter-typeahead {
    display: block !important;
}
.wrong-answer{
	padding: 0 5px;
    border: 1px solid #fb9678;
}
.correct-answer{
	padding: 0 5px;
    border: 1px solid #00c292;
}
.alert-answer{
	background: #ffdfdf;
    color: #820909;
    font-size: 14px;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: 500;
    display: inline-block;
	margin-top: 10px;
}
</style>

</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>

    <!-- Loader Notify -->
    <span class="loader_notify" style="display:none;">
	<img src="images/loader_dcs.gif" style="width: 30px;">
    </span>

    <div id="wrapper">
        <!-- Top Navigation -->
       <?php include 'header.php';?>
        <!-- End Top Navigation -->
        <!-- Left navbar-header -->
       <?php include 'navbar.php';?>
        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <!--<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Starter Page</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                        <ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>

                        </ol>
                    </div>

                </div>-->
                <?php
                
				$perm_form = 1;
				if($nav_main===1)
					$perm_form = 0;
				if(in_array($rowdoc[0]['cat_id'],explode(',',$nav_category)))
					$perm_form = 0;
				if(in_array($rowdoc[0]['scat_id'],explode(',',$nav_sub_category)))
					$perm_form = 0;
				if(in_array($rowdoc[0]['cat_id'],explode(',',$rej_category)))
					$perm_form = 1;
				if(in_array($rowdoc[0]['scat_id'],explode(',',$rej_sub_category)))
					$perm_form = 1;
				if($perm_form===1)
				{
					header('Location:'.LIVE_SITE); exit;
				}
                ?>
                <div class="clearfix"></div>
               <div class="row m-t-15">
                    <div class="col-md-9">
                        <div class="white-box form-wrapper-block">
                            <div class="row">
                              <div class=" row title-hd">

                              <div class="col-md-2"></div>
                              <div class="col-md-8"><h3 class="accident">
				<?php echo $rowdoc[0]['d_template_name']; ?>
				</h3>
				<input type="hidden" class="form_title_hidden" value="<?php echo trim($rowdoc[0]['d_template_name']); ?>" >
				<input type="hidden" class="form_id_hidden" value="<?php echo ($_GET['id']) ? $_GET['id'] : 0 ;?>" >
				<input type="hidden" class="row_id_hidden" value="<?php echo $_GET['row_id']; ?>" >
				</div>
                              <div class="col-md-2"></div>


                              </div>
								<div class="white-box document-sec">
<?php 

$quizAttCount = $prop->counts('id',FORM_FIELDS, array('form_id'=>$rowdoc[0]['d_form_id'],'reassign'=>0,'created_by'=>$_SESSION['US']['user_id']));
if($quizAttCount==0){
?>
<form method="post" id="serialform" data-toggle="validator" enctype="multipart/form-data" action="jvascript:void(0);">
  <?php echo str_replace("…"," ",$rowdoc[0]['d_contat_html']); ?>
</form>
<?php 
}else{
	header('Location:'.LIVE_SITE); exit;
}
?>
<div class="clearfix"></div>

		</div>

                                </div>
                            </div>
                        </div>
				<?php include("doc_sidebar.php"); ?>
                    </div>
				<div class="clearfix"></div>
                <div class="row m-t-15">

                    </div>
                </div>

            </div>
            <!-- /.container-fluid --><?php include 'footer.php';?>

        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="bootstrap/dist/js/tether.min.js"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <script src="js/validator.js"></script>
    <!-- Custom Theme JavaScript -->
    <!-- Custom Theme JavaScript -->
    <script src="js/custom.min.js"></script>
    <script src="plugins/bower_components/custom-select/custom-select.min.js" type="text/javascript"></script>
    <script src="plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

    <!--Style Switcher -->
    <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
	  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/corejs-typeahead/0.11.1/typeahead.bundle.min.js"></script>

    <!-- Form Validation Plugin -->
    <script src="plugins/bower_components/jquery-wizard-master/libs/formvalidation/formValidation.min.js"></script>
    <script src="plugins/bower_components/jquery-wizard-master/libs/formvalidation/bootstrap.min.js"></script>

    <!-- Jquery UI Block -->
    <script src="plugins/bower_components/blockUI/jquery.blockUI.js"></script>


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/corejs-typeahead/0.11.1/typeahead.jquery.min.js"></script>
<script src="plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <script src="plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>

    <script type="text/javascript" src="js/typeheadsearch.js"></script>

    <!-- accordian script -->
    <script type="text/javascript">
	$(function(){
  $(".accordian h3").click(function(e){
    $($(e.target).find('.ti-plus').toggleClass('open'));
  $(".accordian ul ul").slideUp();
    if ($(this).next().is(":hidden")){
    $(this).next().slideDown();
    }
  });

  var divList = $(".grid-stack-item");
  divList.sort(function(a, b){ return $(a).data("gs-y")-$(b).data("gs-y")});

  $("#dragy").html(divList);
});
$(document).ready(function() {
  /* $("input:radio").attr("checked", false); */
	if($('input:radio:checked')){
		$('input:radio:checked').attr('data-is','1');
		$('input:radio:checked').addClass('done-answer');
	}
	$("input:radio").attr("checked", false);
	
	$('input:radio').change(function () {
		var inp = $(this).parent().parent();
		var prnt = $(this).parent();
		var ans = $(inp).find('.done-answer').val();
		$(inp).find('.d-inlineblock').removeClass('correct-answer');
		$(inp).find('.d-inlineblock').removeClass('wrong-answer');
		$(inp).parent().find('.alert-answer').remove();
		if ($(this).attr('data-is')==1) {
			console.log('correct-answer');
		}else{
			$(this).attr('checked', false);
			$(prnt).addClass('wrong-answer');
			$(inp).find('.done-answer').parent().addClass('correct-answer');
			$(inp).parent().append('<div class="alert-answer">You are choosing wrong answer. Coorect Answer is "' + ans + '".</div>');
		}
	});
});
$('#serialform').submit(function () {
	if ($('.alert-answer').length>0) {
        return false;
    }
});
</script>


<script type="text/javascript">
$(function(){

  // Form Validation for Dynamic Form
  $('#serialform').formValidation()
  .on('success.form.fv', function(e){

    // Preparing DataSet for insertion
    var data2Ins = [];
	var fieldvalu=[];
	var radioval=[];
    $('#serialform .form-validate, .formvalidatetext').each(function(){
        var fieldType = $(this).attr('type');
        var tagname = $(this).prop('tagName');
        var fieldIndex = $(this).attr('rel');
        var fieldName = $(this).attr('name');
        if(fieldType == 'text' || tagname=='TEXTAREA'){
          currVal = $(this).val();
		  if(currVal!='' && currVal!=undefined) {
			  fieldvalu.push(currVal);
			  console.log(fieldvalu);
			  data2Ins.push(fieldIndex+':'+currVal);
		  }
        }
		else if(fieldType == 'radio') {
			fieldVal = $('input[name="'+fieldName+'"]'+':checked').val();
			currVal = $('.fieldIndex'+fieldIndex+':checked').val();

			 if(currVal!='' && fieldVal!='' && currVal!=undefined) {
			  radioval.push(currVal);
			  data2Ins.push(fieldIndex+':'+currVal);
			}
		}

    });
    var formTitle = $('.accident').val();
    var formID = $('.form_id_hidden').val();
    var row_id = $('.row_id_hidden').val();
	
if (fieldvalu.length ===0 && radioval.length===0) {
   swal("Warning", "Fill The Form and Save", "warning");
   $(".btntheme2").prop('disabled',false);
   return false;
}

    // Blocking form for detail Fetching
    $('.form-wrapper-block').block({
            message: $('.loader_notify').html(),
            centerY: true,
            css: {
              backgroundColor: 'none',
              border: '0',
            },
            overlayCSS: { backgroundColor: '#FFFFFF' }
        });

    // Request starts here to save data
    $.ajax({
	url: "ajax_form_action.php?module=saveFormField",
        type: "POST",
        data: { insData: data2Ins, title: formTitle, formid: formID, row_id: row_id },
        success: function(data){
		swal("Success", "Your Form Data has been saved", "success");
	    window.location.reload();
	},
    });
    // Request Ends Here
    $('#serialform').formValidation('resetForm', true);
    $('.form-wrapper-block').unblock();

    return false;
  });

  $(document).delegate('.hasDatepicker', 'change', function(){
    var fieldName = $(this).attr('name');
    $('#serialform').formValidation('revalidateField', fieldName);
  });

    // $('form').submit(function(msg) {
    //    alert($(this).serialize()); // check to show that all form data is being submitted
    //     $.post("post.php",$(this).serialize(),function(data){
    //         alert(data); //post check to show that the mysql string is the same as submit
    //     });
    //     return false; // return false to stop the page submitting. You could have the form action set to the same PHP page so if people dont have JS on they can still use the form
    // });

    var requiredValidators = {
          row: '.grid-stack-item',
          validators: {
                notEmpty: {
                    message: 'This Field is Required'
                }
            }
        };

    var dateValidators = {
              row: '.grid-stack-item',
              validators: {
                    notEmpty: {
                        message: 'This Field is Required'
                    },
                    date: {
                      message: 'The Date is not Valid',
                      format: 'MM/DD/YYYY'
                    }
                }
            };



jQuery('.datepicker-autoclose').datepicker({
    autoclose: true,
    todayHighlight: true
});
//$('label').live('click', function (event) {
//  $(document).delegate('label', 'click', function(){
//    var reldf = $(this).attr('rel');
  //  $("input").prop('checked', true);
 //});
function refreshField() {

$('table input').attr('name', 'newName');
	// Add class o form field for validation purpose
	$('input, select, textarea').not('table input').addClass('form-validate');
	$('table input').addClass('formvalidatetext');
  $('table').addClass('table-bordered');

	var rowIndex = 1;
	$('#serialform .form-validate').each(function(){
		$(this).addClass('fieldIndex'+rowIndex);
		$(this).attr('rel', rowIndex);
		$(this).attr('id', 'fieldID'+rowIndex);
		$(this).next('label').attr('for', 'fieldID'+rowIndex);
		var fieldName = $(this).attr('name');
		var isAlreadyValidated = $(this).attr('data-fv-field');

		if($(this).hasClass('hasDatepicker'))
			$('#serialform').formValidation('addField', fieldName, dateValidators);
		else if(isAlreadyValidated==undefined )
			$('#serialform').formValidation('addField', fieldName, requiredValidators);
		rowIndex++;
	});

	$('.formvalidatetext').each(function(){
		$(this).addClass('fieldIndex'+rowIndex);
		$(this).attr('rel', rowIndex);
	    $(this).attr('id', 'fieldID'+rowIndex);
	    $(this).next('label').attr('for', 'fieldID'+rowIndex);
		var fieldName = $(this).attr('name');
		var isAlreadyValidated = $(this).attr('data-fv-field');
	  rowIndex++;
	});

	// Fetch if form fields are exist
	var formID = $('.form_id_hidden').val();
	var edit_id = $('.row_id_hidden').val();

	if(edit_id=='')
		return false;


	// Screen Block
	$('.form-wrapper-block').block({
            message: $('.loader_notify').html(),
            centerY: true,
            css: {
              backgroundColor: 'none',
              border: '0',
            },
            overlayCSS: { backgroundColor: '#FFFFFF' }
        });

	$.ajax({
	url: "ajax_form_action.php?module=fetchFormField",
        type: "POST",
        data: { formid: formID, edit_id: edit_id },
        success: function(data){
	   outputData = $.parseJSON(data);
	   $.each(outputData, function(index, innerData){
		var currValue = innerData.split(':');
		var fieldIndex = currValue[0];
		var fieldValue = currValue[1];

		var fieldType = $('.fieldIndex'+fieldIndex).attr('type');
		var tagname = $('.fieldIndex'+fieldIndex).prop('tagName');
		var fieldName = $('.fieldIndex'+fieldIndex).attr('name');
		if(fieldType == 'text' || tagname=='TEXTAREA'){
		    $('.fieldIndex'+fieldIndex).val(fieldValue);
		} else {
			$('input[name="'+fieldName+'"]').removeAttr('checked');
		    $('.fieldIndex'+fieldIndex).attr('checked', true).trigger('click');
		}

	  });
	},
    });
 	$('.form-wrapper-block').unblock();
	
}

refreshField();
$("#redirct").click(function(){
	window.location.href = 'saved-forms.php';
});
});
</script>


    <!-- accordian script ends-->
</body>

</html>
