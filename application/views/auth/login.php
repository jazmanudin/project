<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo base_url();?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo base_url();?>assets/css/app.min.css" rel="stylesheet" type="text/css" />

</head>

<body class="bg-primary bg-pattern" style="font-family:Roboto,HelveticaNeue,Arial,sans-serif;">

    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mb-4">
                        <a href="index.html" class="logo"><img src="<?php echo base_url(); ?>assets/images/logo-light.png" height="24" alt="logo"></a>
                        <h5 class="font-size-16 text-white-50 mb-4">Model Simulasi</h5>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-xl-5 col-sm-8">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="p-2">
                                <h5 class="mb-5 text-center">Sign in</h5>
                                <form class="" method="POST" autocomplete="off" action="<?php echo base_url(); ?>auth/login">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group form-group-custom mb-4">
                                                <input type="text" class="form-control" autofocus name="username" id="username" required>
                                                <label for="username">User Name</label>
                                            </div>

                                            <div class="form-group form-group-custom mb-4">
                                                <input type="password" class="form-control" name="password" id="userpassword" required>
                                                <label for="userpassword">Password</label>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="customControlInline">
                                                        <label class="custom-control-label" for="customControlInline">Remember me</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="text-md-right mt-3 mt-md-0">
                                                        <a href="auth-recoverpw.html" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <button class="btn btn-success btn-block waves-effect waves-light" name="submit" type="submit">Log In</button>
                                            </div>
                                            <div class="mt-4 text-center">
                                                <a href="auth-register.html" class="text-muted"><i class="mdi mdi-account-circle mr-1"></i> Create an account</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
    </div>
    <!-- end Account pages -->

    <!-- JAVASCRIPT -->
    <script src="<?php echo base_url(); ?>assets/libs/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/node-waves/waves.min.js"></script>

    <script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>

    <script src="<?php echo base_url(); ?>assets/js/app.js"></script>

</body>

</html>