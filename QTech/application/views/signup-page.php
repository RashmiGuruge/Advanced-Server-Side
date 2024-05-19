<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!doctype>
<html lang="en">

<head>
    <title>QTech | Signup</title>
    <?php include 'head.php'; ?>
</head>

<body style="background-color: #f7f3f98c;">

    <!-- Header Start -->
    <?php include('header_before.php'); ?>
    <!--/ Header End -->


    <div class="container" style="margin-top: 120px;"></div>

    <script type="text/template" id="loginpage_template">

        <div class="row justify-content-center no-gutters">

            <!-- SignUp Form Start -->
            <div class="card card-signin my-5 ">
                <div class="card-body p-0">

                    <div class="row m-0">

                        <div class="col pt-4 mt-3 pb-4 mb-3">

                            <div class="text-center">
                                <img class="pb-1" src="../../assets/images/logo/qtech-black.png" alt="" style="width: 3.5rem;">
                                <div class="card-title">Welcome..!</div>
                                <div class="card-title" style="font-size: 14px; margin-bottom: 45px;">Join us today...</div>
                            </div>

                            <form>
                                <p id="error_mes_sign"></p>

                                <div class="container">
                                    <div class="form-input-label-group">
										<input type="text" class="form-control" placeholder="Enter Username" required autofocus id="regUsername">
									</div>
									<div class="form-input-label-group">
										<input type="text" class="form-control" placeholder="Enter Your Name" required autofocus id="regName">
									</div>
									<div class="form-input-label-group">
										<input type="email" class="form-control" placeholder="Enter Email" required autofocus id="regEmail">
									</div>
                                    <div class="form-input-label-group">
                                        <select class="form-control" required autofocus id="regOccupation">
											<option value="" selected disabled>Please select</option>
											<option value="student">Student</option>
											<option value="employee">Employee</option>
										</select>
									</div>
                                    <div class="form-input-label-group">
                                        <input type="password" id="regPassword" class="form-control" placeholder="Password" required name="password">
                                    </div>
                                    <button class="btn btn-qa-form btn-block " id="signup_button" style="margin-top: 50px" type="submit">Sign up</button>
                                </div>

                            </form> 

                        </div>

                        <div class="col col-xl-5">
                            <div class="card-image-overly-1">
                                <img src="../../assets/images/logo/background.png" alt="" style="width: 100%; height: 100%;">
                                <div class="card-image-overly">
                                    <div class="text-center pb-4" style="padding-left: 3rem; padding-right: 3rem;">
                                        <h2 class="text-white playfair pb-4" style="font-size: 30px">One of us?</h2>
                                        <p class="text-white roboto pb-4" style="font-size: 12px">If you already have an account, then log in.</p>
                                        <a href="<?php echo site_url('user/login_page'); ?>" class="btn btn-qa-form-side" type="submit">Log In</a>
                                    </div>
                                </div>
                            </div> 
                        </div>

                    </div>

                </div>
            </div>
            <!--/ ignUp Form End -->
            
        </div>
        
    </script>

</body>

</html>