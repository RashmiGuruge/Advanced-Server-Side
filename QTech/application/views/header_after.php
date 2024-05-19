<!-- Header Start -->
<div>
    <div class="header fixed-top header w-100" style="background-color: #32012F;">

        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">

                <div class="align-items-center justify-content-between row w-100">

                    <div class="col-auto">
                        <a href="#">
                            <img src="../../assets/images/logo/qtech-logo-white.png" alt="" style="width: 10rem;">
                        </a>
                    </div>

                    <div class="col-auto">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link pr-lg-4 pl-lg-5" href="#" aria-current="page">Home</a>
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

                    <div class="col-auto">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="mr-lg-5 ml-lg-5">
                                    <a href="#home/bookmark/<%=user_id%>">
                                        <i class="fa fa-bookmark" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#home/user/<%=user_id%>">
                                        <i class="fa-solid fa-user"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-auto pr-0">
                        <a href="#logout" class="btn my-sm-0 mr-2 header-btn">Logout</a>
                    </div>

                </div>

            </div>
        </nav>

    </div>
</div>
<!--/ Header End -->