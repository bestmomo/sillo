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

##### **Layout:**

    - title :
```php
  <title>{{ (isset($title) ? $title . ' | ' :
  (View::hasSection('title') ? View::getSection('title') . ' | ' :
   '')) . config('app.name') }}</title>
  <meta name="description" content="@yield('description')">
  <meta name="keywords" content="@yield('keywords')">*
```

##### **Vue** (Blade):
```php
@php
  $title='TitrePage'
@endphp
```

    ou :
```php
@section('title', $post->seo_title ?? $post->title)
@section('description', $post->meta_description)
@section('keywords', $post->meta_keywords
```

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

## Les articles <!-- markmap: fold -->

### Tableau des articles <!-- markmap: fold -->

#### Composant <!-- markmap: fold -->

##### CLI

```php
php artisan make:volt admin/posts/index --class
```

##### Code

###### Dans le composant admin.posts.index <!-- markmap: fold -->

```php
<?php

use Mary\Traits\Toast;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\{Post, Category};
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\{Layout, Title};
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\{Builder, Collection};

new 
#[Layout('components.layouts.admin'), Title('List Posts')]
class extends Component {
    use Toast, WithPagination;

    public string $search = '';
    public Collection $categories;
    public $category_id = 0;
    public array $sortBy  = ['column' => 'created_at', 'direction' => 'desc'];

    public function mount(): void {
        $this->categories = $this->getCategories();
    }

    public function getCategories(): Collection {
        if (Auth::user()->isAdmin()) {
            return Category::all();
        }
        
        return Category::whereHas('posts', fn (Builder $q) => $q->where('user_id', Auth::id()))->get();
        }
        
    public function headers(): array {
        $headers = [
            ['key' => 'title', 'label' => __('Title')],
        ];
    
        if (Auth::user()->isAdmin()) {
            $headers = array_merge($headers, [['key' => 'user_name', 'label' => __('Author')]]);
        }
    
        return array_merge($headers, [
            ['key' => 'category_title', 'label' => __('Category')],
            ['key' => 'comments_count', 'label' => __('')],
            ['key' => 'active', 'label' => __('Published')],
            ['key' => 'date', 'label' => __('Date')],
      ]);
      }

    public function posts(): LengthAwarePaginator {
        return Post::query()
            ->select('id', 'title', 'slug', 'category_id', 'active', 'user_id', 'created_at', 'updated_at')
            ->when(Auth::user()->isAdmin(), fn (Builder $q) => $q->withAggregate('user', 'name'))
            ->when(!Auth::user()->isAdmin(), fn (Builder $q) => $q->where('user_id', Auth::id()))
            ->withAggregate('category', 'title')
            ->withcount('comments')
            ->when($this->search, fn (Builder $q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->category_id, fn (Builder $q) => $q->where('category_id', $this->category_id))
            ->when('date' === $this->sortBy['column'], fn (Builder $q) => $q->orderBy('created_at', $this->sortBy['direction']), fn (Builder $q) => $q->orderBy($this->sortBy['column'], $this->sortBy['direction']))
            ->latest()
            ->paginate(6);
    }

    public function deletePost(int $postId): void {
        $post = Post::findOrFail($postId);
        $post->delete();
        $this->success("{$post->title} " . __('deleted'));
    }

    public function clonePost(int $postId): void {
        $originalPost       = Post::findOrFail($postId);
        $clonedPost         = $originalPost->replicate();
        $postRepository     = new PostRepository();
        $clonedPost->slug   = $postRepository->generateUniqueSlug($originalPost->slug);
        $clonedPost->active = false;
        $clonedPost->save();
    
        // Ici on redirigera vers le formulaire de modification de l'article cloné
    }
        
    public function with(): array {
        return [
            'headers' => $this->headers(),
            'posts'   => $this->posts(),
        ];
    }
}; ?>

<div>
    <x-header title="{{ __('Posts') }}" separator progress-indicator>
        <x-slot:actions>
            <x-input placeholder="{{ __('Search...') }}" wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
            <x-button label="{{ __('Add a post') }}" class="btn-outline lg:hidden" link="#" />
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>

    @if ($posts->count() > 0)
                <x-card>
            <x-table striped :headers="$headers" :rows="$posts" :sort-by="$sortBy" link="#" with-pagination>

                @scope('header_comments_count', $header)
                    {{ $header['label'] }}
                    <x-icon name="c-chat-bubble-left" />
                @endscope

                @scope('cell_comments_count', $post)
                    @if ($post->comments_count > 0)
                        <x-badge value="{{ $post->comments_count }}" class="badge-primary" />
                    @endif
                @endscope

                @scope('cell_active', $post)
                    @if ($post->active)
                        <x-icon name="o-check-circle" />
                    @endif
                @endscope

                @scope('cell_date', $post)
                    @lang('Created') {{ $post->created_at->diffForHumans() }}
                    @if ($post->updated_at != $post->created_at)
                        <br>
                        @lang('Updated') {{ $post->updated_at->diffForHumans() }}
                    @endif
                @endscope

                @scope('actions', $post)
                    <div class="flex">
                        <x-popover>
                            <div class="flex">
                                <x-slot:trigger>
                                    <x-button icon="o-finger-print" wire:click="clonePost({{ $post->id }})" spinner
                                        class="btn-ghost btn-sm" />
                                </x-slot:trigger>
                                <x-slot:content class="pop-small">
                                    @lang('Clone')
                                </x-slot:content>
                            </x-popover>
                        <x-popover>
                            <x-slot:trigger>
                                <x-button icon="o-trash" wire:click="deletePost({{ $post->id }})"
                                    wire:confirm="{{ __('Are you sure to delete this post?') }}" spinner
                                    class="text-red-500 btn-ghost btn-sm" />
                            </x-slot:trigger>
                            <x-slot:content class="pop-small">
                                @lang('Delete')
                            </x-slot:content>
                        </x-popover>
                    </div>
                @endscope

            </x-table>
        </x-card>
    @endif
</div>
```

###### Dans le PostRepository <!-- markmap: fold -->

```php
public function generateUniqueSlug(string $slug): string
{
	$newSlug = $slug;
	$counter = 1;
	while (Post::where('slug', $newSlug)->exists()) {
		$newSlug = $slug . '-' . $counter;
		++$counter;
	}
	return $newSlug;
}
```


##### Traductions

```php
"Title": "Titre",
"Author": "Auteur",
"Updated": "Mis à jour",
"Category": "Catégorie",
"Published": "Publié",
"Add a post": "Ajouter un article",
"Are you sure to delete this post?": "Êtes-vous sûr de vouloir supprimer cet article ?",
"deleted": "supprimé",
"Clone": "Dupliquer",
"Filters": "Filtres",
"Select a category": "Sélectionnez une catégorie"
```

#### Routes <!-- markmap: fold -->

```php
Route::middleware('auth')->group(function () {
	...
	Route::middleware(IsAdminOrRedac::class)->prefix('admin')->group(function () {
		...
		Volt::route('/posts/index', 'admin.posts.index')->name('posts.index');
	});
});
```

#### Navigation <!-- markmap: fold -->

##### admin/sidebar

```php
... Dashboard
<x-menu-sub title="{{ __('Posts') }}" icon="s-document-text">
    <x-menu-item title="{{ __('All posts') }}" link="{{ route('posts.index') }}" />
</x-menu-sub>
```

##### Traduction

```php
"All posts": "Tous les articles",
```

#### Réf.: ***<https://laravel.sillo.org/posts/mon-cms-tableau-des-articles>***

### Créer un article <!-- markmap: fold -->

#### Composant (Formulaire) <!-- markmap: fold -->

##### CLI

```php
php artisan make:volt admin/posts/create --class
```

##### Code Création

###### Base <!-- markmap: fold -->

```php
<?php
use Livewire\Volt\Component;
use App\Models\Category;
use Livewire\Attributes\Layout;

new #[Layout('components.layouts.admin')] 

class extends Component {

    public function with(): array {
      return [
        'categories' => Category::orderBy('title')->get(),
    ];}
      
}; ?>

<div>
    <x-header title="{{ __('Add a post') }}" separator progress-indicator>
        <x-slot:actions>
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    <x-card>
        <x-form wire:submit="save">
            <x-select label="{{ __('Category') }}" option-label="title" :options="$categories" wire:model="category_id"
                wire:change="$refresh" />
            <br>
            <div class="flex gap-6">
                <x-checkbox label="{{ __('Published') }}" wire:model="active" />
                <x-checkbox label="{{ __('Pinned') }}" wire:model="pinned" />
            </div>
            <x-input type="text" wire:model="title" label="{{ __('Title') }}"
                placeholder="{{ __('Enter the title') }}" wire:change="$refresh" />
            <x-input type="text" wire:model="slug" label="{{ __('Slug') }}" />
            <x-editor wire:model="body" label="{{ __('Content') }}" :config="config('tinymce.config')"
                folder="{{ 'photos/' . now()->format('Y/m') }}" />
            <x-card title="{{ __('SEO') }}" shadow separator>
                <x-input placeholder="{{ __('Title') }}" wire:model="seo_title" hint="{{ __('Max 70 chars') }}" />
                <br>
                <x-textarea label="{{ __('META Description') }}" wire:model="meta_description"
                    hint="{{ __('Max 160 chars') }}" rows="2" inline />
                <br>
                <x-textarea label="{{ __('META Keywords') }}" wire:model="meta_keywords"
                    hint="{{ __('Keywords separated by comma') }}" rows="1" inline />
            </x-card>
            <x-slot:actions>
                <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                    class="btn-primary" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
```

###### Traduction <!-- markmap: fold -->

```php
"Select a category": "Sélectionnez une catégorie",
"Pinned": "Épinglé",
"Content": "Contenu",
"META Keywords": "META mots-clefs",
"Keywords separated by comma": "Mots-clefs séparés par une virgule",
"Max 70 chars": "Max 70 caractères",
"Max 160 chars": "Max 160 caractères",
"Enter the title": "Entrez le titre",
"Post added with success.": "Article ajouté avec succès."
```

###### Propriétés - Validation <!-- markmap: fold -->

```php
use Livewire\Attributes\{Layout, Validate};
...
public int $category_id;

#[Validate('required|string|max:16777215')]
public string $body = '';

#[Validate('required|string|max:255')]
public string $title = '';

#[Validate('required|max:255|unique:posts,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/')]
public string $slug = '';

#[Validate('required')]
public bool $active = false;

#[Validate('required')]
public bool $pinned = false;

#[Validate('required|max:70')]
public string $seo_title = '';

#[Validate('required|max:160')]
public string $meta_description = '';

#[Validate('required|regex:/^[A-Za-z0-9-éèàù]{1,50}?(,[A-Za-z0-9-éèàù]{1,50})*$/')]
public string $meta_keywords = '';

public function mount(): void
{
    $category          = Category::first();
    $this->category_id = $category->id;
}
```

###### Update du slug du title <!-- markmap: fold -->

```php
public function updatedTitle($value) {
    $this->slug      = Str::slug($value);
    $this->seo_title = $value;
}
```

###### Enregistrement <!-- markmap: fold -->

```php
...

use App\Models\{Category, Post};
use Mary\Traits\Toast;

new #[Layout('components.layouts.admin')] 
class extends Component {
    use Toast;

    ...

    public function save() {
        $data = $this->validate();

    Post::create(
        $data + [
            'user_id'     => Auth::id(),
            'category_id' => $this->category_id,
        ],
    );

        $this->success(__('Post added with success.'), redirectTo: '/admin/posts/index');
    }
```

##### Gestion de l'image <!-- markmap: fold -->

###### Ajout du trait Livewire WithFileUploads <!-- markmap: fold -->

```php
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

new #[Layout('components.layouts.admin')] 
class extends Component {
    use WithFileUploads, Toast;

    #[Rule('required|image|max:2000')]
	public ?TemporaryUploadedFile $photo = null;
```

###### Composant dans form <!-- markmap: fold -->

```php
            <x-file wire:model="photo" label="{{ __('Featured image') }}"
                hint="{{ __('Click on the image to modify') }}" accept="image/png, image/jpeg">
                <img src="{{ $photo == '' ? '/storage/ask.jpg' : $photo }}" class="h-40" />
            </x-file>
            <x-slot:actions>
                ...
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
```

###### Traductions <!-- markmap: fold -->

```php
"Featured image": "Image mise en avant",
"Click on the image to modify": "Cliquez sur cette image pour la modifier",
```

###### Image / défaut <!-- markmap: fold -->

- <a href="https://laravel.sillo.org/ask.jpg">Récupérer l'image</a>
- À poser dans : ./public/storage/ask.jpg

###### Save <!-- markmap: fold -->

- Par défaut, image temporaire ./storage/app/livewire-tmp
- Ajouter :
```php
public function save()
{
    $data = $this->validate();

    $date = now()->format('Y/m');
    $path = $date . '/' . basename($this->photo->store('photos/' . $date, 'public'));

    Post::create(
        $data + [
            'user_id'     => Auth::id(),
            'category_id' => $this->category_id,
            'image'       => $path,
        ],
    );

    $this->success(__('Post added with success.'), redirectTo: '/admin/posts/index');
}
```

###### Url des images <!-- markmap: fold -->

    Ajout dans app/helpers.php :

```php
if (!function_exists('replaceAbsoluteUrlsWithRelative')) {
  function replaceAbsoluteUrlsWithRelative(string $content) {
      $baseUrl = url('/');
  
      if ('/' !== substr($baseUrl, -1)) {
          $baseUrl .= '/';
      }
      
      $pattern     = '/<img\s+[^>]*src="(?:https?:\/\/)?' . preg_quote(parse_url($baseUrl, PHP_URL_HOST), '/') . '\/([^"]+)"/i';
      $replacement = '<img src="/$1"';
  
      return preg_replace($pattern, $replacement, $content);
  }
}
```

    Adaptation de save() :
```php
public function save() {
   ...

    $data['body'] = replaceAbsoluteUrlsWithRelative($data['body']);
    
    Post::create(

    ...

}
```

#### Routes <!-- markmap: fold -->

```php
Route::middleware('auth')->group(function () {
	...
	Route::middleware(IsAdminOrRedac::class)->prefix('admin')->group(function () {
		...
		Volt::route('/posts/create', 'admin.posts.create')->name('posts.create');
	});
});
```

#### Menu (admin.sidebar) <!-- markmap: fold -->

```php
<x-menu-sub title="{{ __('Posts') }}" icon="s-document-text">
    <x-menu-item title="{{ __('All posts') }}" link="{{ route('posts.index') }}" />
    <x-menu-item title="{{ __('Add a post') }}" link="{{ route('posts.create') }}" />
</x-menu-sub>
```

#### Éditeur (TinyMCE) <!-- markmap: fold -->

##### Installation hébergée (Usage Illimité) <!-- markmap: fold -->

###### <a href="https://www.tiny.cloud/get-tiny">Télécharger Free TinyMCE</a>

###### Installer dans : ./storage/app/public/scripts

###### Paramétrage

```php
<?php
// Fichier config/tinymce.php

return [
'config' => [
  'language'       => env('APP_TINYMCE_LOCALE', 'en_US'),
  'plugins'        => 'codesample fullscreen',
  'toolbar'        => 'undo redo style | fontfamily fontsize | alignleft aligncenter alignright alignjustify | bullist numlist | copy cut paste pastetext | hr | codesample | link image quicktable | fullscreen',
  'toolbar_sticky' => true,
  'min_height'     => 1000,
  'license_key'    => 'gpl',
  'valid_elements' => '*[*]',
],
];
```

```php

// Fichier ./.env

APP_TINYMCE_LOCALE=fr_FR
```

###### Traductions

- <a href="https://www.tiny.cloud/get-tiny/language-packages">Récupérer les fichiers de traduction</a>

- Les copier dans : ./storage/app/public/scripts/fr_FR.js

###### Activation

```php
// Fichier ./resources\views\components\layouts\admin.blade.php
<script src="{{ asset('storage/scripts/tinymce.min.js') }}" ></script>
... @vite(...)
```


##### Installation CDN (Usage limité: 1000 appels/mois - Mise à jour auto) <!-- markmap: fold -->

```php
// Fichier ./resources\views\components\layouts\admin.blade.php
<script src="https://cdn.tiny.cloud/1/YOUR-KEY-HERE/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
... @vite(...)
```

#### Réf.: ***<https://mary-ui.com/docs/components/editor>***

#### Réf.: ***<https://laravel.sillo.org/posts/mon-cms-creer-un-article#top>***

### Modifier un article <!-- markmap: fold -->

#### Composant

##### Création <!-- markmap: fold -->

```php
php artisan make:volt admin/posts/edit --class
```

##### Route posts.edit <!-- markmap: fold -->

```php
// Dans le groupe du middleware 'IsAdminOrRedac'
Volt::route('/posts/{post:slug}/edit', 'admin.posts.edit')->name('posts.edit');
```

##### Lien dans tableau des articles (posts.index) <!-- markmap: fold -->

```php
<x-table striped :headers="$headers" :rows="$posts" :sort-by="$sortBy" link="/admin/posts/{slug}/edit" with-pagination>
```

##### Formulaire <!-- markmap: fold -->

```php
<div>
    <x-header title="{{ __('Edit a post') }}" separator progress-indicator>
        <x-slot:actions>
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>

    <x-card>
        <x-form wire:submit="save">
           	<x-select label="{{ __('Category') }}" option-label="title" :options="$categories" wire:model="category_id"
                wire:change="$refresh" />
			<br>
            <div class="flex gap-6">
                <x-checkbox label="{{ __('Published') }}" wire:model="active" />
                <x-checkbox label="{{ __('Pinned') }}" wire:model="pinned" />
            </div>
            <x-input type="text" wire:model="title" label="{{ __('Title') }}"
                placeholder="{{ __('Enter the title') }}" wire:change="$refresh" />
            <x-input type="text" wire:model="slug" label="{{ __('Slug') }}" />
            <x-editor wire:model="body" label="{{ __('Content') }}" :config="config('tinymce.config')"
                folder="{{ 'photos/' . now()->format('Y/m') }}" />
            <x-card title="{{ __('SEO') }}" shadow separator>
                <x-input placeholder="{{ __('Title') }}" wire:model="seo_title" hint="{{ __('Max 70 chars') }}" />
                <br>
                <x-textarea label="{{ __('META Description') }}" wire:model="meta_description"
                    hint="{{ __('Max 160 chars') }}" rows="2" inline />
                <br>
                <x-textarea label="{{ __('META Keywords') }}" wire:model="meta_keywords"
                    hint="{{ __('Keywords separated by comma') }}" rows="1" inline />
            </x-card>
            <x-file wire:model="photo" label="{{ __('Featured image') }}"
                hint="{{ __('Click on the image to modify') }}" accept="image/png, image/jpeg">
                <img src="{{ asset('storage/photos/' . $post->image) }}" class="h-40" />
            </x-file>
            <x-slot:actions>
                <x-button label="{{ __('Preview') }}" icon="m-sun" link="{{ '/posts/' . $post->slug }}" external
                    class="btn-outline" />
                <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                    class="btn-primary" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
```

##### La logique <!-- markmap: fold -->

```php
<?php

use App\Models\{Category, Post};
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\{Layout, Title};
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

new #[Title('Edit Post'), Layout('components.layouts.admin')] 
class extends Component {
  use WithFileUploads, Toast;
  
  public int $postId;
  public ?Collection $categories;
  public int $category_id;
  public Post $post;
  public string $body                  = '';
  public string $title                 = '';
  public string $slug                  = '';
  public bool $active                  = false;
  public bool $pinned                  = false;
  public string $seo_title             = '';
  public string $meta_description      = '';
  public string $meta_keywords         = '';
  public ?TemporaryUploadedFile $photo = null;
  
  public function mount(Post $post): void
  {
    if (Auth()->user()->isRedac() && $post->user_id !== Auth()->id()) {
      abort(403);
    }
  
    $this->post = $post;
    $this->fill($this->post);
    $this->categories = Category::orderBy('title')->get();
  }
  
  public function updatedTitle($value)
  {
    $this->slug      = Str::slug($value);
    $this->seo_title = $value;
  }
  
  public function save()
  {
    $data = $this->validate([
      'title'            => 'required|string|max:255',
      'body'             => 'required|string|max:16777215',
      'category_id'      => 'required',
      'photo'            => 'nullable|image|max:2000',
      'active'           => 'required',
      'pinned'           => 'required',
      'slug'             => ['required', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('posts')->ignore($this->post->id)],
      'seo_title'        => 'required|max:70',
      'meta_description' => 'required|max:160',
      'meta_keywords'    => 'required|regex:/^[A-Za-z0-9-éèàù]{1,50}?(,[A-Za-z0-9-éèàù]{1,50})*$/',
    ]);
    
    if ($this->photo) {
      $date          = now()->format('Y/m');
      $path          = $date . '/' . basename($this->photo->store('photos/' . $date, 'public'));
      $data['image'] = $path;
    }
    
    $data['body'] = replaceAbsoluteUrlsWithRelative($data['body']);
    
    $this->post->update(
      $data + [
      'category_id' => $this->category_id,
      ],
    );
    
    $this->success(__('Post updated with success.'));
  }
}; ?>
```

##### Traduction Éditer <!-- markmap: fold -->

```php
"Edit a post": "Modifier un article",
"Post updated with success.": "Article mis à jour avec succès."
```

##### Bouton édition dans le posts.show <!-- markmap: fold -->

###### HTML

```php
@auth
    <x-popover>
        ...
    </x-popover>
    @if (Auth::user()->isAdmin() || Auth::user()->id == $post->user_id)
        <x-popover>
            <x-slot:trigger>
                <x-button icon="c-pencil-square" link="{{ route('posts.edit', $post) }}" spinner
                    class="btn-ghost btn-sm" />
            </x-slot:trigger>
            <x-slot:content class="pop-small">
                @lang('Edit this post')
            </x-slot:content>
        </x-popover>
    @endif
@endauth
```

###### Traduction Modifier

```php
"Edit this post": "Modifier cet article",
```

##### Bouton clone dans le posts.show <!-- markmap: fold -->

###### HTML <!-- markmap: fold -->

```php
@if (Auth::user()->isAdmin() || Auth::user()->id == $post->user_id)
    <x-popover>
        ...
    </x-popover>
    <x-popover>
        <x-slot:trigger>
            <x-button icon="o-finger-print" wire:click="clonePost({{ $post->id }})" spinner
                class="btn-ghost btn-sm" />
        </x-slot:trigger>
        <x-slot:content class="pop-small">
            @lang('Clone this post')
        </x-slot:content>
    </x-popover>
@endif
```

###### Traduction Clone <!-- markmap: fold -->

```php
"Clone this post": "Dupliquer cet article"
```

###### Logique du clonage  <!-- markmap: fold -->

```php
public function clonePost(int $postId): void
{
    $originalPost = Post::findOrFail($postId);
    $clonedPost = $originalPost->replicate();
    $postRepository = new PostRepository();
    $clonedPost->slug = $postRepository->generateUniqueSlug($originalPost->slug);
    $clonedPost->active = false;
    $clonedPost->save();

    redirect()->route('posts.edit', $clonedPost->slug);
}
```

###### Lien Articles dans dashboard <!-- markmap: fold -->

```php
// admin.index
<a href="{{ route('posts.index') }}" class="flex-grow">
    <x-stat title="{{ __('Posts') }}" description="" value="{{ $posts->count() }}" icon="s-document-text"
        class="shadow-hover" />
</a>
```

#### Réf.: ***<https://laravel.sillo.org/posts/mon-cms-modifier-un-article>***

## Les catégories <!-- markmap: fold -->

### Création category.index <!-- markmap: fold -->

```php
php artisan make:volt admin/categories/index --class
```

### Route categories.index <!-- markmap: fold -->

```php
use App\Http\Middleware\{IsAdmin, IsAdminOrRedac};
...
// Dans le groupe du middleware 'IsAdminOrRedac'
Route::middleware(IsAdmin::class)->group(function () {
    Volt::route('/categories/index', 'admin.categories.index')->name('categories.index');
});
```

### Item dans barre latérale <!-- markmap: fold -->

#### HTML Item dans admin.sidebar
```php
<x-menu-sub title="{{ __('Posts') }}" icon="s-document-text">
    ...
    @if (Auth::user()->isAdmin())
        <x-menu-item title="{{ __('Categories') }}" link="{{ route('categories.index') }}" />
    @endif
</x-menu-sub> 
```

#### Traduction Item \<!-- markmap: fold -->

```php
"Categories": "Catégories"
```

### Code composant categories.index <!-- markmap: fold -->

#### Base <!-- markmap: fold -->

```php
<?php

use Livewire\Volt\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

new #[Layout('components.layouts.admin')] 
class extends Component {
    use WithPagination;

    public array $sortBy = ['column' => 'title', 'direction' => 'asc'];

    public function headers(): array
    {
        return [['key' => 'title', 'label' => __('Title')], ['key' => 'slug', 'label' => 'Slug']];
    }
    
    public function with(): array
    {
        return [
            'categories' => Category::orderBy(...array_values($this->sortBy))->paginate(10),
            'headers'    => $this->headers(),
        ];
    }
    
}; ?>

<div>
    <x-header title="{{ __('Categories') }}" separator progress-indicator>
        <x-slot:actions class="lg:hidden">
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    <x-card>
        <x-table striped :headers="$headers" :rows="$categories" :sort-by="$sortBy" link="#"
            with-pagination>
        </x-table>
    </x-card>
</div>
```

#### Ajout bouton supprimer catégorie <!-- markmap: fold -->

##### HTML Supprimer catégorie

```php
<x-table striped :headers="$headers" :rows="$categories" :sort-by="$sortBy" link="#"
    with-pagination>
        @scope('actions', $category)
        <x-popover>
            <x-slot:trigger>
                <x-button icon="o-trash" wire:click="delete({{ $category->id }})"
                    wire:confirm="{{ __('Are you sure to delete this category?') }}" spinner
                    class="text-red-500 btn-ghost btn-sm" />
            </x-slot:trigger>
            <x-slot:content class="pop-small">
                @lang('Delete')
            </x-slot:content>
        </x-popover>
    @endscope
</x-table>
```

##### Logique Supprimer catégorie

```php
public function delete(Category $category): void
{
    $category->delete();
    $this->success(__('Category deleted with success.'));
}
```

##### Traduction Supprimer catégorie

```php
"Are you sure to delete this category?": "Êtes-vous sûr de vouloir supprimer cette catégorie ?",
"Category deleted with success.": "Catégorie supprimée avec succès."
```

#### Formulaire catégorie <!-- markmap: fold -->

##### Composant formulaire creation/modification <!-- markmap: fold -->

```php
php artisan make:volt admin/categories/category-form
```


##### HTML admin/categories/category-form.blade.php <!-- markmap: fold -->

```php
<x-form wire:submit="save">
    <x-input label="{{ __('Title') }}" wire:model.debounce.500ms="title" wire:change="$refresh" />
    <x-input type="text" wire:model="slug" label="{{ __('Slug') }}" />
    <x-slot:actions>
        <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
            class="btn-primary" />
    </x-slot:actions>
</x-form>
```

##### Ajout du formulaire Créer catégorie <!-- markmap: fold -->

```php
    <x-card title="{{ __('Create a new category') }}">
        @include('livewire.admin.categories.category-form')
    </x-card>
</div>
```

##### Complément logique validation catégorie <!-- markmap: fold -->

```php
...

use Livewire\Attributes\{Layout, Validate};
use Illuminate\Support\Str;
use Mary\Traits\Toast;

new #[Layout('components.layouts.admin')] 
class extends Component {
    use Toast, WithPagination;

    ...

    #[Validate('required|max:255|unique:categories,title')]
	public string $title = '';

    #[Validate('required|max:255|unique:posts,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/')]
    public string $slug = '';

    public function updatedTitle($value): void
	{
		$this->generateSlug($value);
	}

    private function generateSlug(string $title): void
	{
		$this->slug = Str::of($title)->slug('-');
	}

    public function save(): void
	{
		$data = $this->validate();
		Category::create($data);
		$this->success(__('Category created with success.'));
	}
```

##### Traduction Créer catégorie <!-- markmap: fold -->

```php
"Create a new category": "Créer une nouvelle catégorie",
"Category created with success.": "Catégorie créée avec succès."
```

### Modification d'une catégorie <!-- markmap: fold -->

#### Création du composant modification <!-- markmap: fold -->

```php
php artisan make:volt admin/categories/edit --class
```

#### Code du composant d'édition <!-- markmap: fold -->

```php
<?php
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Layout('components.layouts.admin')] 
class extends Component {
  use Toast;
  
  public Category $category;
  public string $title = '';
  public string $slug  = '';
  
  public function mount(Category $category): void {
    $this->category = $category;
    $this->fill($this->category->toArray());
  }
  
  public function updatedTitle($value): void {
    $this->generateSlug($value);
  }
  
  public function save(): void {
    $data = $this->validate($this->rules());
    $this->category->update($data);
    $this->success(__('Category updated successfully.'), redirectTo: '/admin/categories/index');
  }
  
  protected function rules(): array
  {
  return [
      'title' => 'required|string|max:255',
      'slug'  => ['required', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('categories')->ignore($this->category->id)],
  ];
  }
  
  private function generateSlug(string $title): void
  {
    $this->slug = Str::of($title)->slug('-');
  }
}; ?>

<div>
    <x-header title="{{ __('Edit a category') }}" separator progress-indicator>
        <x-slot:actions class="lg:hidden">
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    <x-card>
        @include('livewire.admin.categories.category-form')
    </x-card>
</div>
```

#### Traduction modification de catégorie <!-- markmap: fold -->

```php
"Category updated successfully.": "Catégorie mise à jour avec succès.",
"Edit a category": "Modifier une catégorie",
```

#### Lien dans tableau des catégories  <!-- markmap: fold -->

```php
// admin/categories/index
<x-table striped :headers="$headers" :rows="$categories" :sort-by="$sortBy" link="/admin/categories/{id}/edit" with-pagination>
```

##### Route pour la modification de catégorie <!-- markmap: fold -->

```php
Route::middleware(IsAdmin::class)->group(function () {
	...
	Volt::route('/categories/{category}/edit', 'admin.categories.edit')->name('categories.edit');
});
```

### Réf.: ***<https://laravel.sillo.org/posts/mon-cms-modifier-un-article>***

## Les pages <!-- markmap: fold -->

### Composant Pages <!-- markmap: fold -->

#### CLI Pages

```php
php artisan make:volt admin/pages/index --class
```

#### Route Pages

```php
// Groupe middleware IsAdminOrRedac > IsAdmin
Volt::route('/pages/index', 'admin.pages.index')->name('pages.index');
```

#### Lien Pages

```php
// admin.sidebar
@if (Auth::user()->isAdmin())
    <x-menu-sub title="{{ __('Pages') }}" icon="s-document">
        <x-menu-item title="{{ __('All pages') }}" link="{{ route('pages.index') }}" />
    </x-menu-sub>
@endif
```

#### Traduction Pages

```php
"All pages": "Toutes les pages",
```

#### Code Pages <!-- markmap: fold -->

```php
<?php

use App\Models\Page;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

new #[Title('Pages'), Layout('components.layouts.admin')] 
class extends Component {
  use Toast, WithPagination;
  
  public function headers(): array {
    return [
      ['key' => 'title',  'label' => __('Title')],
      ['key' => 'slug',   'label' => 'Slug'],
      ['key' => 'active', 'label' => __('Published')]
    ];
  }
  
  public function deletePage(Page $page): void {
    $page->delete();
    $this->success(__('Page deleted'));
  }
  
  public function with(): array {
    return [
      'pages'   => Page::select('id', 'title', 'slug', 'active')->get(),
      'headers' => $this->headers(),
    ];
  }
}; ?>

<div>
    <x-header title="{{ __('Pages') }}" separator progress-indicator >
        <x-slot:actions class="lg:hidden">
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
                link="{{ route('admin') }}" />
            <x-button icon="c-document-plus" label="{{ __('Add a page') }}" class="btn-outline"
                link="#" />
        </x-slot:actions>
    </x-header>

    <x-card>
        <x-table striped :headers="$headers" :rows="$pages" link="#">
            @scope('cell_active', $page)
                @if ($page->active)
                    <x-icon name="o-check-circle" />
                @endif
            @endscope
            @scope('actions', $page)
                <x-popover>
                    <x-slot:trigger>
                        <x-button icon="o-trash" wire:click="deletePage({{ $page->id }})"
                            wire:confirm="{{ __('Are you sure to delete this page?') }}" spinner
                            class="text-red-500 btn-ghost btn-sm" />
                    </x-slot:trigger>
                    <x-slot:content class="pop-small">
                        @lang('Delete')
                    </x-slot:content>
                </x-popover>
            @endscope
        </x-table>
    </x-card>
</div>
```

#### Traduction composant Pages

```php
"Add a page": "Ajouter une page",
"Are you sure to delete this page?": "Êtes-vous sûr de vouloir supprimer cette page ?"
```

### Composant création pages <!-- markmap: fold -->

#### CLI Creation Pages

```php
php artisan make:volt admin/pages/create --class
```

#### Route Ajouter Pages

```php
// Groupe middleware IsAdminOrRedac > IsAdmin
Volt::route('/pages/create', 'admin.pages.create')->name('pages.create');
```

#### Lien Ajouter Pages

```php
// admin.sidebar
@if (Auth::user()->isAdmin())
    <x-menu-sub title="{{ __('Pages') }}" icon="s-document">
        <x-menu-item title="{{ __('All pages') }}" link="{{ route('pages.index') }}" />
        <x-menu-item title="{{ __('Add a page') }}" link="{{ route('pages.create') }}" />
    </x-menu-sub>
@endif
```

#### Formulaire Pages (Création & modification) <!-- markmap: fold -->

```php
// pages/page-form.blade.php
<x-card>
    <x-form wire:submit="save">
        <x-input type="text" wire:model="title" label="{{ __('Title') }}"
            placeholder="{{ __('Enter the title') }}" wire:change="$refresh" />
        <x-input type="text" wire:model="slug" label="{{ __('Slug') }}" /><br>
        <x-checkbox label="{{ __('Published') }}" wire:model="active" /><br>
        <x-editor wire:model="body" label="{{ __('Content') }}" :config="config('tinymce.config')"
            folder="{{ 'photos/' . now()->format('Y/m') }}" />
        <x-card title="{{ __('SEO') }}" shadow separator>
            <x-input placeholder="{{ __('Title') }}" wire:model="seo_title" hint="{{ __('Max 70 chars') }}" />
            <br>
            <x-textarea label="{{ __('META Description') }}" wire:model="meta_description"
                hint="{{ __('Max 160 chars') }}" rows="2" inline />
            <br>
            <x-textarea label="{{ __('META Keywords') }}" wire:model="meta_keywords"
                hint="{{ __('Keywords separated by comma') }}" rows="1" inline />
        </x-card>
        <x-slot:actions>
            <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                class="btn-primary" />
        </x-slot:actions>
    </x-form>
</x-card>
```

#### Code Créer Pages <!-- markmap: fold -->

```php
<?php

use App\Models\Page;
use illuminate\Support\Str;
use Livewire\Attributes\{Layout, Validate, Title};
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Title('Create Page'), Layout('components.layouts.admin')] 
class extends Component {
    use Toast;
    
    #[Validate('required|max:65000')]
    public string $body = '';
    
    #[Validate('required|max:255')]
    public string $title = '';
    
    #[Validate('required|max:255|unique:posts,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/')]
    public string $slug = '';
    
    #[Validate('required')]
    public bool $active = false;
    
    #[Validate('required|max:70')]
    public string $seo_title = '';
    
    #[Validate('required|max:160')]
    public string $meta_description = '';
    
    #[Validate('required|regex:/^[A-Za-z0-9-éèàù]{1,50}?(,[A-Za-z0-9-éèàù]{1,50})*$/')]
    public string $meta_keywords = '';
    
    public function updatedTitle($value): void {
        $this->generateSlug($value);
        $this->seo_title = $value;
    }
    
    public function save() {
        $data = $this->validate();
        Page::create($data);
        $this->success(__('Page added with success.'), redirectTo: '/admin/pages/index');
    }
    
    private function generateSlug(string $title): void {
        $this->slug = Str::of($title)->slug('-');
    }
}; ?>

<div>
    <x-header title="{{ __('Add a page') }}" separator progress-indicator>
        <x-slot:actions class="lg:hidden">
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    @include('livewire.admin.pages.page-form')
</div>
```

#### Traduction Ajouter Pages

```php
"Page added with success.": "Page ajoutée avec succès."
```

#### Lien ajout Pages

```php
// pages.index
<x-button icon="c-document-plus" label="{{ __('Add a page') }}" class="btn-outline" link="{{ route('pages.create') }}" />
```


### Composant modification (édition) pages <!-- markmap: fold -->

#### CLI édition Pages

```php
php artisan make:volt admin/pages/edit --class
```

#### Route Éditer Pages

```php
// Groupe middleware IsAdminOrRedac > IsAdmin
Volt::route('/pages/{page:slug}/edit', 'admin.pages.edit')->name('pages.edit');
```

#### Lien Éditer Pages

```php
// pages.index
<x-table striped :headers="$headers" :rows="$pages" link="/admin/pages/{slug}/edit">
```

#### Code Éditer Pages <!-- markmap: fold -->

```php
<?php

use App\Models\Page;
use illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Title('Edit Page'), Layout('components.layouts.admin')] 
class extends Component {
    use Toast;
    
    public Page $page;
    public string $body             = '';
    public string $title            = '';
    public string $slug             = '';
    public bool $active             = false;
    public string $seo_title        = '';
    public string $meta_description = '';
    public string $meta_keywords    = '';
    
    public function mount(Page $page): void {
        $this->page = $page;
        $this->fill($this->page);
    }
    
    public function updatedTitle($value): void {
        $this->generateSlug($value);
    }
    
    public function save() {
        $data = $this->validate([
            'title'            => 'required|string|max:255',
            'body'             => 'required|max:65000',
            'active'           => 'required',
            'slug'             => ['required', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('pages')->ignore($this->page->id)],
            'seo_title'        => 'required|max:70',
            'meta_description' => 'required|max:160',
            'meta_keywords'    => 'required|regex:/^[A-Za-z0-9-éèàù]{1,50}?(,[A-Za-z0-9-éèàù]{1,50})*$/',
        ]);
    
        $this->page->update($data);
        
        $this->success(__('Page edited with success.'), redirectTo: '/admin/pages/index');
    }
    
    private function generateSlug(string $title): void {
        $this->slug = Str::of($title)->slug('-');
    }
}; ?>

<div>
    <x-header title="{{ __('Edit a page') }}" shadow separator progress-indicator>
        <x-slot:actions class="lg:hidden">
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    @include('livewire.admin.pages.page-form')
</div>
```

#### Traduction Éditer Pages

```php
"Page edited with success.": "Page mise à jour avec succès.",
"Edit a page": "Modifier une page"
```

### Réf.: ***<https://laravel.sillo.org/posts/mon-cms-les-pages>***
