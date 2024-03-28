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
        <div class="row">
            <div class="col-xs-12">
                <h1>Connections Game</h1>
            </div>
        </div>

        <!-- end game button -->
        <form action="?command=endGame" method="post" class="py-3">
            <button type="submit"
                class="btn <?= (count($_SESSION["curGame"]["words"]) !== 0) ? 'btn-danger' : 'btn-success' ?>">End
                Game</button>
        </form>

        <!-- feedback -->
        <div class="row">
            <div class="col-xs-12">
                <?= $message ?>
            </div>
        </div>

        <!-- game -->
        <?php if (count($_SESSION["curGame"]["words"]) !== 0): ?>
            <div class="row py-3">
                <div class="col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            Game
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php foreach ($game["words"] as $index => $word): ?>
                                    <div class="col-sm-3 p-1">
                                        <span class="badge bg-primary">
                                            <?= $index ?>
                                        </span>
                                        <?= $word ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- guesses -->
        <div class="row">
            <div class="col-xs-12 py-3">
                <?php if (isset($_SESSION['guesses']) && !empty($_SESSION['guesses'])): ?>
                    <h3>Guesses</h3>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($_SESSION["guesses"] as $guess): ?>
                            <li class="list-group-item">
                                <?= implode(", ", $guess) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <!-- guess input -->
        <div class="row">
            <?php if (count($_SESSION["curGame"]["words"]) !== 0): ?>
                <div class="col-xs-12">
                    <form action="?command=guess" method="post">
                        <input type="hidden" name="gameid" value="<?= $game["id"] ?>">

                        <div class="mb-3">
                            <i>Please input your guess as a space-separated list of numbers</i><br>
                            <label for="guess" class="form-label">Connections Guess: </label>
                            <input type="text" class="form-control" id="guess" name="guess">
                        </div>

                        <button type="submit" class="btn btn-primary">Guess</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>