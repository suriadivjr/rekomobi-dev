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
if (isset($_POST['jenis'], $_POST['hargaMin'], $_POST['hargaMax'], $_POST['sortBy'])) {
    $jenis = $_POST['jenis'];
    $hargaMin = $_POST['hargaMin'];
    $hargaMax = $_POST['hargaMax'];
    $sortBy = $_POST['sortBy'];
    $recommend_results = recommend($jenis, $hargaMin, $hargaMax, $sortBy);
}
?>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-light bg-light static-top">
        <div class="container">
            <a class="navbar-brand" href="#!">Rekomobi</a>
            <a type="button" class="btn-primary" href="./index.php">Car Search</a>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead">
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="text-center text-white">
                        <!-- Page heading-->
                        <h1 class="mb-4">Rekomobi Car Recommendation</h1>
                        <h4 class="mb-5">You ask, We recommend.</h4>
                        <!-- Search form-->
                        <form method="POST" action="">
                            <h5 class="mb-2">Insert your preferred car type:</h5>
                            <div class="input-group input-group-lg">
                                <select class="form-control" id="sortOption" name="jenis">
                                    <option value="SUV" selected="<?php if ($jenis === 'SUV') echo 'selected' ?>">SUV</option>
                                    <option value="MPV" selected="<?php if ($jenis === 'MPV') echo 'selected' ?>">MPV</option>
                                    <option value="Commercial" selected="<?php if ($jenis === 'Commercial') echo 'selected' ?>">Commercial</option>
                                    <option value="Sport" selected="<?php if ($jenis === 'Sport') echo 'selected' ?>">Sport</option>
                                    <option value="Sedan" selected="<?php if ($jenis === 'Sedan') echo 'selected' ?>">Sedan</option>
                                    <option value="Hatchback" selected="<?php if ($jenis === 'Hatchback') echo 'selected' ?>">Hatchback</option>
                                </select>
                            </div><br>
                            <h5 class="mb-2">Insert your preferred car price range:</h5>
                            <div class="input-group input-group-lg">
                                <input value="<?php echo $hargaMin ?>" class="form-control" type="number" placeholder="Lowest Price" aria-label="Lowest Price" name="hargaMin" id="minPrice" required min="0" onchange="document.getElementById('maxPrice').min=parseInt(this.value)+1;" />
                                <input value="<?php echo $hargaMax ?>" class="form-control" type="number" placeholder="Highest Price" aria-label="Highest Price" name="hargaMax" id="maxPrice" required />
                            </div>
                            <br>
                            <h5 class="mb-2">Sort Options:</h5>
                            <div class="input-group input-group-lg">
                                <select class="form-control" id="sortOption" name="sortBy">
                                    <option value="harga-asc" selected="<?php if($sortBy === 'harga-asc') echo 'selected'?>">Lowest to Highest Price</option>
                                    <option value="harga-desc" selected="<?php if($sortBy === 'harga-desc') echo 'selected'?>">Highest to Lowest Price</option>
                                    <option value="rating-asc" selected="<?php if($sortBy === 'rating-asc') echo 'selected'?>">Lowest to Highest Rating</option>
                                    <option value="rating-desc" selected="<?php if($sortBy === 'rating-desc') echo 'selected'?>" >Highest to Lowest Rating</option>
                                </select>
                            </div>
                            <br>
                            <button class="btn btn-primary" id="button-submit" type="submit">Rekomobi
                                Recommendation</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Icons Grid-->
    <section class="features-icons bg-light text-center">
        <?php if (isset($jenis) && isset($hargaMin) && isset($hargaMax) && !empty((array) $recommend_results)) { ?>
            <h1 class="mb-5">Your recommendation results</h1>
        <?php } else if (isset($jenis) && empty((array) $recommend_results)) { ?>
            <h1 class="mb-5">No result found</h1>
        <?php } else { ?>
            <h1 class="mb-5">
                Your recommendation results will appear here...
            </h1>
        <?php } ?>
        <?php if (isset($recommend_results)) {
        ?>
            <?php foreach ($recommend_results as $recommend_result) { ?>
                <div class="car-card-container">
                    <div class="car-card">
                        <h3>
                            <?php echo $recommend_result->nama; ?>
                        </h3><br>
                        <p class="lead mb-0">
                            <?php echo $recommend_result->merek; ?>
                        </p><br>
                        <p class="lead mb-0">
                            <?php echo $recommend_result->harga; ?>
                        </p><br>
                        <p class="lead mb-0">
                            <?php echo $recommend_result->jenis; ?>
                        </p><br>
                        <p class="lead mb-0">
                            <?php echo $recommend_result->rating; ?>
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