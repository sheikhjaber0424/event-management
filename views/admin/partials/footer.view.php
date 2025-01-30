    <!-- FOOTER -->
    <script>
        // Toggle the sidebar visibility
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("active");
        }

        // Reset sidebar visibility on screen resize
        window.addEventListener("resize", function() {
            if (window.innerWidth > 768) {
                document.getElementById("sidebar").classList.remove("active");
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
    <!--END FOOTER -->