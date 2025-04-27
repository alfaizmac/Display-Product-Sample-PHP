<?php
require_once 'db_connect.php';

$sql = "SELECT product_ID, product_img, product_name, product_description FROM product";
$result = sqlsrv_query($conn, $sql);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="margin">
        <div class="header">
            <h1 class="mainTitle">PRODUCTS SAMPLE</h1>
            <div class="searchBarContainer">
                <div class="searchBar">
                    <input type="text" id="searchBar" name="searchBar" placeholder="Search product..."
                        onkeyup="searchProducts()">
                </div>
            </div>
        </div>
        <div class="body">
            <?php while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)): ?>
                <div class="productContainer">
                    <div class="menu">
                        <span class="productName"><?php echo htmlspecialchars($row['product_name']); ?></span>
                        <div class="deleteBtm">
                            <form action="handler/deleteProduct.php" method="POST">
                                <button>
                                    <input type="hidden" name="id" value="<?php echo $row['product_ID']; ?>">
                                    <svg width="30" height="30" fill="#fff" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16 9v10H8V9h8Zm-1.5-6h-5l-1 1H5v2h14V4h-3.5l-1-1ZM18 7H6v12c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7Z">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="productImg">
                        <img src="handler/<?php echo htmlspecialchars($row['product_img']); ?>" alt="">
                    </div>

                    <div class="rate">
                        <span>Rating:</span>
                        <div class="star-rating">
                            <input type="radio" id="star5" name="rating" value="5"><label for="star5">★</label>
                            <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
                            <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
                            <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
                            <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
                        </div>
                    </div>
                    <div class="productDetail">
                        <span><?php echo htmlspecialchars($row['product_description']); ?></span>
                    </div>
                </div>
                <div class="addProduct">
                    <button onclick="openModal()">
                        <svg width="45" height="45" fill="#fff" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2Z"></path>
                        </svg>
                    </button>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <div id="modalOverlay" class="modal-overlay" style="display: none;">
        <div class="modal-content" id="modalContent">
            <button class="close-modal" onclick="closeModal()">×</button>
            <div id="modalBody"></div>
        </div>
    </div>

    <script>
        function openModal() {
            const modal = document.getElementById("modalOverlay");
            const modalBody = document.getElementById("modalBody");

            modal.style.display = "flex";

            // Load the modal content
            fetch("addProductModal.php")
                .then(response => response.text())
                .then(data => {
                    modalBody.innerHTML = data;
                    // Initialize the image upload after content loads
                    initImageUpload();
                });
        }

        function closeModal() {
            document.getElementById("modalOverlay").style.display = "none";
            document.getElementById("modalBody").innerHTML = "";
        }

        function initImageUpload() {
            const uploadBtn = document.getElementById('upload-profile-btn');
            const fileInput = document.getElementById('Profile_Image_Path');
            const profilePic = document.getElementById('profile-picture');

            if (uploadBtn && fileInput && profilePic) {
                uploadBtn.addEventListener('click', function () {
                    fileInput.click();
                });

                fileInput.addEventListener('change', function (event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            profilePic.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        }

        function searchProducts() {
            // Get the search query and all product names
            var query = document.getElementById('searchBar').value.toLowerCase();
            var products = document.querySelectorAll('.productContainer');

            // Loop through all the product containers
            products.forEach(function (product) {
                // Get the product name
                var productName = product.querySelector('.productName').textContent.toLowerCase();

                // Show or hide the product based on the search query
                if (productName.includes(query)) {
                    product.style.display = 'block'; // Show the product if it matches the search query
                } else {
                    product.style.display = 'none'; // Hide the product if it doesn't match
                }
            });
        }
    </script>
    <style>
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        .modal-content {
            border-radius: 8px;
            padding: 20px;
            width: auto;
            max-width: 90%;
            position: relative;
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 25px;
            font-size: 34px;
            background: none;
            border: none;
            cursor: pointer;
            color: #fff;
        }
    </style>
</body>

</html>