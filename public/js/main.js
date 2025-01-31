window.onload = function () {
  var alertMessage = document.getElementById("auto-dismiss-alert");
  if (alertMessage) {
    // After 2 seconds, fade out and remove the alert from the DOM
    setTimeout(function () {
      alertMessage.classList.remove("show");
      alertMessage.classList.add("fade");

      // After the fade, remove the alert element from the DOM
      setTimeout(function () {
        alertMessage.remove();
      }, 500); // Wait for the fade-out transition to complete (Bootstrap's fade duration)
    }, 3000); // 2000 milliseconds = 2 seconds
  }
};
