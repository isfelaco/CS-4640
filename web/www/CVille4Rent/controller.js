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
}
