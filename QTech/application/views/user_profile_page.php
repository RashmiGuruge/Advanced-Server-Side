<div>
    <div id="main-header-div"></div>

    <div class="container">

        <div class="main_page_title pb-5">User Profile</div>

        <div class="question_box user_detail">

            <div class="row p-lg-4">

                <div class="col pt-4 mt-3">
                    <div class="pb-4 mb-2">
                        <span>User Name &nbsp &nbsp &nbsp &nbsp </span>
                        <input type="text" value="<%=username%>" disabled id="editusername">
                    </div>
                    <div class="pb-4 mb-2">
                        <span class="pr-2">Display Name &nbsp </span>
                        <input type="text" value="<%=name%>" disabled id="editname">
                    </div>
                    <div class="pb-4 mb-2">
                        <span>Email &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp </span>
                        <input type="email" value="<%=email%>" disabled id="editemail">
                    </div>
                    <div class="d-flex">
                        <span class="pr-4">Occupation &nbsp &nbsp </span>
                        <select class="user-occupation" disabled id="editOccupation">
                            <option value="<%=occupation%>"><%=occupation%></option>
                            <option value="student">Student</option>
                            <option value="employee">Employee</option>
                        </select>
                    </div>
                    <div class="user_profile_btn">
                        <button type="button" class="btn btn-main-pages mr-4" id="edit_userdetails_btn">Edit User Details</button>
                        <button type="button" class="btn btn-main-pages" id="edit_userpassword_btn">Change Password</button>
                    </div>
                </div>

                <div class="col col-auto">
                    <div class="text-right">
                        <div class="user-image">
                            <% if (userimage != "") { %>
                            <img src="<%=userimage%>" alt="User Image">
                            <% } else { %>
                            <img src="../../assets/images/logo/user-image.png" alt="User Image">
                            <% } %>
                        </div>
                    </div>
                    <div class="text-center pt-5 mt-3">
                        <button type="button" class="btn btn-main-pages" id="edit_userchangedp_btn">Change Profile Picture</button>
                        <input type="file" id="upload_image_input" style="display: none;" accept="image/*">
                    </div>
                </div>

            </div>

        </div>

        <div class="main_page_title pt-5 pb-5">Question Count</div>

        <div class="question_box">

            <div class="row p-lg-4 align-items-center bar-style">
                <div class="col col-4">
                    <p>Answered Questions : <%= answerquestioncnt %></p>
                    <% let anscntstar = Math.floor(answerquestioncnt / 10); %>
                    <% if(anscntstar >= 1) { %>
                    <% for (let i = 0; i < anscntstar; i++) { %>
                    <i class="fa-solid fa-star" style="color: gold; font-size: 30px; font-weight: bold;"></i>
                    <% } %>
                    <% } %>
                </div>
                <div class="col">
                    <div class="progress">
                        <% let answerCnt = answerquestioncnt % 10; %>
                        <% for (let i = 0; i < answerCnt; i++) { %>
                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                        <% } %>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row p-lg-4 align-items-center bar-style">
                <div class="col col-4">
                    <p>Asked Questions: <%= askquestioncnt %></p>
                    <% let askcntstar = Math.floor(askquestioncnt / 10); %>
                    <% if(askcntstar >= 1) { %>
                    <% for (let i = 0; i < askcntstar; i++) { %>
                    <i class="fa-solid fa-star" style="color: gold; font-size: 30px; font-weight: bold;"></i>
                    <% } %>
                    <% } %>
                </div>
                <div class="col">
                    <div class="progress">
                        <% let askCnt = askquestioncnt % 10; %>
                        <% for (let i = 0; i < askCnt; i++) { %>
                        <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                        <% } %>
                    </div>
                </div>
            </div>

        </div>

        <!-- Change Password Form Start -->
        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-backdrop" role="document">
                <div class="modal-content">

                    <div class="modal-body">

                        <div class="modal-title pb-2" id="passwordModalLabel">Change Your Password</div>

                        <form class="p-xl-4" id="changePasswordForm">
                            <div class="form-group pb-2">
                                <label for="oldPassword">Enter Old Password</label>
                                <input type="password" class="form-control" id="oldPassword" required>
                            </div>
                            <div class="form-group pb-2">
                                <label for="newPassword">Enter New Password</label>
                                <input type="password" class="form-control" id="newPassword" required>
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirmPassword" required>
                            </div>
                        </form>
                        <div class="text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="submitPasswordChange">Save changes</button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!--/ Change Password Form End -->

    </div>
</div>