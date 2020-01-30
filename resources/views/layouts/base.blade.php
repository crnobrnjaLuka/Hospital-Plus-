<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
    <header>
        <div class="grid-container">
            <div class="logo">
                <img src="images/logo.png" alt="logo">
            </div>
            <div class="log-out">
                <span><img src="images/user.png" alt="">Username<a href="#">Logout</a></span>
            </div>
        </div>
    </header>
    <section>
        
    @yield('content')
        
    </section>
    <aside>
        <div class="grid-menu">
            <div class="menu">
                <ul>
                    <li><a href="#">Korisnici</a></li>
                    <li><a href="/pacijenti">Pacijenti</a></li>
                    <li><a href="#">Kartoni</a></li>
                    <li><a href="#">Bolesti</a></li>
                    <li><a href="#">Lekovi</a></li>
                    <li><a href="#">O aplikaciji</a></li>
                </ul>
            </div>
            <div class="aside-logo">
                <img src="images/logo.png"alt="logo">
            </div>
        </div>
        
    </aside>
    
    <footer>
        <div class="grid-info">
            <div class="info">
                <span class="icons">
                    <span>
                        <img src="images/clock.png" alt="radno vreme">00 - 24
                    </span>
                    <span>
                        <img src="images/location.png" alt="adresa">Savski Nasip 1
                    </span>
                    <span>
                        <img src="images/phone.png" alt="telefon">011 222 3333
                    </span>
                </span>
            </div>
        </div>
    </footer>
    
</body>
</html>