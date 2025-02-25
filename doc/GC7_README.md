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

10) [Chat V1: between 2 users](https://www.youtube.com/watch?v=huLSxcxFRl4&list=PLr0BjDocnuI1JdTA9aIj5LIM6wcYpvnbq&index=9) - 31' 2024

11) [Chat V2: Real Time Chat With Laravel Reverb - v2](https://www.youtube.com/watch?v=BEKiNgcBqJw) - 50'

<div style="text-align: center;">En cours:</div>


1) [Chat V3: Real Time Chat With Laravel Reverb - Laravel 11, Livewire 3 Volt, AlpineJS and TailwindCSS](https://www.youtube.com/watch?v=yLGCxxwiygc&pp=ygUIYWxwaW5lanM%3D) - 22'

2) [Chat V4: Laracon EU 2024 Reverb](https://www.youtube.com/watch?v=yrL5eCMpqtc) - 35' - Laravel Reverb for Real-Time Laravel

//2do doc AlpineJS

1) [Kanboard](https://www.youtube.com/playlist?list=PLgsruFcRiyk27mlSSi8GDQ6n687v3oACD) - 6 episodes 7 H - 2024


3) [Doc AlpineJS](https://alpinejs.dev/start-here)

### Livewire


1) [Découverte Livewire](https://www.youtube.com/watch?v=zPNdejemUtg) - 52' GA FR

<div style="text-align: center">En cours:</div>

1) [Série free](https://livewire.laravel.com/screencast/getting_started/installation) -  11 épisodes (Fait 7)

//2do doc Livewire

2) [Serie 16](https://www.youtube.com/watch?v=m10TZpWKAVI&list=PLkZU2rKh1mT-Gx1PhzO5Cj83ntdZRmcbo) - 16 épisodes 2023
   
3) [Super serie](https://www.youtube.com/watch?v=dz6_RFrJQlo&list=PLqDySLfPKRn71KGwiS3JGf9aAseh6Gghz) - Série - 64 épisodes 2024
   
4) [A kit of resources, and tuto too](https://github.com/livewire/awesome-tall-stack?tab=readme-ov-file) A kit of resources, and tuto too - GH 2022
   
5) [Laravel Livewire v3 Full Tutorial 2024](https://www.youtube.com/watch?v=2tOgn2HydKE) 4H20' - 2024

6) [Livewire Doc laravel](https://livewire.laravel.com/docs/)

### Volt

//2do doc volt


2) [Volt Doc laravel](https://livewire.laravel.com/docs/volt)

### Autres

1. [All LARACON](https://www.youtube.com/@LaraconEU) (8 videos - See 2024)
2. [17 méthodes pour optimiser les performances de Laravel](https://kinsta.com/fr/blog/methodes-optimisation-performances-laravel) - Article
3. 

[Resource de codes tailwind & AlpineJS](https://www.penguinui.com/components/table)

---

## Built

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
```
@section('styles')
    <style>
        {{ file_get_contents(resource_path('views/chemin/vers/votre/fichier.css')) }}
    </style>
@endsection
```
Note: Idem pour les scripts JS

---

//2see: Divers tutos

- https://www.youtube.com/@Tuto1902/playlists
- (8 séries LARAVEL - 1 VueJS)

- [JS décorer objet avec PROXY]( 
https://www.youtube.com/watch?v=ORQvQViO1v4&ab_channel=Grafikart.fr) - GA 2024 18'

- [10 meilleurs générateurs Synthèse vocale](https://www.codeur.com/blog/generateur-voix-ia/) - Article


https://www.youtube.com/watch?v=5MzhGQ8WL70&ab_channel=Algomius

2see: https://www.youtube.com/watch?v=-XXRlMn04Dk
(CSS 2024 - 12' - FR)


### Pour mémoire:

#### Commande pour avoir tous ces template de barre de pagination de Laravel:

```
php artisan vendor:publish --tag=laravel-pagination
```

Qques resources sympa:
https://www.hover.dev/components
