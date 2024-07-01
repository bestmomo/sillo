# Suivi formations

## Tutos

### TALL

//2do Complete TALL Stack Tuto

1) [FROM NOTHING TO PROD (Tailwind, Alpine, Laravel, Livewire & More)](https://www.youtube.com/watch?v=Ul3sfSDEt9U&pp=ygURYWxwaW5lanMgdnMgcmVhY3Q%3D) - 3h40 2024

### AlpineJS

1) [The Return of jQuery (Not really, just Alpine.js)](https://www.youtube.com/watch?v=9K2yeh8Ne5U&ab_channel=LearnWebCode) - 24' 2023 GB → Pets

2) [Apprenez les bases d’AlpineJS en 5 minutes](https://parfaitementweb.fr/cours/apprendre-alpine-js-en-5-minutes) - 5' - 2022 - FR

3) [Guide complet déb à expert (22' @ 2024 FR)](https://www.youtube.com/watch?v=YbTkdUNDsTU&ab_channel=AlinoCodes) - 22' 2024 FR

4) [Tutoriel JavaScript : Découvert d'Alpine.js](https://www.youtube.com/watch?v=BRCwRhAcLJA&t=208s) - 35' GA 2024 FR

5) [use API - Animal crossing database](https://www.youtube.com/watch?v=iBg6XNy2XWc) Série - 4 parts 2023

6) [Designing a customer dashboard interface with TailwindCSS and AlpineJS](https://www.youtube.com/watch?v=U4P3CLuFz0M&pp=ygUIYWxwaW5lanM%3D) 2' 2024 (Just show what he done with AlpineJs)

7) [CounterDown, Countdown template make with HTML, CSS, TailwindCSS & AlpineJS](https://www.youtube.com/watch?v=1nS5Zna60L0&pp=ygUIYWxwaW5lanM%3D) - 3' 2024 (Just a show)

8) [Serie](https://www.youtube.com/watch?v=Z_QQQdNopp4&list=PLr0BjDocnuI1JdTA9aIj5LIM6wcYpvnbq&ab_channel=CodewithBurt) Série 7 vidéos 2023-24

9) [Serie](https://www.youtube.com/watch?v=9RMJojxoJYc&list=PLKbhw6n2iYKhVSp9wAOPFcdD6EDlfDxQt&ab_channel=projectworld) - 9 épisodes 2024

<div style="text-align: center">En cours:</div>
   
//2do doc AlpineJS
1) [Chat between 2 users](https://www.youtube.com/watch?v=huLSxcxFRl4&list=PLr0BjDocnuI1JdTA9aIj5LIM6wcYpvnbq&index=9) - 31' 2024
   
2) [Laracon EU 2024)(https://www.youtube.com/watch?v=yrL5eCMpqtc) - 35'

3) [Doc AlpineJS](https://alpinejs.dev/start-here)

### Livewire


//2do doc Livewire

1) [Découverte Livewire](https://www.youtube.com/watch?v=zPNdejemUtg) - 52' GA FR

2) [Série free](https://livewire.laravel.com/screencast/getting_started/installation) -  11 épisodes (Fait 7)

3) [Serie 16](https://www.youtube.com/watch?v=m10TZpWKAVI&list=PLkZU2rKh1mT-Gx1PhzO5Cj83ntdZRmcbo) - 16 épisodes 2023
   
4) [Super serie](https://www.youtube.com/watch?v=dz6_RFrJQlo&list=PLqDySLfPKRn71KGwiS3JGf9aAseh6Gghz) - Série - 64 épisodes 2024
5) 
6) [A kit of resources, and tuto too](https://github.com/livewire/awesome-tall-stack?tab=readme-ov-file) A kit of resources, and tuto too - GH 2022
   
7) [Laravel Livewire v3 Full Tutorial 2024](https://www.youtube.com/watch?v=2tOgn2HydKE) 4H20' - 2024

8) [Livewire Doc laravel](https://livewire.laravel.com/docs/)

### Volt

//2do doc volt
1) [Real Time Chat With Laravel Reverb - Laravel 11, Livewire 3 Volt, AlpineJS and TailwindCSS](https://www.youtube.com/watch?v=yLGCxxwiygc&pp=ygUIYWxwaW5lanM%3D) - 22'

2) [Volt Doc laravel](https://livewire.laravel.com/docs/volt)

### Autres

1. [17 méthodes pour optimiser les performances de Laravel](https://kinsta.com/fr/blog/methodes-optimisation-performances-laravel) - Article

[Resource de codes tailwind & AlpineJS](https://www.penguinui.com/components/table)

---

## Built

//2do Build:

npm install laravel-mix --save-dev

Cela compilera votreFichier.css du répertoire resources/assets/css vers public/css.

Exécutez Laravel Mix pour compiler vos assets :
npm run dev

Ou utilisez npm run watch pour compiler automatiquement vos assets chaque fois que vous enregistrez un fichier.

Maintenant, vous pouvez utiliser la fonction asset() pour inclure votre fichier CSS dans votre vue Blade

SINON:
Dans le Layout:
<head>
    <!-- Autres balises head ici -->

    @yield('styles')
</head>

Dans la Vue:
@section('styles')
    <style>
        {{ file_get_contents(resource_path('views/chemin/vers/votre/fichier.css')) }}
    </style>
@endsection

