---
markmap:
  duration: 2000
  initialExpandLevel: -1
---
# Mon CMS <!-- markmap: duration: 1000 -->
<-- Réf.: <https://laravel.sillo.org/posts/mon-cms-les-donnees> -->
<-- VSCode: Utiliser extention markmap -->

## Base <!-- markmap: fold -->

### 1 / Base Laravel <!-- markmap: fold -->

- *composer  create-project laravel/laravel moncms --prefer-dist*
- Paramètres .env file (APP_NAME, APP_URL & DB_DATABASE)
- Ajout Fr : *composer require --dev laravel-lang/common
  php artisan lang:update*

### 2 / Gestion des Models et Tables <!-- markmap: fold -->
  
- Tables: <!-- markmap: fold -->
  - Migration seule : *php artisan make:migration create_nnn_table*
  - Factory : *php artisan make:factory MmmFactory*
  - Seeders : *php artisan make:seeder MmmSeeder*
  - Penser à appeler les seeders dans database/seeders/DataBaseSeeder.php:
    *$this->call([
      Mmm1Seeder::class,
      Mmm2Seeder::class,
      etc...]);*
  - Puis les exécuter : *php artisan db:seed*
- Models + migration : <!-- markmap: fold -->
  - Migrations
    - *php artisan make:model Mmm --migration* ou
      *php artisan make:model Mmm -m*
    - *php artisan migrate* la 1ère fois
    - *php artisan migrate:refresh --seed* ensuite
  - Model (Mmm) :
    - *protected $timestamps = false;*
    - *protected $fillable = ['name', 'email', 'password', 'role', 'valid'];*
  - Relations :
    - 1:n :
      - (1) : Dans MmmN
        - *use Illuminate\Database\Eloquent\Relations\BelongsTo;*
        - *public function Mmm1(): BelongsTo {
        return $this->belongsTo(Mmm1::class);}*
      - (n) : Dans Mmm1
        - *use Illuminate\Database\Eloquent\Relations\HasMany;*
        - *public function MmmN(): HasMany {
        return $this->HasMany(MmmN::class);}*

### 3 / Divers <!-- markmap: fold -->

- helpers:

  - app/helpers.php (Y écrire les fonctions appelées souvent un peu n'importe où)
  - Dans composer.json :
    *"autoload": {
    "files": [
    "app/helpers.php"
    ],...},*
- *composer dumpautoload*

### Réf.: ***<https://laravel.sillo.org/posts/mon-cms-les-donnees>***

## Technos FrontEnd <!-- markmap: fold -->

### MaryUI <!-- markmap: fold -->

- *composer require robsontenorio/mary*
- *php artisan mary:install*
  - Doc MaryUI <https://mary-ui.com>

php artisan mary:install
→ 0 (livewire/Volt)
→ npm install --save-dev (npm)

### Volt <!-- markmap: fold -->

- Une vue Volt (Dans /route/web.php) :
*Volt::route('/*url*', 'dossier(s).fichier')->name('dossier.fichier');*
- Un nouveau composant Volt :
*php artisan make:volt dossier/fichier* --class
  - Class PHP
  - Template Blade
- À utiliser pour faire register / login / forgot-password
(En pensant aussi à faire les routes correspondantes)

### Référence: ***<https://laravel.sillo.org/posts/mon-cms-lauthentification>***

## FrontEnd <!-- markmap: fold -->

### index (HomePage) <!-- markmap: fold -->

#### Image

- *php artisan storage:link*
  (Lien symbolique de public/storage vers storage/app/public)

#### Référence: ***<https://laravel.sillo.org/posts/mon-cms-la-page-daccueil>***

### Les articles <!-- markmap: fold -->

#### posts/show

#### Dynamic Title/Description/Keywords (S.E.O.) <!-- markmap: fold -->

- **Layout:**
title :
*\<title>{{ (isset($title) ? $title . ' | ' :
(View::hasSection('title') ? View::getSection('title') . ' | ' :
 '')) . config('app.name') }}</title>
\<meta name="description" content="@yield('description')">
\<meta name="keywords" content="@yield('keywords')">*
- **Vue** (Blade):
@php
&nbsp;&nbsp;$title='TitrePage'
@endphp
ou :
@section('title', $post->seo_title ?? $post->title)
Et :
@section('description', $post->meta_description)
@section('keywords', $post->meta_keywords

#### Plugin prose de Tailwind <!-- markmap: fold -->

- *npm install -D @tailwindcss/typography*
- exports default {
&nbsp;&nbsp;...
&nbsp;&nbsp;plugins: [
&nbsp;&nbsp;&nbsp;&nbsp;plugins: [require("@tailwindcss/typography"), require("daisyui")],
&nbsp;&nbsp;],
}
- *\<div class="relative items-center w-full py-5 mx-auto prose md:px-12 max-w-7xl">*

#### Librairie prismjs <!-- markmap: fold -->

- Configure prism.css et prism.js : <https://prismjs.com/download.html>
- Poser dans layout:
...
\<head>
...
&nbsp;&nbsp;***\<link rel="stylesheet" href="{{ asset('storage/css/prism.css') }}">***
\</head>
\<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">
...
&nbsp;&nbsp;***\<script src="{{ asset('storage/scripts/prism.js') }}"></script>***
\</body>

#### Mode clair/sombre (MaryIU) <!-- markmap: fold -->

- tailwind.config.js :
*export default {
...
&nbsp;&nbsp;darkMode: 'class',
}*

- navigation/navbar.blade.php :
&nbsp;&nbsp;&nbsp;&nbsp;\<x-theme-toggle title="{{ __('Toggle theme') }}" class="w-4 h-8" />
&nbsp;&nbsp;</x-slot:actions>
\</x-nav>

- Doc MaryUI ***<https://mary-ui.com/docs/components/theme-toggle>***

#### Search bar <!-- markmap: fold -->

##### Composant search <!-- markmap: fold -->

    (PHP (La logique)

  ```bash
    use Livewire\Attributes\Validate;
    use Livewire\Volt\Component;
    
    new class() extends Component {
    
        #[Validate('required|string|max:100')]
        public string $search = '';
    
        public function save() {
        $data = $this->validate();
    
        return redirect('/search/' . $data['search']);
        }
    };
  ```
  
    HTML (Blade) pour La Vue)

  ```bash
    <div>
      <form wire:submit.prevent="save">
      <x-input placeholder="{{ __('Search') }}..." wire:model="search" clearable icon="o-magnifying-glass" />
      </form>
    </div>
  ```

##### Traduction nécessaire (**fr.json**) <!-- markmap: fold -->

- **"Search...": "Rechercher...",**

##### La route (route/web.php) <!-- markmap: fold -->

```bash
*Volt::route('/search/{param}', 'index')->name('posts.search');*
```

Particularité: Renvoie aussi sur la vue index

##### Ajouter dans app/Repositories/PostRepository.php <!-- markmap: fold -->

    La fonction qui inclue la chaîne du formulaire pour gérer la recherche :

  ```php
  public function search(string $search): LengthAwarePaginator {
      return $this->getBaseQuery()
        ->latest()
        ->where(function ($query) use ($search) {
        $query->where('title', 'like', "%{$search}%")
          ->orWhere('body', 'like', "%{$search}%");
        })
        ->paginate(config('app.pagination'));
    }
  ```

##### Composant index (Homepage (Page d'accueil)) <!-- markmap: fold -->

###### **Bloc PHP** : Quand on récupère les posts

    (function getPosts()), on déclenche le composant search
    si l'URI comporte un paramètre) :

```php
if (!empty($this->param)) {
    return $postRepository->search($this->param);
}
```

###### **Bloc Vue Blade** : S'il y a une recherche

    Alors, on affiche le titre de la page adapté :

```php
    @if ($category)
        <x-header title="{{ __('Posts for category ') }} {{ $category->title }}" size="text-2xl sm:text-3xl md:text-4xl" />
    @elseif($param !== '')
        <x-header title="{{ __('Posts for search ') }} '{{ $param }}'" size="text-2xl sm:text-3xl md:text-4xl" />
    @endif
```

    Traduction: 

```php
    "Posts for search ": "Articles pour la recherche ",
```

##### Vue HTML - navigation/navbar.php <!-- markmap: fold -->

```php
      <x-theme-toggle title="{{ __('Toggle theme') }}" class="w-4 h-8" />
      <livewire:search />
  </x-slot:actions>
</x-nav>
```

#### Référence: ***<https://laravel.sillo.org/posts/mon-cms-les-articles>***

### Les menus (Gérés par Backoffice) <!-- markmap: fold -->

#### Les données

##### Les tables + migrations + Models + seeders :
    Menu, Submenu, Footer

#### Composant frontend

##### Nouveauté : AppServiceProvider
    Comme appelé systématiquement 
```php
public function boot(): void
    {
        Facades\View::composer(['components.layouts.app'], function (View $view) {
			$view->with(
				'menus',
				Menu::with(['submenus' => function ($query) {
					$query->orderBy('order');
				}])->orderBy('order')->get()
			);
		});
    }
```

##### Dans layout

    layouts/app.blade.php

```php
<livewire:navigation.navbar :$menus />
...
<livewire:navigation.sidebar :$menus />
```

##### Barre de Navigation

###### navbar.blade.php <!-- markmap: fold -->
    Bloc PHP

```php
use Illuminate\Support\Collection;

new class extends Component {
    
    public Collection $menus;

    public function mount(Collection $menus): void
    {
        $this->menus = $menus;
    }
```
    
    Bloc Blade

```php
    @foreach ($menus as $menu)
        @if ($menu->submenus->isNotEmpty())
            <x-dropdown>
                <x-slot:trigger>
                    <x-button label="{{ $menu->label }}" class="btn-ghost" />
                </x-slot:trigger>
                @foreach ($menu->submenus as $submenu)
                    <x-menu-item title="{{ $submenu->label }}" link="{{ $submenu->link }}"
                        style="min-width: max-content;" />
                @endforeach
            </x-dropdown>
        @else
            <x-button label="{{ $menu->label }}" link="{{ $menu->link }}" :external="Str::startsWith($menu->link, 'http')"
                class="btn-ghost" />
        @endif
    @endforeach
```

###### sidebar.blade.php <!-- markmap: fold -->
    navigation/sidebar.blade.php
```php
    ...

use Illuminate\Support\Collection;

new class extends Component {

    public Collection $menus;

    public function mount(Collection $menus): void
    {
        $this->menus = $menus;
    }

    ...

};

    ...
<x-menu activate-by-route>
    
    ...

    @foreach ($menus as $menu)
        @if($menu->submenus->isNotEmpty())
            <x-menu-sub title="{{ $menu->label }}">
                @foreach ($menu->submenus as $submenu)
                    <x-menu-item title="{{ $submenu->label }}" link="{{ $submenu->link }}" />
                @endforeach
            </x-menu-sub>
        @else
            <x-menu-item title="{{ $menu->label }}" link="{{ $menu->link }}" />
        @endif
    @endforeach
</x-menu>
```

##### Menu Pied de page

###### navigation/footer.php <!-- markmap: fold -->

    Composant
```php
<?php

use App\Models\Footer;
use Livewire\Volt\Component;

new class() extends Component {

	public function with(): array
	{
		return [
			'footers' => Footer::orderBy('order')->get(),
		];
	}
};
?>

<footer class="p-10 rounded footer footer-center bg-base-200 text-base-content">
    <nav class="grid grid-flow-col gap-4">
        @foreach ($footers as $footer)
            <a href="{{ $footer->link }}" class="link link-hover">
                @lang($footer->label)
            </a>
        @endforeach
    </nav>
    <nav>
        <div class="grid grid-flow-col gap-4">
            <a href=" "" title="Github"
            target="_blank">
                <svg 
                    xmlns="http://www.w3.org/2000/svg" 
                    width="24" 
                    height="24" 
                    viewBox="0 0 24 24"
                    class="fill-current">
                    <path
                        d="M12 0C5.372 0 0 5.372 0 12c0 5.303 3.438 9.8 8.207 11.387.6.11.793-.26.793-.577v-2.2c-3.338.726-4.033-1.415-4.033-1.415-.546-1.387-1.333-1.757-1.333-1.757-1.089-.744.083-.729.083-.729 1.204.085 1.838 1.237 1.838 1.237 1.07 1.835 2.809 1.305 3.495.998.108-.775.419-1.305.762-1.605-2.665-.305-5.466-1.335-5.466-5.93 0-1.31.467-2.38 1.235-3.22-.124-.303-.535-1.523.117-3.176 0 0 1.008-.322 3.3 1.23.957-.266 1.98-.399 3-.405 1.02.006 2.043.139 3 .405 2.29-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.873.118 3.176.77.84 1.233 1.91 1.233 3.22 0 4.61-2.804 5.62-5.475 5.92.43.37.815 1.1.815 2.22v3.293c0 .319.192.694.801.576C20.565 21.796 24 17.302 24 12c0-6.628-5.372-12-12-12z" />
                </svg>
            </a>
            <a href=" ""
                title="Discord"
                target="_blank">
                <svg 
                    width="25" 
                    height="28" 
                    viewBox="0 0 71 80" 
                    class="fill-current mt-[-.05rem]"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M60.1045 13.8978C55.5792 11.8214 50.7265 10.2916 45.6527 9.41542C45.5603 9.39851 45.468 9.44077 45.4204 9.52529C44.7963 10.6353 44.105 12.0834 43.6209 13.2216C38.1637 12.4046 32.7345 12.4046 27.3892 13.2216C26.905 12.0581 26.1886 10.6353 25.5617 9.52529C25.5141 9.44359 25.4218 9.40133 25.3294 9.41542C20.2584 10.2888 15.4057 11.8186 10.8776 13.8978C10.8384 13.9147 10.8048 13.9429 10.7825 13.9795C1.57795 27.7309 -0.943561 41.1443 0.293408 54.3914C0.299005 54.4562 0.335386 54.5182 0.385761 54.5576C6.45866 59.0174 12.3413 61.7249 18.1147 63.5195C18.2071 63.5477 18.305 63.5139 18.3638 63.4378C19.7295 61.5728 20.9469 59.6063 21.9907 57.5383C22.0523 57.4172 21.9935 57.2735 21.8676 57.2256C19.9366 56.4931 18.0979 55.6 16.3292 54.5858C16.1893 54.5041 16.1781 54.304 16.3068 54.2082C16.679 53.9293 17.0513 53.6391 17.4067 53.3461C17.471 53.2926 17.5606 53.2813 17.6362 53.3151C29.2558 58.6202 41.8354 58.6202 53.3179 53.3151C53.3935 53.2785 53.4831 53.2898 53.5502 53.3433C53.9057 53.6363 54.2779 53.9293 54.6529 54.2082C54.7816 54.304 54.7732 54.5041 54.6333 54.5858C52.8646 55.6197 51.0259 56.4931 49.0921 57.2228C48.9662 57.2707 48.9102 57.4172 48.9718 57.5383C50.038 59.6034 51.2554 61.5699 52.5959 63.435C52.6519 63.5139 52.7526 63.5477 52.845 63.5195C58.6464 61.7249 64.529 59.0174 70.6019 54.5576C70.6551 54.5182 70.6887 54.459 70.6943 54.3942C72.1747 39.0791 68.2147 25.7757 60.1968 13.9823C60.1772 13.9429 60.1437 13.9147 60.1045 13.8978ZM23.7259 46.3253C20.2276 46.3253 17.3451 43.1136 17.3451 39.1693C17.3451 35.225 20.1717 32.0133 23.7259 32.0133C27.308 32.0133 30.1626 35.2532 30.1066 39.1693C30.1066 43.1136 27.28 46.3253 23.7259 46.3253ZM47.3178 46.3253C43.8196 46.3253 40.9371 43.1136 40.9371 39.1693C40.9371 35.225 43.7636 32.0133 47.3178 32.0133C50.9 32.0133 53.7545 35.2532 53.6986 39.1693C53.6986 43.1136 50.9 46.3253 47.3178 46.3253Z" />
                </svg>
            </a>
        </div>
    </nav>
    <aside>
        <p>Version 0.1.0</a> © {{ date('Y') }} Moi</p>
    </aside>
</footer>
```

    Dans layout
```php
{{-- FOOTER --}}
    <hr><br>
    <livewire:navigation.footer />
    <br>

    {{--  TOAST area --}}
    <x-toast />
```

#### Référence: ***<https://laravel.sillo.org/posts/mon-cms-les-menus>***

## Les commentaires <!-- markmap: fold -->

### Model & Migration et factory & seeder <!-- markmap: fold -->
```php
php artisan make:model Comment --migration
php artisan make:factory CommentFactory
php artisan make:seeder CommentSeeder
```

### PostRepository <!-- markmap: fold -->

```php
public function getPostBySlug(string $slug): Post
{
	return Post::with('user:id,name', 'category')
			->withCount('validComments')
			->whereSlug($slug)->firstOrFail();
}
```

### Réf.: ***<https://laravel.sillo.org/posts/mon-cms-les-commentaires-1-2>***

### Le formulaire <!-- markmap: fold -->

```php
php artisan make:volt posts/comment-form --class
```

### Gravatar <!-- markmap: fold -->

```php
composer require creativeorange/gravatar ~1.0
---
Gravatar::get('email@example.com');
```

### Notification <!-- markmap: fold -->

```php
php artisan make:notification CommentCreated
php artisan make:notification CommentAnswerCreated
```

### Affichage des commentaires <!-- markmap: fold -->

```php
php artisan make:volt posts/commentBase --class
php artisan make:volt posts/comment --class
```

### Sécurité // {!! $uneVariabledansDuCodeBladeQuiContient DuCodeDestinéÀLaVue !!} <!-- markmap: fold --> 

```php
composer require mews/purifier
---
use Mews\Purifier\Casts\CleanHtmlInput;

class Comment extends Model
{
    ...

	protected $casts = [
		'body' => CleanHtmlInput::class,
	];
```


### Réf.: ***<https://laravel.sillo.org/posts/mon-cms-les-commentaires-2-2>***

## Le profil <!-- markmap: fold -->

### Composant <!-- markmap: fold -->

```php	
php artisan make:volt auth/profile --class
```

#### Y coder

- La logique (Bloc PHP)
- Le rendu (Bloc HTML)

### Ajouter les traductions

### Faire la route de ce composant <!-- markmap: fold -->

- (Pensez que c'est que pour les "autorisés"
→ **Middleware('auth')**) et comme il y aura d'autre route pour "eux", en faire un **group()**

### Enfin, ajouter les liens dans les vues adhoc <!-- markmap: fold -->

- Pour les grands écrans, dans **navigation.navbar**
- Pour les plus petits, dans **navigation.sidebar**

### Réf.: ***<https://laravel.sillo.org/posts/mon-cms-le-profil>***

## Les favoris <!-- markmap: fold -->

### Fonctionnalité des Favoris <!-- markmap: fold -->

#### php artisan make:migration create_favorites_table

#### Relation n:n (User & Post) <!-- markmap: fold -->

    Comme convention de nommage de la table pivot pas respectée (Devrait être posts_users mais est favorites), on doit préciser ce nom dans les relations BelongsToMany

#### getPostBySlug: Vérifie en plus si l'user a mis le post en favori

#### Dans show.post, on affiche l'icône étoile pour favori ou pas (Le bloc PHP gère favoritePost() et unfavoritePost())

#### Dans index, affichage de l'icône étoile si post favori

#### Ajout de getFavoritePosts() dans PostRepository

#### Dans la navigation.navbar, code pour afficher l'icône des favoris (Déjà sélectionné par l'utilisateur en cours)

#### Enfin, pour afficher cette page <!-- markmap: fold -->

- Ajout de la route dans **routes/web.php**
- Ajout du bouton dans **navigation/navbar**
- Dans le composant index:
  - On défini une nouvelle propriété $favorites
  - mount() : On gère le cas où la requête est "/favorites" (On met la propriété favorites à true)
  - getPosts() : Si la propriété favorites est à true, on appelle getFavoritePosts(auth()->user()) 
  -Pour le HTML, on adapte le titre de la page
- On renseigne fr.json pour ce titre

### Boutons pour Aller en bas et en haut <!-- markmap: fold -->

- Règle CSS
- HTML des boutons

### Réf.: ***<https://laravel.sillo.org/posts/mon-cms-les-favoris>***

## L'administration <!-- markmap: fold -->

### Gestion des rôles <!-- markmap: fold -->

#### User : Admin ou Redac <!-- markmap: fold -->

##### Model User

```php
public function isAdmin(): bool
{
    return 'admin' === $this->role;
}

public function isRedac(): bool
{
    return 'redac' === $this->role;
}
```

#### Middlewares <!-- markmap: fold -->

##### **admin**

```php
php artisan make:middleware IsAdmin
```

##### Code

```php
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        return $next($request);
  }
```

##### **adminOrRedac**

```php
php artisan make:middleware IsAdminOrRedac
```

##### Code

```php
public function handle(Request $request, Closure $next): Response
{
    if (!auth()->user()->isAdmin() && !auth()->user()->isRedac()) {
        abort(403);
    }
    
    return $next($request);
}
```

### Tableau de Bord <!-- markmap: fold -->

#### SideBar <!-- markmap: fold -->

```php
php artisan make:volt admin/sidebar --class
```

```php
<?php

use Illuminate\Support\Facades\{Auth, Session};
use Livewire\Volt\Component;

new class() extends Component {
  public function logout(): void {
    Auth::guard('web')->logout();
    
    Session::invalidate();
    Session::regenerateToken();
    
    $this->redirect('/');
  }
}; ?>

<div>
    <x-menu activate-by-route>
        <x-menu-separator />
        <x-list-item :item="Auth::user()" value="name" sub-value="email" no-separator no-hover class="-mx-2 !-my-2 rounded">
            <x-slot:actions>
                <x-button icon="o-power" wire:click="logout" class="btn-circle btn-ghost btn-xs"
                    tooltip-left="{{ __('Logout') }}" no-wire-navigate />
            </x-slot:actions>
        </x-list-item>
        <x-menu-separator />
        <x-menu-item title="{{ __('Dashboard') }}" icon="s-building-office-2" link="{{ route('admin') }}" />        
        <x-menu-item icon="m-arrow-right-end-on-rectangle" title="{{ __('Go on site') }}" link="/" />
        <x-menu-item>
            <x-theme-toggle />
        </x-menu-item>
    </x-menu>
</div>
```

#### Layout <!-- markmap: fold -->

##### views/layouts/admin.blade.php

##### Code Layout

```php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' | ' . config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">

    {{-- MAIN --}}
    <x-main full-width>

        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100">
            <livewire:admin.sidebar />
        </x-slot:sidebar>

        <x-slot:content>
            <!-- Drawer toggle for "main-drawer" -->
            <label for="main-drawer" class="mr-3 lg:hidden">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
            {{ $slot }}
        </x-slot:content>

    </x-main>

    {{--  TOAST area --}}
    <x-toast />

</body>

</html>
```

#### Composant <!-- markmap: fold -->

##### CLI <!-- markmap: fold -->

```php
php artisan make:volt admin/index --class
```

##### Code <!-- markmap: fold -->

```php
<?php

use App\Models\{Comment, Page, Post, User};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Title('Dashboard')] #[Layout('components.layouts.admin')] class extends Component {
	use Toast;

	public array $headersPosts;
	public bool $openGlance = true;

	public function mount(): void
	{
		$this->headersPosts = [['key' => 'date', 'label' => __('Date')], ['key' => 'title', 'label' => __('Title')]];
	}

	public function deleteComment(Comment $comment): void
	{
		$comment->delete();

		$this->warning('Comment deleted', __('Good bye!'), position: 'toast-bottom');
	}

	public function with(): array
	{
		$user    = Auth::user();
		$isRedac = $user->isRedac();
		$userId  = $user->id;

		return [
			'pages'          => Page::select('id', 'title', 'slug')->get(),
			'posts'          => Post::select('id', 'title', 'slug', 'user_id', 'created_at', 'updated_at')->when($isRedac, fn (Builder $q) => $q->where('user_id', $userId))->latest()->get(),
			'commentsNumber' => Comment::when($isRedac, fn (Builder $q) => $q->whereRelation('post', 'user_id', $userId))->count(),
			'comments'       => Comment::with('user', 'post:id,title,slug')->when($isRedac, fn (Builder $q) => $q->whereRelation('post', 'user_id', $userId))->latest()->take(5)->get(),
			'users'          => User::count(),
		];
	}
}; ?>

<div>
    <x-collapse wire:model="openGlance" class="shadow-md">
        <x-slot:heading>
            @lang('In a glance')
        </x-slot:heading>
        <x-slot:content class="flex flex-wrap gap-4">

            <a href="#" class="flex-grow">
                <x-stat title="{{ __('Posts') }}" description="" value="{{ $posts->count() }}" icon="s-document-text"
                    class="shadow-hover" />
            </a>

            @if (Auth::user()->isAdmin())
                <a href="#" class="flex-grow">
                    <x-stat title="{{ __('Pages') }}" value="{{ $pages->count() }}" icon="s-document"
                        class="shadow-hover" />
                </a>
                <a href="#" class="flex-grow">
                    <x-stat title="{{ __('Users') }}" value="{{ $users }}" icon="s-user"
                        class="shadow-hover" />
                </a>
            @endif
            <a href="#" class="flex-grow">
                <x-stat title="{{ __('Comments') }}" value="{{ $commentsNumber }}" icon="c-chat-bubble-left"
                    class="shadow-hover" />
            </a>
        </x-slot:content>
    </x-collapse>

    <br>

    @foreach ($comments as $comment)
        @if (!$comment->user->valid)
            <x-alert title="{!! __('Comment to valid from ') . $comment->user->name !!}" description="{!! $comment->body !!}" icon="c-chat-bubble-left"
                class="shadow-md alert-warning">
                <x-slot:actions>
                    <x-button link="#" label="{!! __('Show the comments') !!}" />
                </x-slot:actions>
            </x-alert>
            <br>
        @endif
    @endforeach

    <x-collapse class="shadow-md">
        <x-slot:heading>
            @lang('Recent posts')
        </x-slot:heading>
        <x-slot:content>
            <x-table :headers="$headersPosts" :rows="$posts->take(5)" striped>
                @scope('cell_date', $post)
                    @lang('Created') {{ $post->created_at->diffForHumans() }}
                    @if ($post->updated_at != $post->created_at)
                        <br>
                        @lang('Updated') {{ $post->updated_at->diffForHumans() }}
                    @endif
                @endscope
                @scope('actions', $post)
                    <x-popover>
                        <x-slot:trigger>
                            <x-button icon="s-document-text" link="{{ route('posts.show', $post->slug) }}" spinner class="btn-ghost btn-sm" />                            
                        </x-slot:trigger>
                        <x-slot:content class="pop-small">
                            @lang('Show post')
                        </x-slot:content>
                    </x-popover>
                @endscope
            </x-table>
        </x-slot:content>
    </x-collapse>

    <br>

    <x-collapse class="shadow-md">
        <x-slot:heading>
            @lang('Recent Comments')
        </x-slot:heading>
        <x-slot:content>
            @foreach ($comments as $comment)
                <x-list-item :item="$comment" no-separator no-hover>
                    <x-slot:avatar>
                        <x-avatar :image="Gravatar::get($comment->user->email)">
                            <x-slot:title>
                                {{ $comment->user->name }}
                            </x-slot:title>
                        </x-avatar>
                    </x-slot:avatar>
                    <x-slot:value>
                        @lang ('in post:') {{ $comment->post->title }}
                    </x-slot:value>
                    <x-slot:actions>
                        <x-popover>
                            <x-slot:trigger>
                                <x-button icon="c-eye" link="#" spinner class="btn-ghost btn-sm" />                         
                            </x-slot:trigger>
                            <x-slot:content class="pop-small">
                                @lang('Edit or answer')
                            </x-slot:content>
                        </x-popover>
                        <x-popover>
                            <x-slot:trigger>
                                <x-button icon="s-document-text" link="{{ route('posts.show', $comment->post->slug) }}" spinner class="btn-ghost btn-sm" />                       
                            </x-slot:trigger>
                            <x-slot:content class="pop-small">
                                @lang('Show post')
                            </x-slot:content>
                        </x-popover>
                        <x-popover>
                            <x-slot:trigger>
                                <x-button icon="o-trash" wire:click="deleteComment({{ $comment->id }})"
                                    wire:confirm="{{ __('Are you sure to delete this comment?') }}" 
                                    spinner class="text-red-500 btn-ghost btn-sm" />                   
                            </x-slot:trigger>
                            <x-slot:content class="pop-small">
                                @lang('Delete')
                            </x-slot:content>
                        </x-popover>
                    </x-slot:actions>
                </x-list-item>
                <p class="ml-16">{!! Str::words(nl2br($comment->body), 20, ' ...') !!}</p>
                <br>
            @endforeach
        </x-slot:content>
    </x-collapse>
</div>
```



#### Route <!-- markmap: fold -->

```php
use App\Http\Middleware\IsAdminOrRedac;

...

Route::middleware('auth')->group(function () {
	...
	Route::middleware(IsAdminOrRedac::class)->prefix('admin')->group(function () {
		Volt::route('/dashboard', 'admin.index')->name('admin');
	});
});
```

#### Traductions <!-- markmap: fold -->

```php
"In a glance": "En un coup d'oeil",
"Recent posts": "Articles récents",
"Users": "Utilisateurs",
"Dashboard": "Tableau de bord",
"Recent Comments": "Commentaires récents",
"Show post": "Afficher l'article",
"in post:": "dans l'article :",
"Go on site": "Aller sur le site",
"Edit or answer": "Modifier ou repondre",
"Posts": "Articles"
```

#### Lien dans le menu <!-- markmap: fold -->

##### Logique (model User) <!-- markmap: fold -->

```php
public function isAdminOrRedac(): bool
{
    return 'admin' === $this->role || 'redac' === $this->role;
}
```

##### Lien dans Menu <!-- markmap: fold -->

###### Lien dans navigation.navbar

```php
<x-slot:actions>
    <span class="hidden lg:block">
        @if ($user = auth()->user())
            <x-dropdown>
                ...User name
                @if ($user->isAdminOrRedac())
                    <x-menu-item title="{{ __('Administration') }}" link="{{ route('admin') }}" />
                @endif
                <x-menu-separator />
                ... Profile
                <x-menu-separator />
                ... Logout
            </x-dropdown>
        @else
```

###### Lien dans navigation.sidebar

 
```php
              ... Logout
            </x-list-item>
            @if ($user->isAdminOrRedac())
                <x-menu-item title="{{ __('Administration') }}" icon="s-building-office-2" link="{{ route('admin') }}" />
            @endif
```

#### Redac & Admin: Redirection lors du login <!-- markmap: fold -->

    Composant auth.login :
```php
public function login() {
    ...

        if (auth()->user()->isAdmin()) {
            return redirect()->intended('/admin/dashboard');
        }
        ... return
    
```

### Réf.: ***<https://laravel.sillo.org/posts/mon-cms-ladministration>***
