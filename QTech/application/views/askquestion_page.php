<div>
    <div id="main-header-div"></div>

    <div class="container">

        <div class="main_page_title pb-5">Ask a public question</div>

        <div class="main_questions_area">

            <div class="question_box">
                <p class="question_box_title mb-0">Title</p>
                <p class="question_box_subtxt">Be specific and imaging you're asking a question to another person</p>
                <input type="text" class="form-control" placeholder="Title of the question" required id="inputQuestionTitle" name="inputQuestionTitle">
            </div>

            <div class="question_box">
                <p class="question_box_title mb-0">What are the details of your problem?</p>
                <p class="question_box_subtxt">Introduce the problem and expand on what you put in the title. Minimum 20 characters</p>
                <textarea class="form-control" id="inputQuestionDetails" name="inputQuestionDetails" rows="10" required></textarea>
            </div>

            <div class="question_box">
                <p class="question_box_title mb-0">What did you try and what were you expecting?</p>
                <p class="question_box_subtxt">Describe what you tried, what you expected to happen, and what actually resulted. Minimum 20 Characters</p>
                <textarea class="form-control" id="inputQuestionExpectation" name="inputQuestionExpectation" rows="10" required></textarea>
            </div>

            <div class="question_box">
                <p class="question_box_title mb-0">Upload Image</p>
                <p class="question_box_subtxt">If you have upload an image related to your question</p>
                <input type="file" class="form-control-file" id="imageUpload" name="imageUpload">
            </div>

            <div class="question_box">
                <p class="question_box_title mb-0">Tags</p>
                <p class="question_box_subtxt">Add up tags to describe what your question is about</p>
                <input type="text" class="form-control" placeholder="e.g. (java, react, python, sql)" required id="inputQuestionTags" name="inputQuestionTags">
            </div>

            <div class="question_box">
                <p class="question_box_title mb-0">Category</p>
                <p class="question_box_subtxt">Select the category of your question</p>
                <select class="form-control" required id="questionCategory">
                    <option value="" selected disabled>Select category</option>
                    <option value="software">Software</option>
                    <option value="hardware">Hardware</option>
                    <option value="database">Data Science</option>
                    <option value="programming">Programming</option>
                    <option value="networking">Networking</option>
                    <option value="security">Security</option>
                    <option value="web-development">Web Development</option>
                    <option value="mobile-development">Mobile Development</option>
                    <option value="cloud-computing">Cloud Computing</option>
                    <option value="artificial-intelligence">Artificial Intelligence</option>
                    <option value="artificial-intelligence">Internet of Things (IoT)</option>
                    <option value="artificial-intelligence">Machine Learning</option>
                    <option value="artificial-intelligence">Blockchain</option>
                    <option value="artificial-intelligence">Robotics</option>
                    <option value="artificial-intelligence">Game Development</option>
                    <option value="artificial-intelligence">Natural Language Processing (NLP)</option>
                    <option value="artificial-intelligence">Virtual Reality (VR)</option>
                    <option value="artificial-intelligence">Cognitive Computing</option>
                </select>
            </div>

            <div class="text-right pt-5">
                <button type="submit" id="submit_question" class="btn btn-main-pages">Post Question</button>
            </div>

        </div>

    </div>

</div>