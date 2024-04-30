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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"
        integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="controller.js"></script>

</head>

<body>
    <!-- <?php include '/opt/src/CVille4Rent/components/navbar.php'; ?> -->
    <?php include '/students/isf4rjk/students/isf4rjk/private_html/CVille4Rent/components/navbar.php'; ?>

    <h1>CVille 4 Rent</h1>
    <div class="base-container">
        <!-- instructions and search bar -->
        <span>
            <i>Click an apartment to view more information or Search by name</i>
            <form class="d-flex" role="search" onsubmit="searchApartment(event)" id="search-form">
                <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-secondary" type="submit">Search</button>
            </form>
        </span>

        <!-- listing of apartments -->
        <div class="list-group list-group-flush" aria-label="list" id="apartmentList"></div>
        <div class="alert alert-light" role="alert" style="display: none" id="alert">
            No apartments to show!
        </div>
        <!-- navigate to paginated results of apartments -->
        <nav aria-label="pagination">
            <ul class="pagination justify-content-center">
                <?php
                $perPage = 3; // Number of items per page
                $totalPages = ceil($aptCount / $perPage);
                for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item">
                        <button class="pagination-button page-link" data-page="<?= $i ?>"><?= $i ?></button>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</body>

</html>