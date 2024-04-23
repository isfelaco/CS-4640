$(document).ready(function () {
  var form = document.querySelectorAll(".needs-validation")[0];

  function checkValidity(command, callback) {
    var formData = new FormData(document.getElementById("login-form"));
    const email = formData.get("email");
    const password = formData.get("password");

    $.post(
      "?command=" + command,
      { email: email, password: password },
      function (res) {
        console.log(res);
        if (res && res.message) {
          callback(res.message);
        }
      }
    ).fail(function (xhr, status, error) {
      console.log("AJAX request failed: ", status, error);
      console.log(xhr.responseText);
    });
  }

  form.addEventListener("submit", function (event) {
    event.preventDefault();

    var signInButton = document.getElementById("signin-button");
    // var signUpButton = document.getElementById("signup-button");

    var command = "signup";
    if (event.submitter === signInButton) command = "login";

    console.log(command);

    if (!form.checkValidity()) event.stopPropagation();

    checkValidity(command, function (status) {
      if (status !== "success") {
        var errorMsg = document.getElementById("error-message");
        errorMsg.style.display = "block";
        errorMsg.textContent = status;
      } else form.submit();
    });

    form.classList.add("was-validated");
  });
});
