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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <link rel="stylesheet/less" type="text/css" href="main.less" />
    <script src="https://cdn.jsdelivr.net/npm/less"></script>

</head>

<body>
    <?php include '/opt/src/CVille4Rent/components/navbar.php'; ?>

    <h1>CVille 4 Rent</h1>
    <div class="base-container">
        <!-- instructions and search bar -->
        <span>
            <i>Click an apartment to view more information or Search by name</i>
            <form class="d-flex" role="search" method="POST" action="?command=search">
                <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-secondary" type="submit">Search</button>
            </form>
        </span>

        <!-- listing of apartments -->
        <div class="list-group list-group-flush" aria-label="list">
            <?php foreach ($apartments as $apartment): ?>
                <a href="?command=apartment&name=<?= $apartment['name'] ?>" class="list-group-item list-group-item-action">
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

        <!-- will navigate to paginated results of apartments -->
        <?php if (count($apartments) >= 3): ?>
            <nav aria-label="pagination">
                <ul class="pagination justify-content-center">
                    <?php
                    $perPage = 3; // Number of items per page
                    $totalPages = ceil($aptCount / $perPage);

                    $prevDisabled = $page <= 1 ? 'disabled' : '';
                    $nextDisabled = $page >= $totalPages ? 'disabled' : '';
                    ?>
                    <li class="page-item <?= $prevDisabled ?>">
                        <form method="POST" action="?command=home">
                            <input type="hidden" name="page" value="<?= ($page - 1) ?>">
                        </form>
                        <button class="page-link">Previous</button>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($page == $i ? 'active' : '') ?>">
                            <form method="POST" action="?command=home">
                                <input type="hidden" name="page" value="<?= $i ?>">
                            </form>
                            <button class="page-link">
                                <?= $i ?>
                            </button>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $nextDisabled ?>">
                        <form method="POST" action="?command=home"><input type="hidden" name="page"
                                value="<?= ($page + 1) ?>">
                        </form>
                        <button class="page-link">Next</button>
                    </li>
                </ul>
            </nav>
            <script>
                var pagination = document.getElementsByClassName("pagination")[0];
                var forms = pagination.getElementsByTagName("form");
                var buttons = pagination.getElementsByClassName("page-link");
                for (var i = 0; i < buttons.length; i++) {
                    (function (index) {
                        buttons[index].addEventListener("click", function () {
                            forms[index].submit();
                        });
                    })(i);
                }
            </script>
        <?php endif; ?>
    </div>
</body>

</html>