<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP DASAR - F. Rama</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>

        <h1> Halo! Ini adalah contoh Login Page </h1>
        <img src="../assets/images/space.jpg" alt="space" class="center">
        <br>
        <form action="loginproc.php" method="POST" class="center">
            <label for="email" class="bold">Email</label> <br>
            <input type="email" name="email" placeholder="email anda">
            <br> <br>
            <label for="password" class="bold"> Password </label> <br>
            <input type="password" name="password" placeholder="Password anda">
            <br> <br>
            <button type="submit" class="btnlogin"> 
                LOGIN
            </button>
            <video width="250" height="240" controls autoplay>
                <source src="../assets/video/vid.mp4" type="video/mp4">
                Browser ini tidak support tag video
            </video>
        </form>
        <br>

</body>
</html>