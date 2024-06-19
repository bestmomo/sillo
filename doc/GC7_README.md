# Suivi formations

## Tutos

### TALL

//2do Complete TALL Stack Tuto
1) https://www.youtube.com/watch?v=Ul3sfSDEt9U&pp=ygURYWxwaW5lanMgdnMgcmVhY3Q%3D - 3h40

### AlpineJS

En cours:

1) https://www.youtube.com/watch?v=9K2yeh8Ne5U&ab_channel=LearnWebCode
   
//2do doc AlpineJS
Intro 24' 2023 FR
1) https://www.youtube.com/watch?v=YbTkdUNDsTU&ab_channel=AlinoCodes
   Guide complet déb à expert (22' @ 2024 FR)
2) https://parfaitementweb.fr/cours/apprendre-alpine-js-en-5-minutes
3) https://www.youtube.com/watch?v=BRCwRhAcLJA&t=208s
    GA
4) https://www.youtube.com/watch?v=3fZXKS-g9s0&ab_channel=Jean-LucPetelot
   Redimensionner avec Livewire, AlpineJs et Laravel. Installation d'un nouveau Laravel 11 (10')
5) Designing a customer dashboard interface with TailwindCSS and AlpineJS (2 '): https://www.youtube.com/watch?v=U4P3CLuFz0M&pp=ygUIYWxwaW5lanM%3D
6) https://www.youtube.com/watch?v=iK7-hczgGfI&pp=ygUIYWxwaW5lanM%3D
    Redimensionner et recadrer une photo instantanément avec Livewire, AlpineJs et Laravel, Introduction (6')
7) https://www.youtube.com/watch?v=1nS5Zna60L0&pp=ygUIYWxwaW5lanM%3D
   CounterDown, Countdown template make with HTML, CSS, TailwindCSS & AlpineJS (3')
8)  https://www.youtube.com/watch?v=jxiTVryxono&pp=ygUIYWxwaW5lanM%3D
    Alpine js Search Box | Build Blog with Laravel, Livewire & Filament #7 (11')
9)  https://www.youtube.com/watch?v=dz6_RFrJQlo&list=PLqDySLfPKRn71KGwiS3JGf9aAseh6Gghz
    Infinite Scroll - 5'
10) https://www.youtube.com/watch?v=Z_QQQdNopp4&list=PLr0BjDocnuI1JdTA9aIj5LIM6wcYpvnbq&ab_channel=CodewithBurt
    Série 7 vidéos
11) https://www.youtube.com/watch?v=9RMJojxoJYc&list=PLKbhw6n2iYKhVSp9wAOPFcdD6EDlfDxQt&ab_channel=projectworld
    Série 9 épisodes
12) Doc AlpineJS: https://alpinejs.dev/start-here

### Livewire

//2do doc Livewire
1) https://www.youtube.com/watch?v=dz6_RFrJQlo&list=PLqDySLfPKRn71KGwiS3JGf9aAseh6Gghz
  Série - 64 épisodes
2) [Livewire Doc laravel](https://livewire.laravel.com/docs/)
3) https://livewire.laravel.com/screencast/getting_started/installation
    Série free: 11 épisodes (Fait 7)

### Volt

//2do doc volt
1) https://www.youtube.com/watch?v=yLGCxxwiygc&pp=ygUIYWxwaW5lanM%3D
    Real Time Chat With Laravel Reverb - Laravel 11, Livewire 3 Volt, AlpineJS and TailwindCSS (22')
2) [Volt Doc laravel](https://livewire.laravel.com/docs/volt)

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

