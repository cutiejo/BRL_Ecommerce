document.querySelector('.message-input button').addEventListener('click', function() {
    var messageText = document.querySelector('.message-input input').value;
    if (messageText.trim() !== '') {
        var messageBubble = document.createElement('div');
        messageBubble.classList.add('message-bubble');
        messageBubble.innerText = messageText;
        document.querySelector('.message-content').appendChild(messageBubble);
        document.querySelector('.message-input input').value = '';
    }
});
