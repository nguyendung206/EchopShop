
    <style>
        #loading-UI {
        height: 15px;
        width: 15px;
        aspect-ratio: 1;
        border-radius: 50%;
        animation: loading 1s infinite linear alternate;
        margin: auto;
        display: none;
        }
        @keyframes loading {
            0%  {box-shadow: 20px 0 #000, -20px 0 #0002;background: #000 }
            33% {box-shadow: 20px 0 #000, -20px 0 #0002;background: #0002}
            66% {box-shadow: 20px 0 #0002,-20px 0 #000; background: #0002}
            100%{box-shadow: 20px 0 #0002,-20px 0 #000; background: #000 }
        }
    </style>
    <div id="loading-UI"></div>