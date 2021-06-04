<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Rekomobi</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="./fe/assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css" />
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="./fe/css/styles.css" rel="stylesheet" />
</head>

<?php
require_once './query.php';
if (isset($_POST['keywords'], $_POST['sortBy'])) {
    $keywords = $_POST['keywords'];
    $sortBy = $_POST['sortBy'];
    $search_results = search($keywords, $sortBy);
}
?>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-light bg-light static-top">
        <div class="container">
            <a class="navbar-brand" href="#!">Rekomobi</a>
            <a class="btn-primary" href="./recommendation.php">Car Recommendation</a>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead">
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="text-center text-white">
                        <!-- Page heading-->
                        <h1 class="mb-5">Rekomobi Car Search</h1>
                        <!-- Search form-->
                        <form method="POST" action="">
                            <div class="input-group input-group-lg">
                                <input class="form-control" type="text" value="<?php if (isset($keywords)) echo $keywords;?>" placeholder="Enter your keyword here" aria-label="Enter your keyword here" aria-describedby="button-submit" name="keywords" />
                                <button class="btn btn-primary" id="button-submit" type="submit">Rekomobi
                                    Search</button>
                            </div><br>
                            <div class="input-group input-group-lg">
                                <select class="form-control" id="sortOption" name="sortBy">
                                    <option value="harga-asc" selected="<?php if($sortBy === 'harga-asc') echo 'selected'?>">Lowest to Highest Price</option>
                                    <option value="harga-desc" selected="<?php if($sortBy === 'harga-desc') echo 'selected'?>">Highest to Lowest Price</option>
                                    <option value="rating-asc" selected="<?php if($sortBy === 'rating-asc') echo 'selected'?>">Lowest to Highest Rating</option>
                                    <option value="rating-desc" selected="<?php if($sortBy === 'rating-desc') echo 'selected'?>" >Highest to Lowest Rating</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Icons Grid-->
    <section class="features-icons bg-light text-center">
        <?php if (isset($keywords) && !empty((array) $search_results)) { ?>
            <h1 class="mb-5">Results for "
                <?php echo $keywords; 
                    unset($keywords);?>
                "
            </h1>
        <?php } else if(isset($keywords) && empty((array) $search_results)) { ?>
            <h1 class="mb-5">No result found for "
                <?php echo $keywords;?>
                "
            </h1>
        <?php } else { ?>
            <h1 class="mb-5">
                Your search results will appear here...
            </h1>
        <?php } ?>
        <?php if (isset($search_results)) { 
            ?>
        <?php foreach ($search_results as $search_result) { ?>
            <div class="car-card-container">
                <div class="car-card">
                    <h3>
                        <?php echo $search_result->nama; ?>
                    </h3><br>
                    <p class="lead mb-0">
                        <?php echo $search_result->merek; ?>
                    </p><br>
                    <p class="lead mb-0">
                        <?php echo $search_result->harga; ?>
                    </p><br>
                    <p class="lead mb-0">
                        <?php echo $search_result->jenis; ?>
                    </p><br>
                    <p class="lead mb-0">
                        <?php echo $search_result->rating; ?>
                    </p><br>
                </div>
            </div>
        <?php } ?>
        <?php } ?>
    </section>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>