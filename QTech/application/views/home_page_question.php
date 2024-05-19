<div>
    <div class="home_question_box">

        <div class="home_question_title pb-2">
            <a href="#home/answerquestion/<%=questionid%>"><%=title%></a>
        </div>

        <p class="home_question_subtxt pb-3 mb-2"><%= question.slice(0, 200) %>...</p>

        <div class="all-tags" style="display: flex">
            <% tags.forEach(function(tag) { %>
            <div class="tags-cover mr-1">
                <p><%= tag %></p>
            </div>
            <% }); %>
            <p class="home_question_subtxt pl-3"><strong>rate:</strong> <%= rate %></p>
        </div>

    </div>
</div>