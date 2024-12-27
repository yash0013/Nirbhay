function sendResponse(response) {
    // Logic to handle predefined response
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "handle_response.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("response=" + response);

    xhr.onload = function() {
        if (xhr.status === 200) {
            // Handle response
            const data = JSON.parse(xhr.responseText);
            document.querySelector('.chat').innerHTML += `<div class="message hacker">${data.hacker_message}</div>`;
            // Update progress
            updateProgressBar(data.progress);
        }
    };
}

function updateProgressBar(percentage) {
    document.querySelector('.progress').style.width = percentage + '%';
}
function playSound(url) {
    const audio = new Audio(url);
    audio.play();
}

function sendResponse(response) {
    playSound('click-sound.mp3'); // Path to sound file
    // Existing response handling logic...
}
