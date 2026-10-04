<!DOCTYPE html>
<html lang="en">
<head>
    <title>Spoken English Practice</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Interactive tool for practicing spoken English with text-to-speech and voice recording">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 600px;
            width: 100%;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 2em;
        }

        .subtitle {
            color: #7f8c8d;
            margin-bottom: 30px;
            font-size: 0.95em;
        }

        .section {
            margin-bottom: 30px;
        }

        .section h2 {
            color: #34495e;
            font-size: 1.3em;
            margin-bottom: 15px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
        }

        select, input {
            padding: 10px;
            font-size: 16px;
            border: 2px solid #ecf0f1;
            border-radius: 6px;
            width: 100%;
            margin-bottom: 10px;
            transition: border-color 0.3s;
        }

        select:focus, input:focus {
            outline: none;
            border-color: #667eea;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        button {
            padding: 12px 20px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            flex: 1;
            min-width: 120px;
        }

        .btn-primary {
            background-color: #667eea;
            color: white;
        }

        .btn-primary:hover:not(:disabled) {
            background-color: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background-color: #27ae60;
            color: white;
        }

        .btn-secondary:hover:not(:disabled) {
            background-color: #229954;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.4);
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }

        .btn-danger:hover:not(:disabled) {
            background-color: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.4);
        }

        button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        #output {
            margin-top: 15px;
            padding: 15px;
            background-color: #ecf0f1;
            border-left: 4px solid #667eea;
            border-radius: 6px;
            font-size: 1.1em;
            color: #2c3e50;
            display: none;
        }

        #output.show {
            display: block;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        audio {
            width: 100%;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .status {
            padding: 10px;
            border-radius: 6px;
            margin: 10px 0;
            display: none;
            font-weight: 500;
        }

        .status.success {
            display: block;
            background-color: #d5f4e6;
            color: #27ae60;
            border-left: 4px solid #27ae60;
        }

        .status.error {
            display: block;
            background-color: #fadbd8;
            color: #c0392b;
            border-left: 4px solid #c0392b;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 1.5em;
            }

            .action-buttons {
                flex-direction: column;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>🗣️ Spoken English Practice</h1>
    <p class="subtitle">Learn and practice English pronunciation with ease</p>

    <!-- Sentence Selection Section -->
    <div class="section">
        <h2>📖 Select a Sentence</h2>
        <form id="sentenceForm" method="post">
            <label for="sentence">Choose a sentence to practice:</label>
            <select id="sentence" name="sentence" required>
                <option value="">-- Select a sentence --</option>
                <option value="Hello! How are you?">Hello! How are you?</option>
                <option value="My name is John.">My name is John.</option>
                <option value="I would like a cup of tea.">I would like a cup of tea.</option>
                <option value="Can you help me, please?">Can you help me, please?</option>
                <option value="I am learning English.">I am learning English.</option>
            </select>
            <div class="action-buttons">
                <button type="submit" class="btn-primary">📤 Show Sentence</button>
            </div>
        </form>

        <div id="output"></div>
        <button id="listenBtn" class="btn-secondary" style="display: none; width: 100%;">🔊 Listen to Sentence</button>
    </div>

    <!-- Voice Recording Section -->
    <div class="section">
        <h2>🎤 Record Your Voice</h2>
        <p style="color: #7f8c8d; margin-bottom: 15px; font-size: 0.9em;">Record yourself speaking to practice pronunciation</p>
        
        <div class="action-buttons">
            <button id="startBtn" class="btn-secondary">⏺️ Start Recording</button>
            <button id="stopBtn" class="btn-danger" disabled>⏹️ Stop Recording</button>
        </div>

        <div id="recordingStatus" class="status"></div>
        <audio id="audioPlayback" controls style="display: none;"></audio>
    </div>
</div>

<script>
    // ===== Configuration =====
    const MIME_TYPE = 'audio/webm';
    const SENTENCES = {
        'Hello! How are you?': 'Hello! How are you?',
        'My name is John.': 'My name is John.',
        'I would like a cup of tea.': 'I would like a cup of tea.',
        'Can you help me, please?': 'Can you help me, please?',
        'I am learning English.': 'I am learning English.'
    };

    // ===== DOM Elements =====
    const sentenceForm = document.getElementById('sentenceForm');
    const sentenceSelect = document.getElementById('sentence');
    const outputDiv = document.getElementById('output');
    const listenBtn = document.getElementById('listenBtn');
    const startBtn = document.getElementById('startBtn');
    const stopBtn = document.getElementById('stopBtn');
    const audioPlayback = document.getElementById('audioPlayback');
    const recordingStatus = document.getElementById('recordingStatus');

    // ===== State =====
    let mediaRecorder;
    let audioChunks = [];
    let currentSentence = '';

    // ===== Utility Functions =====
    function showStatus(message, type = 'success') {
        recordingStatus.textContent = message;
        recordingStatus.className = `status ${type}`;
        setTimeout(() => {
            recordingStatus.className = 'status';
        }, 5000);
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // ===== Text-to-Speech =====
    function speakText(text) {
        if (!('speechSynthesis' in window)) {
            showStatus('Your browser does not support text-to-speech', 'error');
            return;
        }

        // Cancel any ongoing speech
        window.speechSynthesis.cancel();

        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'en-US';
        utterance.rate = 0.9;
        utterance.pitch = 1;

        utterance.onstart = () => {
            listenBtn.textContent = '🔊 Playing... (Click to stop)';
            listenBtn.disabled = true;
        };

        utterance.onend = () => {
            listenBtn.textContent = '🔊 Listen to Sentence';
            listenBtn.disabled = false;
        };

        utterance.onerror = (event) => {
            showStatus('Error playing audio: ' + event.error, 'error');
            listenBtn.textContent = '🔊 Listen to Sentence';
            listenBtn.disabled = false;
        };

        window.speechSynthesis.speak(utterance);
    }

    // ===== Form Handling =====
    sentenceForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const sentence = sentenceSelect.value.trim();
        if (!sentence) {
            showStatus('Please select a sentence', 'error');
            return;
        }

        currentSentence = sentence;
        outputDiv.innerHTML = `📖 <strong>Sentence:</strong> ${escapeHtml(sentence)}`;
        outputDiv.classList.add('show');
        listenBtn.style.display = 'block';
        listenBtn.textContent = '🔊 Listen to Sentence';
        listenBtn.disabled = false;
    });

    listenBtn.addEventListener('click', () => {
        if (window.speechSynthesis.speaking) {
            window.speechSynthesis.cancel();
            listenBtn.textContent = '🔊 Listen to Sentence';
            listenBtn.disabled = false;
        } else {
            speakText(currentSentence);
        }
    });

    // ===== Voice Recording =====
    startBtn.addEventListener('click', async () => {
        try {
            startBtn.disabled = true;
            recordingStatus.className = 'status';

            const stream = await navigator.mediaDevices.getUserMedia({ 
                audio: {
                    echoCancellation: true,
                    noiseSuppression: true,
                    autoGainControl: true
                } 
            });

            mediaRecorder = new MediaRecorder(stream, { mimeType: MIME_TYPE });
            audioChunks = [];

            mediaRecorder.addEventListener('dataavailable', (event) => {
                audioChunks.push(event.data);
            });

            mediaRecorder.addEventListener('stop', () => {
                const audioBlob = new Blob(audioChunks, { type: MIME_TYPE });
                const audioUrl = URL.createObjectURL(audioBlob);
                audioPlayback.src = audioUrl;
                audioPlayback.style.display = 'block';
                showStatus('✓ Recording saved successfully', 'success');
            });

            mediaRecorder.addEventListener('error', (event) => {
                showStatus('Recording error: ' + event.error, 'error');
            });

            mediaRecorder.start();
            showStatus('🔴 Recording in progress...', 'success');
            stopBtn.disabled = false;
        } catch (error) {
            showStatus('Microphone access denied. Please allow permission.', 'error');
            startBtn.disabled = false;
        }
    });

    stopBtn.addEventListener('click', () => {
        if (mediaRecorder && mediaRecorder.state !== 'inactive') {
            mediaRecorder.stop();
            mediaRecorder.stream.getTracks().forEach(track => track.stop());
            stopBtn.disabled = true;
            startBtn.disabled = false;
        }
    });

    // ===== Browser Support Check =====
    window.addEventListener('load', () => {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            startBtn.disabled = true;
            showStatus('Your browser does not support audio recording', 'error');
        }
    });
</script>

</body>
</html>
