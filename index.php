<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WEB page</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1>Вітаю на моєму сайті!</h1>
    <h3>Сайт був створений в рамках курсу WEB спеціальності "Комп'ютерна інженерія".</h3>
    <p>Автор: Свиридюк Д. В.<br>Група: КІ-49.<br>Варіант: 23.</p>
    <div id="ajaxContent"></div>
    <button id="loadButton" onclick="loadContent()">Завантажити більше інформації</button>
</div>

<div class="container">
    <h2>Залиште свій коментар або побажання</h2>
    <section>
        <form id="dataForm">
            <div class="form-group">
                <label for="name">Ім'я:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="age">Вік:</label>
                <input type="text" id="age" name="age" required>
            </div>

            <div class="form-group">
                <label for="response">Відгук:</label>
                <textarea id="response" name="response" required></textarea>
            </div>
            <div class="form-group" id="ratingOptions">
                <label>Рейтинг:</label>
                <label><input type="radio" id="rating1" name="rating" value="1" required> 1</label>
                <label><input type="radio" id="rating2" name="rating" value="2"> 2</label>
                <label><input type="radio" id="rating3" name="rating" value="3"> 3</label>
                <label><input type="radio" id="rating4" name="rating" value="4"> 4</label>
                <label><input type="radio" id="rating5" name="rating" value="5"> 5</label>
            </div>

            <div class="form-group">
                <button type="button" onclick="submitForm()">Відправити</button>
                <button type="button" onclick="loadComments()">Завантажити коментарі</button>
            </div>
        </form>
    </section>
</div>

<div id="commentsContainer">
    <!-- Коментарі  -->
</div>

<div id="systemMessage" class="system-message"></div>

<script>
//Завантаження контенту через AJAX
function loadContent() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "content.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("ajaxContent").innerHTML = xhr.responseText;
            document.getElementById("loadButton").style.display = "none";
        }
    };
    xhr.send();
}

//Відправлення форми через AJAX
function submitForm() {
    var name = document.getElementById('name').value;
    var age = document.getElementById('age').value;
    var response = document.getElementById('response').value;
    var rating = document.querySelector('input[name="rating"]:checked');

    if (name === '' || age === '' || response === '' || !rating) {
        showSystemMessage("Будь ласка, заповніть всі поля форми.");
        return false;
    }
    
    if (isNaN(age) || age < 0 || age >100) {
        showSystemMessage("Введіть вік у вигляді коректного числа.");
        return false; 
    }

    var xhr = new XMLHttpRequest();
    var formData = new FormData(document.getElementById('dataForm'));
    xhr.open("POST", "submit_data.php", true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            showSystemMessage("Форму успішно відправлено!");
            document.getElementById('name').value = '';
            document.getElementById('age').value = '';
            document.getElementById('response').value = '';
            document.querySelector('input[name="rating"]:checked').checked = false;
        }
    };
    xhr.send(formData);
    return false;
}


//системне повідомлення
function showSystemMessage(message) {
    var systemMessage = document.getElementById("systemMessage");
    systemMessage.innerText = message;
    systemMessage.style.display = "block";
    setTimeout(function() {
        systemMessage.style.display = "none";
    }, 3000);
}

//завантаження коментарів через AJAX
function loadComments() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "get_comments.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var comments = JSON.parse(xhr.responseText);
            if (comments.length === 0) {
                document.getElementById("commentsContainer").innerHTML = "";
                showSystemMessage("Поки що немає комнтарів...");
            } else {
                var html = "";
                comments.forEach(function(comment) {
                    html += "<div class='comment'>";
                    html += "<p><strong>Ім'я: </strong>" + comment.name + "</p>";
                    html += "<p><strong>Вік: </strong>" + comment.age + "</p>";
                    html += "<p><strong>Відгук: </strong>" + comment.response + "</p>";
                    html += "<p><strong>Рейтинг: </strong>" + comment.rating + "</p>";
                    html += "<p><strong>Дата: </strong>" + comment.date + "</p>";
                    html += "</div>";
                });
                document.getElementById("commentsContainer").innerHTML = html;
            }
        }
    };
    xhr.send();
}
</script>

</body>
</html>
