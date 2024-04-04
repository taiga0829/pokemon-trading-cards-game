<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Success Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css">
    <!-- Add your custom styles if needed -->
    <style>
    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
        margin: 0;
    }

    .success-message {
        margin-top: 20px;
        padding: 20px;
        background-color: #5cb85c;
        color: white;
        text-align: center;
    }

    #footer-page {
        background-color: #5D9CEC;
        padding: 20px;
        text-align: center;
        color: white;
        width: 100%;
        box-sizing: border-box;
        position: absolute;
        bottom: 0;
    }
    </style>
    <script>
    setTimeout(function() {
        window.location.href = "index.php";
    }, 2000); // 5000 milliseconds = 5 seconds
    </script>
</head>

<body>
    <div class="success-message">
        <h2 class="subtitle is-2">Submitted Successfully!</h2>
        <p>Your data has been processed successfully.</p>
    </div>
    <footer style="background-color: #5D9CEC;" id="footer-page">
        Ikemon | ELTE IK Webprogramming
    </footer>
</body>

</html>