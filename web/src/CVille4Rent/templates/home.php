<!DOCTYPE html>
<html lang="en">

<head>
    <!-- url: https://cs4640.cs.virginia.edu/isf4rjk/CVille4Rent -->

    <!-- meta tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta name="author" content="Bella Felaco" />
    <meta name="description" content="Charlottesville Renter's Application" />
    <meta name="keywords" content="UVA Charlottesville Rent Renter Renting Apartment Apartments" />

    <!-- title -->
    <title>CVille 4 Rent: Home</title>

    <!-- styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap"></script>

    <link rel="stylesheet/less" type="text/css" href="styles/main.less" />
    <script src="https://cdn.jsdelivr.net/npm/less"></script>

</head>

<body>
    <?php include '/opt/src/CVille4Rent/components/navbar.php'; ?>
    <?php include '/opt/src/CVille4Rent/data/generateLists.php'; ?>

    <h1>CVille 4 Rent</h1>
    <div class="base-container">
        <!-- instructions and search bar -->
        <span>
            <i>Click an apartment to view more information or Search by name</i>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-secondary" type="submit">Search</button>
            </form>
        </span>

        <!-- listing of apartments -->
        <div class="list-group" aria-label="list">
            <?php foreach ($apartments as $apartment): ?>
                <div class="list-group-item">
                    <a href="?command=apartment&name=<?= $apartment["name"] ?>"
                        class="list-group-item list-group-item-action">
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
                </div>
            <?php endforeach; ?>
        </div>

        <!-- will navigate to paginated results of apartments -->
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
    </div>
</body>

</html>