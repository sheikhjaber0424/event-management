window.onload = function () {
  var alertMessage = document.getElementById("auto-dismiss-alert");
  if (alertMessage) {
    setTimeout(function () {
      alertMessage.classList.remove("show");
      alertMessage.classList.add("fade");

      setTimeout(function () {
        alertMessage.remove();
      }, 500);
    }, 3000);
  }
};

$("#registrationForm").submit(function (event) {
  event.preventDefault();

  $.ajax({
    url: "/events/confirmation",
    type: "POST",
    data: $(this).serialize(),
    dataType: "json",
    success: function (data) {
      if (data.success) {
        $("#registrationForm").hide();
        $("#back-event").hide();
        $("#register-header").hide();
        $("#successMessage").removeClass("d-none");
      } else {
        $("#alertContainer").html(
          `<div class="alert alert-danger">${data.message}</div>`
        );
      }
    },
    error: function (xhr, status, error) {
      console.error("Error:", error);
    },
  });
});
