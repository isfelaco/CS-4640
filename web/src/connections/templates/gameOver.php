<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="CS4640 Spring 2024">
    <meta name="description" content="Our Front-Controller Trivia Game">
    <title>Connections Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container" style="margin-top: 15px;">
        <h1>Game over!</h1>



        <!-- restart game or exit -->
        <div>
            <form action="?command=game" method="post">
                <button type="submit" class="btn btn-primary">Play Again</button>
            </form>

            <form action="?command=welcome" method="post">
                <button type="submit" class="btn btn-secondary">Exit</button>
            </form>
        </div>
    </div>
</body>

</html>