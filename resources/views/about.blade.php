<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite(['resources/css/about.css'])
        <title>RecyShare</title>
    </head>

    <body>
        <!-- Site Header -->
        <header>
            <x-navbar currentPage="about" />
        </header>

        <!-- Main Page Content -->
        <main>
            <!-- Hero Section -->
            <section class="hero-about">
                <h1>Learn more about us</h1>
                <p>
                    We are a team of six students - Adrian, Gabija, Dorina, Aleksandra, Jakub and Tomass - currently
                    studying in our third semester at SDU Sønderborg in Denmark. As part of our Web Technologies project, we
                    created Recyshare, a platform designed to bring people together through food and creativity.
                </p>
                <p>
                    RecyShare makes it easy for users to discover, enjoy, and share recipes. Anyone can browse a variety of
                    dishes, and registered members can contribute their own ideas to inspire others. Our goal is to
                    encourage sharing, reduce food waste, and make cooking a more collaborative and enjoyable experience.
                </p>
                <p>
                    This project reflects our growing skills in web development and design, while also highlighting our
                    passion for building digital solutions that connect communities in meaningful ways.
                </p>

                <div class="logo">
                    <img src="{{ asset('assets/logos/recyshare-logo-no-text.png') }}" alt="">
                </div>
                <div class="text">Let's get cooking!</div>
            </section>

            <!-- Developer Team Section -->
            <section class="developers_circles">
                <h2>Meet our Developers!</h2>
                <div class="developer-row">
                    <article class="developer">
                        <img src="{{ asset('assets/developers/Gabija.jpg') }}" alt="Adrian">
                        <p>Adrian</p>
                    </article>
                    <article class="developer">
                        <img src="{{ asset('assets/developers/Gabija.jpg') }}" alt="Gabija">
                        <p>Gabija</p>
                    </article>
                    <article class="developer">
                        <img src="{{ asset('assets/developers/Gabija.jpg') }}" alt="Aleksandra">
                        <p>Aleksandra</p>
                    </article>
                    <article class="developer">
                        <img src="{{ asset('assets/developers/Gabija.jpg') }}" alt="Dorina">
                        <p>Dorina</p>
                    </article>
                    <article class="developer">
                        <img src="{{ asset('assets/developers/Gabija.jpg') }}" alt="Jakub">
                        <p>Jakub</p>
                    </article>
                    <article class="developer">
                        <img src="{{ asset('assets/developers/Gabija.jpg') }}" alt="Tomass">
                        <p>Tomass</p>
                    </article>
                </div>
            </section>
        </main>
    </body>
</html>