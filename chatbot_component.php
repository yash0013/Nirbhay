<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot Component</title>
    <style>
        /* Floating Button and Chatbot Style */
        .chatbot-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background-color: #007bff61;
            color: white;
            border: none;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            cursor: pointer;
        }
        .chatbot-container {
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 320px;
            max-height: 400px;
            display: none;
            flex-direction: column;
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        .chatbot-header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            border-bottom: 1px solid #0056b3;
        }
        .chatbot-body {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
            max-height: 300px;
        }
        .chatbot-footer {
            padding: 10px;
            border-top: 1px solid #ddd;
        }
        .chatbot-footer button {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <!-- Floating Chatbot Icon -->
    <button class="chatbot-button" onclick="toggleChatbot()">💬</button>

    <!-- Floating Chatbot -->
    <div class="chatbot-container" id="chatbotContainer">
        <div class="chatbot-header">Chatbot</div>
        <div class="chatbot-body" id="chatbotBody"></div>
        <div class="chatbot-footer" id="chatbotFooter"></div>
    </div>

    <script>
        let currentQuestionOffset = 0; // Track the current offset for questions
        let selectedCategoryId = 0; // Track the selected category ID

        function toggleChatbot() {
            const chatbot = document.getElementById('chatbotContainer');
            chatbot.style.display = chatbot.style.display === 'none' ? 'flex' : 'none';
            if (chatbot.style.display === 'flex') {
                loadCategories(); // Load categories when the chatbot is opened
            }
        }

        function loadCategories() {
            const chatBody = document.getElementById('chatbotBody');
            const chatFooter = document.getElementById('chatbotFooter');

            fetch('chatbot.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'step=categories'
            })
            .then(response => response.json())
            .then(data => {
                chatBody.innerHTML = ''; // Clear previous messages
                chatFooter.innerHTML = ''; // Clear previous buttons

                // Display the bot question (prompt for user to select a category)
                const botPrompt = document.createElement('div');
                botPrompt.innerHTML = `Bot: <strong>${data.question}</strong>`;
                chatBody.appendChild(botPrompt);
                chatBody.scrollTop = chatBody.scrollHeight;

                // Create buttons for each available category
                data.options.forEach(option => {
                    const categoryButton = document.createElement('button');
                    categoryButton.textContent = option.text;
                    categoryButton.onclick = function() {
                        selectedCategoryId = option.id; // Set the selected category ID
                        currentQuestionOffset = 0; // Reset question offset
                        loadQuestions(selectedCategoryId); // Load questions for the selected category
                    };
                    chatFooter.appendChild(categoryButton);
                });
            })
            .catch(err => {
                console.error('Error:', err);
            });
        }

        function loadQuestions(categoryId) {
            const chatBody = document.getElementById('chatbotBody');
            const chatFooter = document.getElementById('chatbotFooter');

            fetch('chatbot.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `step=questions&categoryId=${categoryId}&offset=${currentQuestionOffset}`
            })
            .then(response => response.json())
            .then(data => {
                chatBody.innerHTML = ''; // Clear previous messages
                chatFooter.innerHTML = ''; // Clear previous buttons

                // Display the bot question (prompt for user to select a question)
                const botPrompt = document.createElement('div');
                botPrompt.innerHTML = `Bot: <strong>${data.question}</strong>`;
                chatBody.appendChild(botPrompt);
                chatBody.scrollTop = chatBody.scrollHeight;

                // Create buttons for each available question
                data.options.forEach(option => {
                    const questionButton = document.createElement('button');
                    questionButton.textContent = option.text;
                    questionButton.onclick = function() {
                        loadAnswer(option.id); // Load the answer for the selected question
                    };
                    chatFooter.appendChild(questionButton);
                });

                // Add "Load More" button if there are more questions
                if (data.hasMore) {
                    const loadMoreButton = document.createElement('button');
                    loadMoreButton.textContent = 'Load More Questions';
                    loadMoreButton.onclick = function() {
                        currentQuestionOffset += 5; // Increment offset
                        loadQuestions(categoryId); // Load next set of questions
                    };
                    chatFooter.appendChild(loadMoreButton);
                }
            })
            .catch(err => {
                console.error('Error:', err);
            });
        }

        function loadAnswer(questionId) {
            const chatBody = document.getElementById('chatbotBody');

            fetch('chatbot.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `step=answer&id=${questionId}`
            })
            .then(response => response.json())
            .then(data => {
                // Clear previous messages
                chatBody.innerHTML = '';

                // Display the bot's answer
                const botAnswer = document.createElement('div');
                botAnswer.innerHTML = `Bot: <strong>${data.answer}</strong>`;
                chatBody.appendChild(botAnswer);
                chatBody.scrollTop = chatBody.scrollHeight;

                // Add a button to go back to categories
                const backButton = document.createElement('button');
                backButton.textContent = 'Back to Categories';
                backButton.onclick = function() {
                    loadCategories(); // Go back to category selection
                };
                const chatFooter = document.getElementById('chatbotFooter');
                chatFooter.innerHTML = ''; // Clear previous buttons
                chatFooter.appendChild(backButton);
            })
            .catch(err => {
                console.error('Error:', err);
            });
        }
    </script>
</body>
</html>
