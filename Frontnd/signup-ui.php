<!DOCTYPE html>
<html lang="en">
<head>

	<!-- Basic Page Needs
	================================================== -->
	<meta charset="utf-8">
    <title>DCSHRM Signup </title>
    <meta name="description" content="">	
	<meta name="author" content="">

	<!-- Mobile Specific Metas
	================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Favicons
	================================================== -->
	<link rel="icon" href="img/favicon/favicon-32x32.png" type="image/x-icon" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/favicon/favicon-144x144.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/favicon/favicon-72x72.png">
	<link rel="apple-touch-icon-precomposed" href="img/favicon/favicon-54x54.png">
    
	
	<!-- CSS
	================================================== -->
	
	<!-- Bootstrap -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/custom.css">
    <!-- FontAwesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Animation -->
	<link rel="stylesheet" href="css/dropify.css">
</head>
	
<body>

	<section class="signup-page">
    
    <div class="container">
        
        <div class="row">
        
        <div class="col-sm-12">
            
            <div class="content-center">
            
            <div class="col-sm-9 col-md-6 col-xs-12">
                
                <div class="sp-wrapper">
                
                <div class="sp-logo text-center">
                    
                    <img src="images/logo-login.png">
                    
                    </div>
                    
                    <hr>
                    <form action="">
                        
                    <div class="sp-content">
                        
                       <div class="mb-20">
                        <span class="sp-title">Sign Up</span>
                        </div>
                        
                        <div class="sp-component">
                        <label>Company Name <span>*</span></label>
                        <input type="text" class="form-control">
                        </div>
                        
                        <div class="sp-component">
                        <label>Email <span>*</span></label>
                        <input type="email" class="form-control">
                        </div>
                        
                        <div class="row">
                        <div class="col-sm-6 col-md-6 col-xs-12">
                            <div class="sp-component">
                            <label>Password <span>*</span></label>
                            <input type="password" class="form-control">
                            </div>
                            </div>
                            
                            <div class="col-sm-6 col-md-6 col-xs-12">
                            <div class="sp-component">
                            <label>Confirm Password <span>*</span></label>
                            <input type="password" class="form-control">
                            </div>
                            </div>
                            
                            <div class="col-sm-6 col-md-6 col-xs-12">
                            <div class="sp-component">
                            <label>Contact Name</label>
                            <input type="text" class="form-control">
                            </div>
                            </div>
                            
                            <div class="col-sm-6 col-md-6 col-xs-12">
                            <div class="sp-component">
                            <label>Contact Number <span>*</span></label>
                            <input type="text" class="form-control">
                            </div>
                            </div>
                            
                            <div class="col-sm-6 col-md-6 col-xs-12">
                            <div class="sp-component select-icon">
                            <label>Company Size</label>
                            <select class="form-control">
                            <option value="">50</option>        
                            <option value="">100</option>
                            <option value="">150</option>
                            <option value="">200</option>        
                            <option value="">250</option>
                            <option value="">300</option>
                            <option value="">400</option>        
                            <option value="">500</option>
                            <option value="">Above</option>
                            </select>
                        </div>
                            </div>
                            
                            <div class="col-sm-6 col-md-6 col-xs-12">
                                <div class="sp-component">
                                <label class="">&nbsp;</label>
                                    <input type="file" id="input-file-now" class="dropify" />
                                        
                                    </div>
                            </div>
                            
                        
                        </div>
                        
                        <div class="row">
                        
                            <div class="col-sm-12 col-md-12 col-xs-12 text-right">
                            <div class="sp-component ">
                            <div class="mt-10">
                             <em class="">I already have an account</em>
                        <a class="sp-text-signin" href="javascript:void(0);">Sign In</a>
                            </div>
                       
                        </div>
                            </div>
                            
                            <div class="col-sm-6 col-md-6 col-xs-12 pull-right">
                            <div class="sp-component">
                            <div class="mt-15">
                        <button class="btn btn-danger sp-btn btn-block">
                            Sign Up
                            </button>
                            </div>
                        </div>
                            </div>
                        
                        </div>
                        
                        
                    
                    </div>
                        
                    </form>
                
                </div>
                
                </div>
            
            
            
            </div>
            
            
            
            </div>
        
        
        
        </div>
        
        </div>
    
    </section>
    
    <section class="bg-theme-section">
    
    </section>

	<!-- Javascript Files
	================================================== -->

	<!-- initialize jQuery Library -->
	<script type="text/javascript" src="js/jquery.js"></script>
	<!-- Bootstrap jQuery -->
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	
    

	 <!-- jQuery file upload -->
    <script src="js/dropify.js"></script>
    <script>
        $(document).ready(function () {
            // Basic
            $('.dropify').dropify();
            // Translated
            $('.dropify-fr').dropify({
                messages: {
                    default: 'Glissez-déposez un fichier ici ou cliquez'
                    , replace: 'Glissez-déposez un fichier ou cliquez pour remplacer'
                    , remove: 'Supprimer'
                    , error: 'Désolé, le fichier trop volumineux'
                }
            });
            // Used events
            var drEvent = $('#input-file-events').dropify();
            drEvent.on('dropify.beforeClear', function (event, element) {
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });
            drEvent.on('dropify.afterClear', function (event, element) {
                alert('File deleted');
            });
            drEvent.on('dropify.errors', function (event, element) {
                console.log('Has Errors');
            });
            var drDestroy = $('#input-file-to-destroy').dropify();
            drDestroy = drDestroy.data('dropify')
            $('#toggleDropify').on('click', function (e) {
                e.preventDefault();
                if (drDestroy.isDropified()) {
                    drDestroy.destroy();
                }
                else {
                    drDestroy.init();
                }
            })
        });
    </script>

</body>
</html>