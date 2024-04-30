$(document).ready(function () {
  // load apartments and pagination
  loadApartments(1);
  $(".pagination-button").on("click", function (event) {
    event.preventDefault();

    var page = $(this).data("page");
    loadApartments(page);
  });

  // control the login form
  var form = document.querySelectorAll(".needs-validation")[0];

  function checkValidity(command, callback) {
    var formData = new FormData(document.getElementById("login-form"));
    const user = {
      email: formData.get("email"),
      password: formData.get("password"),
    };

    $.post("?command=" + command, { user: user }, (res) => {
      if (res && res.message) {
        console.log(res);
        callback(res.message);
      }
    }).fail((xhr, status, error) => {
      console.log("AJAX request failed: ", status, error);
      console.log(xhr.responseText);
    });
  }

  form.addEventListener("submit", (event) => {
    event.preventDefault();

    var signInButton = document.getElementById("signin-button");

    var command = "signup";
    if (event.submitter === signInButton) command = "login";

    if (!form.checkValidity()) event.stopPropagation();

    checkValidity(command, (status) => {
      if (status !== "success") {
        var errorMsg = document.getElementById("error-message");
        errorMsg.style.display = "block";
        errorMsg.textContent = status;
      } else form.submit();
    });

    form.classList.add("was-validated");
  });
});

// make an async request to the backend to get the apartments
function loadApartments(page) {
  $.get("?command=home&page=" + page, (res) => {
    displayApartments(res);
  }).fail(function (xhr, status, error) {
    console.log("AJAX request failed: ", status, error);
    console.log(xhr.responseText);
  });
}

// render the apartments in the DOM
function displayApartments(apartments) {
  var apartmentList = $("#apartmentList");
  apartmentList.empty();

  if (apartments.length > 0) {
    $("#alert").css("display", "none");
    $("#apartmentList").css("display", "block");

    apartments.forEach((apartment) => {
      var apartmentItem = `
            <a href="?command=apartment&name=${
              apartment.name
            }" class="list-group-item list-group-item-action">
                <h4>${apartment.name}</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>Address:</b> ${
                      apartment.address || "N/A"
                    }</li>
                    <li class="list-group-item"><b>Rent:</b> ${
                      apartment.rent || "N/A"
                    }</li>
                    <li class="list-group-item"><b>Bedrooms:</b> ${
                      apartment.bedrooms || "N/A"
                    }</li>
                    <li class="list-group-item"><b>Bathrooms:</b> ${
                      apartment.bathrooms || "N/A"
                    }</li>
                    <li class="list-group-item"><b>Description:</b> ${
                      apartment.description || "N/A"
                    }</li>
                </ul>
            </a>
        `;
      apartmentList.append(apartmentItem);
    });
  } else {
    $("#alert").css("display", "block");
    $("#apartmentList").css("display", "none");
  }
}

// search for an apartment
function searchApartment(event) {
  event.preventDefault();

  var formData = new FormData(event.target);
  const search = formData.get("search");

  if (search !== "") {
    $.get("?command=search&search=" + search, (res) => {
      displayApartments(res);
    }).fail(function (xhr, status, error) {
      console.log("AJAX request failed: ", status, error);
      console.log(xhr.responseText);
    });
  } else loadApartments(1);
}

// submit a rating
function submitRating(event) {
  event.preventDefault();

  var formData = new FormData(event.target);
  const rating = {
    user_email: formData.get("user"),
    title: formData.get("title"),
    apartment_name: formData.get("apartment-name"),
    rent: formData.get("rent"),
    rate: formData.get("rating"),
    comment: formData.get("comment"),
  };

  $.post("?command=rate", { rating: rating }, (res) => {
    console.log(res);
    $("#rating-alert").css("display", "none");
  }).fail(function (xhr, status, error) {
    console.log("AJAX request failed: ", status, error);
    console.log(xhr.responseText);
    $("#rating-alert").css("display", "block");
  });
}

// favorite or un-favorite an apartment
function favoriteApartment(event) {
  event.preventDefault();

  var formData = new FormData(event.target);

  $.post(
    "?command=favorite",
    {
      apartment_name: formData.get("apartment_name"),
    },
    (res) => {
      var heartIcon = $("<i>", {
        id: "heart-icon",
        class: "bi bi-heart",
      });
      var favBtn = $("#favorite-btn");
      if (res !== "favorite") {
        $("#heart-icon").css("class", "bi bi-heart");
        $("#favorite-btn").text("Favorite Apartment");
      } else {
        $("#heart-icon").css("class", "bi bi-heart-fill");
        $("#favorite-btn").text("Un-Favorite Apartment");
      }
      favBtn.append(heartIcon);
    }
  ).fail(function (xhr, status, error) {
    console.log("AJAX request failed: ", status, error);
    console.log(xhr.responseText);
  });
}
