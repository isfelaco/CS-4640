<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- meta tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta name="author" content="Bella Felaco" />
    <meta name="description" content="Charlottesville Renter's Application" />
    <meta
      name="keywords"
      content="UVA Charlottesville Rent Renter Renting Apartment Apartments"
    />

    <!-- title -->
    <title>CVille 4 Rent: Apartment</title>

    <!-- styles -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap"></script>

    <link rel="stylesheet/less" type="text/css" href="styles/main.less" />
    <script src="https://cdn.jsdelivr.net/npm/less"></script>
  </head>
  <body>
    <?php include 'components/navbar.php'; ?>
    <?php include 'data/generateLists.php'; ?>
    <?php $name = $_GET['name']; ?>

    <h1><?php echo $name; ?></h1>

    <div class="base-container">
      <div class="list-group" aria-label="list">
        <?php
          $jsonString = file_get_contents('data/apartments.json');
          $apartments = json_decode($jsonString, true);
          foreach ($apartments as $apartment) {
              if ($apartment['name'] == $_GET['name']) {
                  $html = '<div class="list-group-item">';
                  $html .= '<ul class="list-group list-group-flush">';
                  $html .= '<li class="list-group-item"><b>Address:</b> ' . $apartment['address'] . '</li>';
                  $html .= '<li class="list-group-item"><b>Rent:</b> ' . $apartment['rent'] . '</li>';
                  $html .= '<li class="list-group-item"><b>Bedrooms:</b> ' . $apartment['bedrooms'] . '</li>';
                  $html .= '<li class="list-group-item"><b>Bathrooms:</b> ' . $apartment['bathrooms'] . '</li>';
                  $html .= '</ul>';
                  $html .= '</div>';
                  break;
              }
          }
          echo $html;
        ?>
      </div>
      <section>
        <h2>Ratings</h2>

        <div class="list-group" aria-label="list">
          <?php
            $jsonString = file_get_contents('data/ratings.json');
            $ratings = json_decode($jsonString, true);
            foreach ($ratings as $rating) {
              if ($rating['apartment']['name'] == $_GET['name']) {
                  $html = '<div class="list-group-item">';
                  $html .= '<h4>' . $rating['title'] . '</h4>';
                  $html .= '<ul class="list-group list-group-flush">';
                  $html .= '<li class="list-group-item"><b>Apartment Name:</b> ' . $rating['apartment']['name'] . '</li>';
                  $html .= '<li class="list-group-item"><b>Rent Paid:</b> ' . $rating['rentPaid'] . '</li>';
                  $html .= '<li class="list-group-item"><b>Rating:</b> ' . $rating['rating'] . '</li>';
                  $html .= '<li class="list-group-item"><b>Comment:</b> ' . $rating['comment'] . '</li>';
                  $html .= '</ul>';
                  $html .= '</div>';
                  break;
              }
            } 
            echo $html;
          ?>
        </div>
      </section>
    </div>
  </body>
</html>
