<!DOCTYPE html>
<html>
<head>
    <title>Embedded Website</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
    img[src*="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png"] {display: none;}

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            overflow: hidden;
        }

        .main-container {
            display: flex;
            height: 100vh;
        }
        
        .episode-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        /* Optional: Adjust button width to make them evenly distributed */
        .episode-button {
            width: 100%;
        }

        .player-section {
            flex: 3; /* 75% width for the player */
            position: relative;
            background-color: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        @media screen and (max-width: 768px) {
        .main-container {
            flex-direction: column;
        }

        .player-section {
            flex: 1;
            height: 50vh;
        }

        .buttons-section {
            flex: 1;
        }
    }

        iframe {
            width: 100%;
            height: 100%; /* Set the player height to occupy 100% of the screen height */
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }

        .episode-indicator {
            color: #fff;
            font-size: 16px;
            margin-top: 8px;
        }

        #fullscreen-button {
            font-size: 16px;
            padding: 8px 16px;
            background-color: #1a73e8;
            color: #fff;
            border: none;
            border-radius: 4px;
            margin-top: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #fullscreen-button:hover {
            background-color: #0f62c2;
        }

        .buttons-section {
            flex: 1; /* 25% width for the buttons section */
            overflow-y: auto;
            background-color: #0a0a0a;
            color: #fff;
            padding: 20px;
        }

        .episode-button {
            font-size: 16px;
            padding: 8px 16px;
            background-color: #f03e3e;
            color: #fff;
            border: none;
            border-radius: 4px;
            margin: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .episode-button:hover {
            background-color: #dc2f2f;
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 2s linear infinite;
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -20px;
            margin-left: -20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="player-section">
            <div id="video-container">
                <iframe id="video-iframe" src="https://player.anikatsu.me/?id=one-piece-episode-1" frameborder="0"></iframe>
                <div class="loader" id="loader"></div>
            </div>
            
        </div>
        <div class="buttons-section">
            <h1 class="text-3xl font-bold mt-6 mb-4"><div class="episode-indicator text-white">Currently Playing: <span id="current-episode">Episode 1</span>
            <button id="fullscreen-button" class="mt-2 ml-4" onclick="toggleFullscreen()">Fullscreen</button></div></h1>
            <!-- Add buttons for episodes 1 to 100 -->
            <div class="episode-list">
                <script>
                    var episodeList = document.querySelector('.episode-list');
                    for (var episode = 1; episode <= 1000; episode++) {
                        var button = document.createElement('button');
                        button.className = 'episode-button';
                        button.textContent = `Episode ${episode}`;
                        button.onclick = (function(episodeNumber) {
                            return function() {
                                changeEpisode(episodeNumber);
                            };
                        })(episode);
                        episodeList.appendChild(button);
                    }
                </script>
            </div>
        </div>
    </div>

    <script>
        function changeEpisode(episodeNumber) {
            var videoIframe = document.getElementById('video-iframe');
            var newSrc = `https://player.anikatsu.me/?id=one-piece-episode-${episodeNumber}`;
            videoIframe.src = newSrc;

            var episodeIndicator = document.getElementById('current-episode');
            episodeIndicator.textContent = `Episode ${episodeNumber}`;

            var loader = document.getElementById('loader');
            loader.style.display = 'block';

            setTimeout(function() {
                loader.style.display = 'none';
            }, 1000);
        }

        function toggleFullscreen() {
            var videoContainer = document.getElementById('video-container');
            if (videoContainer.requestFullscreen) {
                videoContainer.requestFullscreen();
            } else if (videoContainer.mozRequestFullScreen) {
                videoContainer.mozRequestFullScreen();
            } else if (videoContainer.webkitRequestFullscreen) {
                videoContainer.webkitRequestFullscreen();
            } else if (videoContainer.msRequestFullscreen) {
                videoContainer.msRequestFullscreen();
            }
        }
    </script>
</body>
</html>
