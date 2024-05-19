<div>
    <div id="main-header-div"></div>

    <div class="container">

        <div class="row align-items-center pb-5">
            <div class="col">
                <p class="poppins"><strong>Asked:</strong> <%= Qaddeddate %> </p>
            </div>
            <div class="col text-right">
                <a href="http://localhost/QTech/index.php/user/#home/askquestion" class="btn btn-main-pages" id="ask_question_btn">Ask Question</a>
            </div>
        </div>

        <div class="pb-5 mb-4">
            <div class="row">
                <div class="col col-auto">
                    <div class="side_box">
                        <div class="arrow-up" id="up-qviewcount" data-clicked="false">
                            <i class="fa-solid fa-angle-up"></i>
                        </div>
                        <p class="view-count pt-3 pb-3" id="question-view-count"><%=viewstatus%></p>
                        <div class="arrow-down" id="down-qviewcount" data-clicked="false">
                            <i class="fa-solid fa-angle-down"></i>
                        </div>
                        <% if (is_bookmark) { %>
                        <i class="fa-solid fa-bookmark add-to-bookmark" id="remove-bookmark"></i>
                        <% } else {%>
                        <i class="fa-regular fa-bookmark add-to-bookmark" id="add-bookmark"></i>
                        <% } %>
                    </div>
                </div>

                <div class="col">
                    <div class="home_question_title pb-4"><%= title %></div>
                    <p class="home_question_subtxt pb-2"><strong>Rate:</strong> <%= rate %> </p>

                    <div class="all-tags pb-3 mb-2" style="display: flex;">
                        <% tags.forEach(function(tag) { %>
                        <div class="tag-cover" style="margin-right: 10px">
                            <p class="mb-0"><%= tag %></p>
                        </div>
                        <% }); %>
                    </div>

                    <p><%= question %></p>
                    <p class="pb-3"><%= expectationQ %></p>
                    <% if (questionimage !== '') { %>
                    <img src="<%= questionimage %>" alt="Question Image" style="max-width: 40rem; max-height: 40rem;">
                    <% } %>
                </div>
            </div>
        </div>

        <div class="question_box" id="answer" style="display: none">
            <div class="top-answers" style="display: flex; justify-content: space-between; align-items: center;"></div>
        </div>

        <hr style="margin-top: 100px; margin-bottom: 100px;">

        <div class="">
            <p class="main_page_title pb-3">Your Answer</p>
            <div class="question_box">
                <textarea class="form-control" id="inputQuestionDetails" name="inputQuestionDetails" rows="10" required></textarea>
            </div>

            <div class="question_box">
                <p class="question_box_title">Upload Image</p>
                <p class="question_box_subtxt">Upload an image related to your Answer (optional)</p>
                <input type="file" class="form-control-file" id="answerImageUpload" name="answerImageUpload">
            </div>

            <div class="question_box">
                <p class="question_box_title pb-1">Rate Question</p>
                <select class="form-control" required id="questionrate">
                    <option value="" selected disabled>Rate for Question</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

            <div class="text-right pt-3">
                <button type="submit" id="submit_answer" class="btn btn-main-pages ans-subbtn">Post Your Answer</button>
            </div>

        </div>

    </div>
</div>