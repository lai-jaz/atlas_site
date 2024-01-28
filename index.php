<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatGPT PHP Chatbot</title>
</head>
<body>
    <h1>ChatGPT PHP Chatbot</h1>

    <!-- Chat Interface -->
    <div id="chat-container">
        <div id="chat"></div>
        <input type="text" id="user-input" placeholder="Type a message...">
        <button onclick="sendMessage()">Send</button>
    </div>

    <script>
        const chatContainer = document.getElementById('chat');
        const userInput = document.getElementById('user-input');

        function sendMessage() {
            const userMessage = userInput.value.trim();
            if (!userMessage) {
                return;
            }

            // Display user message in the chat
            displayMessage('You', userMessage);

            // Get ChatGPT response
            getChatGPTResponse(userMessage);

            // Clear user input
            userInput.value = '';
        }

        function getChatGPTResponse(userMessage) {
            // Make a request to the ChatGPT API
            const apiUrl = 'chatbot.php';
            
            const requestData = {
                message: userMessage
            };

            fetch(apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestData)
            })
            .then(response => response.json())
            .then(data => {
                const chatGPTResponse = data.message;
                displayMessage('ChatGPT', chatGPTResponse);
            })
            .catch(error => console.error('Error:', error));
        }

        function displayMessage(sender, message) {
            const messageElement = document.createElement('div');
            messageElement.innerHTML = `<strong>${sender}:</strong> ${message}`;
            chatContainer.appendChild(messageElement);
        }
    </script>
</body>
</html>
