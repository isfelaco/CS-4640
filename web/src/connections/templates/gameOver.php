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
        <h1>Game Over!</h1>

        <!-- display categories and their words -->
        <div class="row">
            <div class="col-xs-12 py-3">
                <h4>Categories</h4>
                <ul class="list-group list-group-horizontal-sm py-3">
                    <?php foreach ($game["categories"] as $categoryName => $categoryWords): ?>
                        <li class="list-group-item">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">
                                    <?= $categoryName ?>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($categoryWords as $word): ?>
                                        <li class="list-group-item">
                                            <?= $word ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- display the guesses -->
        <div class="row">
            <div class="col-xs-12 py-3">
                <?php if (isset($_SESSION["guesses"]) && !empty($_SESSION["guesses"])): ?>

                    <h4>Guesses</h4>
                    <ol class="list-group list-group-flush">
                        <?php foreach ($_SESSION["guesses"] as $guess): ?>
                            <li class="list-group-item">
                                <?= implode(", ", $guess["words"]) ?>
                                <?php
                                $numIncorrect = $guess["numIncorrect"];

                                if ($numIncorrect === 0) {
                                    $class = "badge bg-success";
                                } elseif ($numIncorrect === 1 || $numIncorrect === 2) {
                                    $class = "badge bg-warning";
                                } else {
                                    $class = "badge bg-danger";
                                }

                                echo "<span class=\"$class\">" . ($numIncorrect > 0 ? $numIncorrect : "Correct!") . "</span>";
                                ?>
                            <?php endforeach; ?>
                    </ol>
                <?php endif; ?>
            </div>
        </div>

        <!-- restart game or exit -->
        <div class="btn-group pt-3" role="group">
            <form action="?command=newGame" method="post">
                <button type="submit" class="btn btn-primary">Play Again</button>
            </form>

            <form action="?command=logout" method="post">
                <button type="submit" class="btn btn-secondary">Exit</button>
            </form>
        </div>
    </div>
</body>

</html>