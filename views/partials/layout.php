<?php include('header.php'); // Include the navbar 
?>

<main class="container mt-5">
    <?php
    // Dynamically render page-specific content
    if (isset($content)) {
        echo $content;
    } else {
        echo '<p>No content available.</p>';
    }
    ?>
</main>

<?php include('footer.php'); // Include the footer 
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>