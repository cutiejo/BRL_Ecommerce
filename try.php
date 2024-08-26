<?php
// Your sidebar-related PHP code goes here
?>

<!-- =============== Navigation ================ -->
<div class="container">
    <div class="navigation">
        <ul>
            <li>
                <a href="#" onclick="loadProductContent('products.php')">
                    <!-- ... (your navigation item content) ... -->
                    Products
                </a>
            </li>
            <!-- ... (other navigation items) ... -->
        </ul>
    </div>

    <!-- ... (rest of the HTML structure) ... -->
</div>

<script>
    // Function to load product content dynamically
    function loadProductContent(url) {
        var productContent = document.querySelector('.product-content');

        // Use AJAX to load content
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                productContent.innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }
</script>
