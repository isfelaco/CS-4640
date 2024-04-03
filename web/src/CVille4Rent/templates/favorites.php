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
    <?php include '/opt/src/CVille4Rent/components/navbar.php'; ?>

    <h1>Favorite Apartments</h1>

    <div class="base-container">
        <?php if (count($apartments) >= 0): ?>
            <i>Click an apartment to view more information</i>

            <!-- listing of all favorite apartments -->
            <div class="list-group" aria-label="list">
                <?php foreach ($apartments as $apartment): ?>
                    <a href="?command=apartment&name=<?= $apartment["name"] ?>" class="list-group-item list-group-item-action">
                        <h4>
                            <?= $apartment['name'] ?>
                        </h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><b>Address:</b>
                                <?= $apartment['address'] ?? 'N/A'; ?>
                            </li>
                            <li class="list-group-item"><b>Rent:</b>
                                <?= $apartment['rent'] ?? 'N/A'; ?>
                            </li>
                            <li class="list-group-item"><b>Bedrooms:</b>
                                <?= $apartment['bedrooms'] ?? 'N/A'; ?>
                            </li>
                            <li class="list-group-item"><b>Bathrooms:</b>
                                <?= $apartment['bathrooms'] ?? 'N/A'; ?>
                            </li>
                            <li class="list-group-item"><b>Description:</b>
                                <?= $apartment['description'] ?? 'N/A'; ?>
                            </li>
                        </ul>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-light" role="alert">
                You haven't "favorited" any apartments!
            </div>
        <?php endif; ?>
    </div>
</body>

</html>