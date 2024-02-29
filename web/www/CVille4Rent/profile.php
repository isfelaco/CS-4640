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
    <title>CVille 4 Rent: Profile</title>

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

    <h1>Profile</h1>

    <div class="base-container">
        <!-- user email address -->
        <div class="col-md-4">
            <label for="update-email" class="form-label">Email Address</label>
            <div id="update-email" class="input-group mb-3">
                <input type="text" class="form-control editable-input" placeholder="User" disabled>
                <span class="input-group-text">@</span>
                <input type="text" class="form-control editable-input" placeholder="Server" aria-label="Server" disabled>
            </div>
        </div>

        <!-- user password -->
        <div class="col-md-4">
            <label for="update-password" class="form-label">Password</label>
            <input id="update-password" type="text" class="form-control editable-input" placeholder="Password" disabled>
        </div>

        <button id="edit-button" class="btn btn-info" type="button" onclick="toggleInput()">Edit Profile</button>

        <a role="button" href="favorites.php" class="btn btn-light">View Favorite Apartments</a>
        <a role="button" href="ratings.php" class="btn btn-light">View Ratings</a>
    </div>

    <script>
        /* function to toggle the edit button + disable/enable inputs */
        function toggleInput() {
            var inputs = document.querySelectorAll('.editable-input');
            inputs.forEach(function(input) {
                input.disabled = !input.disabled;
                const button = document.getElementById("edit-button");
                if (!input.disabled) button.innerHTML = "Save Changes";
                else button.innerHTML = "Edit Profile";                
            });
        }
    </script>
  </body>
</html>
