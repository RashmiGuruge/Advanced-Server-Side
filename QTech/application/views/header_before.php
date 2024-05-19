<!-- Header Start -->
<div>
    <div class="header fixed-top header top-0 w-100" style="background-color: #32012F;">

        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">

                <div class="align-items-center justify-content-between row w-100">

                    <div class="col-auto">
                        <a href="<?php echo site_url('user/login_page'); ?>">
                            <img src="../../assets/images/logo/qtech-logo-white.png" alt="" style="width: 10rem;">
                        </a>
                    </div>

                    <div class="col-auto">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link pr-lg-4 pl-lg-5" href="<?php echo site_url('user/login_page'); ?>">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link pl-lg-5" href="#">About</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-auto p-0">
                        <div class="d-flex justify-content-center align-items-center flex-grow-1">
                            <form class="form-inline my-2 my-lg-0">
                                <div class="search-btn">
                                    <input class="form-control" id="searchHome" type="search" placeholder="search...." aria-label="Search">
                                    <button class="btn btn-outline-success my-2 my-sm-0" id="homesearch" type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-auto pr-0">
                        <a href="<?php echo site_url('user/login_page'); ?>" id="login" class="btn my-sm-0 mr-2 header-btn">Login</a>
                        <a href="<?php echo site_url('user/signup_page'); ?>" id="signin" class="btn my-sm-0 header-btn">Signup</a>
                    </div>
                    
                </div>

            </div>
        </nav>

    </div>
</div>
<!--/ Header End -->