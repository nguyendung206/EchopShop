<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        #loading-UI {
        height: 15px;
        width: 15px;
        aspect-ratio: 1;
        border-radius: 50%;
        animation: d5 1s infinite linear alternate;
        margin: auto;
        display: none;
        }
        @keyframes d5 {
            0%  {box-shadow: 20px 0 #000, -20px 0 #0002;background: #000 }
            33% {box-shadow: 20px 0 #000, -20px 0 #0002;background: #0002}
            66% {box-shadow: 20px 0 #0002,-20px 0 #000; background: #0002}
            100%{box-shadow: 20px 0 #0002,-20px 0 #000; background: #000 }
        }
    </style>
</head>
<body>
    <div id="loading-UI"></div>
</body>
</html>