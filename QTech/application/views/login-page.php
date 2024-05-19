<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!doctype>
<html lang="en">

<head>
    <title>QTech | Login</title>
    <?php include 'head.php'; ?>
</head>

<body style="background-color: #f7f3f98c;">

    <!-- Header Start -->
    <?php include('header_before.php'); ?>
    <!--/ Header End -->


    <div class="container" style="margin-top: 120px;"></div>

    <script type="text/template" id="loginpage_template">

        <div class="row justify-content-center no-gutters">

            <!-- Login Form Start -->
            <div class="card card-login my-5 ">
                <div class="card-body p-0">

                    <div class="row m-0">

                        <div class="col pt-4 mt-3 pb-4 mb-3">
                            <div class="text-center">
                                <img class="pb-1" src="../../assets/images/logo/qtech-black.png" alt="" style="width: 3.5rem;">
                                <div class="card-title">Welcome Back..!</div>
                                <div class="card-title" style="font-size: 14px; margin-bottom: 45px;">Enter to get unlimited access..</div>
                            </div>
                            <form>
                                <p id="error_mes_log"></p>
                                <div class="form-input-label-group">
                                    <input type="text" class="form-control" placeholder="Username" required id="inputUsername" name="inputEmail">
                                </div>
                                <div class="form-input-label-group">
                                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="password">
                                </div>
                                <div class="text-center pt-4">
                                    <a href="#" id="forget-password" style="color: #32012F; font-size: 13px">Forgot your password?</a>
                                </div>
                                <hr class="w-50">
                                <button id="login_button" class="btn btn-block btn-qa-form" type="submit">Login</button>
                            </form> 
                        </div>

                        <div class="col col-xl-5">
                            <div class="card-image-overly-1">
                                <img src="../../assets/images/logo/background.png" alt="" style="width: 100%; height: 100%;">
                                <div class="card-image-overly">
                                    <div class="text-center pb-4" style="padding-left: 2.5rem; padding-right: 2.5rem;">
                                        <h2 class="text-white playfair pb-4" style="font-size: 30px">New here?</h2>
                                        <p class="text-white roboto pb-4" style="font-size: 12px">Find the best answer to your technical question, help others answer theirs</p>
                                        <a href="<?php echo site_url('user/signup_page'); ?>" class="btn btn-qa-form-side" type="submit">Sign up</a>
                                    </div>
                                </div>
                            </div> 
                        </div>

                    </div>

                </div>
            </div>
            <!--/ Login Form End -->
            
            
            <!-- Forget Password Form Start -->
            <div class="modal fade" data-backdrop="static" data-keyboard="false" id="forgetPasswordModel" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg modal-backdrop" role="document">
                    <div class="modal-content">
 
                        <div class="modal-body">

                            <div class="modal-title pb-2" id="passwordModalLabel">Reset Your Password</div>
                            
                            <div class="p-xl-4">
                                <form id="changePasswordForm">
                                    <div class="form-group pb-2">
                                        <label for="username">Username or Email</label>
                                        <input type="text" class="form-control" id="username" required>
                                    </div>
                                    <div class="form-group pb-2">
                                        <label for="newPassword">New Password</label>
                                        <input type="password" class="form-control" id="newPassword" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmPassword">Confirm Password</label>
                                        <input type="password" class="form-control" id="confirmPassword" required>
                                    </div>
                                </form>
                                <div class="text-right pt-4">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="forgetPasswordChange">Save changes</button>
                                </div>                              
                            </div>  

                        </div>
                        
                    </div>
                </div>
            </div>
            <!--/ Forget Password Form End -->

        </div>
        
    </script>

</body>

</html>