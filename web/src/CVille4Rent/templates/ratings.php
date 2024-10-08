<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta name="author" content="Bella Felaco" />
    <meta name="description" content="Charlottesville Renter's Application" />
    <meta name="keywords" content="UVA Charlottesville Rent Renter Renting Apartment Apartments" />

    <!-- title -->
    <title>CVille 4 Rent: Favorites</title>

    <!-- styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap"></script>

    <link rel="stylesheet/less" type="text/css" href="main.less" />
    <script src="https://cdn.jsdelivr.net/npm/less"></script>

</head>

<body>
    <!-- <?php include '/opt/src/CVille4Rent/components/navbar.php'; ?> -->
    <?php include '/students/isf4rjk/students/isf4rjk/private_html/CVille4Rent/components/navbar.php'; ?>

    <h1>My Ratings</h1>

    <div class="base-container">
        <!-- listing of all ratings by user -->
        <?php if (count($ratings) >= 3): ?>
            <div class="list-group" aria-label="list">
                <?php foreach ($ratings as $rating): ?>
                    <div class="list-group-item">
                        <h4>
                            <?= $rating['title'] ?>
                        </h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><b>Apartment Name: </b>
                                <?= $rating["apartment_name"] ?>
                            </li>
                            <li class="list-group-item"><b>Rent Paid: </b>
                                <?= $rating["rent_paid"] ?>
                            </li>
                            <li class="list-group-item"><b>Rating: </b>
                                <?= $rating["rating"] ?>
                            </li>
                            <li class="list-group-item"><b>Comment: </b>
                                <?= $rating["comment"] ?>
                            </li>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>

            <nav aria-label="pagination">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="">1</a></li>
                    <li class="page-item"><a class="page-link" href="">2</a></li>
                    <li class="page-item"><a class="page-link" href="">3</a></li>
                    <li class="page-item"><a class="page-link" href="">Next</a></li>
                </ul>
            </nav>
        <?php else: ?>
            <div class="alert alert-light" role="alert">
                You haven't left any ratings!
            </div>
        <?php endif; ?>
    </div>
</body>

</html>