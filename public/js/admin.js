function toggleSidebar() {
  document.getElementById("sidebar").classList.toggle("active");
}

window.addEventListener("resize", function () {
  if (window.innerWidth > 768) {
    document.getElementById("sidebar").classList.remove("active");
  }
});
