<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HTML DASAR - F. Rama</title>
    <link rel="stylesheet" href="../assets/css/product.css" />
  </head>
  <body>
    <h1>Halo! Ini adalah contoh Listing Produk</h1>
    <h2>Produk dibawah ini berasal dari data array php </h2>
    <div class="row">

    <?php 
        $products = array (
            array("../assets/images/lego.jpg", "Lego Biru", "Komponen lego biru"),
            array("../assets/images/lego2.jpg", "Action Figure Lego", "Action figure untuk pelengkap mainan lego"),
            array("../assets/images/lego3.jpg", "Komponen Lego", "Kumpulan komponen lego"),
            array("../assets/images/lego4.jpg", "Lego Starwars", "Lego dengan tema starwars"),
            array("../assets/images/lego5.jpg", "Lego Pink", "Komponen lego pink"),
            array("../assets/images/lego6.jpg", "Lego Kuning", "Komponen lego kuning"),
            array("../assets/images/lego7.jpg", "Lego Orange", "Komponen lego orange"),
            array("../assets/images/lego8.jpg", "Lego Hijau", "Komponen lego hijau")
        );

        for($i = 0; $i < count($products); $i++) {
                //echo $products[$i][$j];
                echo '<div class="column">';
                echo '<div class="card">';
                echo '<img src="'. $products[$i][0] .'" width="55%" alt="lego" />';
                echo '<h3>'. $products[$i][1] .'</h3><p>'.  $products[$i][2] .'</p>';
                echo '<a href="#">Lihat Produk</a> </div>';
                echo '</div>';
        }

    ?>

    </div>
  </body>
</html>
