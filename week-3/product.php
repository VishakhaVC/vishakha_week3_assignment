<?php
// Include the database connection file
include 'themepart/connection.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {

        $pro_id = $_POST['pro_id'];
        $pro_name = $_POST['pro_title'];
        $pro_image = $_POST['pro_image'];
        $pro_price = $_POST['pro_price'];
        $pro_qty = $_POST['pro_qty'];
        $pro_subtotal = $pro_price * $pro_qty;
        $user_id = $_POST['user_id'];

        $query = mysqli_query($connection, "INSERT INTO tbl_cart (pro_id, pro_name, pro_image, pro_price, pro_qty, pro_subtotal, user_id) 
    VALUES ('{$pro_id}','{$pro_name}','{$pro_image}','{$pro_price}','{$pro_qty}','{$pro_subtotal}','{$user_id}')");

        if ($query) {
            echo "<script>alert('Product added to cart successfully');</script>";
        } else {
            echo "<script>alert('Error adding product to cart');</script>";
        }
    }
}

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch product details from the database based on the product ID
    $query = "SELECT * FROM tbl_product WHERE product_id = '{$product_id}'";
    $result = $connection->query($query);

    // Check if the product is found
    if ($result->num_rows > 0) {
        // Fetch product details
        $product = $result->fetch_assoc();

        // Fetch feedback details from the database based on the product ID
        $feedbackQuery = "SELECT * FROM tbl_feedback WHERE product_id = '{$product_id}'";
        $feedbackResult = $connection->query($feedbackQuery);

        // Loop through each feedback record
        while ($feedback = $feedbackResult->fetch_assoc()) {

            ?>
            <!DOCTYPE html>
            <html class="no-js" lang="en">

            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <meta name="description" content="">
                <meta name="keywords" content="">
                <!-- Page Title -->
                <title>
                    <?php echo $product['product_name']; ?>
                </title>
                <!--Fevicon-->
                <link rel="icon" href="assets/img/icon/favicon.ico" type="image/x-icon" />
                <!-- Bootstrap css -->
                <link rel="stylesheet" href="assets/css/bootstrap.min.css">
                <!-- linear-icon -->
                <link rel="stylesheet" href="assets/css/font-awesome.min.css">
                <link rel="stylesheet" href="assets/css/linear-icon.css">
                <!-- all css plugins css -->
                <link rel="stylesheet" href="assets/css/plugins.css">
                <!-- default style -->
                <link rel="stylesheet" href="assets/css/default.css">
                <!-- Main Style css -->
                <link rel="stylesheet" href="assets/css/style.css">
                <!-- responsive css -->
                <link rel="stylesheet" href="assets/css/responsive.css">

                <!-- Modernizer JS -->
                <script src="assets/js/vendor/modernizr-3.5.0.min.js"></script>
            </head>

            <body>
                <?php
                include 'themepart/header.php';
                ?>


                <!-- product 1 wrapper start -->
                <div class="product-details-main-wrapper pb-50">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="product-large-slider mb-20">
                                    <div class="pro-large-img">
                                        <!-- <img src="assets/img/product/Asus laptop.jpg" alt="" /> -->
                                        <img src="<?php echo 'assets/img/product/' . $product['product_image']; ?>"
                                            alt="<?php echo ($product['product_name']); ?>" />
                                        <div class="img-view">
                                            <!-- <a class="img-popup" href="assets/img/product/Asus laptop.jpg"><i class="fa fa-search"></i></a> -->
                                            <a class="img-popup"
                                                href="<?php echo 'assets/img/product/' . $product['product_image']; ?>"><i
                                                    class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="product-details-inner">
                                    <div class="product-details-contentt">
                                        <div class="pro-details-name mb-10">
                                            <h3>
                                                <?php echo $product['product_name']; ?>
                                            </h3>
                                        </div>
                                        <div class="pro-details-review mb-20">
                                            <ul class="product-ratings ratting d-flex mt-2">
                                                <?php
                                                // Fetch feedback details from the database based on the product ID
                                                $feedbackQuery = "SELECT AVG(feedback_ratings) AS avg_rating FROM tbl_feedback WHERE product_id = '{$product_id}'";
                                                $feedbackResult = $connection->query($feedbackQuery);

                                                // Check if feedback records are found
                                                if ($feedbackResult->num_rows > 0) {
                                                    $feedback = $feedbackResult->fetch_assoc();
                                                    $avg_rating = $feedback['avg_rating'];

                                                    // Loop through each star (5 stars)
                                                    for ($i = 1; $i <= 5; $i++) {
                                                        // Determine whether to display a full star, half star, or empty star
                                                        if ($i <= floor($avg_rating)) {
                                                            echo '<li><i class="fa fa-star"></i></li>';
                                                        } elseif ($i - 0.5 <= $avg_rating) {
                                                            echo '<li><i class="fa fa-star-half"></i></li>';
                                                        } else {
                                                            echo '<li><i class="fa fa-star-o"></i></li>';
                                                        }
                                                    }
                                                } else {
                                                    echo 'No feedback available.';
                                                }

                                                ?>
                                                <li><i class="fa <?php echo $class; ?>"></i></li>
                                                <?php ?>
                                            </ul>
                                        </div>

                                        <div class="price-box mb-15">
                                            <!-- <span class="regular-price"><span class="special-price">£50.00</span></span> -->
                                            <h3><span class="price">&#8377;
                                                    <?php echo $product['product_price']; ?>
                                                </span></h3>
                                        </div>
                                        <div class="product-detail-sort-des pb-20">
                                            <p>
                                                <?php echo substr($product['product_details'], 0, ); ?>
                                            </p>
                                        </div>
                                        <div class="pro-details-list pt-20">
                                            <ul>
                                                <li><span>Product ID :</span>
                                                    <?php echo $product['product_id']; ?>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="pro-quantity-box mb-30">
                                            <div class="qty-boxx">
                                                <!-- <label>Quantity :</label>
                                                <input type="text" placeholder="0"> -->

                                                <form method="POST" id="form-data">
                                                    <div class="row">
                                                        <div class="col-sm-5">
                                                            <input class="form-control" type="hidden" name="pro_title"
                                                                value="<?php echo $product['product_name']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-5">
                                                            <input class="form-control" type="hidden" name="pro_image"
                                                                value="<?php echo $product['product_image']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-5">
                                                            <input class="pro_price form-control" type="hidden" name="pro_price"
                                                                value="<?php echo $product['product_price']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-5">
                                                            <input class="form-control" type="hidden" name="user_id"
                                                                value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-5">
                                                            <input class="form-control" type="hidden" name="pro_id"
                                                                value="<?php echo $product['product_id']; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="pro-quantity-box mb-30">
                                                        <div class="qty-boxx">
                                                            <div class="row">
                                                                <div class="col-sm-3 pt-20">
                                                                    <li><strong>Quantity:</strong>
                                                                        <select class="pro_qty form-control" name="pro_qty">
                                                                            <?php
                                                                            // Assuming $product['quantity'] contains the available stock/product quantity in database
                                                                            for ($i = 1; $i <= $product['product_quantity']; $i++) {
                                                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </li>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-5">
                                                                        <input class="subtotal_price form-control" type="hidden"
                                                                            name="pro_subtotal" value="">
                                                                    </div>
                                                                </div>

                                                                <button name="submit" type="submit" class="btn-cart">Add to
                                                                    cart</button>

                                                </form>

                                            </div>
                                        </div>
                                        <br>
                                        <div class="useful-links mb-20">
                                            
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- product 1 wrapper end -->

                <!-- product 1 reviews start -->
                <div class="product-details-reviews pb-30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="product-info mt-half">
                                    <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <button type="button" class="nav-link active" id="nav_desctiption" data-bs-toggle="pill"
                                                data-bs-target="#tab_description" role="tab" aria-controls="tab_description"
                                                aria-selected="true">Description</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="tab_description" role="tabpanel"
                                            aria-labelledby="nav_desctiption">
                                            <p>
                                                <?php echo $product['product_details']; ?>
                                            </p>
                                        </div>

                                        <?php
        }
        ?>
                                    </tbody>
                                    </table>
                                </div> <!-- end of customer-review -->

                            </div> <!-- end of product-review -->
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
            </div>
            <?php
    } else {
        echo 'Product not found.';
    }

    // Close the database connection
    $connection->close();
} else {
    echo 'Product ID not provided in the URL.';
}
?>
    <!--  Start related-product -->
    <!--  end related-product -->

    <!-- scroll to top -->
    <div class="scroll-top not-visible">
        <i class="fa fa-angle-up"></i>
    </div> <!-- /End Scroll to Top -->

    <?php
    include 'themepart/footer.php';
    ?>

    <!-- all js include here -->
    <script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/ajax-mail.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>