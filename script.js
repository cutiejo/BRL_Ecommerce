async function loadMessages() {
    try {
        const response = await fetch('fetch_messages1.php'); // Ensure this points to the correct PHP file for System B
        const messages = await response.json();
        const messageBox = document.getElementById('message-box');
        messageBox.innerHTML = '';
        messages.forEach(message => {
            const messageWrapper = document.createElement('div');
            messageWrapper.classList.add('message-wrapper');
            if (message.system === 'B') {
                messageWrapper.classList.add('message-wrapper-right');
            } else {
                messageWrapper.classList.add('message-wrapper-left');
            }

            const timestampElement = document.createElement('div');
            timestampElement.classList.add('timestamp');
            timestampElement.textContent = message.created_at;

            const messageElement = document.createElement('div');
            messageElement.classList.add('message', 'message-blue'); // Apply the blue background for both systems
            messageElement.textContent = message.text;

            messageWrapper.appendChild(timestampElement);
            messageWrapper.appendChild(messageElement);
            messageBox.appendChild(messageWrapper);
        });
        messageBox.scrollTop = messageBox.scrollHeight; // Scroll to bottom after loading messages
    } catch (error) {
        console.error('Error:', error);
    }
}

async function sendMessage() {
    const input = document.getElementById('message-input');
    const message = input.value;
    if (message.trim() === '') return;

    const formData = new FormData();
    formData.append('text', message);
    formData.append('system', 'B'); // Specify the system sending the message (B for System B)

    try {
        const response = await fetch('send_message1.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        console.log(result);  // Add this line to check the response

        if (result.error) {
            console.error('Error:', result.error);
        } else {
            const messageBox = document.getElementById('message-box');
            const messageWrapper = document.createElement('div');
            messageWrapper.classList.add('message-wrapper', 'message-wrapper-right'); // Apply the right alignment for System B messages

            const timestampElement = document.createElement('div');
            timestampElement.classList.add('timestamp');
            timestampElement.textContent = result.created_at;

            const messageElement = document.createElement('div');
            messageElement.classList.add('message', 'message-blue'); // Apply the blue background for both systems
            messageElement.textContent = result.text;

            messageWrapper.appendChild(timestampElement);
            messageWrapper.appendChild(messageElement);
            messageBox.appendChild(messageWrapper);

            input.value = '';
            messageBox.scrollTop = messageBox.scrollHeight; // Scroll to bottom after sending a message
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

// Add event listener for Enter key press
document.getElementById('message-input').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        sendMessage();
    }
});

window.onload = loadMessages;
setInterval(loadMessages, 5000); // Refresh messages every 5 seconds
