---
markmap:
  duration: 2100
  initialExpandLevel: -1
---
# Mon CMS

<!-- VSCode: Utiliser l'extension markmap
Forcer l'ouverture d'une branche en preview :
Ajouter '\' ainsi ' <!-- markmap: fold -->'

<!-- Si vous souhaiter modifier ce mémo,
mais avez besoin d'aide, n'hésitez-pas
à nous contacter. Voir "AIDE & CONTACT" 
en fin de ce mémo -->

## MANUEL → Mode d'Emploi <!-- markmap: fold -->

### Mode d'emploi

#### Explorer les branches

* ... Successivement en 'mode étude'.

  ```markdown
    Développer le noeud le plus haut que vous n'avez pas encore visité
    (Et si vous démarrez tout juste, c'est donc comme vous avez dû le faire
    pour lire ces mots, en ayant cliqué sur... Ce 'MANUEL' ! ), et allez
    alors jusqu'au bout de la branche avant de passer au suivant.
    (Vous êtes 'au bout' d'un flux lorsqu'il n'y a plus de point ou de ligne
    à droite du dernier sujet déployé, comme c'est la cas pour celui-ci.).

    Une fois le sujet en cours exploité, regarder celui (ou ceux) en-dessous,
    et quand il n'y en a plus, pour trouver le noeud suivant, remonter
    au sujet juste là, à gauche : Ici, c'est donc 'Explorer les branches'

    Cliquer sur son point pour le fermer, et ouvrir le suivant.

    Donc, présentement, le prochain point à explorer est :
    'Coder... Oui... Mais pas de suite !'

    Et ainsi de suite...

* ... Selon la thématique de la racine en 'mode recherche'.

#### Coder... Oui... Mais pas de suite ! <!-- markmap: fold -->

##### (Pour Momo, mais pas que... ;-)) Commencer par survoler les généralités, simplement en les lisant toutes

##### → Ne commencer à coder qu'à partir du noeud racine '**Le projet (Mon CMS)**'

##### Astuces

* Considérer que ce Mémo est destiné à, et optimisé pour être utilisé en mode '<a href="https://laravel.sillo.org/doc/laravel" title="See it !" target="_blank">*Preview*</a>' (<a href="https://laravel.sillo.org/doc/laravel" title="La voir !" target="_blank">Prévisualisation</a>) :
* Surtout, utiliser une 'vraie' souris (Et pas le *paddle* si vous êtes sur un *notebook* (Ordinateur portable))
pour entre autre, y naviguer aisément et grâce à la molette, zoomer/dé-zoomer facilement.
* Pour **Copier/Coller** de (s || longs) scripts dans la *Preview* :
\- Cliquer tout à la fin du 'pavé' désiré,
\- Si nécessaire, remonter au tout début en faisant un *drop & drag* (Glisser-déposer)
&nbsp; en cliquant au départ sur 'rien' (un espace 'vide'), peut-être à l'aide d'un coup de "dé-zoom" si le fichier est
&nbsp; vraiment très long pour vous y rendre rapidement...
\- Cliquer juste avant le 1<sup>er</sup> caractère du bloc, en maintenant la touche *SHIFT* (Majuscule) enfoncée,
&nbsp; → À ce stade, l'ensemble du texte doit apparaître sélectionné.
\- Au clavier, faites  la combinaison '**Ctrl + C**' pour **C**opier,
\- Puis '**Ctrl + V**' pour '**V**a !' dans votre éditeur, dans le fichier cible.
&nbsp; *N'hésitez-pas à vous y entraîner et tester, ne serait-ce avec ce bloc...* ;-) *!*

##### *Bonne exploration et... Bon code !*

### Philosophie <!-- markmap: fold -->

* Ce type de présentation peut de prime abord, vous sembler surprenante, mais...

    ... Passé le cap de la surprise et de la découverte... :
    <br>

    Au delà de l'aspect qui peut sembler ludique, et plutôt sympa sur le plan esthétique,
    car étant coloré, animé et dynamique, ce Mémo peut vite devenir, au fil du temps,
    **votre allié le plus puissant** pour avoir une **vision** quasi **synoptique du sujet étudié**.<br>
    Donc, si vous parvenez à réussir à l'utiliser, ne serait-ce dans un premier temps,
    pour découvrir, apprendre, voire réviser vos connaissances, vous observerez
    en principe assez rapidement dans l'avenir que vous saurez y revenir, et y **retrouver**,
    parce qu'organisées, **facilement et rapidement**, les **infos dont vous aurez alors
    ponctuellement besoin** :-) !
    <br>

    *Bon usage... Et bon code !*

## LARAVEL VOLT - Généralités <!-- markmap: fold -->

### 1 / Bases Laravel <!-- markmap: fold -->

* **composer  create-project laravel/laravel monapp --prefer-dist**
* Paramètres .env file (APP_NAME, APP_URL & DB_DATABASE)
* Ajout Fr :
  **composer require --dev laravel-lang/common
  php artisan lang:update**
* Ajout Debugbar : **composer require barryvdh/laravel-debugbar --dev**

### 2 / Gestion des Models et Tables <!-- markmap: fold -->

#### Légendes <!-- markmap: fold -->

* Mmm : Nom d'un Model (ex. User)
* Ttt : Nom d'une table (ex. users)
* Ccc : Nom d'une colonne (ex. name)

#### Tables <!-- markmap: fold -->

* Migration seule : *php artisan make:migration create_nnn_table*
* Factory : *php artisan make:factory MmmFactory*
* Seeders : *php artisan make:seeder MmmSeeder*
* Penser à appeler les seeders dans database/seeders/DataBaseSeeder.php:

  ```php
    $this*>call([
      Mmm1Seeder::class,
      Mmm2Seeder::class,
      etc...
    ]);
  ```

* Puis à les exécuter : *php artisan db:seed*

#### Models, relations & migrations <!-- markmap: fold -->

* Model (Mmm) :
\- **protected $timestamps = false;** *Si pas besoin des champs created_at & updated_at*
\- **protected $fillable = ['Ccc1', 'Ccc2', ...];** *Pour population en masse*

* Relations :
  * 1:n :
    * (1): Dans MmmN :
      &nbsp; &nbsp; - **use Illuminate\Database\Eloquent\Relations\BelongsTo;**
      &nbsp; &nbsp; - **public function Mmm1(): BelongsTo {
      &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;return $this→belongsTo(Mmm1::class);
      &nbsp; &nbsp; &nbsp; }**
    * (n): Dans Mmm1 !
      &nbsp; &nbsp; - **use Illuminate\Database\Eloquent\Relations\HasMany;**
      &nbsp; &nbsp; - **public function MmmN(): HasMany {
      &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;return $this→HasMany(MmmN::class);
      &nbsp; &nbsp; &nbsp; }**

* Migrations seules :
\- **php artisan make:migration create_Ttt_table**
\- **php artisan make:migration create_Ttt_table --create=products**
\- **php artisan make:migration add_Ccc_to_Ttt_table --table=Ttt**

* Model & sa Migration simultanément :
\- **php artisan make:model Mmm -migration**
  ou
\- **php artisan make:model Mmm -m**

* Exécuter les migrations seules :
\- **php artisan migrate** *la 1ère fois*
\- **php artisan migrate:refresh --seed** *pour reset complet*

### 3 / Divers <!-- markmap: fold -->

* Les Helpers ( app/**helpers.php** )
  (*Y écrire les fonctions appelées souvent d'un peu n'importe où ensuite*)

* ./**composer.json** :
<br>

  ```php
    ...
    "autoload": {
      "files": [
        "app/helpers.php"
      ],
      ...
    },
    ...
  ```

  <br>

  ```bash
    composer dumpautoload
  ```

### Extrait de: ***<a href="https://laravel.sillo.org/posts/mon-cms-les-donnees" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-les-donnees</a>***

### Technos

#### MaryUI <!-- markmap: fold -->

##### Installation de MaryUI

* ```bash
    composer require robsontenorio/mary
    php artisan mary:install
  ```

* → **0** (livewire/Volt)
* → **npm install --save-dev** (npm)

##### Réf.: **<a href="https://mary-ui.com" title="Voir les détails" target="_blank">Doc complète MaryUI</a>**

#### Volt <!-- markmap: fold -->

##### Bases d'un composant VOLT

* UNE FONCTIONNALITÉ avec UN COMPOSANT VOLT (LOGIQUE + VUE) :
  
* 1 / Définir une route ( ./route/**web.php** ) :

  ```php
    use Livewire\Volt\Volt
    ...
    Volt::route('/url', 'dossier(s).fichier')->name('dossier.fichier');
  ```

  → Recommandé à chaque changement des routes :

  ```bash
    php artisan view:clear & php artisan route:clear
  ```

  → Pour contrôle, liste de toutes les routes :

  ```bash
    php artisan route:list
  ```

* 2 / Créer un lien quelque part (NavBar, SideBar, Menus, Autres...)

* 3 / Créer le composant :

  ```bash
    php artisan make:volt dossier/fichier --class
  ```

  &nbsp; &nbsp; &nbsp;Y définir :
  &nbsp; &nbsp; &nbsp; - La Logique (La classe **PHP**)
  &nbsp; &nbsp; &nbsp; - La Vue (HTML - Template **Blade**)

* 4 / Parfois, besoin de styliser quelques balises :
  
  &nbsp; &nbsp; &nbsp; → Créer/Compléter le fichier **.css** dans le dossier **resources/css**

* 5 / Souvent, besoin de traduire quelques termes :
  
  &nbsp; &nbsp; &nbsp; → Définir les clés:valeurs pour le fichier de langue (ex.: lang/**fr.json**)

<a href="https://livewire.laravel.com/docs/quickstart" title="Voir tous les détails" target="_blank">Doc complète LIVEWIRE, compris VOLT</a>**

#### Extraits de : ***<a href="https://laravel.sillo.org/posts/mon-cms-lauthentification" title="Voir la totale" target="_blank">https://laravel.sillo.org/posts/mon-cms-lauthentification</a>***

## Le projet (Mon CMS) <!-- markmap: fold -->

### Installation de Laravel <!-- markmap: fold -->

#### Commande de base

* En ***CLI** - **C**ommande **L**ine **I**nterface* (Console) :

  ```bash
    composer create-project laravel/laravel moncms --prefer-dist
  ```

* Cette commande inclue l'installation des dépendances (PHP) et librairies (JS)...
  ... Pour relancer parfois leurs mises à jours, utiliser les commandes suivantes en CLI :

  ```bash
    composer update
  ```

  Et :

  ```bash
    npm i
  ```

#### Settings ( ./.env )

* Adapter le ./**.env** :

  ```json
    APP_NAME="Mon CMS"
    ...
    APP_URL=http://moncms (là ajustez selon votre serveur local)
    ...
    APP_LOCALE=fr
    ...
    DB_CONNECTION=mysql OU sqlite (Alors, pas besoin des lignes DB_... ci-dessous)
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=moncms
    DB_USERNAME=root
    DB_PASSWORD=
    ...
    MAIL_FROM_USER="MonPseudo"
    MAIL_FROM_ADDRESS="MonEmail@example.com"
    ...
  ```

* Pour contrôle :

  ```bash
    php artisan about
  ```

* À noter: ∃ un fichier ./**.env_exemple**...En effet, lors du dépôt **Git** d'un projet, le ./**.env** est souvent,
 pour ne pas dire toujours, ignoré des ***push***es... Donc, en cas de clone par un tier, ce fichier sert
 de matrice pour l'aider à recréer son ./**.env**

### Exécuter votre script <!-- markmap: fold -->

#### Start ( & / || ) Restart des serveurs

* **PHP** dans une première console (**CLI**):

* ```bash
    php artisan serv
  ```

* **VITE!** dans une seconde CLI :

* ```bash
    npm run dev
  ```

#### Ouvrir votre navigateur sur : <a href="http://127.0.0.1:8000" title="Votre App en local" target = "_blank">http://127.0.0.1:8000</a>

### Outil recommandé (La Debugbar) <!-- markmap: fold -->

* Installer la debugbar, active qu'en développement
(Dans ./**.env** : **APP_DEBUG = true**) :

  ```bash
    composer require barryvdh/laravel-debugbar --dev
  ```

* *[Re]start servers* ([Re]démarrer les serveurs)

### Package des langues <!-- markmap: fold -->

* ```bash
    composer require --dev laravel-lang/common
    php artisan lang:update
  ```

* Et modifier dans le fichier généré: lang/**fr.Json** :

  ```json
    "Home": "Maison",
  ```

* en :

  ```json
    "Home": "Accueil",
  ```

### Les données <!-- markmap: fold -->

#### Table *users* <!-- markmap: fold -->

##### database/migrations/**0001_01_01_000000_create_users_table.php** <!-- markmap: fold -->

  ```php
    public function up(): void {
      Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->enum('role', ['user', 'redac', 'admin'])->default('user');
        $table->boolean('valid')->default(false);
        $table->rememberToken();
        $table->timestamps();
      });
      ...
    }
  ```

##### database/factories/**UserFactory.php** <!-- markmap: fold -->

  ```php
  class UserFactory extends Factory {
    public static $users = [];
    protected static ?string $password;
  
    public function definition(): array {
      [$name, $email] = $this->uniqueUserNameAndEmail();
      return [
        'name'           => $name,
        'email'          => $email,
        'password'       => static::$password ??= Hash::make('password'),
        'remember_token' => Str::random(10),
        'valid'          => true,
      ];
    }
    
    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
    
    public function uniqueUserNameAndEmail() {
      static $names;
  
      $name = fake('fr_FR')->lastname();
      // $name = $this->fakeFakes();
      if (!isset($names[$name])) {
        $names[$name] = 1;
        self::$users[] = $pseudo = $name;
      } else {
        $names[$name]++;
        $pseudo = self::$users[] = $name . '-' . ($names[$name] - 1);
      }
      $email = strtolower(str_replace(' ', '_', $pseudo) ) . '@example.com';
  
      return [$name, $email];
    }
  
  // private function fakeFakes() {
  //   static $n  = 0;
  //   $fakeFakes = ['a', 'b', 'a', 'b', 'd', 'a', 'e'];
  
  //   return $fakeFakes[$n++ % count($fakeFakes)];
  // }
  }
  ```

##### app/Models/**User.php** <!-- markmap: fold -->

  ```php
    ...
    class User extends Authenticatable {   
      ...
      protected $fillable = ['name', 'email', 'password', 'role', 'valid'];
    }
  ```

#### Table *categories* <!-- markmap: fold -->

##### Model & migration des *categories* <!-- markmap: fold -->

```bash
  php artisan make:model Category --migration
```

##### Migrations des *categories* <!-- markmap: fold -->

  ```php
    public function up(): void {
      Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('title')->unique();
        $table->string('slug')->unique();
      });
    }
  ```

##### app/Models/Category <!-- markmap: fold -->

  ```php
    <?php
    ...
    class Category extends Model {
      public $timestamps = false;
    
      protected $fillable = ['title', 'slug'];
    }
  ```

#### Table *posts* (Articles) <!-- markmap: fold -->

##### Création model & migration des articles <!-- markmap: fold -->

  ```bash
    php artisan make:model Post --migration
  ```

##### Migration des articles <!-- markmap: fold -->

  ```php
    public function up(): void {
      Schema::create('posts', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->foreignId('user_id')
        ->constrained()
        ->onDelete('cascade')
        ->onUpdate('cascade');
      $table->foreignId('category_id')
        ->constrained()
        ->onDelete('cascade')
        ->onUpdate('cascade');
      $table->boolean('active')->default(false);
      $table->string('slug')->unique();
      $table->mediumText('body');
      $table->string('image')->nullable();
      $table->string('seo_title');
      $table->text('meta_description');
      $table->text('meta_keywords');
      $table->boolean('pinned')->default(false);
      $table->timestamps();
      });
    }
  ```

##### Création Factory des articles <!-- markmap: fold -->

  ```bash
    php artisan make:factory PostFactory
  ```

##### Code factory articles <!-- markmap: fold -->

  ```php
    public function definition(): array {
      return [
        'body'             => fake()->paragraphs($nb = 8, $asText = true),
        'meta_description' => fake()->sentence($nbWords = 6, $variableNbWords = true),
        'meta_keywords'    => implode(',', fake()->words($nb = 3, $asText = false)),
        'active'           => true,
      ];
    }
  ```

##### app/Models/Post <!-- markmap: fold -->

  ```php
    ...
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    ...
    class Post extends Model {
      use HasFactory;
      protected $fillable = ['title', 'slug', 'body', 'active', 'image', 'user_id', 'category_id', 'seo_title', 'meta_description', 'meta_keywords', 'pinned'];
    }
  ```

#### Les relations <!-- markmap: fold -->

##### Les relations dans Models/**Post.php** <!-- markmap: fold -->

  ```php
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    
    class Post extends Model {
      ...
      public function user(): BelongsTo {
        return $this->belongsTo(User::class);
      }
      public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
      }
    }
  ```

##### La relation dans Models/**User.php** <!-- markmap: fold -->

  ```php
    use Illuminate\Database\Eloquent\Relations\HasMany;
    
    class User extends Authenticatable {
      ...
      public function posts(): HasMany {
        return $this->hasMany(Post::class);
      }
      ...
    }
  ```

##### La relation dans Models/**Category.php** <!-- markmap: fold -->

  ```php
    use Illuminate\Database\Eloquent\Relations\HasMany;
    
    class Category extends Model {
      ...
      public function posts(): HasMany {
        return $this->hasMany(Post::class);
      }
    }
  ```

#### Exécution des migrations <!-- markmap: fold -->

* ```bash
  php artisan migrate
  ```

* **<a href="https://laravel.sillo.org/storage/photos/2024/08/XIVfqMqmJ7OUNl9kwGWNk5duv0U0nweTIz2nbI1E.png" title="Voir les détails" target="_blank">Voir diagramme UML des 3 tables</a>**

#### Population des *users* <!-- markmap: fold -->

##### Création du seeder User

  ```bash
    php artisan make:seeder UserSeeder
  ```

##### Code du seeder des fake users

  ```php
    <?php
    namespace Database\Seeders;
    
    use Carbon\Carbon;
    use App\Models\User;
    use Illuminate\Database\Seeder;
    
    class UserSeeder extends Seeder {
      public function run() {
        $users = [
          [
              'name'       => 'Admin',
              'email'      => 'admin@example.com',
              'role'       => 'admin',
              'created_at' => Carbon::now()->subYears(3),
              'updated_at' => Carbon::now()->subYears(3),
          ],
          [
              'name'       => 'Redac',
              'email'      => 'redac@example.com',
              'role'       => 'redac',
              'created_at' => Carbon::now()->subYears(3),
              'updated_at' => Carbon::now()->subYears(3),
          ],
          [
              'name'       => 'User',
              'email'      => 'user@example.com',
              'role'       => 'user',
              'created_at' => Carbon::now()->subYears(2),
              'updated_at' => Carbon::now()->subYears(2),
          ],
          [
              'name'       => env('MAIL_FROM_USER', 'Moi'),
              'email'      => env('MAIL_FROM_ADDRESS', 'moi@example.com'),
              'role'       => 'admin',
              'created_at' => Carbon::now()->subYears(3),
              'updated_at' => Carbon::now()->subYears(3),
          ],
        ];
        foreach ($users as $userData) {
          User::factory()->create($userData);
        }
        User::factory(3)->create();

        $u = User::find(6);
        $u->valid = false;
        $u->save();
      }
    }
  ```

#### Population des *categories* <!-- markmap: fold -->

##### Création du seeder Category

  ```bash
    php artisan make:seeder CategorySeeder
  ```

##### Code du seeder des fake categories

  ```php
  ...
  public function run(): void {
      $nbCategories = 3;
      for ($i = 1; $i <= $nbCategories; ++$i) {
        $title        = "Catégorie {$i}";
        $titleForSlug = str_replace('ie', 'y', $title);
        $slug         = Str::slug($titleForSlug);
        Category::create(['title' => $title, 'slug' => $slug]);
      }
  }
  ```

#### Population des *posts* <!-- markmap: fold -->

##### Créer app/**helpers.php** <!-- markmap: fold -->

###### Y copier : generateRandomDateInRange()

  ```php
    <?php
    if (!function_exists('generateRandomDateInRange')) {
      function generateRandomDateInRange($startDate, $endDate) {
        $start = Carbon\Carbon::parse($startDate);
        $end   = Carbon\Carbon::parse($endDate);
    
        $difference = $end->timestamp - $start->timestamp;
    
        $randomSeconds = rand(0, $difference);
    
        return $start->copy()->addSeconds($randomSeconds);
      }
    }
  ```

###### Activation de ce helper dans **composer.json**

  ```php
    "autoload": {
        "files": [
          "app/helpers.php"
        ],
        ...
    },
```

###### Update de l'autoload

  ```bash
    composer dumpautoload
  ```

##### Création du seeder de fake posts

  ```bash
    php artisan make:seeder PostSeeder
  ```

##### Code du seeder des fake posts

  ```php
    <?php
    namespace Database\Seeders;
    
    use App\Models\Post;
    use Illuminate\Support\Str;
    use Illuminate\Database\Seeder;
    
    class PostSeeder extends Seeder {
      public static $nbrPosts;
  
      public function run() {
        $nbrCategories = 3;
    
        $this->createPost(1, 1);
        $this->createPost(2, rand(1, $nbrCategories));
        $this->createPost(3, 1);
        $this->createPost(4, 1);
        $this->createPost(5, rand(1, $nbrCategories));
        $this->createPost(6, 1);
        $this->createPost(7, 1);
        $this->createPost(8, rand(1, $nbrCategories));
        $this->createPost(9, rand(1, $nbrCategories));
      }
    
      protected function createPost($id, $category_id) {
        $months = ['03', '03', '03', '04', '04', '06', '06', '06', '06'];
    
        $date = generateRandomDateInRange('2022-01-01', '2024-11-07');
    
        $postId = "Post {$id}";
    
        return Post::factory()->create([
          'title'       => $postId,
          'seo_title'   => $postId,
          'slug'        => Str::of($postId)->slug('-'),
          'user_id'     => rand(1, 2),
          'image'       => '2024/' . $months[$id - 1] . '/img0' . $id . '.jpg',
          'category_id' => $category_id,
          'created_at'  => $date,
          'updated_at'  => $date,
          'pinned'      => 5 == $id,
        ]);
      }
    }
  ```

#### Activation des *seeders* <!-- markmap: fold -->

* database/seeders/**DatabaseSeeder.php** :

  ```php
    <?php
    namespace Database\Seeders;
    
    use Illuminate\Database\Seeder;
    
    class DatabaseSeeder extends Seeder {
      public function run(): void {
        $this->call([
          UserSeeder::class,
          CategorySeeder::class,
          PostSeeder::class,          
        ]);
    
        printf('%s%s', str_repeat(' ', 2), "Data tables properly filled.\n\n");
      }
    }
  ```

  ```php
    php artisan db:seed
  // Ou, reset complet :
    php artisan migrate:refresh --seed
  ```

#### Les pages <!-- markmap: fold -->

##### Création Model & migration Page <!-- markmap: fold -->

  ```bash
    php artisan make:model Page --migration
  ```

##### Code migration Page <!-- markmap: fold -->

  ```php
    public function up(): void {
      Schema::create('pages', function (Blueprint $table) {
        $table->id();
        $table->string('slug');
        $table->string('title');
        $table->mediumText('body');
        $table->boolean('active')->default(false);
        $table->string('seo_title');
        $table->text('meta_description');
        $table->text('meta_keywords');
      });
    }
  ```

##### Code app/models/Page <!-- markmap: fold -->

  ```php
    <?php
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    
    class Page extends Model {
      use HasFactory;
    
      public $timestamps  = false;
      protected $fillable = [
        'title',
        'slug',
        'body',
        'active',
        'seo_title',
        'meta_description',
        'meta_keywords',
      ];
    }
  ```

##### Création factory Page <!-- markmap: fold -->

  ```bash
    php artisan make:factory PageFactory
  ```

##### Code factory Page <!-- markmap: fold -->

  ```php
    public function definition(): array {
      return [
        'body'             => fake()->paragraph(10),
        'meta_description' => fake()->sentence($nbWords = 6, $variableNbWords = true),
        'meta_keywords'    => implode(',', fake()->words($nb = 3, $asText = false)),
      ];
    }
  ```

##### Création seeder Page <!-- markmap: fold -->

  ```bash
    php artisan make:seeder PageSeeder
  ```

##### Code du seeder Page <!-- markmap: fold -->

  ```php
    <?php
    namespace Database\Seeders;
    
    use App\Models\Page;
    use Illuminate\Database\Seeder;
    
    class PageSeeder extends Seeder {
      public function run() {
        $items = [
          ['slug' => 'terms', 'title' => 'Terms'],
          ['slug' => 'privacy-policy', 'title' => 'Privacy Policy'],
        ];
    
        foreach ($items as $item) {
          Page::factory()->create([
            'title'     => $item['title'],
            'seo_title' => 'Page ' . $item['title'],
            'slug'      => $item['slug'],
            'active'    => true,
          ]);
        }
      }
    }
  ```

##### Ajout de ce seeder dans **DatabaseSeeder.php** <!-- markmap: fold -->

  ```php
    public function run(): void {
      $this->call([
        ...
        PageSeeder::class,   
      ]);
      ...
    }
  ```

##### Rafraîchissement de la base <!-- markmap: fold -->

  ```bash
    php artisan migrate:fresh --seed
  ```

### Réf.: ***<a href="https://laravel.sillo.org/posts/mon-cms-les-donnees" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-les-donnees</a>***

## &nbsp;**I &nbsp;/ &nbsp; F R O N T &nbsp;- &nbsp;E N D &nbsp;:**

## - L'authentification <!-- markmap: fold -->

### Installer **MaryUI** (Avec **Volt** et **npm**) <!-- markmap: fold -->

#### Revoir ci-avant : ' Généralités / Technos / MaryUI ' pour l'installation

#### Sont alors créés (Entre autres...)

* Une route (./routes/**web.php**)
* Un layout (./resources/views/components/layouts/**app.blade.php**)
* Un composant Volt (./resources/views/livewire/users/**index.blade.php**)

#### Rappel : Dorénavant, bien lancer aussi le serveur Vite

  ```bash
    npm run dev
  ```

##### **<a href="http://127.0.0.1:8000" title="Votre App en local" target="_blank">URL du rendu</a>**

### Layout pour l'authentification <!-- markmap: fold -->

* ./resources/views/components/layouts/**auth.blade.php** :

  ```html
  <!DOCTYPE html>
  <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>{{ (isset($title) ? $title . ' | ' : (View::hasSection('title') ? View::getSection('title') . ' | ' : '')) . config('app.name') }}</title>
      @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  
  <body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">
  
      <x-main full-width>
          <x-slot:content>
              {{ $slot }}
          </x-slot:content>
      </x-main>
  
      <x-toast />
  </body>
  
  </html>
  ```

### Composants **VOLT** pour l'authentification <!-- markmap: fold -->

#### Composant Register <!-- markmap: fold -->

##### Route pour Register <!-- markmap: fold -->

* ./routes/**web.php** :

  ```php
  use Illuminate\Support\Facades\Route;
  ...
  Route::middleware('guest')->group(function () {
      Volt::route('/register', 'auth.register');
  });
  ```

##### Création composant Register <!-- markmap: fold -->

  ```bash
    php artisan make:volt auth/register --class
  ```

##### Code register <!-- markmap: fold -->

  ```html
    <?php
    use App\Models\User;
    use Mary\Traits\Toast;
    use Livewire\Volt\Component;
    use Illuminate\Support\Facades\Hash;
    use App\Notifications\UserRegistered;
    use Livewire\Attributes\{Layout, Validate, Title};
    
    new #[Layout('components.layouts.auth')] 
    class extends Component {
        use Toast;
  
      #[Validate('required|string|max:255|unique:users')]
      public string $name = '';
      #[Validate('required|email|unique:users')]
      public string $email = '';
      #[Validate('required|confirmed')]
      public string $password = '';
      #[Validate('required')]
      public string $password_confirmation = '';
      #[Validate('sometimes|nullable')]
      public ?string $gender = null;
  
      public function register() {
        if ($this->gender) {
            abort(403);
        }
        $data = $this->validate();
        $user = $this->createUser($data);
        auth()->login($user);
        request()->session()->regenerate();
        $this->success(__('Registration successful!'), redirectTo: '/');
      }
  
      protected function createUser(array $data): User {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
      }
    
    }; ?>
    @section('title', __('Register'))
    <div>
      <x-card class="flex items-center justify-center h-[96vh]">
        <a href="/" title="{{ __('Back to site') }}">
          <x-card class="items-center" title="{{ __('Register') }}" shadow separator progress-indicator />
        </a>
        <x-form wire:submit="register" class="w-full sm:min-w-[30vw]">
          <x-input label="{{ __('Name') }} *" wire:model="name" icon="o-user" inline required />
          <x-input label="{{ __('E-mail') }} *" wire:model="email" icon="o-envelope" inline required />
          <x-input label="{{ __('Password') }} *" wire:model="password" type="password" icon="o-key" inline required />
          <x-input label="{{ __('Confirm Password') }} *" wire:model="password_confirmation" type="password" icon="o-key" inline required />
          <p class="text-[12px] text-right italic my-[-10px]">* : {{__('Required information') }}</p>
          <div style="display: none;">
              <x-input wire:model="gender" type="text" inline />
          </div>
          <x-slot:actions>
            <x-button label="{{ __('Already registered?') }}" class="btn-ghost" link="/login" />
            <x-button label="{{ __('Register') }}" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="login" />
          </x-slot:actions>
          </x-form>
      </x-card>
    </div>
  ```

##### Traductions pour formulaire Register <!-- markmap: fold -->

* ./lang/**fr.json** :

  ```json
  "Password": "Mot de passe",
  "Confirm Password": "Confirmation du mot de passe",
  "Register": "Créer un compte",
  "Already registered?": "Déjà enregistré ?",
  "Name": "Nom",
  "E-mail": "Courriel",
  "Required information": "Information requise",
  "Registration successful!": "Compte créé avec succès !"
  ```

##### Particularité : Pot de miel <!-- markmap: fold -->

* À noter : ∃ un champs caché (gender) pour identifier les robots...
* '*On n'arrête pas l'progrès'* !' (*Lol* !) : Un 'robot' extralucide, car
ce champs est logiquement invisible..., va dire de quel sexe il est !!! ;-)
* Voir dans le code du composant : **if ($this->gender) abort(403);**
(*Bon, même si on n'est pas encore à la pire ère de *Terminator*,
on l'envoie quand même immédiatement bouler* ! :-) → *Error* **403 !**

##### **<a href="http://127.0.0.1:8000/register" title="Tester la validation des champs" target="_blank">Rendu Register</a>**

#### Composant Login <!-- markmap: fold -->

##### Route pour Login <!-- markmap: fold -->

  ```php
  ...
  Route::middleware('guest')->group(function () {
      ...
      Volt::route('/login', 'auth.login')->name('login');
  });
  ```

##### Création composant Login <!-- markmap: fold -->

  ```bash
    php artisan make:volt auth/login --class
  ```

##### Code Login <!-- markmap: fold -->

  ```html
  <?php
    use Livewire\Volt\Component;
    use Illuminate\Support\Str;
    use Illuminate\Auth\Events\Lockout;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\RateLimiter;
    use Illuminate\Validation\ValidationException;
    use Livewire\Attributes\{Layout, Validate, Title};

    new
    #[Layout('components.layouts.auth')]
    class extends Component {
    
      #[Validate('required|string|email')]
      public string $email = '';
      #[Validate('required|string')]
      public string $password = '';
      #[Validate('boolean')]
      public bool $remember = false;
  
      public function login() {
        $this->validate();
        $this->authenticate();
        Session::regenerate();
        if (auth()->user()->isAdmin()) {
            return redirect()->intended('/admin/dashboard');
        }
        $this->redirectIntended(default: url('/'), navigate: true);
      }
    
      public function authenticate(): void {
        $this->ensureIsNotRateLimited();
        if (! Auth::attempt($this->only(['email', 'password']), $this->remember)) {
          RateLimiter::hit($this->throttleKey());
          throw ValidationException::withMessages([
              'email' => __('auth.failed'),
          ]);
        }
        RateLimiter::clear($this->throttleKey());
      }
    
      protected function ensureIsNotRateLimited(): void {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
          return;
        }
        event(new Lockout(request()));
        $seconds = RateLimiter::availableIn($this->throttleKey());
        throw ValidationException::withMessages([
          'email' => trans('auth.throttle', [
            'seconds' => $seconds,
            'minutes' => ceil($seconds / 60),
          ]),
        ]);
      }
  
      protected function throttleKey(): string {
        return Str::transliterate(Str::lower($this->email).'|'. request()->ip());
      }
    
    }; ?>
    
    @section('title', __('Login'))
    <div>
      <x-card class="flex items-center justify-center h-screen">
        <a href="/" title="{{ __('Back to site') }}">
          <x-card class="items-center" title="{{ __('Login') }}" shadow separator progress-indicator />
        </a>
        <x-form wire:submit="login">
          <x-input label="{{ __('E-mail') }} *" wire:model="email" icon="o-envelope" type="email" inline />
          <x-input label="{{ __('Password') }} *" wire:model="password" type="password" icon="o-key" type="password" inline />
          <x-checkbox label="{{ __('Remember me') }}" wire:model="remember" />
          <p class="text-[12px] text-right italic my-[-10px]">* : {{__('Required information') }}</p> 
          <x-slot:actions>
            <div class="flex flex-col space-y-2 flex-end sm:flex-row sm:space-y-0 sm:space-x-2">
              <x-button label="{{ __('Login') }}" type="submit" icon="o-paper-airplane" class="ml-2 btn-primary sm:order-1" />
              <div class="flex flex-col space-y-2 flex-end sm:flex-row sm:space-y-0 sm:space-x-2">
                <x-button label="{{ __('Forgot your password?') }}" class="btn-ghost" link="/forgot-password" />
                <x-button label="{{ __('Register') }}" class="btn-ghost" link="/register" />
              </div>
            </div>
          </x-slot:actions>
        </x-form>
      </x-card>
    </div>
  ```

##### Traductions pour formulaire Login <!-- markmap: fold -->

  ```json
"Forgot your password?": "Mot de passe oublié ?",
"Remember me": "Se rappeler de moi"
  ```

##### **<a href="http://127.0.0.1:8000/login" title="Tester la validation des champs" target="_blank">Rendu Login</a>**

#### Oubli et reset du mot de passe

##### Gestion des sessions <!-- markmap: fold -->

###### Création composant messages en session

  ```bash
  php artisan make:component session-status --view
  ```

###### Code composant Session

  ```html
  @props(['status'])
  
  @if ($status)
      <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600']) }}>
      {{ $status }}
      </div>
  @endif
  ```

##### Gestion de l'oubli du mot de passe <!-- markmap: fold -->

###### Route pour forgot-password <!-- markmap: fold -->

  ```php
  Route::middleware('guest')->group(function () {
      ...
      Volt::route('/forgot-password', 'auth.forgot-password');
  });
  ```

###### Création composant oubli mot de passe <!-- markmap: fold -->

  ```bash
php artisan   make:volt auth/forgot-password --class
  ```

###### Composant forgot-password <!-- markmap: fold -->

  ```html
    <?php
    use Livewire\Volt\Component;
    use Livewire\Attributes\{ Layout, Title };
    use Illuminate\Support\Facades\Password;
    
    new
    #[Layout('components.layouts.auth')]
    class extends Component {
    
      public string $email = '';
      public function sendPasswordResetLink(): void {
        $this->validate([
          'email' => ['required', 'string', 'email'],
        ]);
        $status = Password::sendResetLink(
            $this->only('email')
        );
        if (Password::RESET_LINK_SENT != $status) {
            $this->addError('email', __($status));
  
            return;
        }
    
        $this->reset('email');
        session()->flash('status', __($status));
      }
    }; ?>
    
  @section('title', __('Password renewal'))
  <div>
    <x-card class="flex items-center justify-center h-[96vh]" data-link='/' data-tip="{{  __('Back to site') }}" title="{{ __('Password renewal') }}" subtitle="{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}" shadow separator progress-indicator id='my-title'>
      <x-session-status class="mb-4" :status="session('status')" />
      <x-form wire:submit="sendPasswordResetLink">
        <x-input label="{{ __('E-mail') }} *" wire:model="email" icon="o-envelope" inline required />
        <x-slot:actions>
          <x-button label="{{ __('Email Password Reset Link') }}" type="submit" icon="o-paper-airplane" class="btn-primary" />
        </x-slot:actions>
      </x-form>
    </x-card>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
      const card = document.getElementById('my-title');
      const link = card.getAttribute('data-link');
      const tip = card.getAttribute('data-tip');
      const divs = card.getElementsByTagName('div');
      // console.log(divs)
      const titleElement = card.querySelector('title');
      if (divs.length >= 4) {
        const titleElement = divs[3]; // Cible le quatrième <div>
        titleElement.innerHTML = `<a href="${link}" title="${tip}">${titleElement.innerHTML}</a>`;
      }
    });
    </script>
  </div>
  ```

###### Traduction pour forgot-password <!-- markmap: fold -->

  ```json
  "Password renewal": "Renouvellement du mot de passe",
  "Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.": "Mot de passe oublié ? Pas de problème. Indiquez-nous simplement votre adresse courriel et nous vous enverrons par courriel un lien de réinitialisation du mot de passe pour en choisir un nouveau.",
  "Email Password Reset Link": "Envoi du lien de renouvellement"
  ```

###### **<a href="http://127.0.0.1:8000/forgot-password" title="Tester la validation du champs - Ne pas soumettre le Formulaire" target="_blank">Rendu forgot-password</a>**

##### Gestion du reset du mot de passe <!-- markmap: fold -->

###### Route pour reset-password <!-- markmap: fold -->

  ```php
  Route::middleware('guest')->group(function () {
      ...
      Volt::route('/reset-password/{token}', 'auth.reset-password')->name('password.reset');
  });
  ```

###### Création composant reset-password <!-- markmap: fold -->

  ```bash
  php artisan make:volt auth/reset-password --class
  ```

###### Composant reset-password <!-- markmap: fold -->

  ```html
    <?php
    use Illuminate\Support\Str;
    use Livewire\Volt\Component;
    use Illuminate\Validation\Rules;
    use Livewire\Attributes\{Layout, Locked};
    use Illuminate\Auth\Events\PasswordReset;
    use Illuminate\Support\Facades\{Hash, Password, Session};
    
    new
    #[Layout('components.layouts.auth')]
    class extends Component {
      #[Locked]
      public string $token                 = '';
  
      public string $email                 = '';
      public string $password              = '';
      public string $password_confirmation = '';
      
      public function mount(string $token): void {
        $this->token = $token;
        $this->email = request()->input('email');
      }
      
      public function resetPassword(): void {
        $this->validate([
          'token'    => ['required'],
          'email'    => ['required', 'string', 'email'],
          'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);
    
        $status = Password::reset(
          $this->only('email', 'password', 'password_confirmation', 'token'),
          function ($user) {
            $user->forceFill([
                'password'       => Hash::make($this->password),
                'remember_token' => Str::random(60),
            ])->save();
            event(new PasswordReset($user));
          }
        );
    
        if (Password::PASSWORD_RESET != $status) {
            $this->addError('email', __($status));
  
            return;
        }
    
        Session::flash('status', __($status));
        $this->redirectRoute('login', navigate: true);
      }
    }; ?>
    
    @section('title', __('Reset Password'))
    <div>
      <x-card class="flex items-center justify-center h-[96vh]" shadow separator progress-indicator>
        <a href="/" title="{{ __('Back to site') }}">
            <x-card class="items-center" title="{{__('Reset Password')}}" shadow separator progress-indicator />
        </a>
        <x-session-status class="mb-4" :status="session('status')" />
        <x-form wire:submit="resetPassword">
          <x-input label="{{ __('E-mail') }} *" wire:model="email" icon="o-envelope" inline />
          <x-input label="{{ __('Password') }} *" wire:model="password" type="password" icon="o-key" inline />
          <x-input label="{{ __('Confirm Password') }} *" wire:model="password_confirmation" type="password" icon="o-key" inline required autocomplete="new-password" />
          <p class="text-[12px] text-right italic my-[-10px]">* : {{__('Required information') }}</p>
          <x-slot:actions>
            <x-button label="{{ __('Reset Password') }}" type="submit" icon="o-paper-airplane" class="btn-primary" />
          </x-slot:actions>
        </x-form>
      </x-card>
  </div>
  ```

<a href="http://127.0.0.1:8000/forgot-password" title="Tester la soumission du Formulaire" target="_blank">**Rendu forgot-password**</a>

###### Voir le email reçu <!-- markmap: fold -->

* Par défaut: Dans storage\logs\\**laravel.log** (Tout à la fin du fichier, le code HTML du courriel)

  OU, pour avoir le vrai rendu de ce courriel, une très bonne solution GRATUITE est **MailHog** :

<a href="https://github.com/mailhog/MailHog" title="Dépôt de MailHog" target="_blank">Installer MailHog</a> <!-- markmap: fold -->

* \- Dans .env :

  ```json
    # Start MailHog
    # Go to: http://localhost:8025
    MAIL_MAILER=smtp
    MAIL_HOST=localhost
    MAIL_PORT=1025
    MAIL_USERNAME=Admin
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="admin@example.com"
    MAIL_FROM_NAME="${APP_NAME}"
  ```

* \- Lancer le serveur **MailHog** :
&nbsp; → Exécuter le fichier exécutable récupéré

###### **<a href="http://127.0.0.1:8025" title="Ouvrir votre messagerie locale" target="_blank">URL du rendu des courriels avec MailHog</a>**

### Réf.: ***<a href="https://laravel.sillo.org/posts/mon-cms-lauthentification" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-lauthentification</a>***

## - La page d'accueil (*Homepage*) <!-- markmap: fold -->

### Routes index & category <!-- markmap: fold -->

  ```php
    Volt::route('/', 'index');
  // Supprimer : Volt::route('/', 'users.index');
    Volt::route('/category/{slug}', 'index');
  ```

### Création composant index <!-- markmap: fold -->

  ```bash
  php artisan make:volt index --class 
  ```

### Les images <!-- markmap: fold -->

* ```bash
  php artisan storage:link
  ```

  *(Cela crée un lien symbolique de public/storage vers storage/app/public)*
* Pour obtenir les images par défaut : [Télécharger le projet](https://laravel.sillo.org/tuto/moncms3.zip) et copier **storage/app/public/**\**/\*.\*
* Pour avoir vos images dans votre dépôt git, vu que publiques, supprimer :
\- storage/app/.gitignore
\- storage/app/public/.gitignore

### Layout app <!-- markmap: fold -->

* resources/components/layouts/**app.blade.php** :

  ```html
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>
        {{ (isset($title) ? $title . ' | ' : (View::hasSection('title') ? View::getSection('title') . ' | ' : '')) . config('app.name') }}
      </title>
      <meta name="description" content="@yield('description')">
      <meta name="keywords" content="@yield('keywords')">
      @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">
      {{-- HERO --}}
      <div class="min-h-[10vw] hero" style="background-image: url({{ asset('storage/hero.jpg') }});">
        <div class="bg-opacity-60 hero-overlay">
        </div>
        <a href="{{ '/' }}">
        <div class="text-center hero-content text-neutral-content">
          <div>
            <h1 class="mb-5 text-4xl font-bold sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl">
                Mon Titre
            </h1>
            <p class="mb-1 text-lg sm:text-xl md:text-1xl lg:text-2xl xl:text-3xl">
                Mon sous-titre
            </p>
          </div>              
        </div>
      </a>
      </div>
    </body>
  ```

### La barre de navigation <!-- markmap: fold -->

#### La Navbar (Grand écran ou bouton burger) <!-- markmap: fold -->

##### Création composant navbar <!-- markmap: fold -->

  ```bash
  php artisan make:volt navigation/navbar --class
  ```
  
##### Code composant navbar <!-- markmap: fold -->

  ```html
  <?php
    use Illuminate\Support\Facades\{Auth, Session};
    use Livewire\Volt\Component;
    
    new class extends Component {
    
      public function logout(): void {
        Auth::guard('web')->logout();
        Session::invalidate();
        Session::regenerateToken();
        $this->redirect('/');
      }
    }; ?>
    
    <x-nav sticky full-width >
      <x-slot:brand>
        <label for="main-drawer" class="mr-3 sm:hidden">
          <x-icon name="o-bars-3" class="cursor-pointer" />
        </label>
      </x-slot:brand>
      
      <x-slot:actions>
        <span class="hidden sm:block">
          @if ($user = auth()->user())
            <x-dropdown>
              <x-slot:trigger>
                <x-button label="{{ $user->name }}" class="btn-ghost" />
              </x-slot:trigger>
            <x-menu-item title="{{ __('Logout') }}" wire:click="logout" />
            </x-dropdown>
            @else
              <x-button label="{{ __('Login') }}" link="/login" class="btn-ghost" />
          @endif
        </span>
      </x-slot:actions>
    </x-nav>
  ```

##### Layout pour le composant navbar <!-- markmap: fold -->

* Attention: À ce stade, se connecter fait apparaître une erreur...
(Juste rafraîchir, et tester responsive - Ex.: Réduire la taille de l'écran...)

* Dans components/layouts/**app.blade.php** :

* Remplacer le bloc :

  ```html
    {{-- NAVBAR mobile only --}}
    <x-nav>
      ...
    <x-nav>
  ```

* Par :

  ```html
    ...
    {{-- NAVBAR --}}
    <livewire:navigation.navbar/>
  </body>
  ```

#### La Sidebar (Petit écran) <!-- markmap: fold -->

##### Création composant sidebar <!-- markmap: fold -->

  ```bash
    php artisan make:volt navigation/sidebar --class
  ```

##### Code composant sidebar <!-- markmap: fold -->

  ```html
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
    };
    ?>
    
    <div>
      <x-menu activate-by-route>
        @if($user = auth()->user())
          <x-menu-separator />
          <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="-mx-2 !-my-2 rounded">
            <x-slot:actions>
              <x-button icon="o-power" wire:click="logout" class="btn-circle btn-ghost btn-xs" tooltip-left="{{ __('Logout') }}" no-wire-navigate />
            </x-slot:actions>
          </x-list-item>
          <x-menu-separator />
        @else
          <x-menu-item title="{{ __('Login') }}" link="/login" />
        @endif
      </x-menu>
    </div>
  ```

##### Layout pour le composant sidebar <!-- markmap: fold -->

  ```html
    ...
    {{-- MAIN --}}
    <x-main full-width>
    
      {{-- SIDEBAR --}}
      <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit lg:hidden">
        <livewire:navigation.sidebar />
      </x-slot:sidebar>
  
      {{-- SLOT --}}
      <x-slot:content>
        {{ $slot }}
      </x-slot:content>
    
    </x-main>
  
  </body>
  ```

### Bloc central : Les articles <!-- markmap: fold -->

#### Création app/Repositories/**PostRepository.php** <!-- markmap: fold -->

  ```php
    <?php
    namespace App\Repositories;
    
    use App\Models\{Category, Post};
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Pagination\LengthAwarePaginator;
    
    class PostRepository {
      public function getPostsPaginate(?Category $category): LengthAwarePaginator {
        $query = $this->getBaseQuery()->orderBy('pinned', 'desc')->latest();
        
        if ($category) {
          $query->whereBelongsTo($category);
        }
        
        return $query->paginate(config('app.pagination'));
      }
    
      protected function getBaseQuery(): Builder {
        $specificReqs = [
          'mysql'  => "LEFT(body, LOCATE(' ', body, 700))",
          'sqlite' => 'substr(body, 1, 700)',
          'pgsql'  => 'substring(body from 1 for 700)',
        ];
        
        $usedDbSystem = env('DB_CONNECTION', 'mysql');
        
        if (!isset($specificReqs[$usedDbSystem])) {
          throw new \Exception("Base de données non supportée: {$usedDbSystem}");
        }
    
      $adaptedReq = $specificReqs[$usedDbSystem];
      
      return Post::select('id', 'slug', 'image', 'title', 'user_id', 'category_id', 'created_at', 'pinned')
        ->selectRaw("
          CASE
            WHEN LENGTH(body) <= 300 THEN body
            ELSE {$adaptedReq}
          END AS excerpt
        ",)
      ->with('user:id,name', 'category')
      ->whereActive(true);
      }
    }
  ```

#### config/**app.php** <!-- markmap: fold -->

  ```php
  return [
    ...
    'pagination'  =>  6,
    'excerptSize' => 30,
  ]
  ```

#### Code composant index <!-- markmap: fold -->

  ```html
    <?php
    use App\Models\Category;
    use Livewire\Volt\Component;
    use Livewire\WithPagination;
    use App\Repositories\PostRepository;
    use Illuminate\Pagination\LengthAwarePaginator;
    
    new class extends Component {
      use WithPagination;
    
      public ?Category $category = null;
    
      public function mount(string $slug = ''): void {
        if (request()->is('category/*')) {
          $this->category = $this->getCategoryBySlug($slug);
        } 
      }
    
      public function getPosts(): LengthAwarePaginator {
        $postRepository = new PostRepository();
  
        return $postRepository->getPostsPaginate($this->category);
      }
    
      protected function getCategoryBySlug(string $slug): ?Category {
  
        return 'category' === request()->segment(1) ? Category::whereSlug($slug)->firstOrFail() : null;
      }
    
      public function with(): array {
  
        return ['posts' => $this->getPosts()];
      }
    }; ?>
  
    @section('title',__('Home'))
    <div class="relative grid items-center w-full py-5 mx-auto md:px-6 max-w-12xl">
      @if ($category)
        <x-header title="{{ __('Posts for category ') }} {{ $category->title }}" size="text-2xl sm:text-3xl   md:text-4xl" />
      @endif
      <div class="mb-5 mary-table-pagination">
        {{ $posts->links() }}
      </div>
      <div class="container mx-auto">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
          @forelse($posts as $post)
            <x-card class="w-full transition duration-5500 ease-in-out shadow-md shadow-gray-500 hover:shadow-xl hover:shadow-orange-400" title="{!! $post->title !!}">
              <div class="text-justify">
                {!! str(strip_tags($post->excerpt))->words(config('app.excerptSize')) !!}
              </div>
              <br>
              <hr>
              <div class="flex justify-between">
                <p wire:click="" class="text-left cursor-pointer">{{ $post->user->name }}</p>
                <p class="text-right"><em>{{ $post->created_at->isoFormat('LL') }}</em></p>
              </div>
              @if($post->image)
                <x-slot:figure>
                  <a href="{{ url('/posts/' . $post->slug) }}">
                    <img src="{{ asset('storage/photos/' . $post->image) }}" alt="{{ $post->title }}" />
                  </a>
                </x-slot:figure>
              @endif
              <x-slot:menu>
                @if ($post->pinned)
                  <x-badge value="{{ __('Pinned') }}" class="p-3 badge-warning" />
                @endif
              </x-slot:menu>
              <x-slot:actions>
                <div class="flex flex-col items-end space-y-2 sm:items-start sm:flex-row sm:space-y-0 sm:space-x-2">
                  <x-popover>
                    <x-slot:trigger>
                      <x-button label="{{ $post->category->title }}" link="{{ url('/category/' . $post->category->slug) }}" class="mt-1 btn-outline btn-sm" />
                    </x-slot:trigger>
                    <x-slot:content class="pop-small">
                        @lang('Show this category')
                    </x-slot:content>
                  </x-popover>
                  <x-popover>
                    <x-slot:trigger>
                      <x-button label="{{ __('Read') }}" link="{{ url('/posts/' . $post->slug) }}" class="mt-1 btn-outline btn-sm" />
                    </x-slot:trigger>
                    <x-slot:content class="pop-small">
                      @lang('Read this post')
                    </x-slot:content>
                  </x-popover>
                </div>
              </x-slot:actions>
            </x-card>
              @empty
                <div class="col-span-3">
                  <x-card title="{{ __('Nothing to show !') }}">
                    {{ __('No Post found with these criteria') }}
                  </x-card>
                </div>
              @endforelse
            </div>
        </div>
      <!-- Pagination inférieure -->
      <div class="mt-5 mary-table-pagination">
        {{ $posts->links() }}
      </div>
    </div>
  ```

#### Traduction pour les articles <!-- markmap: fold -->

  ```json
    "Show this category": "Voir cette catégorie",
    "Read this post": "Lire cet article",
    "Posts for category ": "Articles pour la catégorie ",
    "Read": "Lire",
    "Nothing to show !": "Rien à montrer !",
    "No Post found with these criteria": "Aucun article trouvé avec ces critères"
  ```

### Styles pagination & popups <!-- markmap: fold -->

* \- Pour le menu pagination : ./**tailwind.config.js**

  ```js
    export default {
      content: [
        ...
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
      ],
      ...
    }
  ```

* \- Pour les Popups : ./resources/css/**app.css** :

  ```css
    ...
    .pop-small {
      @apply !p-1 !px-2 text-sm border-warning text-center
  }
  ```

### Réf.: ***<a href="https://laravel.sillo.org/posts/mon-cms-la-page-daccueil" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-la-page-daccueil</a>***

## - Les articles & les pages <!-- markmap: fold -->

### Composant posts.show <!-- markmap: fold -->

#### Route posts.show <!-- markmap: fold -->

  ```php
    Volt::route('/posts/{slug}', 'posts.show')->name('posts.show');
  ```

#### PostRepository <!-- markmap: fold -->

```php
  public function getPostBySlug(string $slug): Post {
      
    return Post::with('user:id,name', 'category')->whereSlug($slug)->firstOrFail();
  }
```

#### Création composant posts.show <!-- markmap: fold -->

  ```bash
    php artisan make:volt posts/show --class
  ```

#### Code composant posts.show <!-- markmap: fold -->

  ```html
    <?php
    use App\Models\Post;
    use App\Repositories\PostRepository;
    use Livewire\Volt\Component;
    
    new class extends Component {
      public Post $post;
      public function mount($slug): void {
        $postRepository = new PostRepository();
        $this->post     = $postRepository->getPostBySlug($slug);
      }
    }; ?>
  
    <div>
      @section('title', $post->seo_title ?? $post->title)
      @section('description', $post->meta_description)
      @section('keywords', $post->meta_keywords)
      <div id="top" class="flex justify-end gap-4">
        <x-popover>
          <x-slot:trigger>
            <x-button class="btn-sm"><a href="{{ url('/category/' . $post->category->slug) }}">{{ $post->category->title }}</a></x-button>
          </x-slot:trigger>
          <x-slot:content class="pop-small">
            @lang('Show this category')
          </x-slot:content>
        </x-popover>
      </div>
      <x-header title="{!! $post->title !!}" subtitle="{{ ucfirst($post->created_at->isoFormat('LLLL')) }} " size="text-2xl sm:text-3xl md:text-4xl" />
      <div class="relative items-center w-full py-5 mx-auto prose md:px-12 max-w-7xl">
        @if ($post->image)
          <div class="flex flex-col items-center mb-4">
            <img src="{{ asset('storage/photos/' . $post->image) }}" />
          </div>
          <br>
        @endif
        <div class="text-justify">
          {!! $post->body !!}
        </div>
      </div>
      <br>
      <hr>
      <p>@lang('By') {{ $post->user->name }}</p>
    </div>
  ```

#### Traduction posts.show <!-- markmap: fold -->

  ```json
    "By": "Par"
  ```

### Dynamic Title/Description/Keywords (S.E.O.) <!-- markmap: fold -->

#### Dans le **Layout**

* Rappel extrait title & meta :

  ```html
    <title>{{ (isset($title) ? $title . ' | ' :
    (View::hasSection('title') ? View::getSection('title') . ' | ' :
     '')) . config('app.name') }}</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
  ```

#### Dans la **Vue**

##### Bloc PHP

  ```php
    use Livewire\Attributes\Title;
    use App\Repositories\PostRepository;
    use Illuminate\Pagination\LengthAwarePaginator;
    
    new 
    #[Title('Contact']
    class extends Component {
      ...
    }
  ```

##### OU

##### Bloc Blade

* ```html
    @php
      $title='TitrePage'
    @endphp
  ```

* OU :

  ```html
    @section('title', $post->seo_title ?? $post->title)
    @section('description', $post->meta_description)
    @section('keywords', $post->meta_keywords
  ```

* À noter que ces dernières méthodes permettent par exemple
de traduire le titre dans l'onglet :

* ```html
  @section('title', __('Add a post'))
  ```

  Fera apparaître : "Ajouter un article | Mon CMS"

### Typographie: Plugin **prose** de Tailwind <!-- markmap: fold -->

* ```bash
  npm install -D @tailwindcss/typography
  ```

* ./**tailwind.config.js** :

  ```js
  exports default {
      ...
      plugins: [
          plugins: [require("@tailwindcss/typography"), require("daisyui")],
      ],
  }
  ```
  
* *Ex. d'utilisation : \<div class="relative items-center w-full py-5 mx-auto **prose** md:px-12 max-w-7xl">*

### Style avec Librairie **prismjs** <!-- markmap: fold -->

* Configurer **prism.css** et **prism.js** : [https://prismjs.com/download.html](https://prismjs.com/download.html)
  OU :
  Récupérer ceux du site Sillo: <a href="https://laravel.sillo.org/storage/css/prism.css" title="pour obtenir exactement le même rendu" target="_blank">CSS</a> et <a href="https://laravel.sillo.org/storage/scripts/prism.js" title="pour obtenir exactement le même rendu" target="_blank">JS</a>

* Quelque soit le choix, poser dans le layout :

  ```html
    ...
    <head>
    ...
      <link rel="stylesheet" href="{{ asset('storage/css/prism.css') }}">
    ... @vite(...)
    </head>
    <body class="h-[96vh] font-sans antialiased bg-base-200/50 dark:bg-base-200">
      ...
      <script src="{{ asset('storage/scripts/prism.js') }}"></script>
    \</body>
  ```

### Mode clair/sombre (MaryIU) <!-- markmap: fold -->

* ./**tailwind.config.js** :

  ```js
    export default {
      ...
      theme: {
        extend: {},
      },
      darkMode: 'class',
    }
  ```

* navigation/**navbar.blade.php** :

  ```html
        <x-theme-toggle title="{{ __('Toggle theme') }}" class="w-4 h-8" />
      </x-slot:actions>
    </x-nav>
  ```

* lang/**fr.json** :

  ```json
  "Toggle theme": "Basculer le thème"
  ```

* Doc MaryUI ***<a href="https://mary-ui.com/docs/components/theme-toggle" title="Voir les détails" target="_blank">https://mary-ui.com/docs/components/theme-toggle</a>***

### Search bar <!-- markmap: fold -->

#### La route (routes/**web.php**) <!-- markmap: fold -->

* ```php
    Volt::route('/search/{param}', 'index')->name('posts.search');
  ```

* À noter sa particularité : Renvoie aussi sur la vue index

#### Composant search <!-- markmap: fold -->

* Création composant Search :

  ```bash
    php artisan make:volt search --class
  ```
  
* PHP (La logique) :

  ```php
    <?php
    use Livewire\Volt\Component;
    use Livewire\Attributes\Validate;

    new class extends Component {

      #[Validate('required|string|max:100')]
      public string $search = '';
  
      public function save() {
        $data = $this->validate();
  
        return redirect('/search/' . $data['search']);
      }
    }; ?>
  ```

* HTML (Blade - La Vue) :

  ```html
    <div>
      <form wire:submit.prevent="save">
      <x-input placeholder="{{ __('Search') }}..." wire:model="search" clearable icon="o-magnifying-glass" />
      </form>
    </div>
  ```

#### Vue HTML - navigation/navbar.php <!-- markmap: fold -->

  ```html
      ...
      <livewire:search />
    </x-slot:actions>
  </x-nav>
  ```

#### Ajouter search() dans app/Repositories/**PostRepository.php** <!-- markmap: fold -->

* search(), La fonction qui inclue la chaîne du formulaire pour gérer la recherche :

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

#### Composant index (Homepage (Page d'accueil)) <!-- markmap: fold -->

##### **Bloc Logique PHP** : Quand on récupère les posts... <!-- markmap: fold -->

* ...On déclenche le composant search
&nbsp; &nbsp; si l'URI comporte un paramètre (function getPosts()) :

  ```php
    ...
    public string $param = '';
    
    public function mount(string $slug = '', string $param = ''): void {
      $this->param = $param;
      if (request()->is('category/*')) {
        $this->category = $this->getCategoryBySlug($slug);
      }
    }
    
    public function getPosts(): LengthAwarePaginator {
      $postRepository = new PostRepository();
  
      if (!empty($this->param)) {
        return $postRepository->search($this->param);
      }
  
      return $postRepository->getPostsPaginate($this->category);
    }
  ```

##### **Bloc Vue Blade** : S'il y a une recherche... <!-- markmap: fold -->

* ...Alors, on affiche le titre de la page adapté :

  ```php
    @if ($category)
      <x-header title="{{ __('Posts for category ') }} {{ $category->title }}" size="text-2xl sm:text-3xl md:text-4xl" />
    @elseif($param !== '')
      <x-header title="{{ __('Posts for search ') }} '{{ $param }}'" size="text-2xl sm:text-3xl md:text-4xl" />
    @endif
  ```

#### Traductions nécessaires (**lang/fr.json**) <!-- markmap: fold -->

  ```json
    "Search...": "Rechercher...",
    "Posts for search ": "Articles pour la recherche",
  ```

### Affichage d'une page <!-- markmap: fold -->

#### Route pages.show

```php
  Volt::route('/pages/{page:slug}', 'pages.show')->name('pages.show');
```

#### Créer composant pages.show

  ```bash
    php artisan make:volt pages/show --class
  ```

#### Composant pages.show

  ```html
    <?php
    use App\Models\Page;
    use Livewire\Volt\Component;
    
    new class extends Component {
    public Page $page;
    
    public function mount(Page $page): void {
      if (!$page->active) {
        abort(404);
      }
    
      $this->page = $page;
    }
    }; ?>
    
    <div>
      @section('title', $page->seo_title ?? $page->title)
      @section('description', $page->meta_description)
      @section('keywords', $page->meta_keywords)
  
      <div class="flex justify-end gap-4">
        @auth
          @if (Auth::user()->isAdmin())
            <x-popover>
              <x-slot:trigger>
                <x-button icon="c-pencil-square" link="#" spinner class="btn-ghost btn-sm" />
              </x-slot:trigger>
              <x-slot:content class="pop-small">
                @lang('Edit this page')
              </x-slot:content>
            </x-popover>
          @endif
        @endauth
      </div>
  
      <x-header title="{!! $page->title !!}" />
  
      <div class="relative items-center w-full px-5 py-5 mx-auto prose md:px-12 max-w-7xl text-justify">
        {!! $page->body !!}
      </div>
    </div>
  ```

#### Traduction pages.show

  ```json
    "Edit this page": "Modifier cette page"
  ```

### Réf.: ***<a href="https://laravel.sillo.org/posts/mon-cms-les-articles" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-les-articles</a>***

### La page Contact <!-- markmap: fold -->

#### Données Contact <!-- markmap: fold -->

##### Model & Migration Contact <!-- markmap: fold -->

  ```bash
  php artisan make:model Contact -m
  ```

  ```php
  <?php
  namespace App\Models;
  
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Notifications\Notifiable;
  use Illuminate\Database\Eloquent\Relations\BelongsTo;
  use Illuminate\Database\Eloquent\Factories\HasFactory;
  
  class Contact extends Model {
      use HasFactory;
      use Notifiable;
  
      protected $fillable = ['name', 'email', 'message', 'user_id'];
  
      public function user(): BelongsTo {
          return $this->belongsTo(User::class);
      }
  }
  ```

  ```php
  <?php
  use Illuminate\Support\Facades\Schema;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Database\Migrations\Migration;
  
      class CreateContactsTable extends Migration {
      public function up() {
          Schema::create('contacts', function (Blueprint $table) {
              $table->id();
              $table->unsignedBigInteger('user_id')->nullable()->default(null);
              $table->string('name');
              $table->string('email');
              $table->text('message');
              $table->boolean('handled')->default(false);
              $table->timestamps();
          });
      }
  
      public function down() {
        Schema::dropIfExists('contacts');
      }
  }
  ```

##### Seeder avec Factory Contact <!-- markmap: fold -->

  ```bash
  php artisan make:factory Contact
  ```

  ```php  
  <?php
  namespace Database\Factories;
  
  use App\Models\Contact;
  use Faker\Factory as Faker;
  use Illuminate\Database\Eloquent\Factories\Factory;
  
      class ContactFactory extends Factory {
      
          protected $model = Contact::class;
      
          public function definition() {
              $faker = Faker::create('fr_FR');
        
              return [
                  'name'    => $faker->name,
                  'email'   => $faker->unique()->safeEmail,
                  'message' => $faker->realText(200, 2),
            ];
      }
  }  
  ```

  ```bash
  php artisan make:seeder ContactSeeder
  ```

  ```php
  <?php
  namespace database\seeders;
  
  use App\Models\Contact;
  use Illuminate\Database\Seeder;
  use Illuminate\Database\Console\Seeds\WithoutModelEvents;
  
  class ContactSeeder extends Seeder {
      use WithoutModelEvents;
      
      public function run() {
          Contact::factory()->count(5)->create();
      }
  }
  ```

  ```php
  class DatabaseSeeder extends Seeder {
      public function run(): void {
          $this->call([
              ...
              ContactSeeder::class,
          ]);
          ...
      }
  }
  ```

  ```bash
  php artisan db:seed
  ```

#### Route Contact <!-- markmap: fold -->

  ```php
  ... /pages/{page:slug} (Ndlr: Route pages.show)
  Volt::route('/contact', 'pages.contact')->name('pages.contact');
  ```

#### Composant Contact (livewire/**contact.blade.php**) <!-- markmap: fold -->

```php
php artisan make:volt pages/contact --class
```

  ```html
  <?php
  use Mary\Traits\Toast;
  use App\Models\Contact;
  use Livewire\Volt\Component;
  use Livewire\Attributes\{Layout, Rule};
  
  new
  #[Title('Contact')]
  class extends Component {
      use Toast;
  
      #[Rule('required|string|max:255')]
      public string $name = '';
  
      #[Rule('required|email')]
      public string $email = '';
  
      #[Rule('required|max:1000')]
      public string $message = '';
  
      #[Rule('nullable|numeric|exists:users,id')]
      public ?int $user_id = null;
  
      // Méthode de montage pour pré-remplir les champs avec les informations de l'utilisateur authentifié
      public function mount(): void {
          if (Auth::check()) {
              $this->name = Auth::user()->name;
              $this->email = Auth::user()->email;
              $this->user_id = Auth::id();
          }
      }
      // Méthode pour enregistrer le formulaire de contact
      public function save() {
          // Validation des données du formulaire
          $data = $this->validate();
          // Création d'un nouveau contact avec les données validées
          Contact::create($data);
          // Affichage d'un message de réussite avec une redirection
          $this->success(__('Your message has been sent!'), redirectTo: '/');
      }
  }; ?>
  
  <div>
      @section('title', 'Contact')
      <!-- Formulaire de contact encapsulé dans une carte -->
      <x-card title="{{ __('Contact') }}" subtitle="{{ __('Use this form to contact me') }}" shadow separator
          progress-indicator>
          <x-form wire:submit="save">
              <!-- Affichage des champs de nom et d\'email uniquement si \'utilisateur n\'est pas connecté -->
              @if (!Auth()->check())
                  <x-input label="{{ __('Name') }} *" wire:model="name" icon="o-user" inline />
                  <x-input label="{{ __('E-mail') }} *" wire:model="email" icon="o-envelope" inline />
              @endif
              <!-- Champ de message -->
              <x-textarea wire:model="message" hint="{{ __('Max 1000 chars') }}" rows="5"
                  placeholder="{{ __('Your message...') }} *" inline />
              <p class="text-[12px] text-right italic my-[-10px]">* : {{ __('Required information') }}</p>
              <!-- Boutons d'actions -->
              <x-slot:actions>
                  <x-button label="{{ __('Cancel') }}" link="/" class="btn-ghost" />
                  <x-button label="{{ __('Send') }}" type="submit" icon="o-paper-airplane" class="btn-primary"
                      spinner="login" />
              </x-slot:actions>
          </x-form>
      </x-card>
  </div>
  ```

#### Traductions Contact <!-- markmap: fold -->

  ```json
  "Use this form to contact me": "Utilisez ce formulaire pour me contacter",
  "Your message...": "Votre message...",
  "Max 1000 chars": "Max 1000 caractères",
  "Your message has been sent!": "Votre message a bien été envoyé !"
  ```

## - Les menus & le footer <!-- markmap: fold -->

### Les données pour menus et footer <!-- markmap: fold -->

#### Structures <!-- markmap: fold -->

##### Model & migration Menu <!-- markmap: fold -->

```bash
  php artisan make:model Menu --migration
```

```php
  <?php
  namespace App\Models;
  
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Relations\HasMany;
  
  class Menu extends Model {
    public $timestamps = false;
    
    protected $fillable = [
      'label',
      'link',
      'order',
    ];
    
    public function submenus(): HasMany {
      
      return $this->hasMany(Submenu::class);
    }
  }
```

```php
  public function up(): void {
    Schema::create('menus', function (Blueprint $table) {
      $table->id();
      $table->string('label');
      $table->string('link')->nullable();
      $table->integer('order');
    });
  }
```

##### Model & migration Submenu <!-- markmap: fold -->

  ```bash
    php artisan make:model Submenu --migration
  ```

  ```php
    class Submenu extends Model {
      public $timestamps = false;
      
      protected $fillable = [
        'label',
        'link',
        'order',
      ];
    }
  ```

```php
  public function up(): void {
    Schema::create('submenus', function (Blueprint $table) {
      $table->id();
      $table->string('label');
      $table->integer('order');
      $table->string('link')->default('#');
      $table->foreignId('menu_id')->constrained()->onDelete('cascade');
    });
  }
```

##### Model & migration Footer <!-- markmap: fold -->

  ```bash
    php artisan make:model Footer --migration
```

  ```php
    class Footer extends Model {
      public $timestamps = false;
  
      protected $fillable = [
        'label',
        'link',
        'order',
      ];
    }
  ```

  ```php
    public function up(): void {
      Schema::create('footers', function (Blueprint $table) {
        $table->id();
        $table->string('label');
        $table->string('link');
        $table->integer('order');
      });
    }
  ```

#### Population (Seeders) <!-- markmap: fold -->

##### Rappel pour créer un seeder <!-- markmap: fold -->

* Exemple avec le seeder des menus :

* ```bash
    php artisan make:seeder MenusSeeder
  ```
  
* OU :

* Créer le fichier **MenusSeeder.php** dans database/seeders

##### **MenusSeeder.php** <!-- markmap: fold -->

  ```php
    namespace database\seeders;
    
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    class MenusSeeder extends Seeder
    {
      public function run() {
        $menus = [
            ['label' => 'Catégorie 1', 'link' => null, 'order' => 3],
            ['label' => 'Catégorie 2', 'link' => '/category/category-2', 'order' => 2],
            ['label' => 'Catégorie 3', 'link' => '/category/category-3', 'order' => 1],
        ];
    
        DB::table('menus')->insert($menus);
    
        $submenus = [
            ['label' => 'Post 1', 'order' => 1, 'link' => '/posts/post-1', 'menu_id' => 1],
            ['label' => 'Tout', 'order' => 3, 'link' => '/category/category-1', 'menu_id' => 1],
        ];
    
        DB::table('submenus')->insert($submenus);
      }
    }
```

##### **FooterSeeder.php** <!-- markmap: fold -->

  ```php
    <?php
    namespace database\seeders;
    
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    
    class FooterSeeder extends Seeder
    {
      public function run() {
        // Données des éléments du pied de page
        $footers = [
          ['label' => 'Accueil', 'order' => 1, 'link' => '/'],
          ['label' => 'Terms', 'order' => 3, 'link' => '/pages/terms'],
          ['label' => 'Policy', 'order' => 4, 'link' => '/pages/privacy-policy'],
          ['label' => 'Contact', 'order' => 5, 'link' => '/contact'],
        ];
  
        // Insérer les données dans la table footers
        DB::table('footers')->insert($footers);
      }
    }
  ```

##### **DatabaseSeeder.php** <!-- markmap: fold -->

  ```php
    public function run(): void {
      $this->call([
        ...
        MenusSeeder::class,
        FooterSeeder::class, 
      ]);
    }
```

  ```bash
    php artisan migrate:fresh --seed
  ```

#### Nouveauté : app/Providers/**AppServiceProvider.php** <!-- markmap: fold -->

* Parce que les menus et submenus sont appelés systématiquement :

  ```php
    ...
    use App\Models\Menu;
    use Illuminate\View\View;
    use Illuminate\Support\{Facades, ServiceProvider};
    
    class AppServiceProvider extends ServiceProvider {
      ...
      public function boot(): void {
        Facades\View::composer(['components.layouts.app'], function (View $view) {
          $view->with(
            'menus',
            Menu::with(['submenus' => function ($query) {
              $query->orderBy('order');
            }])->orderBy('order')->get()
          );
        });
      }
    }
  ```

### Affichages des menus <!-- markmap: fold -->

#### Ajouter ***:$menus*** dans layouts/**app.blade.php** <!-- markmap: fold -->

  ```html
    <livewire:navigation.navbar :$menus />
    ...
    <livewire:navigation.sidebar :$menus />
  ```
  
#### Barres de Navigation

##### navigation/**navbar.blade.php** <!-- markmap: fold -->

* Bloc PHP :

  ```php
  use Illuminate\Support\Collection;
  
  new class extends Component {
      
      public Collection $menus;
  
      public function mount(Collection $menus): void {
        $this->menus = $menus;
      }
      ...
  }
  ```

* Bloc Blade :

  ```html
  <span class="hidden sm:block">
      @foreach ($menus as $menu)
      @if ($menu->submenus->isNotEmpty())
          <x-dropdown>
          <x-slot:trigger>
              <x-button label="{{ $menu->label }}"  class="btn-ghost" />
          </x-slot:trigger>
          @foreach ($menu->submenus as $submenu)
              <x-menu-item title="{{ $submenu->label }}" link="{{ $submenu->link }}" style="min-width: max-content;" />
          @endforeach
          </x-dropdown>
      @else
          <x-button label="{{ $menu->label }}" link="{{ $menu->link }}" :external="Str::startsWith($menu->link, 'http')" class="btn-ghost" />
      @endif
      @endforeach
      ...
  </span>
  ```

##### navigation/**sidebar.blade.php** <!-- markmap: fold -->

  ```html
  ...
  use Illuminate\Support\Collection;
  
  new class extends Component {
  
      public Collection $menus;
  
      public function mount(Collection $menus): void {
      $this->menus = $menus;
      }
      ...
  };
  ...
  <x-menu activate-by-route>
      ... // Ici suppression du separator reporté ci-dessous
      </x-list-item>
      @else
          <x-menu-item title="{{ __('Login') }}" link="/login" />
      @endif
      <x-menu-separator />
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

#### Menu Pied de page <!-- markmap: fold -->

* Composant navigation/**footer.blade.php** :

  ```html
    <?php
    use App\Models\Footer;
    use Livewire\Volt\Component;
    
    new class() extends Component {
    
      public function with(): array {
    
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
        <a href="https://github.com/bestmomo/sillo" title=" {{ __('Go to the GitHub repository and... Fork it!') }} ! target="_blank">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" 
          height="24" viewBox="0 0 24 24" class="fill-current">
            <path d="M12 0C5.372 0 0 5.372 0 12c0 5.303 3.438 9.8 8.207 11.387.6.11.793-.26.793-.577v-2.2c-3.338.726-4.033-1.415-4.033-1.415-.546-1.387-1.333-1.757-1.333-1.757-1.089-.744.083-.729.083-.729 1.204.085 1.838 1.237 1.838 1.237 1.07 1.835 2.809 1.305 3.495.998.108-.775.419-1.305.762-1.605-2.665-.305-5.466-1.335-5.466-5.93 0-1.31.467-2.38 1.235-3.22-.124-.303-.535-1.523.117-3.176 0 0 1.008-.322 3.3 1.23.957-.266 1.98-.399 3-.405 1.02.006 2.043.139 3 .405 2.29-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.873.118 3.176.77.84 1.233 1.91 1.233 3.22 0 4.61-2.804 5.62-5.475 5.92.43.37.815 1.1.815 2.22v3.293c0 .319.192.694.801.576C20.565 21.796 24 17.302 24 12c0-6.628-5.372-12-12-12z" />
          </svg>
        </a>
        <a href="https://discord.com/channels/1258750464800063640/1258750464800063646" title=" {{ __('Go to the Discord channel') }} !" target="_blank">
          <svg width="25" height="28" viewBox="0 0 71 80" class="fill-current mt-[-.05rem]" xmlns="http://www.w3.org/2000/svg">
            <path d="M60.1045 13.8978C55.5792 11.8214 50.7265 10.2916 45.6527 9.41542C45.5603 9.39851 45.468 9.44077 45.4204 9.52529C44.7963 10.6353 44.105 12.0834 43.6209 13.2216C38.1637 12.4046 32.7345 12.4046 27.3892 13.2216C26.905 12.0581 26.1886 10.6353 25.5617 9.52529C25.5141 9.44359 25.4218 9.40133 25.3294 9.41542C20.2584 10.2888 15.4057 11.8186 10.8776 13.8978C10.8384 13.9147 10.8048 13.9429 10.7825 13.9795C1.57795 27.7309 -0.943561 41.1443 0.293408 54.3914C0.299005 54.4562 0.335386 54.5182 0.385761 54.5576C6.45866 59.0174 12.3413 61.7249 18.1147 63.5195C18.2071 63.5477 18.305 63.5139 18.3638 63.4378C19.7295 61.5728 20.9469 59.6063 21.9907 57.5383C22.0523 57.4172 21.9935 57.2735 21.8676 57.2256C19.9366 56.4931 18.0979 55.6 16.3292 54.5858C16.1893 54.5041 16.1781 54.304 16.3068 54.2082C16.679 53.9293 17.0513 53.6391 17.4067 53.3461C17.471 53.2926 17.5606 53.2813 17.6362 53.3151C29.2558 58.6202 41.8354 58.6202 53.3179 53.3151C53.3935 53.2785 53.4831 53.2898 53.5502 53.3433C53.9057 53.6363 54.2779 53.9293 54.6529 54.2082C54.7816 54.304 54.7732 54.5041 54.6333 54.5858C52.8646 55.6197 51.0259 56.4931 49.0921 57.2228C48.9662 57.2707 48.9102 57.4172 48.9718 57.5383C50.038 59.6034 51.2554 61.5699 52.5959 63.435C52.6519 63.5139 52.7526 63.5477 52.845 63.5195C58.6464 61.7249 64.529 59.0174 70.6019 54.5576C70.6551 54.5182 70.6887 54.459 70.6943 54.3942C72.1747 39.0791 68.2147 25.7757 60.1968 13.9823C60.1772 13.9429 60.1437 13.9147 60.1045 13.8978ZM23.7259 46.3253C20.2276 46.3253 17.3451 43.1136 17.3451 39.1693C17.3451 35.225 20.1717 32.0133 23.7259 32.0133C27.308 32.0133 30.1626 35.2532 30.1066 39.1693C30.1066 43.1136 27.28 46.3253 23.7259 46.3253ZM47.3178 46.3253C43.8196 46.3253 40.9371 43.1136 40.9371 39.1693C40.9371 35.225 43.7636 32.0133 47.3178 32.0133C50.9 32.0133 53.7545 35.2532 53.6986 39.1693C53.6986 43.1136 50.9 46.3253 47.3178 46.3253Z" />
          </svg>
        </a>
      </div>
    </nav>
    <aside>
      <p>Version 0.1.0</a> - © {{ date('Y') }} Moi</p>
    </aside>
  </footer>
  ```

* Dans les layouts (app & auth) :

  ```html
    {{-- FOOTER --}}
    <hr><br>
    <livewire:navigation.footer />
    <br>
    
    {{--  TOAST area --}}
    <x-toast />
    <script src="{{ asset('storage/scripts/prism.js') }}"></script>
  </body>
  ```

* ./lang/**fr.json** :

  ```json
  "Go to the GitHub repository and... Fork it": "Aller sur le dépôt GitHub et... Le cloner",
  "Go to the Discord channel": "Aller sur le canal Discord"
  ```

### Réf.: ***<a href="https://laravel.sillo.org/posts/mon-cms-les-menus" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-les-menus</a>***

## - Les commentaires <!-- markmap: fold -->

### Model & Migration et factory & seeder Comment <!-- markmap: fold -->

#### Model Comment <!-- markmap: fold -->

  ```bash
  php artisan make:model Comment --migration
  ```

  ```php
  <?php
  namespace App\Models;
  
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Notifications\Notifiable;
  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
  
  class Comment extends Model {
      use HasFactory, Notifiable;
  
      protected $fillable = [
          'body',
          'post_id',
          'user_id',
          'parent_id',
      ];
    
      public function user(): BelongsTo {
          return $this->belongsTo(User::class);
      }
    
      public function post(): BelongsTo {
          return $this->belongsTo(Post::class);
      }
    
      public function parent(): BelongsTo {
          return $this->belongsTo(Comment::class, 'parent_id');
      }
    
      public function children(): HasMany {
          return $this->hasMany(Comment::class, 'parent_id');
    }
  }
  ```

#### Structure Comment <!-- markmap: fold -->

* Migration de comments_table :

  ```php
  public function up(): void {
      Schema::create('comments', function (Blueprint $table) {
          $table->id();
          $table->text('body');
          $table->foreignId('post_id')->constrained()->onDelete('cascade');
          $table->foreignId('user_id')->constrained()->onDelete('cascade');
          $table->unsignedBigInteger('parent_id')->nullable()->default(null);
          $table->foreign('parent_id')
              ->references('id')
              ->on('comments')
              ->onDelete('cascade');
          $table->timestamps();
      });
  }
  ```

#### Relations avec Comment <!-- markmap: fold -->

* Model Post

* ```php
  use Illuminate\Database\Eloquent\Relations\{ HasMany, BelongsTo};
  
  class Post extends Model {
      ...
    
      public function comments(): HasMany {
          return $this->hasMany(Comment::class);
      }
    
      public function validComments(): HasMany {
          return $this->comments()->whereHas('user', function ($query) {
              $query->whereValid(true);
        });
    }
  }
  ```

* Model User

* ```php
  public function comments(): HasMany {
      return $this->hasMany(Comment::class);
  }
  ```

<a href="https://laravel.sillo.org/storage/photos/2024/08/535DwpjTWsqCqM6Zut9mwt10mL0FeZp303J1W1Ef.png" title="Voir le diagramme" target="_blank">Diagramme UML</a>

#### Population Comment <!-- markmap: fold -->

* ```bash
  php artisan make:factory CommentFactory
  ```

* ```php
  public function definition(): array {
      return [
          'body' => fake()->paragraph(4),
      ];
  }
  ```

* ```bash
  php artisan make:seeder CommentSeeder
  ```

* ```php
  <?php
  namespace Database\Seeders;
  
  use App\Models\Comment;
  use Illuminate\Database\Seeder;
  
  class CommentSeeder extends Seeder {
      public function run() {
          $nbrPosts = 9;
          $nbrUsers = 3;
    
          foreach (range(1, $nbrPosts - 1) as $i) {
              $this->createComment($i, rand(1, $nbrUsers));
          }
    
          $comment = $this->createComment(2, 3);
          $this->createComment(2, 2, $comment->id);
    
          $comment = $this->createComment(2, 2);
          $this->createComment(2, 3, $comment->id);
    
          $comment = $this->createComment(2, 3, $comment->id);
    
          $comment = $this->createComment(2, 1, $comment->id);
          $this->createComment(2, 3, $comment->id);
    
          $comment = $this->createComment(4, 1);
    
          $comment = $this->createComment(4, 3, $comment->id);
          $this->createComment(4, 2, $comment->id);
          $this->createComment(4, 1, $comment->id);
      }
    
      protected function createComment($post_id, $user_id, $id = null) {
          return Comment::factory()->create([
              'post_id' => $post_id,
              'user_id' => $user_id,
            'parent_id' => $id,
        ]);
    }
  }
  ```

* **DatabaseSeeder.php** :

* ```php
  public function run(): void {
      $this->call([
          ...
          CommentSeeder::class,
      ]);
  }
  ```

* ```bash
  php artisan migrate:fresh --seed
  ```

### Modifier dans PostRepository pour Comment <!-- markmap: fold -->

  ```php
  public function getPostBySlug(string $slug): Post {
      return Post::with('user:id,name', 'category')
          ->withCount('validComments')
          ->whereSlug($slug)->firstOrFail();
  }
  ```

### Ajouter & modifier dans posts.show pour Comment <!-- markmap: fold -->

* Notons que le bouton pour voir le(s) commentaire(s) n'est pas encore opérationnel...

* ```html
  new class extends Component {
      ...
      public int $commentsCount;
  
      public function mount($slug): void {
          $postRepository = new PostRepository();
          $this->post = $postRepository->getPostBySlug($slug);
          $this->commentsCount = $this->post->valid_comments_count;
      }
  }; ?>
     ...
      <div class="flex justify-between">
          <p>@lang('By ') {{ $post->user->name }}</p>
          <em>
              @if ($commentsCount > 0)
                  @lang('Number of comments: ') {{ $commentsCount }}
              @else
                  @lang('No comments')
              @endif
          </em>
      </div>
      <div id="bottom" class="relative items-center w-full py-5 mx-auto md:px-12 max-w-7xl">
          @if ($commentsCount > 0)
              <div class="flex justify-center">
                  <x-button label="{{ $commentsCount > 1 ? __('View comments') : __('View comment') }}" class="btn-outline" spinner />
              </div>
          @else
              @auth
                  <livewire:posts.commentBase :postId="$post->id" />
              @endauth
          @endif
          @guest
              <div class="text-center mt-8 italic">
                <a href="{{ route('login') }}" title="{{ __('Click here to log in') }} !">
                {{ __('You must be logged in to comment') }}</a>.
              </div>
          @endguest
      </div>
  </div>
  ```

* Traductions Comment nécessaires dans posts.show :

  ```json
  "Number of comments: ": "Nombre de commentaires : ",
  "View comment": "Voir le commentaire",
  "View comments": "Voir les commentaires",
  "All comments": "Tous les commentaires",
  "No comments": "Aucun commentaire",
  "You must be logged in to comment": "Vous devez être connecté pour publier un commentaire",
  "Click here to log in": "Cliquez ici pour vous connecter"
  ```

### Voir les commentaires dans posts.show <!-- markmap: fold -->

* ```php
  <?php
  ...
  use Illuminate\Support\Collection;
  
  new class extends Component {
      ...
      public Collection $comments;
      public bool $listComments = false;
      ...
      public function showComments(): void {
          $this->listComments = true;
  
          $this->comments = $this->post
              ->validComments()
              ->where('parent_id', null)
              ->withCount([
                  'children' => function ($query) {
                      $query->whereHas('user', function ($q) {
                          $q->where('valid', true);
                      });
                  },
              ])
              ->with([
                  'user' => function ($query) {
                      $query->select('id', 'name', 'email', 'role')->withCount('comments');
                  },
              ])
              ->latest()
              ->get();
          dd ($this->comments); 
          // Commenter le dd() ci-dessus après avoir observé le bon contenu de $this->comments
          // Qui doit-être un truc style : 
          //   Illuminate\Database\Eloquent\Collection {#609 ▼ // resources\views\livewire\posts\show.blade.php:44
          //     #items: array:3 [▼
          //       0 => App\Models\Comment {#612 ▶}
          //       1 => App\Models\Comment {#606 ▶}
          //       2 => App\Models\Comment {#616 ▶}
          //     ]
          //     #escapeWhenCastingToString: false
          //   }
          // Supprimer ces lignes commentées après avoir observé ce résultat à partir de // Commenter...
      }
  }; ?>
  ```

* Modifier le bouton pour l'activer au click :

  ```html
  <x-button label="{{ $commentsCount > 1 ? __('View comments') : __('View comment') }}"
  wire:click="showComments" class="btn-outline" spinner />
  ...
  ```

### Réf.: ***<a href="https://laravel.sillo.org/posts/mon-cms-les-commentaires-1-2" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-les-commentaires-1-2</a>***

### Le formulaire (Composant posts/comment-form) <!-- markmap: fold -->

  ```bash
  php artisan make:volt posts/comment-form --class
  ```

  ```html
  @if ($showForm)
      <x-card title="{{ $formTitle }}" shadow="hidden" class="!p-0">
          <x-form wire:submit="{{ $formAction }}" class="mb-4">
              <x-textarea wire:model="message" hint="{{ __('Max 10000 chars') }}" rows="5" placeholder="{{ __('Your message...') }}" inline />
              <x-slot:actions>
                  @if ($formAction === 'updateComment')
                      <x-button label="{{ __('Cancel') }}" wire:click="toggleModifyForm(false)"
                          class="btn-ghost" spinner />
                  @endif
                  <x-button label="{{ __('Save') }}" class="btn-primary" type="submit" spinner="save" />
              </x-slot:actions>
          </x-form>
      </x-card>
  @else
      <div class="mb-4">{!! $message !!}</div>
  @endif
  ```

### Gravatar <!-- markmap: fold -->

#### Installer Gravatar

* ```bash
  composer require creativeorange/gravatar ~1.0
  ```

* Usage:

  ```php
  Gravatar::get('email@example.com');
  ```

#### <a href="https://gravatar.com" title="Aller sur le site de Gravatar" target="_blank">Créer son Gravatar</a>

### Les notifications <!-- markmap: fold -->

#### Création de commentaire <!-- markmap: fold -->

* ```bash
  php artisan make:notification CommentCreated
  ```

* Dans app/Notifications/**CommentCreated.php** :

  ```php
  <?php
  namespace App\Notifications;
  
  use App\Models\Comment;
  use Illuminate\Bus\Queueable;
  use Illuminate\Notifications\Notification;
  use Illuminate\Notifications\Messages\MailMessage;
  
  class CommentCreated extends Notification
  {
      use Queueable;
    
      public Comment $comment;
    
      public function __construct(Comment $comment) {
          $this->comment = $comment;
      }
    
      public function via(object $notifiable): array {
          return ['mail'];
      }
    
      public function toMail(object $notifiable): MailMessage {
          return (new MailMessage())
              ->subject(__('A comment has been created on your post'))
              ->line(__('A comment has been created on your post') . ' "' . $this->comment->post->title . '" ' . __('by') . ' ' . $this->comment->user->name . '.')
              ->lineIf(!$this->comment->user->valid, __('This comment is awaiting moderation.'))
              ->action(__('Manage this comment'), route('comments.edit',$this->comment->id));
      }
    
      public function toArray(object $notifiable): array {
          return [
          ];
      }
  }
  ```

* ```json
  "A comment has been created on your post": "Un commentaire a été ajouté à votre article",
  "This comment is awaiting moderation.": "Ce commentaire est en attente de modération.",
  "Manage this comment": "Gérer ce commentaire",
  "by": "par"
  ```

#### Affichage des commentaires 1er niveau <!-- markmap: fold -->

* ```bash
  php artisan make:volt posts/commentBase --class
  ```

* ```html
  <?php
  use Livewire\Volt\Component;
  use App\Models\{ Comment, Post };
  use Livewire\Attributes\Validate;
  use App\Notifications\CommentCreated;
  use Illuminate\Contracts\Database\Eloquent\Builder;
  
  new class() extends Component {
      public int $postId;
      public ?Comment $comment    = null;
      public bool $showCreateForm = true;
      public bool $showModifyForm = false;
      public bool $alert          = false;
    
      #[Validate('required|max:10000')]
      public string $message = '';
    
      public function mount($postId): void {
          $this->postId = $postId;
      }
    
      public function createComment(): void {
          $data = $this->validate();
    
          if (!Auth::user()->valid) {
              $this->alert = true;
          }
    
          $post = Post::select('id', 'title', 'user_id')->with('user')->findOrFail($this->postId);
    
          $this->comment = Comment::create([
              'user_id' => Auth::id(),
              'post_id' => $this->postId,
              'body'    => $this->message,
          ]);
    
          if ($this->post->user_id != Auth::id()) {
              $post->user->notify(new CommentCreated($this->comment));
          }
    
          $this->message = $data['message'];
      }
    
      public function updateComment(): void {
          $data = $this->validate();
    
          $this->comment->body = $data['message'];
          $this->comment->save();
    
          $this->toggleModifyForm(false);
      }
    
      public function toggleModifyForm(bool $state): void {
          $this->showModifyForm = $state;
      }
    
      public function deleteComment(): void {
          $this->comment->delete();
    
          $this->comment = null;
          $this->message = '';
      }
  }; ?>
  
  <div class="flex flex-col mt-4">
      @if ($this->comment)
  
          @if ($alert)
              <x-alert title="{!! __('This is your first comment') !!}" description="{!! __('It will be validated by an administrator before it appears here') !!}" icon="o-exclamation-triangle"
                  class="alert-warning" />
          @else
              <div class="flex flex-col justify-between mb-4 md:flex-row">
                  <x-avatar :image="Gravatar::get(Auth::user()->email)" class="!w-24">
                      <x-slot:title class="pl-2 text-xl">
                          {{ Auth::user()->name }}
                      </x-slot:title>
                      <x-slot:subtitle class="flex flex-col gap-1 pl-2 mt-2 text-gray-500">
                          <x-icon name="o-calendar" label="{{ $comment->created_at->diffForHumans() }}" />
                          <x-icon name="o-chat-bubble-left"
                              label="{{ $comment->user->comments_count }} {{ __(' comments') }}" />
                      </x-slot:subtitle>
                  </x-avatar>
  
                  <div class="flex flex-col mt-4 space-y-2 lg:mt-0 lg:flex-row lg:items-center lg:space-y-0 lg:space-x-2">
                      <x-button label="{{ __('Modify') }}" wire:click="toggleModifyForm(true)"
                          class="btn-outline btn-sm" />
                      <x-button label="{{ __('Delete') }}" wire:click="deleteComment()"
                          wire:confirm="{{ __('Are you sure to delete this comment?') }}"
                          class="btn-outline btn-error btn-sm" />
                  </div>
              </div>
  
              @include('livewire.posts.comment-form', ['formTitle' => __('Update your comment'), 'formAction' => 'updateComment', 'showForm' => $showModifyForm, 'message' => $comment->body])
  
          @endif
  
      @else
          @include('livewire.posts.comment-form', ['formTitle' => __('Leave a comment'), 'formAction' => 'createComment', 'showForm' => true, 'message' => ''])
      @endif
  </div>
  ```

* ```json
  "This is your first comment": "C'est votre premier commentaire",
  "It will be validate by an administrator before it appears here": "Il sera valide par un administrateur avant qu'il ne soit affiché ici",
  "Leave a comment": "Laissez un commentaire",
  "Your comment": "Votre commentaire",
  "Update your comment": "Modifier votre commentaire",
  "Are you sure to delete this comment?": "Êtes-vous sûr de vouloir supprimer ce commentaire ?",
  "Comments": "Commentaires",
  "Modify": "Modifier",
  "1 comment": "1 commentaire",
  "comments": "commentaires",
  "Max 10000 chars": "Max 10 000 caractères"
  ```

* Modification de posts.show :

* ```php
  ...
     <div id="bottom" class="relative items-center w-full py-5 mx-auto md:px-12 max-w-7xl">
          @if ($listComments)
              <x-card title="{{ __('Comments') }}" shadow separator>
                   Affichage des commentaires ici !
                  @auth
                      <livewire:posts.commentBase :postId="$post->id" />
                  @endauth
              </x-card>
          @else
              @if ($commentsCount > 0)
                  <div class="flex justify-center">
                      <x-button label="{{ $commentsCount > 1 ? __('View comments') : __('View comment') }}"
                          wire:click="showComments" class="btn-outline" spinner />
                  </div>
              @else
                  @auth
                      <livewire:posts.commentBase :postId="$post->id" />
                  @endauth
              @endif
          @endif
          ...
      </div>
  </div>
  ```

#### Notification de réponse à un commentaire <!-- markmap: fold -->

  ```bash
  php artisan make:notification CommentAnswerCreated
  ```
  
  ```php
  <?php
  namespace App\Notifications;
  
  use App\Models\Comment;
  use Illuminate\Bus\Queueable;
  use Illuminate\Notifications\Notification;
  use Illuminate\Notifications\Messages\MailMessage;
  
  class CommentAnswerCreated extends Notification
  {
      use Queueable;
  
      public Comment $comment;
  
      public function __construct(Comment $comment) {
          $this->comment = $comment;
      }
    
      public function via(object $notifiable): array {
          return ['mail'];
      }
    
      public function toMail(object $notifiable): MailMessage {
          return (new MailMessage())
              ->subject(__('An answer has been created on your comment'))
              ->line(__('An answer has been created on your comment') . ' "' . $this->comment->post->title . '" ' . __('by') . ' ' . $this->comment->user->name . '.')
              ->action(__('Show this comment'), route('posts.show', $this->comment->post->slug));
      }
    
      public function toArray(object $notifiable): array {
          return [
          ];
      }
  }
  ```

  ```json
  "An answer has been created on your comment": "Une réponse a été apportée à votre commentaire",
  "Show this comment": "Voir ce commentaire"
  ```

### Composant pour l'affichage des commentaires <!-- markmap: fold -->

  ```bash
  php artisan make:volt posts/comment --class
  ```

  ```CleanHtmlInput
  <?php
  use Livewire\Volt\Component;
  use Livewire\Attributes\Validate;
  use Illuminate\Support\Collection;
  use App\Models\{ Comment, Reaction };
  use App\Notifications\{CommentAnswerCreated, CommentCreated};
  
  new class() extends Component {
      public ?Comment $comment;
      public ?Collection $children;
      public bool $showAnswerForm = false;
      public bool $showModifyForm = false;
      public bool $alert          = false;
      public int $children_count  = 0;
      public int $depth;
    
      #[Validate('required|max:10000')]
      public string $message = '';
    
      public function mount($comment, $depth): void {
          $this->comment = $comment;
          $this->depth   = $depth;
          $this->message = strip_tags($comment->body);
          $this->children_count = $comment->children_count;
      }
    
      public function showAnswers(): void {
          $this->children = Comment::where('parent_id', $this->comment->id)
              ->with([
                  'user' => function ($query) {
                      $query->select('id', 'name', 'email', 'role')->withCount('comments');
                  },
              ])
              ->withCount(['children' => function ($query) {
                  $query->whereHas('user', function ($q) {
                      $q->where('valid', true);
                  });
              }])
              ->get();
    
          $this->children_count = 0;
      }
    
      public function toggleAnswerForm(bool $state): void {
          $this->showAnswerForm = $state;
          $this->message        = '';
      }
    
      public function toggleModifyForm(bool $state): void {
          $this->showModifyForm = $state;
      }
    
      public function createAnswer(): void {
          $data              = $this->validate();
          $data['parent_id'] = $this->comment->id;
          $data['user_id']   = Auth::id();
          $data['post_id']   = $this->comment->post_id;
          $data['body']      = $this->message;
    
          $item = Comment::create($data);
    
          $item->save();
    
          if ($item->post->user_id != Auth::id()) {
              $item->post->user->notify(new CommentCreated($item));
          }
    
          $author = $this->comment->user;
          if ($author->id != $item->post->user_id && $author->id != Auth::id()) {
              $author->notify(new CommentAnswerCreated($item));
          }
    
          $this->toggleAnswerForm(false);
    
          $this->showAnswers();
      }
    
      public function updateAnswer(): void {
          $data = $this->validate();
    
          $this->comment->body = $data['message'];
          $this->comment->save();
    
          $this->toggleModifyForm(false);
      }
    
      public function deleteComment(): void {
          $this->comment->delete();
          $this->childs  = null;
          $this->comment = null;
      } 
  }; ?>
  
  <div>
      <style>
          @media (max-width: 768px) {
              .ml-0 { margin-left: 0rem; }
              .ml-3 { margin-left: 0.75rem; }
              .ml-6 { margin-left: 1.5rem; }
              .ml-9 { margin-left: 2.25rem; }
          }
          @media (min-width: 769px) {
              .ml-0 { margin-left: 0rem; }
              .ml-3 { margin-left: 3rem; }
              .ml-6 { margin-left: 6rem; }
              .ml-9 { margin-left: 9rem; }
          }
      </style>
  
      @if ($comment)
          <div class="flex flex-col mt-4 ml-{{ $depth * 3 }} lg:ml-{{ $depth * 3 }} border-2 border-gray-400 rounded-md p-2 selection:transition duration-500 ease-in-out shadow-md shadow-gray-500 hover:shadow-xl hover:shadow-gray-500" >
  
              <div class="flex flex-col justify-between mb-4 md:flex-row">
                  <x-avatar :image="Gravatar::get($comment->user->email)" class="!w-24">
                      <x-slot:title class="pl-2 text-xl">
                          {{ $comment->user->name }}
                      </x-slot:title>
                      <x-slot:subtitle class="flex flex-col gap-1 pl-2 mt-2 text-gray-500">
                          <x-icon name="o-calendar" label="{{ $comment->created_at->diffForHumans() }}" />
                          <x-icon name="o-chat-bubble-left"  label="{{ $comment->user->comments_count == 0 ? '' : ($comment->user->comments_count == 1 ? __('1 comment') : $comment->user->comments_count . ' ' . __('comments')) }}" />
                      </x-slot:subtitle>
                  </x-avatar>
  
                  <div class="flex flex-col mt-4 space-y-2 lg:mt-0 lg:flex-row lg:items-center lg:space-y-0 lg:space-x-2">
                      @auth
                          @if (Auth::user()->name == $comment->user->name)
                              <x-button label="{{ __('Modify') }}" wire:click="toggleModifyForm(true)"
                                  class="btn-outline btn-warning btn-sm" spinner />
                              <x-button label="{{ __('Delete') }}" wire:click="deleteComment()"
                                  wire:confirm="{{ __('Are you sure to delete this comment?') }}"
                                  class="mt-2 btn-outline btn-error btn-sm" spinner />
                          @endif
                          @if ($depth < 3)
                              <x-button label="{{ __('Answer') }}" wire:click="toggleAnswerForm(true)"
                                  class="mt-2 btn-outline btn-sm" spinner />
                          @endif
                      @endauth
                  </div>
              </div>
  
              @if(!$showModifyForm)
                  <div class="mb-4">
                      {!! nl2br($comment->body) !!}
                  </div>
              @endif
              @if ($showModifyForm || $showAnswerForm)
                  <x-card :title="($showModifyForm ? __('Update your comment') : __('Your answer'))" shadow="hidden" class="!p-0">
                      <x-form :wire:submit="($showModifyForm ? 'updateAnswer' : 'createAnswer')" class="mb-4">
                          <x-textarea wire:model="message" :placeholder="($showAnswerForm ? __('Your answer') . ' ...' : '')" hint="{{ __('Max 10000 chars') }}" rows="5" inline />
                          <x-slot:actions>
                              <x-button label="{{ __('Cancel') }}" :wire:click="($showModifyForm ? 'toggleModifyForm(false)' : 'toggleAnswerForm(false)')"
                                  class="btn-ghost" />
                              <x-button label="{{ __('Save') }}" class="btn-primary" type="submit" spinner="save" />
                          </x-slot:actions>
                      </x-form>
                  </x-card>
              @endif
  
              @if ($alert)
                  <x-alert title="{!! __('This is your first comment') !!}"
                      description="{{ __('It will be validated by an administrator before it appears here') }}"
                      icon="o-exclamation-triangle" class="alert-warning" />
              @endif
  
              @if($children_count > 0)
                  <x-button label="{{ __('Show the answers') }} ({{ $children_count }})" wire:click="showAnswers" class="mt-2 btn-outline btn-sm" spinner />
              @endif
  
          </div>
      @endif
  
      @if($children)
          @foreach ($children as $child)
              <livewire:posts.comment :comment="$child" :depth="$depth + 1" :key="$child->id">
          @endforeach
      @endif
  
  </div>
  ```

  ```json
  "Answer": "Répondre",
  "Show the answers": "Afficher les réponses"
  ```

* Adaptation du posts.show à la place de : 'Affichage des commentaires ici !'

  ```html
      @foreach ($comments as $comment)
          @if (!$comment->parent_id)
              <livewire:posts.comment :$comment :depth="0" :key="$comment->id" />
          @endif
      @endforeach
  ```

### Sécurité // {!! $uneVariabledansDuCodeBladeQuiContientDuCodeDestinéÀLaVue !!} <!-- markmap: fold -->

  ```bash
  composer require mews/purifier
  ```
  
  ```php
  use Mews\Purifier\Casts\CleanHtmlInput;
  
  class Comment extends Model {
      ...
      protected $casts = [
          'body' => CleanHtmlInput::class,
      ];
      ...
  }
  ```

### Réf.: ***<a href="https://laravel.sillo.org/posts/mon-cms-les-commentaires-2-2" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-les-commentaires-2-2</a>***

## - Le profil <!-- markmap: fold -->

### Route du profil <!-- markmap: fold -->

* Considérer que ce n'est que pour les *users* "autorisés"
    → **Middleware('auth')**) et comme il y aura d'autres routes
    pour "eux", en faire un **group()** :

  ```php
  Route::middleware('auth')->group(function () {
      Volt::route('/profile', 'auth.profile')->name('profile');
  });
  ```

### Liens dans les vues adhoc <!-- markmap: fold -->

* \- Pour les grands écrans, dans **navigation.navbar** :

  ```html
  @if ($user = auth()->user())
      <x-dropdown>
          <x-slot:trigger>
              <x-button label="{{ $user->name }}" class="btn-ghost" />
          </x-slot:trigger>
          <x-menu-item title="{{ __('Profile') }}" link="{{ route('profile') }}" />
  ```

* \- Pour les plus petits, dans **navigation.sidebar** :

  ```html
  @if($user = auth()->user())
      <x-menu-separator />
          <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="-mx-2 !-my-2 rounded">
              <x-slot:actions>
                  <x-button icon="o-power" wire:click="logout" class="btn-circle btn-ghost btn-xs" tooltip-left="{{ __('Logout') }}" no-wire-navigate />
              </x-slot:actions>
          </x-list-item>
          <x-menu-item title="{{ __('Profile') }}" icon="o-user" link="{{ route('profile') }}" />
  ```

### Composant Profile <!-- markmap: fold -->

  ```bash
  php artisan make:volt auth/profile --class
  ```

  ```html
  <?php
  use App\Models\User;
  use Mary\Traits\Toast;
  use Illuminate\Support\Str;
  use Livewire\Volt\Component;
  use Livewire\Attributes\Layout;
  use Illuminate\Validation\Rule;
  use Illuminate\Support\Facades\{Auth, Hash};
  
  new #[Title('Profile')] #[Layout('components.layouts.auth')]
  class extends Component {
      use Toast;
  
      public User $user;
      public string $email = '';
      public string $password = '';
      public string $password_confirmation = '';
  
      public function mount(): void {
          $this->user = Auth::user();
          $this->email = $this->user->email;
      }
  
      public function save(): void {
          $data = $this->validate([
              'email' => ['required', 'email', Rule::unique('users')->ignore($this->user->id)],
              'password' => 'confirmed',
          ]);
  
          if (!empty($data['password'])) {
              $data['password'] = Hash::make($data['password']);
          }
  
          $this->user->update($data);
          $this->success(__('Profile updated with success.'), redirectTo: '/profile');
      }
  
      public function deleteAccount(): void {
          $this->user->delete();
          $this->success(__('Account deleted with success.'), redirectTo: '/');
      }
  
      public function generatePassword($length = 16): void {
          $this->password = Str::random($length);
          $this->password_confirmation = $this->password;
      }
  }; ?>
  
  <div>
      <x-card class="flex items-center justify-center h-[96vh]">
  
          <a href="/" title="{{ __('Go to site') }}">
              <x-card class="items-center py-0" title="{{ __('Update profile') }}" shadow separator
                  progress-indicator></x-card>
          </a>
  
          <x-form wire:submit="save">
  
              <x-avatar :image="Gravatar::get($user->email)" class="!w-24">
                  <x-slot:title class="pl-2 text-xl">
                      {{ $user->name }}
                  </x-slot:title>
                  <x-slot:subtitle class="flex flex-col gap-1 pl-2 mt-2 text-gray-500">
                      <x-icon name="o-hand-raised" label="{!! __('Your name can\'t be changed') !!}" />
                      <a href="https://fr.gravatar.com/" target="_blank" title=" {{ __('Go on Gravatar!') }} ">
                          <x-icon name="c-user" label="{{ __('You can change your profile picture on Gravatar') }}" />
                      </a>
                  </x-slot:subtitle>
              </x-avatar>
  
              <x-input label="{{ __('E-mail') }}" wire:model="email" icon="o-envelope" inline /><hr>
              <x-input label="{{ __('Password') }}" wire:model="password" icon="o-key" inline />
              <x-input label="{{ __('Confirm Password') }}" wire:model="password_confirmation" icon="o-key" inline />
              <x-button label="{{ __('Generate a secure password') }}" wire:click="generatePassword()" icon="m-wrench"
                  class="btn-outline btn-sm" />
  
              <x-slot:actions>
                  <x-button label="{{ __('Cancel') }}" link="/" class="btn-ghost" title=" {{ __('Back to site') }} "/>
                  <x-button label="{{ __('Delete account') }}" icon="c-hand-thumb-down"
                      wire:confirm="{{ __('Are you sure to delete your account?') }}" wire:click="deleteAccount"
                      class="btn-warning" />
                  <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                      class="btn-primary" />
              </x-slot:actions>
  
          </x-form>
      </x-card>
  </div>
  ```

### Traductions pour Profile <!-- markmap: fold -->

  ```json
  "Update profile": "Modifier le profil",
  "Your name can't be changed": "Votre nom ne peut pas être modifié",
  "You can change your profile picture on Gravatar": "Vous pouvez changer votre image de profil sur Gravatar",
  "Go on Gravatar!": "Vous rendre sur Gravatar !",
  "Generate a secure password": "Créer un mot de passe sécurisé",
  "Profile updated with success.": "Profil mis à jour avec succès.",
  "Delete account": "Supprimer le compte",
  "Are you sure to delete your account?": "Êtes-vous sûr de vouloir supprimer votre compte ?",
  "Profile": "Profil",
  "Go to site": "Allez sur le site",
  "Back to site": "Retourner sur le site"
  ```

### Réf.: ***<a href="https://laravel.sillo.org/posts/mon-cms-le-profil" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-le-profil</a>***

## - Les favoris <!-- markmap: fold -->

### Fonctionnalité des Favoris <!-- markmap: fold -->

#### Migration Favoris <!-- markmap: fold -->

  ```bash
  php artisan make:migration create_favorites_table
  ```

  ```php
  public function up(): void {
      Schema::create('favorites', function (Blueprint $table) {
          $table->id();
          $table->foreignId('post_id')->constrained()->onDelete('cascade');
          $table->foreignId('user_id')->constrained()->onDelete('cascade');
      });
  }
  ```

  ```bash
  php artisan migrate
  ```

#### Relation n:n (User & Post) <!-- markmap: fold -->

* À noter :
    Comme la convention de nommage de la table pivot n'est pas respectée
    (Devrait être 'posts_users' mais est 'favorites'), on doit
    préciser ce nom dans les relations BelongsToMany
  
* Models/**User.php** :

  ```php
  use Illuminate\Database\Eloquent\Relations\{ HasMany, BelongsToMany };
  ...
  public function favoritePosts(): BelongsToMany {
      return $this->belongsToMany(Post::class, 'favorites');
  }
  ```

* Models/**Post.php** :

  ```php
  use Illuminate\Database\Eloquent\Relations\{ HasMany, BelongsTo, BelongsToMany };
  ...
  public function favoritedByUsers(): BelongsToMany {
      return $this->belongsToMany(User::class, 'favorites');
  }
  ```

#### PostRepository: getPostBySlug() <!-- markmap: fold -->

* Vérifier en plus si l'*user* a mis le *post* en favori :

* ```php
  public function getPostBySlug(string $slug): Post {
      $userId = auth()->id();
    
      return Post::with('user:id,name', 'category')
          ->withCount('validComments')
          ->withExists([
              'favoritedByUsers as is_favorited' => function ($query) use ($userId) {
                  $query->where('user_id', $userId);
              },
        ])
        ->where('slug', $slug)->firstOrFail();
  }
  ```

#### Route Favoris <!-- markmap: fold -->

  ```php
  Route::middleware('auth')->group(function () {
      ...
      Volt::route('/favorites', 'index')->name('posts.favorites');
  });
  ```

#### Lien Favoris dans posts.show <!-- markmap: fold -->

* On affiche l'icône étoile pour mettre en favoris ou retirer l'article des favoris :

* ```html
  public function favoritePost(): void {
      $user = auth()->user();
  
      if ($user) {
          $user->favoritePosts()->attach($this->post->id);
          $this->post->is_favorited = true;
      }
  }
  
  public function unfavoritePost(): void {
      $user = auth()->user();
  
      if ($user) {
          $user->favoritePosts()->detach($this->post->id);
          $this->post->is_favorited = false;
      }
  }
  ...
  <div id="top" class="flex justify-end gap-4">
      @auth
          <x-popover>
              <x-slot:trigger>
                  @if ($post->is_favorited)
                      <x-button icon="s-star" wire:click="unfavoritePost" spinner
                          class="text-yellow-500 btn-ghost btn-sm" />
                  @else
                      <x-button icon="s-star" wire:click="favoritePost" spinner class="btn-ghost btn-sm" />
                  @endif
              </x-slot:trigger>
              <x-slot:content class="pop-small">
                  @if ($post->is_favorited)
                      @lang('Remove from favorites')
                  @else
                      @lang('Bookmark this post')
                  @endif
              </x-slot:content>
          </x-popover>
      @endauth
      ...
  </div>
  ```

* ```json
  "Bookmark this post": "Marquer cet article dans vos favoris",
  "Remove from favorites": "Supprimer de vos favoris"
  ```

#### PostRepository pour "is_favorited" <!-- markmap: fold -->

* Si connecté, trouver ses articles favoris :

  ```php
  use Illuminate\Support\Facades\DB;
  ...
  protected function getBaseQuery(): Builder {
   ...
      return Post::select('id', 'slug', 'image', 'title', 'user_id', 'category_id', 'created_at', 'pinned')
      ...
      ->when(auth()->check(), function ($query) {
          $userId = auth()->id();
          $query->addSelect([
              'is_favorited' => DB::table('favorites')
                  ->selectRaw('1')
                  ->whereColumn('post_id', 'posts.id')
                  ->where('user_id', $userId)
                  ->limit(1)
          ]);
      });
  }
  ```

#### Page d'accueil (Homepage) <!-- markmap: fold -->

  ```html
  <x-slot:menu>
      @if ($post->pinned)
          <x-badge value="{{ __('Pinned') }}" class="p-3 badge-warning" />
      @endif
      @auth
          @if ($post->is_favorited)
              <x-icon name="s-star" class="w-6 h-6 text-yellow-500 cursor-pointer" />
          @endif
      @endauth
  </x-slot:menu>
  ```

#### Logique & lien des favoris <!-- markmap: fold -->

* Ajout de getFavoritePosts() dans PostRepository

* ```php
  use App\Models\{Category, Post, User};
  ...
  public function getFavoritePosts(User $user): LengthAwarePaginator {
  
      return $this->getBaseQuery()
          ->whereHas('favoritedByUsers', function (Builder $query) {
              $query->where('user_id', auth()->id());
          })
          ->latest()
        ->paginate(config('app.pagination'));
  }
  ```

* Ajout du bouton des favoris éventuels de l'user dans navigation/navbar :

  ```html
          ...
          @auth
              @if ($user->favoritePosts()->exists())
                  <a title="{{ __('Your favorites posts') }}" href="{{ route('posts.favorites') }}"><x-icon name="s-star"
                          class="w-7 h-7" /></a>
              @endif
          @endauth
          <x-theme-toggle title="{{ __('Toggle theme') }}" class="w-4 h-8" />
          <livewire:search />
      </x-slot:actions>
  </x-nav>
  ```

#### Afficher la page Favoris <!-- markmap: fold -->

* Composant index :

* ```markdown
  - On défini une nouvelle propriété $favorites
  - mount() : On gère le cas où la requête est "/favorites" (On met la propriété favorites à true)
  - getPosts() : Si la propriété favorites est à true, on appelle getFavoritePosts(auth()->user()) 
  - Pour le HTML, on adapte alors le titre de la page :
  ```
  
* ```html
  public bool $favorites = false;
  
  public function mount(string $slug = '', string $param = ''): void {
      $this->param = $param;
    
      if (request()->is('category/*')) {
          $this->category = $this->getCategoryBySlug($slug);
      } elseif (request()->is('favorites')) {
          $this->favorites = true;
      }
  }
  ...
  public function getPosts(): LengthAwarePaginator {
      ...
      if ($this->favorites) {
          return $postRepository->getFavoritePosts(auth()->user());
      }     
      return $postRepository->getPostsPaginate($this->category);
  }
  ...
  @if ($category)
      <x-header title="{{ __('Posts for category ') }} {{ $category->title }}" size="text-2xl sm:text-3xl md:text-4xl" />
  @elseif($param !== '')
      <x-header title="{{ __('Posts for search ') }} '{{ $param }}'" size="text-2xl sm:text-3xl md:text-4xl" />
  @elseif($favorites)
      <x-header title="{{ __('Your favorites posts') }}" size="text-2xl sm:text-3xl md:text-4xl" />
  @endif
  ```

* ```json
  "Your favorites posts": "Vos articles favoris",
  "Toggle theme": "Basculer le thème",
  ```

### Boutons pour scroller (Aller en bas et en haut) <!-- markmap: fold -->

* resources/css/**app.css** :

  ```css
  html {
      scroll-behavior: smooth;
  }
  ```

* posts.show :

  ```html
    ...

    <div id="top" class="flex justify-end gap-4">

        .... (Nouveau x-popover :)

        <x-popover>
            <x-slot:trigger>
                <a href="#bottom"><x-icon name="c-arrow-long-down" /></a>
            </x-slot:trigger>
            <x-slot:content class="pop-small">
                @lang('To bottom')
            </x-slot:content>
        </x-popover>
    </div>

    ... (Nouveau div :)

    <div id="bottom" class="relative flex justify-end w-full py-5 mx-auto md:px-12 max-w-7xl">
        ...
        <x-popover>
            <x-slot:trigger>
                <a href="#top"><x-icon name="c-arrow-long-up" />
            </x-slot:trigger>
            <x-slot:content class="pop-small">
                @lang('To up')
            </x-slot:content>
        </x-popover>
    </div>
  
  </div>
  ```

* ```json
  "To up": "Vers le haut",
  "To bottom": "Vers le bas"
  ```

### Réf.: ***<a href="https://laravel.sillo.org/posts/mon-cms-les-favoris" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-les-favoris</a>***

## &nbsp;**II &nbsp;/ &nbsp; B A C K &nbsp;- &nbsp;O F F I C E &nbsp;:**

## - L'administration <!-- markmap: fold -->

### Gestion des rôles

#### Model User : Admin ou Redac <!-- markmap: fold -->

  ```php
  public function isAdmin(): bool {
      return 'admin' === $this->role;
  }
  
  public function isRedac(): bool {
      return 'redac' === $this->role;
  }
  
  public function isAdminOrRedac(): bool {
      return 'admin' === $this->role || 'redac' === $this->role;
  }
```

#### Middlewares <!-- markmap: fold -->

##### **admin**

  ```bash
  php artisan make:middleware IsAdmin
  ```

  ```php
  public function handle(Request $request, Closure $next): Response {
      if (!auth()->user()->isAdmin()) {
          abort(403);
      }
    
      return $next($request);
  }
  ```

##### **adminOrRedac**

  ```bash
  php artisan make:middleware IsAdminOrRedac
  ```

  ```php
  public function handle(Request $request, Closure $next): Response {
      if (!auth()->user()->isAdmin() && !auth()->user()->isRedac()) {
          abort(403);
      }
    
      return $next($request);
  }
  ```

### Tableau de Bord

#### Route <!-- markmap: fold -->

  ```php
  use App\Http\Middleware\IsAdminOrRedac;
  ...
  Route::middleware('auth')->group(function () {
      ...
      Route::middleware(IsAdminOrRedac::class)->prefix('admin')->group(function () {
          Volt::route('/', 'admin.index')->name('admin.root');        
          Volt::route('/dashboard', 'admin.index')->name('admin');
  
      });
  });
```

#### SideBar <!-- markmap: fold -->

##### Création Sidebar de l'admin

  ```bash
  php artisan make:volt admin/sidebar --class
  ```

  ```html
  <?php
  use Livewire\Volt\Component;
  use Illuminate\Support\Facades\{Auth, Session};

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
          <x-menu-item icon="m-arrow-right-end-on-rectangle" title="{{ __('Go to site') }}" link="/" />
          <x-menu-item>
              <x-theme-toggle />
          </x-menu-item>
      </x-menu>
  </div>
  ```

#### Layout <!-- markmap: fold -->

* Créer views/layouts/**admin.blade.php** :

  ```html
  <!DOCTYPE html>
  <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <title>
        {{ (isset($title) ? $title . ' | ' : (View::hasSection('title') ? View::getSection('title') . ' | ' : '')) . config('app.name') }}
      </title>
  
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

  ```bash
  php artisan make:volt admin/index --class
  ```

  ```html
  <?php
  use Mary\Traits\Toast;
  use Livewire\Volt\Component;
  use Illuminate\Support\Facades\Auth;
  use Livewire\Attributes\{Layout, Title};
  use Illuminate\Database\Eloquent\Builder;
  use App\Models\{Comment, Page, Post, User};
  
  new #[Title('Dashboard')] #[Layout('components.layouts.admin')] class extends Component {
      use Toast;
    
      public array $headersPosts;
      public bool $openGlance = true;
    
      public function mount(): void {
          $this->headersPosts = [['key' => 'date', 'label' => __('Date')], ['key' => 'title', 'label' => __('Title')]];
      }
    
      public function deleteComment(Comment $comment): void {
          $comment->delete();
    
          $this->warning('Comment deleted', __('Good bye!'), position: 'toast-bottom');
      }
    
      public function with(): array {
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

#### Traductions Dashboard <!-- markmap: fold -->

  ```json
  "In a glance": "En un coup d'oeil",
  "Recent posts": "Articles récents",
  "Show post": "Afficher l'article",
  "in post:": "dans l'article :",
  "Users": "Utilisateurs",
  "Dashboard": "Tableau de bord",
  "Edit or answer": "Modifier ou répondre",
  "Posts": "Articles",
  "Recent Comments": "Commentaires récents",
  "Comment to valid from ": "Commentaire à valider de "
  ```

#### Style Valeurs dans les pavés du *Dashboard* <!-- markmap: fold -->

  ```css
  .shadow-hover {
      @apply transition duration-500 ease-in-out shadow shadow-gray-500
      hover:shadow-md hover:shadow-gray-500 hover:text-orange-500;
  }
  ```
  
#### Lien dans les menus <!-- markmap: fold -->

##### Dans navigation.navbar

  ```html
  <x-slot:actions>
      <span class="hidden sm:block">
          ...
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
          @else ...
```

##### Dans navigation.sidebar

  ```html
      ... Logout
      </x-list-item>
      @if ($user->isAdminOrRedac())
          <x-menu-item title="{{ __('Administration') }}" icon="s-building-office-2" link="{{ route('admin') }}" />
      @endif
      <x-menu-separator />
      ... Profile
  ```

#### Redac & Admin: Redirection lors du login <!-- markmap: fold -->

* Composant auth.login :

  ```php
  public function login() {
      ...
      if (auth()->user()->isAdmin()) {
          return redirect()->intended('/admin/dashboard');
      }
      ... $this->redirectIntended()...
  }
  ```

### Réf.: ***<a href="https://laravel.sillo.org/posts/mon-cms-ladministration" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-ladministration</a>***

## - Les Articles <!-- markmap: fold -->

### Tableau des articles <!-- markmap: fold -->

#### Route Articles <!-- markmap: fold -->

  ```php
  Route::middleware('auth')->group(function () {
      ...
      Route::middleware(IsAdminOrRedac::class)->prefix('admin')->group(function () {
          ...
          Volt::route('/posts/index', 'admin.posts.index')->name('posts.index');
    });
  });
  ```

#### Navigation Articles <!-- markmap: fold -->

* Lien des articles dans dashboard (Pavé 'En un coup d'oeil') :

  ```html
  ... admin.index, pavé Posts
  <a href="{{ route('posts.index') }}" class="flex-grow" title="{{ __('All posts') }}">
      <x-stat title="{{ __('Posts') }}" description="" value="{{ $posts->count() }}" icon="s-document-text" class="shadow-hover" />
  </a>
  ```

* Lien des articles dans admin/sidebar :

  ```html
  ... Lien Dashboard
  <x-menu-sub title="{{ __('Posts') }}" icon="s-document-text">
      <x-menu-item title="{{ __('All posts') }}" link="{{ route('posts.index') }}" />
  </x-menu-sub>
  ```

* lang/**fr.json** :

  ```json
  "All posts": "Tous les articles",
  ```

#### Composant Articles <!-- markmap: fold -->

##### CLI
<!-- markmap: fold -->

  ```bash
  php artisan make:volt admin/posts/index --class
  ```

##### Code admin.posts.index <!-- markmap: fold -->

  ```html
  <?php
  use Mary\Traits\Toast;
  use Livewire\Volt\Component;
  use Livewire\WithPagination;
  use Livewire\Attributes\Layout;
  use App\Models\{Post, Category};
  use Illuminate\Support\Facades\Auth;
  use App\Repositories\PostRepository;
  use Illuminate\Pagination\LengthAwarePaginator;
  use Illuminate\Database\Eloquent\{Builder, Collection};
  
  new 
  #[Layout('components.layouts.admin')]
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

  @section('title', __('Posts'))
  <div>
    <x-header separator progress-indicator>
        <x-slot:title><a href="/" title="{{ __('Go to site') }}">{{ __('Posts') }}</a></x-slot:title>
        <x-slot:actions>
            <x-input placeholder="{{ __('Search...') }}" wire:model.live.debounce="search" clearable
                icon="o-magnifying-glass" />
            <x-button label="{{ __('Add a post') }}" class="btn-outline lg:hidden"
                link="{{ route('posts.create') }}" />
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
  
      <x-collapse>
          <x-slot:heading>@lang(__('Filters'))</x-slot:heading>
          <x-slot:content>
              <x-select label="{{ __('Category') }}" :options="$categories" placeholder="{{ __('Select a category') }}"
                  option-label="title" wire:model="category_id" wire:change="$refresh" />
          </x-slot:content>
      </x-collapse>
    
      <br>
  
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
                              <x-slot:content class="pop-small">@lang('Delete')</x-slot:content>
                          </x-popover>
                      </div>
                  @endscope
  
              </x-table>
          </x-card>
      @endif
  </div>
  ```

##### Dans PostRepository <!-- markmap: fold -->

  ```php
  public function generateUniqueSlug(string $slug): string {
      $newSlug = $slug;
      $counter = 1;
      while (Post::where('slug', $newSlug)->exists()) {
          $newSlug = $slug . '-' . $counter;
          ++$counter;
    }
    return $newSlug;
  }
  ```

##### Traductions admin posts list <!-- markmap: fold -->

  ```json
  "Title": "Titre",
  "Author": "Auteur",
  "Updated": "Mis à jour",
  "Category": "Catégorie",
  "Published": "Publié",
  "Add a post": "Ajouter un article",
  "Are you sure to delete this post?": "Êtes-vous sûr de vouloir supprimer cet article ?",
  "deleted": "supprimé",
  "Clone": "Dupliquer",
  "Filters": "Filtres"
  ```

#### Réf.: ***<a href="https://laravel.sillo.org/posts/mon-cms-tableau-des-articles" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-tableau-des-articles</a>***

### Créer un article <!-- markmap: fold -->

#### Route admin/posts/create <!-- markmap: fold -->

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

  ```html
  <x-menu-sub title="{{ __('Posts') }}" icon="s-document-text">
      <x-menu-item title="{{ __('All posts') }}" link="{{ route('posts.index') }}" />
      <x-menu-item title="{{ __('Add a post') }}" link="{{ route('posts.create') }}" />
  </x-menu-sub>
  ```

#### Composant (Formulaire) <!-- markmap: fold -->

##### CLI admin.posts.create <!-- markmap: fold -->

  ```bash
  php artisan make:volt admin/posts/create --class
  ```

##### Code Création article

###### Base du code <!-- markmap: fold -->

  ```html
  <?php
  use App\Models\Category;
  use Livewire\Volt\Component;
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
              {{-- <x-editor wire:model="body" label="{{ __('Content') }}" :config="config('tinymce.config')"
                  folder="{{ 'photos/' . now()->format('Y/m') }}" /> --}}
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
  
  public function mount(): void {
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
  use Mary\Traits\Toast;
  use App\Models\{Category, Post};
  
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
  }
  ```

##### Traductions admin.posts.create <!-- markmap: fold -->

  ```json
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

#### Éditeur (TinyMCE) <!-- markmap: fold -->

##### Installation hébergée (Usage Illimité → Notre choix) <!-- markmap: fold -->

###### <a href="https://www.tiny.cloud/get-tiny" title="Sur le site !" target="_blank">Télécharger Free TinyMCE</a>

###### À décompresser dans : ./storage/app/public/scripts

###### Paramétrages

* ./config/**tinymce.php** :

  ```php
  <?php
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

* Fichier ./.env :

  ```json
  APP_TINYMCE_LOCALE=fr_FR
  ```

###### Traductions TinyMCE

* <a href="https://www.tiny.cloud/get-tiny/language-packages" title="Sur le site !" target="_blank">Récupérer les fichiers de traduction</a>
* Les copier dans : ./storage/app/public/scripts/**fr_FR.js**

###### Activation de TinyMCE

* Fichier ./resources/views/components/layouts/**admin.blade.php** :

  ```html
  <script src="{{ asset('storage/scripts/tinymce.min.js') }}" ></script>
  ... @vite(...)
  ```

* Dans la vue du composant admin.posts.create :

  ```html
  <x-editor wire:model="body" label="{{ __('Content') }}" :config="config('tinymce.config')" folder="{{ 'photos/' . now()->format('Y/m') }}" />
  ```

##### Installation CDN (Usage limité: 1000 appels/mois - Mise à jour auto) <!-- markmap: fold -->

* Fichier ./resources/views/components/layouts/**admin.blade.php** :

  ```html
  <script src="https://cdn.tiny.cloud/1/YOUR-KEY-HERE/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  ... @vite(...)
  ```

##### Réf.: ***<a href="https://mary-ui.com/docs/components/editor" title="Voir les détails" target="_blank">https://mary-ui.com/docs/components/editor</a>***

#### Gestion de l'image <!-- markmap: fold -->

##### Ajout du trait Livewire WithFileUploads <!-- markmap: fold -->

* admin.posts.create :

  ```php
  use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
  use Livewire\WithFileUploads;
  
  new #[Layout('components.layouts.admin')] 
  class extends Component {
      use WithFileUploads, Toast;
  
      #[Rule('required|image|max:7000')]
      public ?TemporaryUploadedFile $photo = null;
  ```

##### Image / défaut <!-- markmap: fold -->

* <a href="https://laravel.sillo.org/ask.jpg" target="_blank">Récupérer l'image</a>
* À poser dans : ./public/storage/**ask.jpg**

##### Composant de MaryUI dans le formulaire <!-- markmap: fold -->

  ```html
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

##### Traductions pour Image <!-- markmap: fold -->

  ```json
  "Featured image": "Image mise en avant",
  "Click on the image to modify": "Cliquez sur cette image pour la modifier",
  ```

##### Save Image <!-- markmap: fold -->

###### Dossier par défaut → **photos/** <!-- markmap: fold -->

* Image temporaire → ./storage/app/livewire-tmp/
* → Pour poser dans le dossier **photos/**, adapter la fonction save() :

* ```php
  public function save() {
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

* Ajout dans app/**helpers.php** :

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

* Adaptation de save() :

  ```php
  public function save() {
     ...
      $data['body'] = replaceAbsoluteUrlsWithRelative($data['body']);
   
      Post::create(
      ...
  }
  ```

#### Réf.: ***<a href="https://laravel.sillo.org/posts/mon-cms-creer-un-article" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-creer-un-article</a>***

### Modifier un article <!-- markmap: fold -->

#### Route posts.edit <!-- markmap: fold -->

* Dans le groupe du middleware 'IsAdminOrRedac' :

  ```php
  Volt::route('/posts/{post:slug}/edit', 'admin.posts.edit')->name('posts.edit');
  ```

#### Lien dans tableau des articles (admin.posts.index) <!-- markmap: fold -->

```html
<x-table striped :headers="$headers" :rows="$posts" :sort-by="$sortBy" link="/admin/posts/{slug}/edit" with-pagination>
```

#### Composant édition articles admin.posts.edit <!-- markmap: fold -->

  ```bash
  php artisan make:volt admin/posts/edit --class
  ```

#### La logique admin.posts.edit <!-- markmap: fold -->

  ```php
  <?php
  use Mary\Traits\Toast;
  use illuminate\Support\Str;
  use Livewire\Volt\Component;
  use Livewire\WithFileUploads;
  use Livewire\Attributes\Layout;
  use Illuminate\Validation\Rule;
  use App\Models\{Category, Post};
  use Illuminate\Support\Collection;
  use Illuminate\Support\Facades\Storage;
  use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
  
  new #[Layout('components.layouts.admin')] 
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
    
    public function mount(Post $post): void {
      if (Auth()->user()->isRedac() && $post->user_id !== Auth()->id()) {
        abort(403);
      }
    
      $this->post = $post;
      $this->fill($this->post);
      $this->categories = Category::orderBy('title')->get();
    }
    
    public function updatedTitle($value) {
      $this->slug      = Str::slug($value);
      $this->seo_title = $value;
    }
    
    public function save() {
      $data = $this->validate([
        'title'            => 'required|string|max:255',
        'body'             => 'required|string|max:16777215',
        'category_id'      => 'required',
        'photo'            => 'nullable|image|max:7000',
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

#### Formulaire d'édition <!-- markmap: fold -->

  ```html
  @section('title', __('Edit a post'))
  <div>
      <x-header title="{{ __('Edit a post') }}" separator progress-indicator>
          <x-slot:actions>
              <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                  link="{{ route('admin') }}" />
          </x-slot:actions>
      </x-header>
  
      <x-card>
          <x-form wire:submit="save">
              <x-select label="{{ __('Category') }}" option-label="title" :options="$categories" wire:model="category_id" wire:change="$refresh" />
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

#### Traductions Édition <!-- markmap: fold -->

  ```json
  "Edit a post": "Modifier un article",
  "Post updated with success.": "Article mis à jour avec succès."
  ```

#### Bouton édition dans posts.show <!-- markmap: fold -->

##### HTML

  ```html
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

##### Traduction Édition du post

  ```json
  "Edit this post": "Modifier cet article"
  ```

#### Bouton clone dans posts.show <!-- markmap: fold -->

##### Lien dans post.show

  ```html
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

##### Logique du clonage

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

##### Traduction Clone

  ```json
  "Clone this post": "Dupliquer cet article"
  ```

#### Réf.: ***<a href="https://laravel.sillo.org/posts/mon-cms-modifier-un-article" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-modifier-un-article</a>

## - Les Catégories <!-- markmap: fold -->

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

* HTML Item dans admin.sidebar :

  ```html
  <x-menu-sub title="{{ __('Posts') }}" icon="s-document-text">
      ...
      @if (Auth::user()->isAdmin())
          <x-menu-item title="{{ __('Categories') }}" link="{{ route('categories.index') }}" />
      @endif
  </x-menu-sub> 
  ```

* Traduction Item :

  ```json
  "Categories": "Catégories"
  ```

### Création composant category.index <!-- markmap: fold -->

  ```bash
  php artisan make:volt admin/categories/index --class
  ```

### Code composant categories.index <!-- markmap: fold -->

#### Code de base <!-- markmap: fold -->

  ```html
  <?php
  use App\Models\Category;
  use Livewire\Volt\Component;
  use Livewire\WithPagination;
  use Livewire\Attributes\Layout;
  
  new #[Layout('components.layouts.admin')] 
  class extends Component {
      use WithPagination;
  
      public array $sortBy = ['column' => 'title', 'direction' => 'asc'];
  
      public function headers(): array {
          return [['key' => 'title', 'label' => __('Title')], ['key' => 'slug', 'label' => 'Slug']];
      }
    
      public function with(): array {
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

  ```html
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
  public function delete(Category $category): void {
      $category->delete();
      $this->success(__('Category deleted with success.'));
  }
  ```

##### Traduction Supprimer catégorie

  ```json
  "Are you sure to delete this category?": "Êtes-vous sûr de vouloir supprimer cette catégorie ?",
  "Category deleted with success.": "Catégorie supprimée avec succès."
  ```

#### Formulaire catégorie <!-- markmap: fold -->

##### Composant formulaire creation/modification

  ```bash
  php artisan make:volt admin/categories/category-form
  ```

##### HTML admin/categories/**category-form.blade.php**

  ```html
  <x-form wire:submit="save">
      <x-input label="{{ __('Title') }}" wire:model.debounce.500ms="title" wire:change="$refresh" />
      <x-input type="text" wire:model="slug" label="{{ __('Slug') }}" />
      <x-slot:actions>
          <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
              class="btn-primary" />
      </x-slot:actions>
  </x-form>
  ```

##### Ajout du formulaire Créer catégorie (categories.index)

  ```html
      <x-card title="{{ __('Create a new category') }}">
          @include('livewire.admin.categories.category-form')
      </x-card>
  </div>
  ```

##### Complément logique validation catégorie

  ```php
  ...
  use Mary\Traits\Toast;
  use Illuminate\Support\Str;
  use Livewire\Attributes\{Layout, Validate};
  
  new #[Layout('components.layouts.admin')] 
  class extends Component {
      use Toast, WithPagination;
      ...
      #[Validate('required|max:255|unique:categories,title')]
      public string $title = '';
    
      #[Validate('required|max:255|unique:posts,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/')]
      public string $slug = '';
    
      public function updatedTitle($value): void {
          $this->generateSlug($value);
      }
    
      private function generateSlug(string $title): void {
          $this->slug = Str::of($title)->slug('-');
      }
    
      public function save(): void {
          $data = $this->validate();
          Category::create($data);
          $this->success(__('Category created with success.'));
    }
  ```

##### Traduction Créer catégorie

  ```json
  "Create a new category": "Créer une nouvelle catégorie",
  "Category created with success.": "Catégorie créée avec succès."
  ```

### Modification d'une catégorie <!-- markmap: fold -->

#### Route pour la modification de catégorie

  ```php
  Route::middleware(IsAdmin::class)->group(function () {
      ...
      Volt::route('/categories/{category}/edit', 'admin.categories.edit')->name('categories.edit');
  });
  ```

#### Lien dans tableau des catégories

  ```html
  // admin/categories/index
  <x-table striped :headers="$headers" :rows="$categories" :sort-by="$sortBy" link="/admin/categories/{id}/edit" with-pagination>
  ```

#### Création du composant modification

  ```bash
  php artisan make:volt admin/categories/edit --class
  ```

#### Code du composant d'édition <!-- markmap: fold -->

  ```html
  <?php
  use Mary\Traits\Toast;
  use App\Models\Category;
  use Illuminate\Support\Str;
  use Livewire\Volt\Component;
  use Livewire\Attributes\Layout;
  use Illuminate\Validation\Rule;
  
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
    
    protected function rules(): array {
    return [
        'title' => 'required|string|max:255',
        'slug'  => ['required', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('categories')->ignore($this->category->id)],
    ];
    }
    
    private function generateSlug(string $title): void {
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

#### Traduction modification de catégorie

  ```json
  "Category updated successfully.": "Catégorie mise à jour avec succès.",
  "Edit a category": "Modifier une catégorie"
  ```

### Réf.: ***<a href="https://laravel.sillo.org/posts/mon-cms-les-categories" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-les-categories</a>***

## - Les Pages <!-- markmap: fold -->

### Liste des pages <!-- markmap: fold -->

#### Route Pages <!-- markmap: fold -->

* Groupe middleware IsAdminOrRedac > IsAdmin :

  ```php
  Volt::route('/pages/index', 'admin.pages.index')->name('pages.index');
  ```

#### Navigation Pages <!-- markmap: fold -->

* Lien Pages dans le pavé en haut du dashboard (admin.index) :

  ```html
   <a href="{{ route('pages.index') }}" class="flex-grow" title="{{ __('All pages') }}">
      <x-stat title="{{ __('Pages') }}" value="{{ $pages->count() }}" icon="s-document" class="shadow-hover" />
  </a>
  ```

* Lien Pages dans admin.sidebar :

  ```html
  ...(Posts)
  @if (Auth::user()->isAdmin())
      <x-menu-sub title="{{ __('Pages') }}" icon="s-document">
          <x-menu-item title="{{ __('All pages') }}" link="{{ route('pages.index') }}" />
      </x-menu-sub>
  @endif
  ...
  ```

* Traduction Pages :

  ```json
  "All pages": "Toutes les pages",
  ```

#### Composant Pages <!-- markmap: fold -->

  ```php
  php artisan make:volt admin/pages/index --class
  ```

  ```html
  <?php
  use App\Models\Page;
  use Mary\Traits\Toast;
  use Livewire\Volt\Component;
  use Livewire\WithPagination;
  use Livewire\Attributes\Layout;
  
  new #[Layout('components.layouts.admin')] 
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

  ```json
  "All pages": "Toutes les pages",
  "Add a page": "Ajouter une page",
  "Are you sure to delete this page?": "Êtes-vous sûr de vouloir supprimer cette page ?",
  "Page deleted": "Page effacée avec succès."
  ```

### Création pages <!-- markmap: fold -->

#### Route Ajouter Pages <!-- markmap: fold -->

  ```php
  // Groupe middleware IsAdminOrRedac > IsAdmin
  Volt::route('/pages/create', 'admin.pages.create')->name('pages.create');
  ```

#### Liens Ajouter Pages <!-- markmap: fold -->

* admin.pages.index :

  ```html
  <x-button icon="c-document-plus" label="{{ __('Add a page') }}" class="btn-outline" link="{{ route('pages.create') }}" />
  ```

* admin.sidebar :

  ```html
  @if (Auth::user()->isAdmin())
      <x-menu-sub title="{{ __('Pages') }}" icon="s-document">
          <x-menu-item title="{{ __('All pages') }}" link="{{ route('pages.index') }}" />
          <x-menu-item title="{{ __('Add a page') }}" link="{{ route('pages.create') }}" />
      </x-menu-sub>
  @endif
  ```

#### Formulaire Pages (Création & modification) <!-- markmap: fold -->

* Créer pages/**page-form.blade.php** :
  
  ```html
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

#### CLI Creation Pages <!-- markmap: fold -->

  ```bash
  php artisan make:volt admin/pages/create --class
  ```

#### Code composant Créer Pages <!-- markmap: fold -->

  ```html
  <?php
  use App\Models\Page;
  use Mary\Traits\Toast;
  use illuminate\Support\Str;
  use Livewire\Volt\Component;
  use Livewire\Attributes\{Layout, Validate, Title};
  
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
    
      #[Validate('required|regex:/^[A-Za-z0-9-éèàù]{1,50}(, ?[A-Za-z0-9-éèàù]{1,50})*$/')]
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

#### Traduction Ajouter Pages <!-- markmap: fold -->

  ```json
  "Page added with success.": "Page ajoutée avec succès."
  ```

### Modification (→ Édition) Pages <!-- markmap: fold -->

#### Route Éditer Pages <!-- markmap: fold -->

* Groupe middleware IsAdminOrRedac > IsAdmin :

  ```php
  Volt::route('/pages/{page:slug}/edit', 'admin.pages.edit')->name('pages.edit');
  ```

#### Lien Éditer Pages <!-- markmap: fold -->

* admin.pages.index :

  ```php
  <x-table striped :headers="$headers" :rows="$pages" link="/admin/pages/{slug}/edit">
  ```

#### CLI édition Pages <!-- markmap: fold -->

  ```bash
  php artisan make:volt admin/pages/edit --class
  ```

#### Code Éditer Pages <!-- markmap: fold -->

  ```html
  <?php
  use App\Models\Page;
  use Mary\Traits\Toast;
  use illuminate\Support\Str;
  use Livewire\Volt\Component;
  use Illuminate\Validation\Rule;
  use Livewire\Attributes\{Layout, Title};
  
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

#### Traductions Éditer Pages <!-- markmap: fold -->

  ```json
  "Page edited with success.": "Page mise à jour avec succès.",
  "Edit a page": "Modifier une page"
  ```

### Réf.: ***<a href="https://laravel.sillo.org/posts/mon-cms-les-pages" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-les-pages</a>***

### Liste des contacts <!-- markmap: fold -->

#### Route Index Contact <!-- markmap: fold -->

* Groupe middleware IsAdminOrRedac > IsAdmin :

  ```php
  ... Route Catégories
  Volt::route('/contacts/index', 'admin.contacts.index')->name('contacts.index');
  ```

#### Liens Index Contact <!-- markmap: fold -->

* admin.sidebar :

  ```html
  <x-menu-item icon="s-pencil-square" title="{{ __('Contacts') }}" link="{{ route('contacts.index') }}" />
  ... Liens Pages
  ```

* admin.index :

  ```html
  use App\Models\{Comment, Contact, Page, Post, User};
  ...
  return [
    'users'          => User::count(),
    'contacts'       => Contact::whereHandled(false)->get(),
  ]
  ...
  </x-collapse>
  <br>
    @if (Auth::user()->isAdmin())
      @foreach ($contacts as $contact)
          <x-alert title="{!! __('Contact to handle from ') . html_entity_decode($contact->name) !!}" description="{!! html_entity_decode($contact->message) !!}" icon="s-pencil-square"
              class="shadow-md alert-info">
              <x-slot:actions>
                  <x-button link="{{ route('contacts.index') }}" label="{!! __('Show the contacts') !!}" />
              </x-slot:actions>
          </x-alert>
          <br>
      @endforeach
  @endif
  ```

#### CLI Index Contact <!-- markmap: fold -->

  ```bash
  php artisan make:volt admin/contacts/index --class
  ```

#### Code Index Contact <!-- markmap: fold -->

  ```html
  <?php
  use Mary\Traits\Toast;
  use App\Models\Contact;
  use Livewire\Volt\Component;
  use Livewire\WithPagination;
  use Livewire\Attributes\{Layout, Title};
  
  new #[Title('Contacts')] #[Layout('components.layouts.admin')] class extends Component {
      use Toast;
      use WithPagination;
  
      // Définition des en-têtes des colonnes
      public function headers(): array {
          return [['key' => 'name', 'label' => __('Name')], ['key' => 'email', 'label' => __('Email')], ['key' => 'message', 'label' => __('Message')], ['key' => 'created_at', 'label' => __('Sent on')]];
      }
  
      // Méthode pour supprimer un contact
      public function deleteContact(Contact $contact): void {
          $contact->delete();
          $this->success(__('Contact deleted'));
      }
  
      // Méthode pour la mise à jour du statut traité/non traité
      public function toggleContact(Contact $contact, bool $status): void {
          $contact->handled = $status;
          $contact->save();
          $message = $status ? __('Contact marked as handled') : __('Contact marked as unhandled');
          $this->success($message);
      }
  
      // Méthode pour récupérer les données nécessaires à la vue
      public function with(): array {
          return [
              'headers' => $this->headers(),
              'contacts' => Contact::latest()->paginate(10),
              'row_decoration' => ['bg-yellow-500/25' => fn(Contact $contact) => !$contact->handled],
          ];
      }
  }; ?>
  
  <div>
      <x-header title="{{ __('Contacts') }}" separator progress-indicator>
          <x-slot:actions class="lg:hidden">
              <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
                  link="{{ route('admin') }}" />
          </x-slot:actions>
      </x-header>
      <x-card>
          <x-table :headers="$headers" :rows="$contacts" :row-decoration="$row_decoration">
              @scope('cell_created_at', $contact)
                  {{ $contact->created_at->isoFormat('LL') }} {{ __('at') }}
                  {{ $contact->created_at->isoFormat('HH:mm') }}
              @endscope
              @scope('actions', $contact)
                  <div class="flex">
                      @if ($contact->handled)
                          <x-popover>
                              <x-slot:trigger>
                                  <x-button icon="o-face-smile" wire:click="toggleContact({{ $contact->id }}, false)" spinner
                                      class="text-green-500 btn-ghost btn-sm" />
                              </x-slot:trigger>
                              <x-slot:content class="pop-small">
                                  @lang('Mark as unhandled')
                              </x-slot:content>
                          </x-popover>
                      @else
                          <x-popover>
                              <x-slot:trigger>
                                  <x-button icon="o-face-smile" wire:click="toggleContact({{ $contact->id }}, true)" spinner
                                      class="text-red-500 btn-ghost btn-sm" />
                              </x-slot:trigger>
                              <x-slot:content class="pop-small">
                                  @lang('Mark as handled')
                              </x-slot:content>
                          </x-popover>
                      @endif
                      <x-popover>
                          <x-slot:trigger>
                              <x-button icon="o-envelope"
                                  link="mailto:{{ $contact->email }}?subject={{ __('Contact') }}&body={{ $contact->message }}"
                                  no-wire-navigate spinner class="text-blue-500 btn-ghost btn-sm" />
                          </x-slot:trigger>
                          <x-slot:content class="pop-small">
                              @lang('Answer')
                          </x-slot:content>
                      </x-popover>
                      <x-popover>
                          <x-slot:trigger>
                              <x-button icon="o-trash" wire:click="deleteContact({{ $contact->id }})"
                                  wire:confirm="{{ __('Are you sure to delete this contact?') }}" spinner
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
  </div>
  ```

#### Traductions Index Contact <!-- markmap: fold -->

  ```json
  ...
  "Use this form to contact me": "Utilisez ce formulaire pour me contacter",
  "Contact to handle from ": "Contact à traiter de ",
  "Show the contacts": "Voir les contacts",
  "Handled": "Traité",
  "Contact marked as handled": "Contact marqué comme traité",
  "Contact marked as unhandled": "Contact marqué comme non traité",
  "Mark as unhandled": "Marquer comme non traité",
  "Contact unhandled": "Contact non traité",
  "Mark as handled": "Marquer comme traité",
  "Are you sure to delete this contact?": "Êtes-vous sûr de vouloir supprimer ce contact ?",
  "Contact deleted": "Contact supprimé",
  ```

## - Les Comptes (Users) <!-- markmap: fold -->

### Liste des comptes <!-- markmap: fold -->

#### Route Comptes <!-- markmap: fold -->

  ```php
  Route::middleware(IsAdmin::class)->group(function () {
      ...
      Volt::route('/users/index', 'admin.users.index')->name('users.index');
  });
```

#### Liens Comptes <!-- markmap: fold -->

* admin.sidebar :

  ```html
  @if (Auth::user()->isAdmin())
      ...
      <x-menu-item icon="s-user" title="{{ __('Accounts') }}" link="{{ route('users.index') }}" />
      ... (Pages)
  @endif
  ```

* admin.index (Pavé) :

  ```html
  @if (Auth::user()->isAdmin())
      ...
      <a href="{{ route('users.index') }}" class="flex-grow" title="{{ __('Users list') }}">
          <x-stat title="{{ __('Users') }}" value="{{ $users }}" icon="s-user" class="shadow-hover" />
      </a>
  @endif
  ```

* Traduction lien dans pavé :

  ```json
  "Users list":"Tous les utilisateurs"
  ```

#### Composant Comptes <!-- markmap: fold -->

##### Création composant Comptes <!-- markmap: fold -->

  ```php
  php artisan make:volt admin/users/index --class
  ```

##### Code Comptes <!-- markmap: fold -->

  ```php
  <?php
  use App\Models\User;
  use Mary\Traits\Toast;
  use Livewire\Volt\Component;
  use Livewire\WithPagination;
  use Livewire\Attributes\{Layout, Title};
  use Illuminate\Pagination\LengthAwarePaginator;
  
  new #[Title('Users'), Layout('components.layouts.admin')] class extends Component {
      use Toast;
      use WithPagination;
    
      public string $search = '';
      public array $sortBy  = ['column' => 'name', 'direction' => 'asc'];
      public string $role   = 'all';
      public array $roles   = [];
    
      public function deleteUser(User $user): void {
          $user->delete();
          $this->success($user->name . ' ' . __('deleted'));
      }
    
      // Définir les en-têtes de table.
      public function headers(): array {
          $headers = [
              ['key' => 'name',  'label' => __('Name')],
              ['key' => 'email', 'label' => 'E-mail'],
              ['key' => 'role',  'label' => __('Role')],
              ['key' => 'valid', 'label' => __('Valid')],
          ];
        
          if ('user' !== $this->role) {
              $headers = array_merge($headers, [
                  ['key' => 'posts_count', 'label' => __('Posts')],
              ]);
          }
        
          return array_merge($headers, [
              ['key' => 'comments_count', 'label' => __('Comments')],
              ['key' => 'created_at',     'label' => __('Registration')],
        ]);
      }
    
      public function users(): LengthAwarePaginator {
          $query = User::query()
              ->when($this->search, fn ($q) => $q
                  ->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%"))
              ->when('all' !== $this->role, fn ($q) => $q
                  ->where('role', $this->role))
              ->withCount('posts', 'comments')
              ->orderBy(...array_values($this->sortBy));
        
          $users = $query->paginate(10);
        
          $userCountsByRole = User::selectRaw('role, count(*) as total')
              ->groupBy('role')
              ->pluck('total', 'role');
        
          $totalUsers = $userCountsByRole->sum();
        
          $this->roles = collect([
              'all'   => __('All') . " ({$totalUsers})",
              'admin' => __('Administrators'),
              'redac' => __('Redactors'),
              'user'  => __('Users'),
          ])
          ->map(function ($roleName, $roleId) use ($userCountsByRole) {
              $count = $userCountsByRole->get($roleId, 0);
        
              return [
                  'name' => 'all' === $roleId ? $roleName : "{$roleName} ({$count})",
                  'id'   => $roleId,
              ];
          })
          ->values()
          ->all();
    
          return $users;
      }
    
          public function with(): array {
              return [
                  'users'   => $this->users(),
                  'headers' => $this->headers(),
          ];
      }
  }; ?>
  
  <div>
      <x-header separator progress-indicator>
          <x-slot:title>
              <a href="/admin/dashboard" title="{{ __('Back to Dashboard') }}">
                  {{ __('Users') }}
              </a>
          </x-slot:title>
          <x-slot:middle class="!justify-end">
              <x-input placeholder="{{ __('Search') }}..." wire:model.live.debounce="search" clearable
                  icon="o-magnifying-glass" />
          </x-slot:middle>
      </x-header>
  
  
      <x-radio inline :options="$roles" wire:model="role" wire:change="$refresh" />
      <br>
  
      <x-card>
  
          @if (count($users))
  
              <x-table striped :headers="$headers" :rows="$users" :sort-by="$sortBy" link="/admin/users/{id}/edit"
                  with-pagination>
                  @scope('cell_name', $user)
                      <x-avatar :image="Gravatar::get($user->email)">
                          <x-slot:title>
                              {{ $user->name }}
                          </x-slot:title>
                      </x-avatar>
                  @endscope
                  @scope('cell_valid', $user)
                      @if ($user->valid)
                          <x-icon name="o-check-circle" />
                      @endif
                  @endscope
                  @scope('cell_role', $user)
                      @if ($user->role === 'admin')
                          <x-badge value="{{ __('Administrator') }}" class="badge-error" />
                      @elseif($user->role === 'redac')
                          <x-badge value="{{ __('Redactor') }}" class="badge-warning" />
                      @elseif($user->role === 'user')
                          {{ __('User') }}
                      @endif
                  @endscope
                  @scope('cell_posts_count', $user)
                      @if ($user->posts_count > 0)
                          <x-badge value="{{ $user->posts_count }}" class="badge-primary" />
                      @endif
                  @endscope
                  @scope('cell_comments_count', $user)
                      @if ($user->comments_count > 0)
                          <x-badge value="{{ $user->comments_count }}" class="badge-success" />
                      @endif
                  @endscope
                  @scope('cell_created_at', $user)
                      {{ $user->created_at->isoFormat('LL') }}
                  @endscope
                  @scope('actions', $user)
                      <div class="flex">
                          <x-popover>
                              <x-slot:trigger>
                                  <x-button icon="o-envelope" link="mailto:{{ $user->email }}" no-wire-navigate spinner
                                      class="text-blue-500 btn-ghost btn-sm" />
                              </x-slot:trigger>
                              <x-slot:content class="pop-small">
                                  @lang('Send an email')
                              </x-slot:content>
                          </x-popover>
                          <x-popover>
                              <x-slot:trigger>
                                  <x-button icon="o-trash" wire:click="deleteUser({{ $user->id }})"
                                      wire:confirm="{{ __('Are you sure to delete this user?') }}"
                                      confirm-text="Are you sure?" spinner class="text-red-500 btn-ghost btn-sm" />
                              </x-slot:trigger>
                              <x-slot:content class="pop-small">
                                  @lang('Delete')
                              </x-slot:content>
                          </x-popover>
                      </div>
                  @endscope
              </x-table>
          @else
              <p>@lang('No users with these criteria').</p>
          @endif
  
      </x-card>
  </div>
  ```

##### Traductions Comptes <!-- markmap: fold -->

  ```json
  "Accounts": "Comptes",
  "No users with these criteria": "Aucun utilisateur avec ces critères",
  "All": "Tous",
  "Users list": "Liste des utilisateurs",
  "Administrators": "Administrateurs",
  "Redactors": "Rédacteurs",
  "Administrator": "Administrateur",
  "Redactor": "Rédacteur",
  "Role": "Rôle",
  "Valid": "Valide",
  "Valid user": "Utilisateur validé",
  "Send an email": "Envoyer un email",
  "Are you sure to delete this user?": "Êtes-vous sûr de vouloir supprimer cet utilisateur ?",
  "Registration": "Inscription",
  "Back to Dashboard": "Retour sur le Tableau de Bord"
  ```

### Modification de comptes <!-- markmap: fold -->

#### Route Modification Comptes <!-- markmap: fold -->

  ```php
  // Groupe middleware IsAdminOrRedac > IsAdmin
  Volt::route('/users/{user}/edit', 'admin.users.edit')->name('users.edit');
  ```

#### Lien Modification Comptes <!-- markmap: fold -->

  ```php
  // Déjà fait dans affichage de la liste (Composant Comptes) :
  // (<x-table striped :headers="$headers" :rows="$users" :sort-by="$sortBy" link="/admin/users/{id}/edit" with-pagination>)
  ```

#### Composant Modification Comptes <!-- markmap: fold -->

##### CLI Modification Comptes <!-- markmap: fold -->

  ```html
  php artisan make:volt admin/users/edit --class
  ```

##### Code Modification Comptes <!-- markmap: fold -->

  ```html
  <?php
  use App\Models\User;
  use Mary\Traits\Toast;
  use Livewire\Volt\Component;
  use Illuminate\Validation\Rule;
  use Livewire\Attributes\Layout;
  
  new #[Layout('components.layouts.admin')]
  class extends Component {
      use Toast;
    
      public User $user;
      public string $name  = '';
      public string $email = '';
      public string $role  = '';
      public bool $valid   = false;
      public bool $isStudent;
    
      public function mount(User $user): void {
          $this->user = $user;
          $this->fill($this->user);
      }
    
      public function save() {
          $data = $this->validate([
              'name'  => ['required', 'string', 'max:255'],
              'email' => ['required', 'email', Rule::unique('users')->ignore($this->user->id)],
              'role'  => ['required', Rule::in(['admin', 'redac', 'user'])],
              'valid' => ['required', 'boolean'],
          ]);
    
          $this->user->update($data);
        
          $this->success(__('User edited with success.'), redirectTo: '/admin/users/index');
      }
    
      public function with(): array {
          return [
              'roles' => [
                  ['name' => __('Administrator'), 'id' => 'admin'],
                  ['name' => __('Redactor'), 'id' => 'redac'],
                  ['name' => __('User'), 'id' => 'user'],
              ],
          ];
      }
  }; ?>
  
  <div>
    <x-header title="{{ __('Edit an account') }}" separator progress-indicator>
      <x-slot:actions>
        <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
          link="{{ route('admin') }}" />
      </x-slot:actions>
    </x-header>
    <x-card>
      <x-form wire:submit="save">
        <x-input label="{{ __('Name') }}" wire:model="name" icon="o-user" inline />
        <x-input label="{{ __('E-mail') }}" wire:model="email" icon="o-envelope" inline />
        <br>
        <x-radio label="{{ __('User role') }}" inline label="{{ __('Select a role') }}" :options="$roles"
          wire:model="role" />
        <br>
        <x-toggle label="{{ __('Valid user') }}" inline wire:model="valid" />
        <x-slot:actions>
          <div class="text-right">
            <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
          </div>
        </x-slot:actions>
      </x-form>
    </x-card>
  </div>
  ```

##### Traductions Modification Comptes <!-- markmap: fold -->

  ```json
  "Edit an account": "Modifier un compte",
  "Select a role": "Sélectionnez un rôle",
  "User edited with success.": "Utilisateur mis à jour avec succès."
  ```

### Réf.: ***<a href="https://laravel.sillo.org/posts/mon-cms-les-comptes" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-les-comptes</a>***

## - Les Commentaires <!-- markmap: fold -->

### Liste admin.comments <!-- markmap: fold -->

#### Route admin.comments.index <!-- markmap: fold -->

```php
Route::middleware('auth')->group(function () {
    ...
    Route::middleware(IsAdminOrRedac::class)->prefix('admin')->group(function () {
        ...
        Volt::route('/comments/index', 'admin.comments.index')->name('comments.index');
    })
})
```

#### Liens comments dans admin.sidebars <!-- markmap: fold -->

  ```html
    ...(Posts) 
    <x-menu-item icon="c-chat-bubble-left" title="{{ __('Comments') }}" link="{{ route('comments.index') }}" />
  ```

#### Composant admin.comment <!-- markmap: fold -->

  ```php
  php artisan make:volt admin/comments/index --class
  ```

  ```html
  <?php
  use Mary\Traits\Toast;
  use App\Models\Comment;
  use Livewire\Volt\Component;
  use Livewire\WithPagination;
  use Livewire\Attributes\{Layout, Title};
  use Illuminate\Pagination\LengthAwarePaginator;
  
  new #[Title('Comments'), Layout('components.layouts.admin')] 
  class extends Component {
      use Toast, WithPagination;
  
      public string $search = '';
      public array $sortBy = ['column' => 'created_at', 'direction' => 'desc'];
      public $role = 'all';
  
      public function deleteComment(Comment $comment): void {
          $comment->delete();
          $this->success(__('Comment deleted'));
      }
  
      public function validComment(Comment $comment): void {
          $comment->user->valid = true;
          $comment->user->save();
  
          $this->success(__('Comment validated'));
      }
  
      public function headers(): array {
          return [['key' => 'user_name', 'label' => __('Author')], ['key' => 'body', 'label' => __('Comment'), 'sortable' => false], ['key' => 'post_title', 'label' => __('Post')], ['key' => 'created_at', 'label' => __('Sent on')]];
      }
  
      public function comments(): LengthAwarePaginator {
          return Comment::query()
              ->when($this->search, fn($q) => $q->where('body', 'like', "%{$this->search}%"))
              ->when('post_title' === $this->sortBy['column'], fn($q) => $q->join('posts', 'comments.post_id', '=', 'posts.id')->orderBy('posts.title', $this->sortBy['direction']), fn($q) => $q->orderBy($this->sortBy['column'], $this->sortBy['direction']))
              ->when(Auth::user()->isRedac(), fn($q) => $q->whereRelation('post', 'user_id', Auth::id()))
              ->with([
                  'user:id,name,email,valid',
                  'post:id,title,slug,user_id',
              ])
              ->withAggregate('user', 'name')
              ->paginate(10);
      }
  
      public function with(): array {
          return [
              'headers'  => $this->headers(),
              'comments' => $this->comments(),
          ];
      }
  }; ?>
  
  <div>
      <x-header title="{{ __('Comments') }}" separator progress-indicator>
          <x-slot:actions>
              <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                  link="{{ route('admin') }}" />
              <x-input placeholder="{{ __('Search') }}..." wire:model.live.debounce="search" clearable
                  icon="o-magnifying-glass" />
          </x-slot:actions>
      </x-header>
      <x-card>
          <x-table striped :headers="$headers" :rows="$comments" link="/admin/comments/{id}/edit" :sort-by="$sortBy"
              with-pagination>
              @scope('cell_created_at', $comment)
                  {{ $comment->created_at->isoFormat('LL') }} {{ __('at') }}
                  {{ $comment->created_at->isoFormat('HH:mm') }}
              @endscope
              @scope('cell_body', $comment)
                  {!! nl2br($comment->body) !!}
              @endscope
              @scope('cell_user_name', $comment)
                  <x-avatar :image="Gravatar::get($comment->user->email)">
                      <x-slot:title>
                          {{ $comment->user->name }}
                      </x-slot:title>
                  </x-avatar>
              @endscope
              @scope('cell_post_title', $comment)
                  {{ $comment->post->title }}
              @endscope
              @scope('actions', $comment)
                  <div class="flex">
                      @if (!$comment->user->valid)
                          <x-popover>
                              <x-slot:trigger>
                                  <x-button icon="c-eye" wire:click="validComment({{ $comment->id }})"
                                      wire:confirm="{{ __('Are you sure to validate this user for comment?') }}" spinner
                                      class="text-yellow-500 btn-ghost btn-sm" />
                              </x-slot:trigger>
                              <x-slot:content class="pop-small">
                                  @lang('Validate the user')
                              </x-slot:content>
                          </x-popover>
                      @endif
                      <x-popover>
                          <x-slot:trigger>
                              <x-button icon="s-document-text" link="{{ route('posts.show', $comment->post->slug) }}" spinner
                                  class="btn-ghost btn-sm" />
                          </x-slot:trigger>
                          <x-slot:content class="pop-small">
                              @lang('Show post')
                          </x-slot:content>
                      </x-popover>
                      <x-popover>
                          <x-slot:trigger>
                              <x-button icon="o-trash" wire:click="deleteComment({{ $comment->id }})"
                                  wire:confirm="{{ __('Are you sure to delete this comment?') }}" spinner
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
  </div>
  ```

  ```json
  "Comment validated": "Commentaire validé",
  "Comment deleted": "Commentaire supprimé",
  "Sent on": "Envoyé le",
  "Post": "Article",
  "Are you sure to validate this user for comment?": "Êtes-vous sûr de vouloir valider cet utilisateur pour les commentaires ?",
  "Validate the user": "Valider l'utilisateur"
  ```

### Modifier admin.comments <!-- markmap: fold -->

#### Route admin.comments.edit <!-- markmap: fold -->

  ```php
  Route::middleware('auth')->group(function () {
      ...
      Route::middleware(IsAdminOrRedac::class)->prefix('admin')->group(function () {
          ...
          Volt::route('/comments/{comment}/edit', 'admin.comments.edit')->name('comments.edit');
      })
  })
```

#### Liens modif. admin. Comment <!-- markmap: fold -->

* Pour pavé Commentaires de Dashboard :

  ```html
  <a href="{{ route('comments.index') }}" class="flex-grow" title="{{  __('All comments') }}">
      <x-stat title="{{ __('Comments') }}" value="{{ $commentsNumber }}" icon="c-chat-bubble-left" class="shadow-hover" />
  </a>
  ```

* Dans la liste des commentaires récents :

  ```html
  <x-popover>
      <x-slot:trigger>
          <x-button icon="c-eye" link="{{ route('comments.edit', $comment->id) }}" spinner class="btn-ghost btn-sm" />                       
      </x-slot:trigger>
      <x-slot:content class="pop-small">
          @lang('Edit or answer')
      </x-slot:content>
  </x-popover>
  ```

* Affichage explicite d'une alerte de commentaires à valider :
    (Issu(s) d'users non validés)

  ```html
  ...
  @foreach ($comments as $comment)
      @if (!$comment->user->valid)
          <x-alert title="{!! __('Comment to valid from ') . $comment->user->name !!}" description="{!! $comment->body !!}" icon="c-chat-bubble-left"
              class="shadow-md alert-warning">
              <x-slot:actions>
                  <x-button link="{{ route('comments.index') }}" label="{!! __('Show this comment') !!}" />
              </x-slot:actions>
          </x-alert>
          <br>
      @endif
  @endforeach
  ... Bloc 'Recent posts'
  ```

#### Pré-requis <!-- markmap: fold -->

* Models/Comment - Ajout de :

  ```php
  public function getDepth(): int {
      return $this->parent ? $this->parent->getDepth() + 1 : 0;
  }
  ```

* Fichier ./config/**tinymce.php** :

  ```php
  return [
      'config' => [
          ...
      ],
      'config_comment' => [
          'language'       => env('APP_TINYMCE_LOCALE', 'en_US'),
          'plugins'        => 'codesample',
          'toolbar'        => 'undo redo | styles | copy cut paste pastetext | hr | codesample',
          'toolbar_sticky' => true,
          'min_height'     => 300,
          'license_key'    => 'gpl',
      ],
  ];
  ```

#### Composant admin.comments.edit <!-- markmap: fold -->

* Création composant admin des commentaires :

  ```bash
  php artisan make:volt admin/comments/edit --class
  ```

* Code composant admin. des modifs. :

  ```html
  <?php
  use Mary\Traits\Toast;
  use App\Models\Comment;
  use Livewire\Volt\Component;
  use Livewire\Attributes\{Layout, Title};
  
  new #[Title('Edit Comment'), Layout('components.layouts.admin')] 
  class extends Component {
      use Toast;
    
      public Comment $comment;
      public string $body        = '';
      public string $body_answer = '';
      public int $depth          = 0;
    
      public function mount(Comment $comment): void {
          $this->authorizeCommentAccess($comment);
    
          $this->comment = $comment;
          $this->fill($this->comment->toArray());
          $this->depth = $this->comment->getDepth();
      }
    
      public function save() {
          $data = $this->validate([
              'body' => 'required|max:10000',
          ]);
    
          $this->comment->update($data);
    
          $this->success(__('Comment edited with success.'), redirectTo: '/admin/comments/index');
      }
    
      public function saveAnswer() {
          $data = $this->validate([
              'body_answer' => 'required|max:10000',
          ]);
    
          $data['body']      = $data['body_answer'];
          $data['user_id']   = Auth::id();
          $data['parent_id'] = $this->comment->id;
          $data['post_id']   = $this->comment->post_id;
    
          Comment::create($data);
    
          $this->success(__('Answer created with success.'), redirectTo: '/admin/comments/index');
      }
    
      private function authorizeCommentAccess(Comment $comment): void {
          if (auth()->user()->isRedac() && $comment->post->user_id !== auth()->id()) {
            abort(403);
        }
      }
  }; ?>
  
  <div>
      <x-header title="{{ __('Edit a comment') }}" separator progress-indicator>
          <x-slot:actions class="lg:hidden">
              <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
                  link="{{ route('admin') }}" />
          </x-slot:actions>
      </x-header>
      <x-card>
          <x-form wire:submit="save">
              <x-textarea wire:model="body" label="{{ __('Content') }}" hint="{{ __('Max 10000 chars') }}" rows="5"
                  inline />
              <x-slot:actions>
                  <x-button label="{{ __('Cancel') }}" icon="o-hand-thumb-down" class="btn-outline"
                      link="/admin/comments/index" />
                  <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                      class="btn-primary" />
              </x-slot:actions>
          </x-form>
  
          @if ($depth < 3)
              <x-card title="{{ __('Your answer') }}" shadow separator progress-indicator>
                  <x-form wire:submit="saveAnswer">
                      <x-editor wire:model="body_answer" label="{{ __('Content') }}" :config="config('tinymce.config_comment')" folder="photos" />
                      <x-slot:actions>
                          <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                              class="btn-primary" />
                      </x-slot:actions>
                  </x-form>
              </x-card>
          @endif
      </x-card>
  </div>
  ```

* Traductions admin. modif. des commentaires :

  ```json
  "Edit a comment": "Modifier un commentaire",
  "Your answer": "Votre réponse",
  "Comment edited with success.": "Commentaire mis à jour avec succès.",
  "Answer created with success.": "Réponse ajoutée avec succès."
  ```

### Réf.: ***<a href="https://laravel.sillo.org/posts/mon-cms-les-commentaires" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-les-commentaires</a>***

## - Les Menus <!-- markmap: fold -->

### Liste des Menus & Submenus <!-- markmap: fold -->

#### Route admin.menus.index <!-- markmap: fold -->

  ```php
  Route::middleware('auth')->group(function () {
    ...
    Route::middleware(IsAdminOrRedac::class)->prefix('admin')->group(function () {
      ...
      Route::middleware(IsAdmin::class)->group(function () {
        ...
        Volt::route('/menus/index', 'admin.menus.index')->name('menus.index');
      });
    });
  });
  ```

#### Lien Menus dans admin.sidebar <!-- markmap: fold -->

  ```html
  ... (Pages))
    <x-menu-sub title="{{ __('Menus') }}" icon="m-list-bullet">
      <x-menu-item title="{{ __('Navbar') }}" link="{{ route('menus.index') }}" />
    </x-menu-sub>
  @endif
  ```

  ```json
  "Navbar": "Navigation"
  ```

#### Trait ManageMenus (Menus & submenus) <!-- markmap: fold -->

* Créer un trait ./app/Traits/**ManageMenus.php** :

  ```html
  <?php
  namespace App\Traits;
  
  use Illuminate\Support\Collection;
  use App\Models\{Category, Page, Post};
  
  trait ManageMenus {
    public ?int $post_id = null;
    public Collection $postsSearchable;

    public function search(string $value = ''): void {
      $selectedOption = Post::select('id', 'title')->where('id', $this->post_id)->get();

      $this->postsSearchable = Post::query()
        ->select('id', 'title')
        ->where('title', 'like', "%{$value}%")
        ->orderBy('title')
        ->take(5)
        ->get()
        ->merge($selectedOption);
    }

    public function changeSelection($value): void {
      $this->updateSubProperties(['model' => Post::class, 'route' => 'posts.show'], $value);
    }

    public function updating($property, $value): void {
      if ('' === $value) {
        return;
      }

      $modelMap = [
        'subPage'     => ['model' => Page::class, 'route' => 'pages.show'],
        'subCategory' => ['model' => Category::class, 'route' => 'category'],
      ];

      if (array_key_exists($property, $modelMap)) {
        $this->updateSubProperties($modelMap[$property], $value);
      } elseif ('subOption' === $property) {
        $this->resetSubProperties();
        $this->search();
      }
    }

    public function with(): array {
      return [
        'pages'      => Page::select('id', 'title', 'slug')->get(),
        'categories' => Category::all(),
        'subOptions' => [['id' => 1, 'name' => __('Post')], ['id' => 2, 'name' => __('Page')], ['id' => 3, 'name' => __('Category')]],
      ];
    }

    private function updateSubProperties($modelInfo, $value): void {
      $model = $modelInfo['model']::find($value);
      if ($model) {
        $this->sublabel = $model->title;
        $this->sublink  = 'posts.show' === $modelInfo['route'] || 'pages.show' === $modelInfo['route']
          ? route($modelInfo['route'], $model->slug)
          : url($modelInfo['route'] . '/' . $model->slug);
      }
    }

    private function resetSubProperties(): void {
      $this->sublabel    = '';
      $this->sublink     = '';
      $this->subPost     = 0;
      $this->subPage     = 0;
      $this->subCategory = 0;
      $this->subOption   = 4;  
    }
  }

  ```

#### Formulaire submenus (Création & Modification) <!-- markmap: fold -->

* Créer admin.menus.**submenu-form.blade.php** :

  ```html
  <x-form wire:submit="saveSubmenu({{ $menu->id ?? 'null' }})">
    <x-radio :options="$subOptions" wire:model="subOption" wire:change="$refresh" />
    @if ($subOption == 1)
      <x-choices label="{{ __('Post') }}" wire:model="subPost" :options="$postsSearchable" option-label="title"
        hint="{{ __('Select a post, type to search') }}" debounce="300ms" min-chars="2"
        no-result-text="{{ __('No result found!') }}" single searchable @change-selection="$wire.changeSelection($event.detail.value)" />
    @elseif($subOption == 2)
      <x-select label="{{ __('Page') }}" option-label="title" :options="$pages"
        placeholder="{{ __('Select a page') }}" wire:model="subPage"
        wire:change="$refresh" />
    @elseif($subOption == 3)
      <x-select label="{{ __('Category') }}" option-label="title" :options="$categories"
        placeholder="{{ __('Select a category') }}" wire:model="subCategory"
        wire:change="$refresh" />
    @endif
    <x-input label="{{ __('Title') }}" wire:model="sublabel" />
    <x-input type="text" wire:model="sublink" label="{{ __('Link') }}" />
    <x-slot:actions>
    <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save"
      type="submit" class="btn-primary" />
    </x-slot:actions>
  </x-form>
  ```

#### Composant Liste des Menus (admin.menus.index) <!-- markmap: fold -->

##### Création admin.menus.index <!-- markmap: fold -->

  ```bash
  php artisan make:volt admin/menus/index --class
  ```

##### Code admin.menus.index <!-- markmap: fold -->

  ```html
  <?php
  use Mary\Traits\Toast;
  use App\Traits\ManageMenus;
  use Livewire\Volt\Component;
  use App\Models\{Menu, Submenu};
  use Illuminate\Support\Collection;
  use Livewire\Attributes\{Layout, Title, Validate};
  use Illuminate\Contracts\Database\Eloquent\Builder;
  
  new #[Title('Nav Menu'), Layout('components.layouts.admin')]
  class extends Component {
    use Toast;
    use ManageMenus;
    
    public Collection $menus;
    
    #[Validate('required|max:255|unique:menus,label')]
    public string $label = '';
    
    #[Validate('nullable|regex:/\/([a-z0-9_-]\/*)*[a-z0-9_-]*/')]
    public string $link = '';
    
    public string $sublabel = '';
    public string $sublink  = '';
    public int $subPost     = 0;
    public int $subPage     = 0;
    public int $subCategory = 0;
    public int $subOption   = 4;
    
    // Méthode appelée lors de l'initialisation du composant.
    public function mount(): void {
      $this->getMenus();
      $this->search();
    }
    
    // Récupérer les menus avec leurs sous-menus triés par ordre.
    public function getMenus(): void {
      $this->menus = Menu::with([
        'submenus' => function (Builder $query) {
          $query->orderBy('order');
        },
      ])
        ->orderBy('order')
        ->get();
    }
    
    public function up(Menu $menu): void {
      $this->move($menu, 'up');
    }
    
    public function upSub(Submenu $submenu): void {
    $this->move($submenu, 'up', true);
    }
    
    public function down(Menu $menu): void {
      $this->move($menu, 'down');
    }
    
    public function downSub(Submenu $submenu): void {
      $this->move($submenu, 'down', true);
    }
    
    public function deleteMenu(Menu $menu): void {
      $this->deleteItem($menu);
    }
    
    public function deleteSubmenu(Menu $menu, Submenu $submenu): void {
      $this->deleteItem($submenu, $menu);
    }
    
    // Enregistrer un nouveau menu.
    public function saveMenu(): void {
      $data          = $this->validate();
      $data['order'] = $this->menus->count() + 1;
      Menu::create($data);
  
      $this->success(__('Menu created with success.'), redirectTo: '/admin/menus/index');
    }
    
    // Enregistrer un nouveau sous-menu.
    public function saveSubmenu(Menu $menu): void {
      $data = $this->validate([
        'sublabel' => ['required', 'string', 'max:255'],
        'sublink'  => 'required|regex:/\/([a-z0-9_-]\/*)*[a-z0-9_-]*/',
      ]);
  
      $data['order'] = $menu->submenus->count() + 1;
      $data['label'] = $this->sublabel;
      $data['link']  = $this->sublink;
  
      $menu->submenus()->save(new Submenu($data));
  
      $this->sublabel = '';
      $this->sublink  = '';
  
      $this->success(__('Submenu created with success.'));
    }
    
    // Méthode générique pour déplacer un élément (menu ou sous-menu)
    private function move($item, $direction, $isSubmenu = false): void {
      $operator       = 'up' === $direction ? '<' : '>';
      $orderDirection = 'up' === $direction ? 'desc' : 'asc';
  
      $query = $isSubmenu ? Submenu::where('menu_id', $item->menu_id) : Menu::query();
  
      $adjacentItem = $query
        ->where('order', $operator, $item->order)
        ->orderBy('order', $orderDirection)
        ->first();
  
      if ($adjacentItem) {
        $this->swap($item, $adjacentItem);
      }
    }
    
    private function swap($item1, $item2): void {
      $tempOrder    = $item1->order;
      $item1->order = $item2->order;
      $item2->order = $tempOrder;
  
      $item1->save();
      $item2->save();
  
      $this->getMenus();
    }
    
    // Méthode générique pour supprimer un élément (menu ou sous-menu)
    private function deleteItem($item, $parent = null): void {
      $isSubmenu = null !== $parent;
  
      $item->delete();
  
      if ($isSubmenu) {
        $this->reorderItems($parent->submenus());
      } else {
        $this->reorderItems(Menu::query());
      }
  
      $this->getMenus();
      $this->success(__($isSubmenu ? 'Submenu' : 'Menu') . __(' deleted with success.'));
    }
    
    // Méthode générique pour réordonner les éléments
    private function reorderItems($query): void {
      $items = $query->orderBy('order')->get();
      foreach ($items as $index => $item) {
        $item->order = $index + 1;
        $item->save();
      }
    }
  };?>
  
  <div>
    <x-header title="{{ __('Navigation') }}" separator progress-indicator>
      <x-slot:actions class="lg:hidden">
        <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
          link="{{ route('admin') }}" />
      </x-slot:actions>
    </x-header>
    <x-card>
      @foreach ($menus as $menu)
      <x-list-item :item="$menu" no-separator no-hover>
        <x-slot:value>
          {{ $menu->label }}
        </x-slot:value>
        <x-slot:sub-value>
          @if ($menu->link)
          {{ $menu->link }}
          @else
          @lang('Root menu')
          @endif
        </x-slot:sub-value>
        <x-slot:actions>
          @if ($menu->order > 1)
          <x-popover>
            <x-slot:trigger>
              <x-button icon="s-chevron-up" wire:click="up({{ $menu->id }})" spinner />
            </x-slot:trigger>
            <x-slot:content class="pop-small">
              @lang('Up')
            </x-slot:content>
          </x-popover>
          @endif
          @if ($menu->order < $menus->count())
            <x-popover>
              <x-slot:trigger>
                <x-button icon="s-chevron-down" wire:click="down({{ $menu->id }})" spinner />
              </x-slot:trigger>
              <x-slot:content class="pop-small">
                @lang('Down')
              </x-slot:content>
            </x-popover>
            @endif
            <x-popover>
              <x-slot:trigger>
                <x-button icon="c-arrow-path-rounded-square" link="#" class="text-blue-500 btn-ghost btn-sm" spinner />
              </x-slot:trigger>
              <x-slot:content class="pop-small">
                @lang('Edit')
              </x-slot:content>
            </x-popover>
            <x-popover>
              <x-slot:trigger>
                <x-button icon="o-trash" wire:click="deleteMenu({{ $menu->id }})"
                  wire:confirm="{{ __('Are you sure to delete this menu?') }}" spinner
                  class="text-red-500 btn-ghost btn-sm" />
              </x-slot:trigger>
              <x-slot:content class="pop-small">
                @lang('Delete')
              </x-slot:content>
            </x-popover>
        </x-slot:actions>
      </x-list-item>
  
      <x-collapse collapse-plus-minus no-icon class="ml-8">
        <x-slot:heading>
          <x-icon name="o-chevron-down" /><span class="pl-2 text-sm">{{ __('Submenus') }}</span>
        </x-slot:heading>
        <x-slot:content>
          @foreach ($menu->submenus as $submenu)
          <x-list-item :item="$menu" no-separator no-hover>
            <x-slot:value>
              {{ $submenu->label }}
            </x-slot:value>
            <x-slot:sub-value>
              {{ $submenu->link }}
            </x-slot:sub-value>
            <x-slot:actions>
              @if ($submenu->order > 1)
              <x-popover>
                <x-slot:trigger>
                  <x-button icon="s-chevron-up" wire:click="upSub({{ $submenu->id }})" spinner />
                </x-slot:trigger>
                <x-slot:content class="pop-small">
                  @lang('Up')
                </x-slot:content>
              </x-popover>
              @endif
              @if ($submenu->order < $menu->submenus->count())
                <x-popover>
                  <x-slot:trigger>
                    <x-button icon="s-chevron-down" wire:click="downSub({{ $submenu->id }})" spinner />
                  </x-slot:trigger>
                  <x-slot:content class="pop-small">
                    @lang('Down')
                  </x-slot:content>
                </x-popover>
                @endif
                <x-popover>
                  <x-slot:trigger>
                    <x-button icon="c-arrow-path-rounded-square" link="#" class="text-blue-500 btn-ghost btn-sm"
                      spinner />
                  </x-slot:trigger>
                  <x-slot:content class="pop-small">
                    @lang('Edit')
                  </x-slot:content>
                </x-popover>
                <x-popover>
                  <x-slot:trigger>
                    <x-button icon="o-trash" wire:click="deleteSubmenu({{ $menu->id }}, {{ $submenu->id }})"
                      wire:confirm="{{ __('Are you sure to delete this menu?') }}" spinner
                      class="text-red-500 btn-ghost btn-sm" />
                  </x-slot:trigger>
                  <x-slot:content class="pop-small">
                    @lang('Delete')
                  </x-slot:content>
                </x-popover>
            </x-slot:actions>
          </x-list-item>
          @endforeach
  
          <br>
  
          <x-card class="" title="{{ __('Create a new submenu') }}">
            @include('livewire.admin.menus.submenu-form')
          </x-card>
  
        </x-slot:content>
      </x-collapse>
      @endforeach
  
    </x-card>
  
    <br>
  
    <x-card class="" title="{{ __('Create a new menu') }}">
  
      <x-form wire:submit="saveMenu">
        <x-input label="{{ __('Title') }}" wire:model="label" />
        <x-input type="text" wire:model="link" label="{{ __('Link') }}" />
        <x-slot:actions>
          <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
        </x-slot:actions>
      </x-form>
  
    </x-card>
  </div>
  ```

##### Traductions Liste Menus <!-- markmap: fold -->

* N.B.: *"Edit" existe déjà, mais est remplacé ici*

  ```json
  "Submenus": "Sous-menus",
  "Edit a submenu": "Modifier un sous-menu",
  "Create a new menu": "Créer un nouveau menu",
  "Are you sure to delete this menu?": "Êtes-vous sûr de vouloir supprimer ce menu ?",
  "Menu created with success.": "Menu ajouté avec succès.",
  "Menu updated with success.": "Menu mis à jour avec succès.",
  "Edit a menu": "Modifier un menu",
  "Create a new submenu": "Créer un nouveau sous-menu",
  "Submenu created with success.": "Sous-menu créé avec succès.",
  "Other": "Autre",
  "Are you sure to delete this submenu?": "Êtes-vous sûr de vouloir supprimer ce sous-menu ?",
  " deleted with success.": " supprimé avec succès.",
  "Select a page": "Sélectionner une page",
  "Root menu": "Menu racine",
  "Submenu": "Sous-menu",
  "sublink": "Lien",
  "sublabel": "Titre",
  "Edit": "Modifier",
  "Link": "Lien",
  "Select a post, type to search": "Sélectionnez un article, tapez pour rechercher"
  ```

  <br>
* Ajouter aussi dans lang/fr/**validation.php**, dans le tableau: 'attributes'  => [...] :

  ```json
    "label"    => "Titre",
    "sublabel" => "Titre",
    "lien"     => "Lien",
    "sublink"  => "Lien",
  ```

### Réf.: ***<a href="https://laravel.sillo.org/posts/mon-cms-les-menus-partie-1" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-les-menus-partie-1</a>***

### Modification d'un menu <!-- markmap: fold -->

#### Route admin.menus.edit <!-- markmap: fold -->

  ```php
  Route::middleware('auth')->group(function () {
    ...
    Route::middleware(IsAdminOrRedac::class)->prefix('admin')->group(function () {
      ...
      Route::middleware(IsAdmin::class)->group(function () {
        ...
        Volt::route('/menus/{menu}/edit', 'admin.menus.edit')->name('menus.edit');
      });
    });
  });
```

#### Lien Modification de Menus dans la liste (admin.menus.index) <!-- markmap: fold -->

  ```html
  @if ($menu->order < $menus->count())
    <x-popover>
      ...
    </x-popover>
  @endif
  <x-popover>
    <x-slot:trigger>
      <x-button icon="c-arrow-path-rounded-square" link="{{ route('menus.edit', $menu->id) }}"
      class="text-blue-500 btn-ghost btn-sm" spinner />
    ...
  ```

#### Composant modification d'un menu (admin.menus.edit) <!-- markmap: fold -->

##### Création admin.menus.edit <!-- markmap: fold -->

  ```bash
  php artisan make:volt admin/menus/edit --class
  ```

##### Code admin.menus.edit <!-- markmap: fold -->

  ```html
  <?php
  use App\Models\Menu;
  use Mary\Traits\Toast;
  use Livewire\Volt\Component;
  use Illuminate\Validation\Rule;
  use Livewire\Attributes\{Layout, Title};
  
  new #[Title('Edit menu'), Layout('components.layouts.admin')]
  class extends Component {
    use Toast;

    public Menu $menu;
    public string $label = '';
    public ?string $link = null;

    public function mount(Menu $menu): void {
      $this->menu = $menu;
      $this->fill($this->menu);
    }

    public function save(): void {
      $data = $this->validate([
        'label' => ['required', 'string', 'max:255', Rule::unique('menus')->ignore($this->menu->id)],
        'link' => 'nullable|regex:/\/([a-z0-9_-]\/*)*[a-z0-9_-]*/',
      ]);
  
      $this->menu->update($data);
  
      $this->success(__('Menu updated with success.'), redirectTo: '/admin/menus/index');
    }
  }; ?>
  
  <div>
    <x-header title="{{ __('Edit a menu') }}" separator progress-indicator>
      <x-slot:actions class="lg:hidden">
        <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
          link="{{ route('admin') }}" />
      </x-slot:actions>
    </x-header>
    <x-card>
      <x-form wire:submit="save">
          <x-input label="{{ __('Title') }}" wire:model="label" />
          <x-input type="text" wire:model="link" label="{{ __('Link') }}" />
          <x-slot:actions>
            <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
              class="btn-primary" />
          </x-slot:actions>
      </x-form>
    </x-card>
  </div>
  ```

### Modification d'un submenu <!-- markmap: fold -->

#### Route admin.menus.editsub <!-- markmap: fold -->

  ```php
  Volt::route('/submenus/{submenu}/edit', 'admin.menus.editsub')->name('submenus.edit');
  ```

#### Lien Modification d'un submenu dans la liste (admin.menus.index) <!-- markmap: fold -->

  ```html
  @if ($submenu->order < $menu->submenus->count())
    <x-popover>
      ...
    </x-popover>
  @endif
  <x-popover>
    <x-slot:trigger>
      <x-button icon="c-arrow-path-rounded-square" link="{{ route('submenus.edit', $submenu->id) }}"...(À la place du '#')
    ...
  ```

#### Composant modification d'un sous-menu (admin.menus.editsub) <!-- markmap: fold -->

##### Création admin.menus.editsub <!-- markmap: fold -->

  ```bash
  php artisan make:volt admin/menus/editsub --class
  ```

##### Code admin.menus.editsub <!-- markmap: fold -->

  ```html
  <?php
  use Mary\Traits\Toast;
  use App\Models\Submenu;
  use App\Traits\ManageMenus;
  use Livewire\Volt\Component;
  use Livewire\Attributes\{Layout, Title};
  
  new #[Title('Edit Submenu'), Layout('components.layouts.admin')] class extends Component {
    use Toast, ManageMenus;

    public Submenu $submenu;
    public string $sublabel = '';
    public string $sublink  = '';
    public int $subPost     = 0;
    public int $subPage     = 0;
    public int $subCategory = 0;
    public int $subOption   = 1;

    public function mount(Submenu $submenu): void {
      $this->submenu  = $submenu;
      $this->sublabel = $submenu->label;
      $this->sublink  = $submenu->link;
      $this->search();
    }

    public function saveSubmenu($menu = null): void {
      $data = $this->validate([
        'sublabel' => ['required', 'string', 'max:255'],
        'sublink'  => 'required|regex:/\/([a-z0-9_-]\/*)*[a-z0-9_-]*/',
      ]);
  
      $this->submenu->update([
        'label' => $data['sublabel'],
        'link'  => $data['sublink'],
      ]);
  
      $this->success(__('Menu updated with success.'), redirectTo: '/admin/menus/index');
    }
  }; ?>
  
  <div>
    <x-header title="{{ __('Edit a submenu') }}" separator progress-indicator>
      <x-slot:actions class="lg:hidden">
        <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
          link="{{ route('admin') }}" />
      </x-slot:actions>
    </x-header>
    <x-card>
      @include('livewire.admin.menus.submenu-form')
    </x-card>
  </div>
  ```

### Le menu du footer <!-- markmap: fold -->

#### Route admin.menus.footers

  ```php
  Volt::route('/footers/index', 'admin.menus.footers')->name('menus.footers');
  ```

#### Lien du menu du footer dans la sidebar (admin.sidebar)

  ```html
  @if (Auth::user()->isAdmin())
    ...
    <x-menu-sub title="{{ __('Menus') }}" icon="m-list-bullet">
      ...
      <x-menu-item title="{{ __('Footer') }}" link="{{ route('menus.footers') }}" />
  ```

  ```json
  "Footer": "Pied de page"
  ```

#### Composant menu du footer (admin.menus.footers)

##### Création admin.menus.footers <!-- markmap: fold -->

  ```bash
  php artisan make:volt admin/menus/footers --class
  ```

##### Code admin.menus.footers <!-- markmap: fold -->

  ```html
  <?php
  use Mary\Traits\Toast;
  use App\Models\{Footer};
  use Livewire\Volt\Component;
  use Illuminate\Support\Collection;
  use Livewire\Attributes\{Layout, Validate, Title};
  
  new #[Title('Footer Menu'), Layout('components.layouts.admin')]
  class extends Component {
    use Toast;
    
    public Collection $footers;
    
    #[Validate('required|max:255|unique:footers,label')]
    public string $label = '';
    
    #[Validate('nullable|regex:/\/([a-z0-9_-]\/*)*[a-z0-9_-]*/')]
    public string $link = '';
    
    public function mount(): void {
      $this->getFooters();
    }
    
    public function getFooters(): void {
      $this->footers = Footer::orderBy('order')->get();
    }
    
    public function up(Footer $footer): void {
      $previousFooter = Footer::where('order', '<', $footer->order)
        ->orderBy('order', 'desc')
        ->first();
  
      $this->swap($footer, $previousFooter);
    }
    
    public function down(Footer $footer): void {
      $previousFooter = Footer::where('order', '>', $footer->order)
        ->orderBy('order', 'asc')
        ->first();
  
      $this->swap($footer, $previousFooter);
    }
    
    public function deleteFooter(Footer $footer): void {
      $footer->delete();
      $this->reorderFooters();
      $this->getFooters();
      $this->success(__('Footer deleted with success.'));
    }
    
    public function saveFooter(): void {
      $data          = $this->validate();
      $data['order'] = $this->footers->count() + 1;
      $newFooter     = Footer::create($data);
      $this->footers->push($newFooter);
      $this->success(__('Footer created with success.'));
    }
    
    private function swap(Footer $footer, Footer $previousFooter): void {
      $tempOrder             = $footer->order;
      $footer->order         = $previousFooter->order;
      $previousFooter->order = $tempOrder;
  
      $footer->save();
      $previousFooter->save();
      $this->getFooters();
    }
    
    private function reorderFooters(): void {
      $footers = Footer::orderBy('order')->get();
      foreach ($footers as $index => $footer) {
        $footer->order = $index + 1;
        $footer->save();
      }
    }
  }; ?>
  
  <div>
    <x-header title="{{ __('Footer') }}" separator progress-indicator>
      <x-slot:actions class="lg:hidden">
        <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
          link="{{ route('admin') }}" />
      </x-slot:actions>
    </x-header>

    <x-card>
      @foreach ($footers as $footer)
        <x-list-item :item="$footer" no-separator no-hover>
          <x-slot:value>
            {{ $footer->label }}
          </x-slot:value>
          <x-slot:sub-value>
            {{ $footer->link }}
          </x-slot:sub-value>
          <x-slot:actions>
            @if ($footer->order > 1)
              <x-popover>
                <x-slot:trigger>
                  <x-button icon="s-chevron-up" wire:click="up({{ $footer->id }})" spinner />
                </x-slot:trigger>
                <x-slot:content class="pop-small">
                  @lang('Up')
                </x-slot:content>
              </x-popover>
            @endif
            @if ($footer->order < $footers->count())
              <x-popover>
                <x-slot:trigger>
                  <x-button icon="s-chevron-down" wire:click="down({{ $footer->id }})" spinner />
                </x-slot:trigger>
                <x-slot:content class="pop-small">
                  @lang('Down')
                </x-slot:content>
              </x-popover>
            @endif

            <x-popover>
              <x-slot:trigger>
                <x-button icon="c-arrow-path-rounded-square" link="{{ route('footers.edit', $footer->id) }}"
                  class="text-blue-500 btn-ghost   btn-sm" spinner />
              </x-slot:trigger>
              <x-slot:content class="pop-small">
                  @lang('Edit')
              </x-slot:content>
            </x-popover>

            <x-popover>
              <x-slot:trigger>
                <x-button icon="o-trash" wire:click="deleteFooter({{ $footer->id }})"
                  wire:confirm="{{ __('Are you sure to delete this footer?') }}" spinner
                  class="text-red-500 btn-ghost btn-sm" />
              </x-slot:trigger>
              <x-slot:content class="pop-small">
                @lang('Delete')
              </x-slot:content>
            </x-popover>
          </x-slot:actions>
        </x-list-item>
      @endforeach
    </x-card>
    <br>
    <x-card class="" title="{{ __('Create a new footer') }}">
      <x-form wire:submit="saveFooter">
        <x-input label="{{ __('Title') }}" wire:model="label" />
        <x-input type="text" wire:model="link"
          label="{{ __('Link') }} ({{ __('i.e.') }}: /{{ __('my_page') }}, /pages/slug {{ __('or') }} /pages/{{ strtolower(__('Folder')) }}/  {{ __('my_page') }}-1)" />
        <x-slot:actions>
          <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
            class="btn-primary" />
          </x-slot:actions>
      </x-form>
    </x-card>
  </div>
  ```

  ```json
  "Edit a footer": "Modifier le pied de page",
  "Footer deleted with success.": "Pied de page supprimé avec succès.",
  "Create a new footer": "Créer un nouveau pied de page",
  "Are you sure to delete this footer?": "Êtes-vous sûr de vouloir supprimer ce menu de pied de page ?"
  ```

##### Traductions admin.menus.footers <!-- markmap: fold -->

  ```json
  "Edit a footer": "Modifier le pied de page",
  "Footer deleted with success.": "Pied de page supprimé avec succès.",
  "Create a new footer": "Créer un nouveau pied de page",
  "Are you sure to delete this footer?": "Êtes-vous sûr de vouloir supprimer ce menu de pied de page ?",
  "i.e.": "Ex. ",
  "my_page": "ma_page",
  "or": "ou",
  "Folder": "Dossier"
  ```

### Modification du menu du footer <!-- markmap: fold -->

#### Route admin.menus.editfooter

  ```php
  Volt::route('/footers/{footer}/edit', 'admin.menus.editfooter')->name('footers.edit');
  ```

#### Lien Modification d'un menu du footer dans la liste (admin.menus.footer)

* (*Déjà posé dans le code*)

  ```html
  <x-button icon="c-arrow-path-rounded-square" link="{{ route('footers.edit', $footer->id) }}" class="text-blue-500 btn-ghost btn-sm" spinner />
  ```

#### Composant modification d'un menu footer (admin.menus.editfooter)

##### Création admin.menus.editfooter <!-- markmap: fold -->

  ```bash
  php artisan make:volt admin/menus/editfooter --class
  ```

##### Code admin.menus.editfooter <!-- markmap: fold -->

  ```html
  <?php
  use Mary\Traits\Toast;
  use App\Models\Footer;
  use Livewire\Volt\Component;
  use Illuminate\Validation\Rule;
  use Livewire\Attributes\{Layout, Title};
  
  new #[Title('Edit Footer'), Layout('components.layouts.admin')] 
  class extends Component {
    use Toast;
    
    public Footer $footer;
    public string $label = '';
    public string $link  = '';
    
    public function mount(Footer $footer): void {
      $this->footer = $footer;
      $this->fill($this->footer);
    }
    
    public function save(): void {
      $data = $this->validate([
        'label' => ['required', 'string', 'max:255', Rule::unique('footers')->ignore($this->footer->id)],
        'link'  => 'regex:/\/([a-z0-9_-]\/*)*[a-z0-9_-]*/',
      ]);
  
      $this->footer->update($data);
  
      $this->success(__('Footer updated with success.'), redirectTo: '/admin/footers/index');
    }
  }; ?>
  
  <div>
    <x-header title="{{ __('Edit a footer') }}" separator progress-indicator>
      <x-slot:actions class="lg:hidden">
        <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
          link="{{ route('admin') }}" />
      </x-slot:actions>
    </x-header>
    <x-card>
      <x-form wire:submit="save">
        <x-input label="{{ __('Title') }}" wire:model="label" />
        <x-input type="text" wire:model="link" label="{{ __('Link') }}" />
        <x-slot:actions>
        <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
          class="btn-primary" />
        </x-slot:actions>
      </x-form>
    </x-card>
  </div>
  ```

  ```json
  "Footer updated with success.": "Pied de page mis à jour avec succès"
  ```

### Réf.: ***<a href="https://laravel.sillo.org/posts/mon-cms-les-menus-partie-2" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-les-menus-partie-2</a>***

## - Les Médias <!-- markmap: fold -->

### 1 ) &nbsp;Gestion des Images <!-- markmap: fold -->

#### Route admin.images.index <!-- markmap: fold -->

* À noter : La route images.edit est créée 'en avance' car nécessaire dans la vue images.index
(*Cela évite une erreur à l'affichage si on clique maintenant sur le lien dans la sidebar...*)

  ```php
  Route::middleware('auth')->group(function () {
    ...
    Route::middleware(IsAdminOrRedac::class)->prefix('admin')->group(function () {
      ...
      Route::middleware(IsAdmin::class)->group(function () {
        ...
        Volt::route('/images/index', 'admin.images.index')->name('images.index');
        Volt::route('/images/{year}/{month}/{id}/edit', 'admin.images.edit')->name('images.edit');
  ```

#### Lien admin.images.index dans admin.sidebar <!-- markmap: fold -->

  ```html
      ...  
    </x-menu-sub>
    @if (Auth::user()->isAdmin())
      <x-menu-item icon="c-photo" title="{{ __('Images') }}" link="{{ route('images.index') }}" />
      ... (Accounts)
    @endif
  @endif
  ```

#### Composant admin.images.index <!-- markmap: fold -->

##### Création composant admin.images.index <!-- markmap: fold -->

  ```bash
  php artisan make:volt admin/images/index --class
  ```

##### Code composant admin.images.index <!-- markmap: fold -->

###### À noter : La fonction "Gérer l'image" n'est pas encore codée

###### *Le code étant un peu long, il est scindé en 2 fichiers* **:**

###### **PHP** : Créer admin/images/**index_images.php** <!-- markmap: fold -->

  ```php
  <?php
  use Mary\Traits\Toast;
  use Livewire\Volt\Component;
  use Livewire\WithPagination;
  use Illuminate\Support\Collection;
  use Illuminate\Support\Facades\Storage;
  use Livewire\Attributes\{Layout, Title};
  use Illuminate\Pagination\LengthAwarePaginator;
  
  new #[Title('Images')] #[Layout('components.layouts.admin')]
  class extends Component {
    use Toast;
    use WithPagination;

    public array $allImages = [];
    public Collection $years;
    public Collection $months;
    public $selectedYear;
    public $selectedMonth;
    public int $perPage = 10;
    public int $page    = 1;
    public $myDirectory;

    // Définir les en-têtes de table.
    public function headers(): array {
      return [
        ['key' => 'image', 'label' => 'Image'], // Colonne ne correspondant pas à un champs de la BdD
        ['key' => 'path', 'label' => __('Path') . ' (/photos/)'],
        ['key' => 'actions', 'label' => 'Actions', 'class' => 'bg-red-500/10 text-center'], // 3 colonnes groupées
      ];
    }

    public function mount(): void {
      $this->years  = $this->getYears();
      $this->months = $this->getMonths($this->selectedYear);
      $this->getImages();
    }

    public function updating($property, $value): void {
      if ('selectedYear' == $property) {
        $this->months = $this->getMonths($value);
      }
    }

    public function getImages(): LengthAwarePaginator {
      $imagesPath = "photos/{$this->selectedYear}/{$this->selectedMonth}";
      $allFiles   = Storage::disk('public')->files($imagesPath);

      $this->allImages = collect($allFiles)
        ->map(function ($file) {
          return [
            'path' => (strlen($file) > 30) ? substr($file, 7, 13) . ' ... ' . substr($file, -9) : substr($file, 7, 23),
            // 'path' => $file,
            'url' => Storage::disk('public')->url($file),
          ];
        })
        ->toArray();

      $this->page = LengthAwarePaginator::resolveCurrentPage('page');
      $total      = count($this->allImages);
      $images     = array_slice($this->allImages, ($this->page - 1) * $this->perPage, $this->perPage, true);

      return new LengthAwarePaginator($images, $total, $this->perPage, $this->page, [
        'path'     => LengthAwarePaginator::resolveCurrentPath(),
        'pageName' => 'page',
      ]);
    }

    public function deleteImage($index): void {
      $url = $this->allImages[$index]['url'];

      // Trouver la position de '/storage'
      $pos = strpos($url, '/storage');
      // Extraire la partie de l'URL après '/storage'
      $path = substr($url, $pos + strlen('/storage'));
      // dd($index, $url, $relativePath);

      Storage::disk('public')->delete($path);

      $this->success(__('Image deleted with success.'));

      // $this->getImages();
      $this->deleteDirectoryIfEmpty();
    }

    public function deleteDirectoryIfEmpty() {
      $directory = "photos/{$this->selectedYear}/{$this->selectedMonth}";
      $files     = Storage::disk('public')->files($directory);

      if (0 == count($files)) {
        Storage::disk('public')->deleteDirectory($directory);
        $this->success(__('Image and empty directory deleted with success.'));
        redirect()->route('images.index');
      } else {
        // $this->error(__('Directory is not empty.'));
        $this->success(__('Image deleted with success.'));
        $this->getImages();
      }
    }

    public function with(): array {
      return [
        'headers' => $this->headers(),
        'images'  => $this->getImages(),
      ];
    }

    private function getYears(): Collection {
      return $this->getDirectories('photos', function ($years) {
        $this->selectedYear = $years->first()['id'] ?? null;

        return $years;
      });
    }

    private function getMonths($year): Collection {
      return $this->getDirectories("photos/{$year}", function ($months) {
        $this->selectedMonth = $months->first()['id'] ?? null;
        // À activer avec l'exemple de débogage à dé-commenter aussi (en fin de ce code)
        // IMPORTANT: Faire une copie de l'image de ce dossier 07 pour la régénérer aisément...
        // $this->selectedMonth = '07'; // '07' par défaut
        $this->getImages();

        return $months;
      });
    }

    private function getDirectories(string $basePath, Closure $callback): Collection {
      $directories = Storage::disk('public')-  >directories($basePath);

      $items = collect($directories)->map(function ($path) {
        $name = basename($path);

        return ['id' => $name, 'name' => $name];
      })->sortByDesc('id');

      return $callback($items);
    }
  };
  ```

###### **BLADE** (Le fichier créé par la commande en CLI) - admin/images/**index.blade.php** <!-- markmap: fold -->

  ```html
  <?php
    include_once 'index_images.php';
  ?>
  
  <div>
    <x-header title="{{ __('Images') }}" separator progress-indicator>
      <x-slot:actions class="lg:hidden">
        <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
          link="{{ route('admin') }}" />
      </x-slot:actions>
    </x-header>

    <x-card title="{!! __('Select year and month') !!}" class="shadow-md">
      <x-select label="{{ __('Year') }}" :options="$years" wire:model="selectedYear" wire:change="$refresh" />
      <br>
      <x-select label="{{ __('Month') }}" :options="$months" wire:model="selectedMonth" wire:change="$refresh" />
    </x-card>

    <x-card>
      <x-table striped :headers="$headers" :rows="$images" class="border-2 border-red-500/10" with-pagination>
        @scope('cell_image', $image)
          <div class="w-20 border-white border-[3px]">
            <a href="{{ $image['url'] }}" target="_blank">
              <img src="{{ $image['url'] }}" alt="" title="{{ __('Click here to see bigger!') }}">
            </a>
            {{-- {{ dd($image) }} --}}
          </div>
        @endscope

        @scope('cell_actions', $image, $selectedYear, $selectedMonth, $perPage, $page, $loop)
        <div class="flex flex-nowrap justify-center text-center gap-2 h-12">
          <x-popover>
            <x-slot:trigger>
              <x-button icon="s-briefcase" data-url="{{ $image['url'] }}" onClick="copyUrl(this)"
                class="text-blue-500 btn-ghost btn-sm" spinner />
            </x-slot:trigger>
            <x-slot:content class="pop-small">
              @lang('Copy url')
            </x-slot:content>
          </x-popover>

          <x-popover>
            <x-slot:trigger>
              <x-button icon="c-wrench"
                  link="{{ route('images.edit', ['year' => $selectedYear, 'month' => $selectedMonth, 'id' => $loop->index + ($page - 1) * $perPage]) }}" class="text-blue-500 btn-ghost btn-sm" spinner />
            </x-slot:trigger>
            <x-slot:content class="pop-small">
              @lang('Manage image')
            </x-slot:content>
          </x-popover>

          <x-popover class="border-white border-2">
            <x-slot:trigger>
              <x-button icon="o-trash" wire:click="deleteImage({{ $loop->index }})"
                wire:confirm="{{ __('Are you sure to delete this image?') }}" spinner
                class="text-red-500 btn-ghost btn-sm" />
            </x-slot:trigger>
            <x-slot:content class="pop-small">
              @lang('Delete image')
            </x-slot:content>
          </x-popover>
        </div>
        @endscope
    </x-table>
      <x-header class="my-3 mb-0" separator progress-indicator />

      {{--
      <h3 class="text-xl font-bold">Exemple de débogage rapide :</h3>
      <pre>
        @php
          $imagesPath = "photos/{$this->selectedYear}/{$this->selectedMonth}";
          $allFiles = Storage::disk('public')->files($imagesPath);
          echo 'Dossier demandé : ' . $imagesPath . '<br>';
          // var_dump($allFiles);
          print_r($allFiles);
          echo '<br><hr><br>';

          // Exemple de l'image 2024/07 :
          $path = '/photos/2024/07/j6pMm9U3u2VbmaHYePcDfXzeHC3hIn8fvjH7nlzo.jpg';
          echo 'La photo : <b>photos/2024/07/j6pMm9U3u2VbmaHYePcDfXzeHC3hIn8fvjH7nlzo.jpg</b><br>
          existe t\'elle dans 2024/07 ? <b>' . (Storage::disk('public')->exists($path) ? 'Oui' : 'Non').' !</b>';
          // Attention: Dé-commenter ci-dessous effacera réellement l'image...Conserver la copie pour une restauration facile
          // Storage::disk('public')->delete($path);
        @endphp
      </pre>
      --}}
    </x-card>

    <script>
      function copyUrl(button) {
        const url = button.getAttribute('data-url');
        const textArea = document.createElement('textarea');
        textArea.value = url;
        document.body.appendChild(textArea);
        textArea.select();
        try {
          document.execCommand('copy');
          alert('URL copiée : ' + url);
        } catch (err) {
          console.error('Erreur lors de la copie de l\'URL: ', err);
        }
        document.body.removeChild(textArea);
      }
    </script>
  </div>
  ```

##### Traductions code composant admin.images.index <!-- markmap: fold -->

  ```json
  "Select year and month": "Sélectionner l'année et le mois",
  "Year": "Année",
  "Month": "Mois",
  "Click here to see bigger!": "Cliquer ici pour voir en plus grand !",
  "Path": "Chemin",
  "Copy url": "Copier l'URL",
  "Manage image": "Gérer l'image",
  "Delete image": "Supprimer l'image",
  "Image deleted with success.": "Image supprimée avec succès.",
  "Image and empty directory deleted with success.":"Image et dossier (vide) supprimés avec succès."
  ```

### Réf.: ***<a href="https://laravel.sillo.org/posts/mon-cms-les-medias-partie-1" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-les-medias-partie-1</a>***

### 2 ) &nbsp;Modification des Images <!-- markmap: fold -->

#### Route admin.images.edit (*Déjà créée à l'étape précédente, gestion des Images*)

#### Lien admin.images.edit dans admin.images.index (Partie Blade) <!-- markmap: fold -->

* (*Aussi déjà posé*)

  ```html
  <x-popover>
    <x-slot:trigger>
    <x-button icon="c-wrench"
      link="{{ route('images.edit', ['year' => $selectedYear, 'month' => $selectedMonth, 'id' => $loop->index + ($page - 1) * $perPage]) }}"...
  ```

#### Package Intervention Image <!-- markmap: fold -->

##### Installation Intervention Image

  ```php
  composer require intervention/image-laravel
  ```

##### Publication de la configuration Intervention Image

  ```bash
  php artisan vendor:publish --provider="Intervention\Image\Laravel\ServiceProvider"
  ```

##### Réf.: <a href="https://image.intervention.io/v3/introduction/frameworks" title="Voir les détails" target="_blank">https://image.intervention.io</a>

#### Composant admin.images.edit <!-- markmap: fold -->

##### Création composant admin.images.edit <!-- markmap: fold -->

  ```php
  php artisan make:volt admin/images/edit --class
  ```

##### Code composant admin.images.edit <!-- markmap: fold -->

###### *Le code étant long, il est scindé en 2 fichiers* **:**

###### PHP : Créer admin/images/**edit_image.php** <!-- markmap: fold -->

  ```php
  <?php
  use Mary\Traits\Toast;
  use Livewire\Volt\Component;
  use App\Models\{Page, Post};
  use Intervention\Image\ImageManager;
  use Livewire\Attributes\{Layout, Title};
  use Intervention\Image\Drivers\Gd\Driver;
  use Illuminate\Support\Facades\{File, Storage};

  new #[Title('Edit Image'), Layout('components.layouts.admin')] class extends Component {
    use Toast;

    public int $year;
    public int $month;
    public int $id;
    public string $image;
    public string $displayImage;
    public array $usage;
    public string $fileName;
    public string $imagePath;
    public string $tempPath;
    public int $width;
    public int $height;
    public string $imageScale  = '1';
    public array $selectValues = [['id' => '1', 'name' => '1'], ['id' => '0.95', 'name' => '0.95'], ['id' => '0.9', 'name' => '0.9'], ['id' => '0.85', 'name' => '0.85'], ['id' => '0.8', 'name' => '0.8']];
    public string $group;
    public int $brightness = 0;
    public int $contrast   = 0;
    public int $gamma      = 10;
    public int $red        = 0;
    public int $green      = 0;
    public int $blue       = 0;
    public int $reduce     = 0;
    public int $blur       = 0;
    public int $sharpen    = 0;
    public bool $changed;
    public int $clipW = 0;
    public int $clipH = 0;

    public function mount($year, $month, $id): void {
      $this->year  = $year;
      $this->month = $month;
      $this->id    = $id;
      $this->getImage($year, $month, $id);
      $this->usage = $this->findUsage();
      $this->saveImageToTemp(false);
      $this->getImageInfos();
    }

    public function saveImageToTemp($viewToast): void {
      $tempDir        = Storage::disk('public')->path('temp');
      $this->tempPath = "{$tempDir}/{$this->fileName}";

      if (!File::exists($tempDir)) {
        File::makeDirectory($tempDir, 0o755, true);
      }

      if (File::exists($this->imagePath)) {
        File::copy($this->imagePath, $this->tempPath);
      }

      if ($viewToast) {
        $this->success(__('Changes validated'));
      }
      $this->image = Storage::disk('public')->url('temp/' . $this->fileName);
    }
    public function restoreImage($cancel): void {
      if (File::exists($this->imagePath)) {
        File::copy($this->imagePath, $this->tempPath);
        $this->refreshImageUrl();
        $this->clipW = 0;
        $this->clipH = 0;
        $this->getImageInfos();
        $this->success(__('Image restored'));
      }

      $this->changed = false;

      if ($cancel) {
        $this->info(__('No modification has been made'));
        $this->exit();
      }
    }
    public function updated($property, $value) {
      if ('group' === $property) {
          return;
      }
      $manager = new ImageManager(new Driver());
      $image   = $manager->read($this->tempPath);
      switch ($property) {
        case 'imageScale':
          $image->scale(height: $this->height * $value);
          $this->width      = $image->width();
          $this->height     = $image->height();
          $this->imageScale = '1';
          break;
        case 'brightness':
          $image->brightness($value);
          $this->brightness = 0;
          break;
        case 'contrast':
          $image->contrast($value);
          $this->contrast = 0;
          break;
        case 'gamma':
          $image->gamma($value / 10.0);
          $this->gamma = 10;
          break;
        case 'red':
          $image->colorize(red: $value);
          $this->red = 0;
        break;
        case 'green':
          $image->colorize(green: $value);
          $this->green = 0;
        break;
        case 'blue':
          $image->colorize(blue: $value);
          $this->blue = 0;
        break;
        case 'blur':
          $image->blur($value);
          $this->blur = 0;
        break;
        case 'sharpen':
          $image->sharpen($value);
          $this->sharpen = 0;
        break;
        case 'clipW':
          $width  = $this->width - $this->width * $value * 0.01;
          $offset = ($this->width - $width) / 2;
          $image->crop($width, $this->height, $offset);
          $this->width  = $image->width();
          $this->height = $image->height();
          $this->clipW  = 0;
        break;
        case 'clipH':
          $height = $this->height - $this->height * $value * 0.01;
          $offset = ($this->height - $height) / 2;
          $image->crop($this->width, $height, 0, $offset);
          $this->width  = $image->width();
          $this->height = $image->height();
          $this->clipH  = 0;
        break;
        case 'reduce':
          $image->reduceColors(49 - $value);
          $this->reduce = 0;
        break;
          default:
        break;
      }
      $image->save();
      $this->info(__('Image modified ! (Not saved yet)'));
      $this->changed = true;
      $this->refreshImageUrl();
    }

    public function invert(): void {
      $manager = new ImageManager(new Driver());
      $image   = $manager->read($this->tempPath);
      $image->invert();
      $image->save();
      $this->info(__('Image modified ! (Not saved yet)'));
      $this->changed = true;
      $this->refreshImageUrl();
    }
    public function getImage($year, $month, $id): void {
      $imagesPath         = "photos/{$year}/{$month}";
      $allFiles           = Storage::disk('public')->files($imagesPath);
      $image              = $allFiles[$id];
      $this->imagePath    = Storage::disk('public')->path($image);
      $this->fileName     = basename($this->imagePath);
      $this->image        = Storage::disk('public')->url("temp/{$this->fileName}");
      $this->displayImage = Storage::disk('public')->url($image);
      $this->refreshImageUrl();
    }
    public function keepVersion(): void {
      if (File::exists($this->tempPath)) {
        File::copy($this->tempPath, $this->imagePath);
      }
      $this->success(__('Image changes applied successfully'));
      $this->exit();
    }
    public function exit(): void {
      if (File::exists($this->tempPath)) {
        File::delete($this->tempPath);
      }
      redirect()->route('images.index');
    }
    public function applyChanges(): void {
      if (File::exists($this->tempPath)) {
        File::copy($this->tempPath, $this->imagePath);
      }
      $this->changed = false;
      $this->success(__('Image changes applied successfully'));
    }
    private function getImageInfos(): void {
      $manager      = new ImageManager(new Driver());
      $image        = $manager->read($this->tempPath);
      $this->width  = $image->width();
      $this->height = $image->height();
    }
    private function findUsage(): array {
      $usage = [];
      $name = $this->year . '/' . str_pad($this->month, 2, '0', STR_PAD_LEFT) . '/' . $this->fileName;
      $posts = Post::select('id', 'title', 'slug')
        ->where('image', 'LIKE', "%{$name}%")
        ->orWhere('body', 'LIKE', "%{$name}%")
        ->get();
      foreach ($posts as $post) {
        $usage[] = [
          'type'  => 'post',
          'id'    => $post->id,
          'title' => $post->title,
          'slug'  => $post->slug,
        ];
      }
      $pages = Page::where('body', 'LIKE', "%{$name}%")->get();
      foreach ($pages as $page) {
        $usage[] = [
          'type'  => 'page',
          'id'    => $page->id,
          'title' => $page->title,
          'slug'  => $page->slug,
        ];
      }
      return $usage;
    }
    private function refreshImageUrl(): void {
      $this->image = Storage::disk('public')->url("temp/{$this->fileName}") . '?' . now()->timestamp;
    }
  };
  ```

###### BLADE : admin/images/**edit.blade.php** <!-- markmap: fold -->

  ```html
  <?php
    include_once 'edit_image.php';
  ?>
  
  <div class="flex flex-col h-full lg:flex-row">
    <div class="w-full p-4 lg:w-3/4">
      <x-header title="{{ __('Manage an image') }}" separator progress-indicator>
        <x-slot:actions class="lg:hidden">
          <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
            link="{{ route('admin') }}" />
        </x-slot:actions>
      </x-header>
      <x-card>
          <div class="flex items-center justify-between h-full">
            <p>@lang('The url of this image is :') <i>{{ $this->displayImage }}</i></p>
            <x-button label="{!! __('Copy url') !!}" data-url="{{ $this->displayImage }}" onclick="copyUrl(this)" class="btn-sm" />
          </div>
          <br>
          @if (empty($this->usage))
            <x-badge value="{!! __('This image is not used') !!}" class="badge-warning" />
          @else
            @foreach ($this->usage as $use)
              @if ($use['type'] == 'post')
                <p>@lang('This image is in the post ') : <b><a href="{{ route('posts.show', $use['slug']) }}" target="_blank">{{ $use['title'] }}</a></b></p>
              @else
                <p>@lang('This image is in the page ') :
                  <b><a href="{{ route('pages.show', $use['slug']) }}" target="_blank">{{ $use['title'] }}</a></b>
                </p>
              @endif
            @endforeach
          @endif
          <br><br>
          <x-header separator progress-indicator />
          <div class="flex items-center justify-center h-full">
            <img src="{{ $image }}" alt="">
          </div>
          <x-header separator progress-indicator />
      </x-card>
    </div>

    <div class="w-full p-4 lg:w-1/4">
      <p class="mb-2 text-3xl">@lang('Settings')</p>
      <x-accordion wire:model="group" class="mb-4 shadow-md">
        <x-collapse name="group1">
          <x-slot:heading>
            @lang('Size change')
          </x-slot:heading>
          <x-slot:content>
            @lang('Height') :
            <x-badge value="{{ $this->height }}px" class="badge-primary" /><br>
            @lang('Width') :
            <x-badge value="{{ $this->width }}px" class="badge-primary" /><br><br>
            <x-radio inline label="{{ __('Select a rescale value') }}" :options="$selectValues"
                wire:model="imageScale" wire:change="$refresh" />
          </x-slot:content>
        </x-collapse>
        <x-collapse name="group2">
          <x-slot:heading>
            @lang('Brightness, contrast and gamma correction')
          </x-slot:heading>
          <x-slot:content>
            <x-range wire:model.live.debounce="brightness" min="-20" max="20" step="2"
                label="{{ __('Brightness') }}" class="range-primary" />
            <x-range wire:model.live.debounce="contrast" min="-20" max="20" step="2"
                label="{{ __('Contrast') }}" class="range-primary" />
            <x-range wire:model.live.debounce="gamma" min="5" max="22"
                label="{{ __('Gamma Correction') }}" class="range-primary" />
          </x-slot:content>
        </x-collapse>
        <x-collapse name="group3">
          <x-slot:heading>
            @lang('Color correction')
          </x-slot:heading>
          <x-slot:content>
            <x-range wire:model.live.debounce="red" min="-20" max="20" step="2"
                label="{{ __('Red') }}" class="range-primary" />
            <x-range wire:model.live.debounce="green" min="-20" max="20" step="2"
                label="{{ __('Green') }}" class="range-primary" />
            <x-range wire:model.live.debounce="blue" min="-20" max="20" step="2"
                label="{{ __('Blue') }}" class="range-primary" />
            <x-range wire:model.live.debounce="reduce" min="0" max="48" step="2"
                label="{{ __('Reduce color') }}" class="range-primary" />
            <x-button label="{{ __('Invert colors') }}" wire:click="invert" class="mt-2 btn-outline btn-sm" />
          </x-slot:content>
        </x-collapse>
        <x-collapse name="group4">
            <x-slot:heading>
                @lang('Blur and sharpen')
            </x-slot:heading>
            <x-slot:content>
              <x-range wire:model.live.debounce="blur" min="0" max="20" step="2"
                  label="{{ __('Blur') }}" class="range-primary" />
              <x-range wire:model.live.debounce="sharpen" min="0" max="20" step="2"
                  label="{{ __('Sharpen') }}" class="range-primary" />
            </x-slot:content>
        </x-collapse>
        <x-collapse name="group5">
        <x-slot:heading>
          @lang('Crop')
        </x-slot:heading>
        <x-slot:content>
          <x-range wire:model.live.debounce="clipW" min="0" max="40" step="2"
              label="{{ __('Width') }}" class="range-primary" />
          <x-range wire:model.live.debounce="clipH" min="0" max="40" step="2"
              label="{{ __('Height') }}" class="range-primary" />
        </x-slot:content>
        </x-collapse>
      </x-accordion>
        @if ($changed)
          <x-button wire:click="restoreImage(false)" class="btn-sm">@lang('Restore image to its original state')
          </x-button><br>
          <x-button wire:click="applyChanges" class="mt-2 btn-sm">@lang('Valid changes')</x-button><br>
          <x-button wire:click="restoreImage(true)" class="mt-2 btn-sm">@lang('Finish and discard this version')</x-button>
      @endif
      <x-button wire:click="keepVersion" class="mt-2 btn-sm">@lang('Finish and keep this version')</x-button><br>
    </div>

    <script>
      function copyUrl(button) {
        const url = button.dataset.url; //+ succinct...
        const textArea = document.createElement('textarea');
        textArea.value = url;
        document.body.appendChild(textArea);
        textArea.select();
        try {
          document.execCommand('copy');
          alert('URL copiée: ' + url);
        } catch (err) {
          console.error('Erreur lors de la copie de l\'URL: ', err);
        }
        document.body.removeChild(textArea);
      }
    </script>
  </div>
  ```

##### Traductions code composant admin.images.edit <!-- markmap: fold -->

  ```json
  "Manage an image": "Gérer une image",
  "The url of this image is :": "L'URL de cette image est :",
  "This image is in the post ": "Cette image est dans l'article ",
  "This image is in the page ": "Cette image est dans la page ",
  "Select a rescale value": "Sélectionnez une valeur de redimensionnement",
  "Height": "Hauteur",
  "Width": "Largeur",
  "Size change": "Changement des dimensions",
  "Brightness": "Luminosité",
  "Brightness, contrast and gamma correction": "Correction de luminosité, contraste et gamma",
  "Contrast": "Contraste",
  "Restore image to its original state": "Restaurer l'image à son état d'origine",
  "Color correction": "Correction de couleur",
  "Valid changes": "Valider les modifications",
  "Changes validated": "Modifications validées",
  "Finish and keep this version": "Terminer et garder cette version",
  "This image is not used": "Cette image n'est pas utilisée",
  "Finish and discard this version": "Terminer et oublier cette version",
  "Are you sure to delete this image?": "Êtes-vous sûr de vouloir supprimer cette image ?",
  "Blur and sharpen": "Flou et netteté",
  "Blur": "Flou",
  "Sharpen": "Netteté",
  "Image modified ! (Not saved yet)": "Image modifiée ! (Non sauvegardée)",
  "Image restored": "Image restaurée",
  "No modification has been made": "Aucune modification n'a été apportée à l'image",
  "Image changes applied successfully": "Modifications de l'image appliquées avec succès"
  ```

### Réf.: ***<a href="https://laravel.sillo.org/posts/mon-cms-les-medias-partie-2" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-les-medias-partie-2</a>***

## - Les Paramètres (*Setting*) <!-- markmap: fold -->

### Route Setting <!-- markmap: fold -->

  ```php
    Route::middleware('auth')->group(function () {
      ...
      Route::middleware(IsAdminOrRedac::class)->prefix('admin')->group(function () {
        ...
        Route::middleware(IsAdmin::class)->group(function () {
          ...
          Volt::route('/settings', 'admin.settings')->name('settings');
        ...
  ```

### Création composant Setting <!-- markmap: fold -->

  ```php
    php artisan make:volt admin/settings --class
  ```

### Lien Setting dans admin.sidebar <!-- markmap: fold -->

  ```html
    @if (Auth::user()->isAdmin())
      ... (Menus)
      <x-menu-item icon="m-cog-8-tooth" title="{{ __('Settings') }}"
      link="{{ route('settings') }}" :class="App::isDownForMaintenance() ? 'bg-red-300' : ''" />
    @endif
  ```

### Variables Setting ( ./**.env** ) <!-- markmap: fold -->

  ```json
    APP_MAINTENANCE_DRIVER=file
    APP_MAINTENANCE_STORE=database
    APP_MAINTENANCE_SECRET=230542a-177b-4b66-ffb1-dd77g4c93515
  ```

### Le rendu Front-End de Setting <!-- markmap: fold -->

#### layout.app

  ```html
    <div class="text-center hero-content text-neutral-content">
      <div>
        <h1 class="mb-5 text-4xl font-bold sm:text-5xl md:text-6xl lg:text-7xl xl:text-8xl">
          {{ config('app.title') }}
        </h1>
        <p class="mb-1 text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl">
          {{ config('app.subTitle') }}
        </p>
      </div>
    </div>
  ```

#### index

  ```html
    @if ($post->pinned)
      <x-badge value="{{ __('Pinned') }}" class="p-3 badge-warning" />
    @elseif($post->created_at->gt(now()->subWeeks(config('app.newPost'))))
    <x-badge value="{{ __('New') }}" class="p-3 badge-success" />
    @endif
  ```

### Les données pour Setting <!-- markmap: fold -->

#### Model & Migration Setting <!-- markmap: fold -->

  ```bash
    php artisan make:model Setting -m
  ```

  ```php
    class Setting extends Model {
      public $timestamps = false;
      protected $fillable = ['key', 'value'];
    }
  ```

  ```php
  public function up(): void {
    Schema::create('settings', function (Blueprint $table) {
      $table->id();
      $table->string('key')->unique();
      $table->text('value');
    });
  }
```

#### Seeder Setting <!-- markmap: fold -->

  ```php
    php artisan make:seeder SettingSeeder
  ```
  
  ```php
    <?php
    namespace Database\seeders;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    class SettingSeeder extends Seeder {
      public function run() {
        $settings = [
          ['key' => 'pagination', 'value' => 6],
          ['key' => 'excerptSize', 'value' => 30],
          ['key' => 'title', 'value' => 'Mon titre'],
          ['key' => 'subTitle', 'value' => 'Mon sous-titre'],
          ['key' => 'newPost', 'value' => 4],
        ];
    
        DB::table('settings')->insert($settings);
      }
    }
  ```

#### DatabaseSeeder Setting <!-- markmap: fold -->

  ```php
    public function run(): void {
      $this->call([
        ...
        SettingSeeder::class,
      ]);
    }
  ```
  
  ```bash
    php artisan migrate:fresh --seed
  ```

### Chargement systématique des paramètres <!-- markmap: fold -->

* Dans **AppServiceProvider.php** :

  ```php
  use App\Models\{Menu, Setting};
  ...
    public function boot(): void {
      if (!$this->app->runningInConsole()) {
        $settings = Setting::all();
          foreach ($settings as $setting) {
            config(['app.' . $setting->key => $setting->value]);
          }
        }
      ...
    }
  ```

### Code composant Setting <!-- markmap: fold -->

  ```html
  <?php
  use Mary\Traits\Toast;
  use App\Models\Setting;
  use Livewire\Volt\Component;
  use Illuminate\Support\Facades\Artisan;
  use Livewire\Attributes\{Layout, Validate};
  use Illuminate\Database\Eloquent\Collection;
  
  new #[Title('Settings')] #[Layout('components.layouts.admin')] class extends Component {
    use Toast;

    private const SETTINGS_KEYS = ['pagination', 'excerptSize', 'title', 'subTitle', 'newPost'];

    #[Validate('required|max:30')]
    public string $title;

    #[Validate('required|max:50')]
    public string $subTitle;

    #[Validate('required|integer|between:2,12')]
    public int $pagination;

    #[Validate('required|integer|between:10,60')]
    public int $excerptSize;

    #[Validate('required|integer|between:1,12')]
    public int $newPost;

    public bool $maintenance = false;
    public Collection $settings;

    public function mount(): void {
      $this->settings = Setting::all();
  
      $this->maintenance = App::isDownForMaintenance();
  
      foreach (self::SETTINGS_KEYS as $key) {
        $this->{$key} = $this->settings->where('key', $key)->first()->value ?? null;
      }
    }

    public function updatedMaintenance(): void {
      if ($this->maintenance) {
        Artisan::call('down', ['--secret' => env('APP_MAINTENANCE_SECRET')]);
      } else {
        Artisan::call('up'); // → php artisan up
      }
    }

    public function save() {
      $data = $this->validate();
  
      DB::transaction(function () use ($data) {
        foreach (self::SETTINGS_KEYS as $key) {
          $setting = $this->settings->where('key', $key)->first();
          if ($setting) {
            $setting->value = $data[$key];
            $setting->save();
          }
        }
      });
  
      $this->success(__('Settings updated successfully!'));
    }
  }; ?>
  <div>
    <x-header title="{{ __('Settings') }}" separator progress-indicator>
      <x-slot:actions>
        <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden" link="{{ route('admin') }}" />
      </x-slot:actions>
    </x-header>
    <x-card>
      <x-card separator class="mb-6 border-4 {{ $maintenance ? 'bg-red-300' : 'bg-zinc-100' }} border-zinc-950">
          <div class="flex items-center justify-between">
            <x-toggle label="{{ __('Maintenance Mode') }}" wire:model="maintenance" wire:change="$refresh" />
            @if($maintenance)
              <x-button label="{{ __('Go to bypass page')}}" link="/{{ env('APP_MAINTENANCE_SECRET') }}"  />
            @endif
          </div>
      </x-card>
      <x-form wire:submit="save">
        <x-card separator class="border-4 bg-zinc-100 border-zinc-950">
          <x-input label="{{ __('Site title') }}" wire:model="title" />
          <br>
          <x-input label="{{ __('Site sub title') }}" wire:model="subTitle" />
        </x-card>
        <x-card separator class="border-4 bg-zinc-100 border-zinc-950">
        <x-range min="2" max="12" wire:model="pagination" label="{!! __('Home pagination') !!}" hint="{{ __('Between 2 and 12.') }}" class="range-info" wire:change="$refresh" />
        <x-badge value="{{ $pagination }}" class="my-2 badge-neutral" />
        </x-card>
        <x-card separator class="border-4 bg-zinc-100 border-zinc-950">
          <x-range min="10" max="60" step="5" wire:model="excerptSize"
            label="{!! __('Post excerpt (number of words)') !!}" hint="{{ __('Between 10 and 60.') }}"
            class="range-info" wire:change="$refresh" />
          <x-badge value="{{ $excerptSize }}" class="my-2 badge-neutral" />
        </x-card>
        <x-card separator class="border-4 bg-zinc-100 border-zinc-950">
          <x-range min="1" max="12" step="1" wire:model="newPost" label="{!! __('Number of weeks a post is marked new') !!}"
            hint="{{ __('Between 1 and 12.') }}" class="range-info" wire:change="$refresh" />
          <x-badge value="{{ $newPost }}" class="my-2 badge-neutral" />
        </x-card>
        <x-slot:actions>
          <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
        </x-slot:actions>
      </x-form>
    </x-card>
  </div>
  ```

### Nettoyage code (*Code cleaning*) <!-- markmap: fold -->

* Suppression de code (Devenu inutile) dans config/**app.php** :

  ```php
    'pagination'  => 6,
    'excerptSize' => 30,
  ```
  
### Traductions Setting <!-- markmap: fold -->

  ```json
  "Home pagination": "Pagination de la page d'accueil",
  "Between 2 and 12.": "Entre 2 et 12.",
  "Post excerpt (number of words)": "Extrait de l'article (nombre de mots)",
  "Between 30 and 60.": "Entre 10 et 60.",
  "Site title": "Titre du site",
  "Site sub title": "Sous-titre",
  "Settings updated successfully!": "Paramètres bien enregistrés !",
  "Number of weeks a post is marked new": "Nombre de semaines qu'un article est marqué comme nouveau",
  "Between 1 and 12.": "Entre 1 et 12",
  "Go to bypass page": "Aller sur la page de bypass"
  ```

### Réf. Maintenance : <a href="https://laravel.com/docs/11.x/configuration#maintenance-mode" title="Doc officielle" target="_blank">Doc Laravel // Maintenance</a>

### Réf.: ***<a href="https://laravel.sillo.org/posts/mon-cms-les-parametres" title="Voir les détails" target="_blank">https://laravel.sillo.org/posts/mon-cms-les-parametres</a>***

### Fin du tutoriel : Vérifications de la *sidebar* <!-- markmap: fold -->

* Si tout s'est bien passé, voilà l'admin sidebar obtenue :

* \- <a href="https://prnt.sc/hRJ5vlR_fIv0" title="Voir... Ce qu'ils voient !" target="_blank">Pour les'Admin'</a>

* \- <a href="https://prnt.sc/CF0xu6jK6NUc" title="Voir... Ce qu'ils voient !" target="_blank">Pour les 'Redac'</a>

## - Et après ? Optimisations diverses <!-- markmap: fold -->

### Bien évidemment, ce qui suit n'est en rien exhaustif ! <!-- markmap: fold -->

* ...Car ON PEUT TOUJOURS TOUT AMÉLIORER !

* Donc, si VOUS y 'voyez' un manquement...
... Reportez-vous au point 1 de AIDE & CONTACT ;-) !
( *Le faible critique... Le FORT agit !* :-) )

### Données <!-- markmap: fold -->

#### DataBaseSeeder <!-- markmap: fold -->

##### Principe: Pour l'instant, nous avons beaucoup (trop) de seeders dans la racine du dossier **seeders/** <!-- markmap: fold -->

* Aussi, comme il est possible qu'à l'avenir, notre application s'étoffe, et recèle d'autres parties très distinctes...
Alors, pour plus de clarté, isolons les seeders propres à la base de l'app., pour ultérieurement pouvoir,
selon le même principe, isoler dans d'autres dossiers, des seeders qui seront plus spécifiques...

##### Modus operandi <!-- markmap: fold -->

* 1 ) &nbsp; Créer un dossier **database/seeders/Main**

* 2 ) &nbsp; Y copier dedans tous les seeders nécessaires à la base de l'app à ce stade, soit :
    CategorySeeder, CommentSeeder, ContactSeeder, FooterSeeder, MenusSeeder, PageSeeder, PostSeeder, SettingSeeder et UserSeeder
    &nbsp; &nbsp; &nbsp; &nbsp; ... Mais attention, car du coup, leur espace de nom change... :
    &nbsp; &nbsp; &nbsp; &nbsp; → Donc, dans chacun d'eux, changer celui-ci: '**namespace Database\Seeders;**' → '**namespace Database\Seeders\Main;**'

* 3 ) &nbsp; Créer un fichier database/seeders/**MainDatabaseSeeder.php** :
    &nbsp; &nbsp; &nbsp; &nbsp; → Y copier le code de DataBaseSeeder.php
    &nbsp; &nbsp; &nbsp; &nbsp; → Mais y remplacer la classe ainsi pour la factorisation des call() :

  ```php
  class MainDatabaseSeeder extends Seeder {
    private string $namespace = 'Database\\Seeders\\Main\\';
    private array $seeders   = ['User', 'Category', 'Post', 'Page', 'Contact', 'Menus', 'Footer', 'Comment', 'Setting'];
    
    public function run(): void {
      foreach ($this->seeders as $seeder) {
        $this->call("{$this->namespace}{$seeder}Seeder");
      }
    }
  }
  ```

* 4 ) &nbsp; Modifier database/seeders/**DatabaseSeeder.php** qui se résume alors à :

  ```php
    $this->call([
      MainDatabaseSeeder::class,
    ]);
  ```

##### Résultat *(L'instant de vérité...)* <!-- markmap: fold -->

  ```bash
    php artisan migrate:refresh --seed
  ```

#### Modification du ContactSeeder <!-- markmap: fold -->

##### Problème & Solution <!-- markmap: fold -->

* Situation actuelle :

  ```markdown
    Voir dans la base de données : Dans les enregistrements fakes de
    la table contacts, le champs "message" contient souvent des phrases
    qui se terminent de façon plutôt bizarre...
  ```

* Situation proposée :

  ```markdown
    Faire une sorte d'helper* pour améliorer la terminaison des phrases, en
    fonction de la ponctuation contenue dans le texte généré par le Faker.
  ```

* \* : <small><i>Cependant, comme ceci n'a pas besoin d'être chargé systématiquement par l'appli, puisque juste
nécessaire à priori que pour la population (*seed*) de la table 'contacts', nous le ferons en dehors des 'vrais' helpers...</i></small>

##### Création d'outils (*Tools*) <!-- markmap: fold -->

* → Créer app/Http/Tools/**Fakers.php** :

  ```php
  <?php
  namespace App\Http\Tools;
  use Faker\Factory as FakerBase;
  
  class Fakers {
    /**
     * Generates a fake sentence (a paragraph with 3 sentences)
     * which is cut at a hyphen (., ;, !, ...) which is the closest
     * to the given length.
     *
     * @param int $length The length of the sentence to generate.
     * @return object Contains properties 'complete' and 'wellCut'.
    */
    public function fakerSentence($length = 250): object {
      $locale = (new TimeFcts())->appLocale();
  
      $faker                = FakerBase::create($locale);
      $completeFakeSentence = $faker->realText($length + 100, 3);
  
      return $this->cutSentence($completeFakeSentence);
    }
    
    /**
     * Cut a sentence at the hyphen (., ;, !, ...) which is the closest to the given length.
     *
     * @param string $completeFakeSentence The sentence to cut.
     * @param int $length The length of the sentence to generate.
     * @return object Contains properties 'complete' and 'wellCut'.
     */
    public function cutSentence($completeFakeSentence, $length = 200): object {
      $hyphens  = ['.', ';', '!', '...'];
      $position = $this->findLastHyphenPosition($completeFakeSentence, $length, $hyphens);
  
      $etc = ($position === $length) ? ' [...]' : '';
      // echo "{$position} - {$length}";
      $wellCut = substr($completeFakeSentence, 0, $position) . $etc;
  
      return (object) [
        'complete' => $completeFakeSentence,
        'wellCut'  => $wellCut,
      ];
  
      // echo '<pre>';
      //   print_r($this->sentence);
      // echo '</pre>';
    }
    
    /**
     * Finds the position of the last hyphen in a string, given the length
     * and the hyphens to search for.
     *
     * @param string $text The string to search.
     * @param int $length The length of the string to search.
     * @param array $hyphens The hyphens to search for.
     * @return int The position of the last hyphen, or the length of the string if no hyphen is found.
     */
    private function findLastHyphenPosition($text, $length, $hyphens): int {
      $positions = array_map(function ($hyphen) use ($text, $length) {
          return strrpos(substr($text, 0, $length), $hyphen);
      }, $hyphens);
  
      // Remove false values and get the max position
      $positions = array_filter($positions, fn ($pos) => false !== $pos);
  
      return !empty($positions) ? max($positions) + 1 : $length;
    }
  }
  ```

* Cette classe utilise app/Http/Tools/**TimeFcts.php** (Fichier à créer)

  ```php
  <?php
  namespace App\Http\Tools;
  use Illuminate\Support\Facades\Config;
  
  class TimeFcts {
    /**
     * Return the locale for a given language code
     *
     * @return string The locale, ie: fr → fr_FR
     */
    public function appLocale(): bool|string {
      $languageCode = Config::get('app.locale');
      return \Locale::composeLocale(['language' => $languageCode, 'region' => strtoupper($languageCode)]);
    }
  }
  ```

##### Modification de ContactFactory <!-- markmap: fold -->

  ```php
  <?php
  namespace Database\Factories;
  use App\Models\Contact;
  use Faker\Factory as Faker;
  use App\Http\Tools\{Fakers, TimeFcts};
  use Illuminate\Database\Eloquent\Factories\Factory;

  class ContactFactory extends Factory {
      protected $model = Contact::class;

      public function definition(): array {
        $localeConverter = new TimeFcts();
        $locale          = $localeConverter->appLocale();
        $faker           = Faker::create($locale);
        $fakerTool       = new Fakers();

        return [
          'name'    => $faker->name,
          'email'   => $faker->unique()->safeEmail,
          'message' => $fakerTool->fakerSentence()->wellCut,
        ];
      }
  }
  ```

### Front-End <!-- markmap: fold -->

#### Espace de test <!-- markmap: fold -->

##### Objectif <!-- markmap: fold -->

* En phase de dev, on a fréquemment besoin de tester une fonction native ou perso, bref, un bout de code...
<br>

* En effet, par exemple, pour définir cutSentence(), qui est destiné au ContactSeeder,
il aurait fallu à chaque avancée, relancer le process de *migration:(re)fresh --seed* puis aller
consulter la BdD..., et en particuliers, la table *contacts*... Etc... Plutôt fastidieux !<br>
Pour avoir l'aisance d'obtenir le rendu de notre code, sans avoir besoin de lancer quelque
commande que se soit, une extension de BdD de VSC, ou d'actualiser quoique ce soit, voire pire
encore, de passer sur une autre appli (Style HeidiSQL, SQLite Studio, MySQL Workbench, etc...),
l'idéal est d'avoir un espace d'accès rapide, isolé du reste pour simplifier la problématique,
et aussi éviter ainsi de s'immiscer dans le script principal...<br>
Une fois au point, plus qu'à copier/coller le code dans le fichier ad'hoc :-) !
* Voyons ci-après comment cela a été réalisé ici, grâce à un nouveau composant spécifique :

##### Exemple de Test avec et pour **cutSentence()** <!-- markmap: fold -->

* 1 / **Route Test** : *Pour des raisons de sécurité, cette page ne sera accessible qu'aux admins.
(Cette route sera donc par exemple juste après celle nommée* **settings** *). Et bien-sûr, rien ne vous empêche d'ajouter
à la suite d'autres routes pour d'autres tests, quitte à transformer à terme, le lien ci-après, en dropdown...* :

  ```php
    Volt::route('/test', 'various.test')->name('various.test');
  ```

* 2 / Lien d'accès dans Navbar aisément, rapidement accessible et réservé aux 'admin' uniquement :

  ```html
    @if (auth()->user() && $user->isAdmin())
      <a href="{{ route('various.test') }}" title=" {{ __  ('Test page') }} "><x-icon name="c-cog" /></a>
    @endif
    ... <x-theme-toggle ...
  ```

* 3 / Layout épuré dédié à Test :

  ```html
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>
          {{ (isset($title) ? $title . ' | ' : (View::hasSection('title') ? View::getSection('title') . ' | ' : '')) . config('app.name') }}
      </title>
      <meta name="description" content="@yield('description')">
      <meta name="keywords" content="@yield('keywords')">

      <link rel="stylesheet" href="{{ asset('storage/css/prism.css') }}">
      @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    <body class="h-[96vh] font-sans antialiased bg-base-200/50 dark:bg-base-200 my-3">

      <x-main full-width>
        <x-slot:content>
          {{ $slot }}
        </x-slot:content>
      </x-main>

      <x-toast />
      <script src="{{ asset('storage/scripts/prism.js') }}"></script>
    </body>
    </html>
  ```

* 4 / Traductions pour le test courant :

  * Dans **lang/fr.json**, ajouter :
  
    ```json
      "Test page": "Page de test",
      "Study": "Étude"
    ```
  
  * Créer **lang/de.json** :
  
    ```json
    {
      "Study": "Studie",
      "Test page": "Testseite",
      "of": "von"
    }
    ```
  
  * Créer **es.json** :
  
    ```json
    {
      "Study": "Estudio",
      "Test page": "Página de prueba",
      "of": "de"
    }
    ```

* 5 / **Composant Test** (*Le fichier est scindé, cette fois non pas qu'il soit long, mais afin d'optimiser le travail du formateur de l'IDE...*)

  ```bash
    php artisan make:volt various/test
  ```

* 6 / Créer various/**test.php** :

  ```php
    <?php
    use App\Http\Tools\Fakers;
    use Livewire\Volt\Component;
    use Livewire\Attributes\{Layout, Title};

    new #[Layout('components.layouts.test')] class extends Component {
      public $sentence;
      private $faker;

      public function mount() {
        $this->faker = new Fakers();
        /* À noter : Cette classe utilise un autre outil : TimeFcts()->getLocale() qui extrait la variable d'environnement APP_LOCALE
        de votre .env... Essayer de lui affecter 'de', 'es', 'it', 'nl', ou 'ru'... Tout en regardant : http://127.0.0.1:8000/test */
        $completeFakeSentence = $this->completeFixedOrRealSentence(); // 1 param.: 0 ou rien pour avoir fake || Autre valeur pour avoir fixe
        $this->sentence       = $this->faker->cutSentence($completeFakeSentence);
      }
  
      private function completeFixedOrRealSentence($fixedSentence = 0) {
        // Cas le + fréquent en 1er
        return !$fixedSentence ? $this->faker->fakerSentence()->complete : "La belle-mère répondit n'avoir plus rien de la liquidation
                qui était close, et qu'il leur restait, outre Belleville, six cents livres de rente. Quoiqu'elle fût laide, sèche comme
                un cotret. et bourgeonnée comme un printemps, certes madame Martin ne manquait pas de lui en procurer une autre plus
                riche commode. Le médecin, bien entendu, fit encore les frais de...";
        }
    };
  ```

* 7 / Et dans various/**test.blade.php** (*Déjà créé par la commande en CLI ci-avant*) :

  ```html
    <?php
      include_once 'test.php';
    ?>

    @section('title', __('Test page'))
    <div>
      <a href="/" title="{{ __('Back to site') }}"><x-header class="text-lg m-0" title="{{ __('Test page') }}" shadow separator progress-indicator /></a>

      <p class="text-2xl mb-5">{{ __('Study') }} {{ __('of') }} app/Http/Tools/Fakers.php-><b>cutSentence()</b></p>
      <div class="w-full text-justify">
        {{ $sentence->complete }}
        <hr class="my-3">
        {{ $sentence->wellCut }}
      </div>
    </div>
  ```

### Back-End-End <!-- markmap: fold -->

#### Ajout d'un lien Front-End & bouton Annuler (BLADE) <!-- markmap: fold -->

##### Réalisation d'helpers de vues <!-- markmap: fold -->

* Créer views/components/helpers/**header-lk.blade.php** :

  ```html
  @props([
    'title'        => '',
    'dashboardBtn' => true,
    'addBtn'       => null,
    'noHeader'     => false,
    'forceHeader'  => false,
  ])

  @if (!$noHeader || $forceHeader)
      <div>
          <x-header separator progress-indicator>
              <x-slot:title><a href="/"
                      title="{{ __('Go to site') }}">{{ $title }}</a></x-slot:title>
              <x-slot:actions>
                 @if($addBtn)
                    <x-button icon="c-document-plus" label="{{ $addBtn['label'] }}" class="btn-outline lg:hidden"
                    link="{{ $addBtn['link'] }}" />
                  @endif
                  @if ($dashboardBtn)
                      <x-button icon="s-building-office-2" :label="__('Dashboard')" class="btn-outline lg:hidden"
                          link="{{ route('admin') }}" />
                  @endif
              </x-slot:actions>
          </x-header>
      </div>
  @endif
  ```

* Et views/components/helpers/**progress-bar.blade.php** :

  ```html
  <x-header class="-mt-5 -mb-4" separator progress-indicator />
  ```

* Et views/components/helpers/**cancel-btn.blade.php** :

  ```html
  @props(['lk'=>'#'])

  <x-button label="{{ __('Cancel') }}" icon="o-hand-thumb-down" class="btn-outline" link="{{ $lk }}" />
  ```

* Et views/components/helpers/**save-btn.blade.php** :

  ```html
  <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
  ```

* Et views/components/helpers/**cancel-save-btns.blade.php** :

  ```html
  @props(['lk' => '#'])
  
  <x-helpers.cancel-btn lk="{{ $lk }}" />
  <x-helpers.save-btn />
  ```

##### Nos layouts (admin & test) <!-- markmap: fold -->

  ```html
    <x-helpers.header-lk :title="trim($__env->yieldContent('title'))" />

    {{ $slot }}
  ```

##### admin.index <!-- markmap: fold -->

* *Le tableau de bord n'a pas besoin du bouton... 'Tableau de bord' !"* ;-) :
<br>
  ```php
  public function mount(): void {
    View::share([
      'dashboardBtn' => 0,
      // 'search'    => 0,
      // 'noHeader'  => 1,
    ]);
    ...
  ```
  *→ Noter qu'une variable **noHeader** est prévue, car notre composant
  header est maintenant appelé systématiquement dans nos layouts...
  Elle sert donc lorsqu'on ne souhaite pas du tout de header.*
  <br>
  Pour la Vue :
  ```html
  @section('title', __('Dashboard'))
  <div>
    <x-collapse wire:model="openGlance"...
  ```

##### admin.posts <!-- markmap: fold -->

* \- index :
  <br>

  ```php
  public function mount(): void {
    View::share('noHeader',true);
    ...
  ```

  ```html
  @section('title', __('Post'))
  <div>
    <x-helpers.header-lk title="{{ trim(
        $__env->yieldContent('title')
      ) }}"
      forceHeader = true
      search      = 'true'
      :addBtn     ="[
        'link'  => route('posts.create'),
        'label' => __('Add a post')
      ]"
    />
    ...
  ```

* \- edit :
  <br>

  ```html
  @section('title', __('Edit a post'))
  <div>
    <x-card>
    ...
    </x-card>
    <x-helpers.progress-bar />
  </div>
  ```

* \- create :
<br>
  ```htm
  @section('title', __('Add a post'))
  <div>
    <x-card>
    ...
          <x-helpers.cancel-save-btns :lk="route('posts.index')" />
        </x-slot:actions>
      </x-form>
    </x-card>
    <x-helpers.progress-bar />
  </div>
  ```

##### admin.categories <!-- markmap: fold -->

* \- admin.categories.index :
<br>
  ```html
  @section('title', __('Categories'))
  <div>
    <x-card>
    ...
    </x-card>
    <x-helpers.progress-bar />
  </div>
  ```

* \- admin.category-form :
<br>
  ```html
    <x-slot:actions>
      <x-helpers.cancel-save-btns :lk="route('comments.index')" />
    </x-slot:actions>
  </x-form>
  ```

* \- admin.category.edit :
<br>
  ```html
  @section('title', __('Edit a category'))
  <div>
    <x-card>
    ...
    <x-helpers.progress-bar />
  </div>
  ```

##### admin.pages <!-- markmap: fold -->

* \- index :
  Supprimer l'attribut *title** de la classe pour *n*'avoir *que* :
  <br>

  ```html
  use Livewire\Attributes\Layout;
  ...
  new #[Layout('components.layouts.admin')]
  class extends Component {
  ...
    public function mount(): void {
        View::share([
            'addBtn' => [
                'link'=>route('pages.create'),
                'label' => __('Add a page')
            ]
        ]);
    }
  ...
  ```

  (*: *Penser à faire pareil (Suppression de l'attribut title) pour toutes les pages suivantes*...
  ...Car si pour anglais & français, 'pages', c'est '*kif-kif*', en allemand, par exemple, c'est '*Seite*'...)
  <br>

  ```html
  @section('title', __('Pages'))
  <div>
    <x-card>
    ...
  ```

* \- create *(Penser à retirer l'attribut 'title' de la classe (Et son 'use')...*):
<br>
  ```html
  @section('title', __('Add a page'))
  <div>
    @include('livewire.admin.pages.page-form')
  </div>
  ```

* \- page-form :
<br>
  ```html
  </x-card>
  <x-helpers.progress-bar/>
  ```

* \- edit :
  *Supp. dans les attributs de la classe: **title('Edit Page')*** (*Dernier rappel...*),
  <br>

  ```html
  @section('title', __('Edit a page'))
  <div>
    @include('livewire.admin.pages.page-form')
  </div>
  ```

##### admin.contact <!-- markmap: fold -->

* \- index :
(*Est-ce encore utile...: La Classe, l'attribut "title"...?*)
<br>
  ```html
  @section('title', __('Contacts'))
  <div>
    <x-card>
  ```

##### admin.users <!-- markmap: fold -->

* \- index :
<br>
  ```php
  public function mount(): void {
    View::share('noHeader', true);
  }
  ```
  <br>

  ```html
  @section('title', __('Users'))
  <div>
    <x-helpers.header-lk title="{{ trim($__env->yieldContent('title')) }}" forceHeader=true search='true' />
    <x-radio inline...
  ```

* \- edit :
<br>
  ```html
  @section('title', __('Edit an account'))
  <div>
    <x-card>
    ...
          <x-helpers.cancel-save-btns :lk="route('users.index')" />
        </x-slot:actions>
    </x-form>
    </x-card>
  </div>
  ```

##### admin.comments <!-- markmap: fold -->

* \- index :
<br>
  ```php
  public function mount(): void {
    View::share('noHeader', true);
  }
  ```
  <br>

  ```html
  @section('title', __('Comments'))
  <div>
    <x-helpers.header-lk title="{{ trim($__env->yieldContent('title')) }}" forceHeader=true search='true' />
    <x-card>
  ```

* \- edit :
<br>
  ```html
  @section('title', __('Edit a comment'))
  <div>
    <x-card>
    ...
    <x-slot:actions>
        <x-helpers.cancel-save-btns :lk="route('comments.index')" />
    ...
    <x-slot:actions>
      <x-helpers.cancel-save-btns :lk="route('comments.index')" />
    ...
    </x-card>
    <x-helpers.progress-bar />
  </div>
  ```

##### admin.menus <!-- markmap: fold -->

* \- index :
<br>
  ```html
  @section('title', __('Navbar'))
  <div>
    <x-card>
    ...
          <x-helpers.cancel-save-btns :lk="route('menus.index')" />
        </x-slot:actions>
      </x-form>
    </x-card>
    <x-helpers.progress-bar />
  </div>
  ```

* \- edit :
<br>
  ```html
  @section('title', __('Edit a menu'))
  <div>
    <x-card>
    ...
          <x-helpers.cancel-save-btns :lk="route('menus.index')" />
        </x-slot:actions>
      </x-form>
    </x-card>
    <x-helpers.progress-bar />
  </div>
  ```

* \- editsub :
<br>
  ```html
  @section('title', __('Edit a submenu'))
    <div>
      <x-card>
  ```

* \- submenu-form :
<br>
  ```html
      <x-helpers.cancel-btn :lk="route('menus.index')" />
      <x-helpers.save-btn />
    </x-slot:actions>
  </x-form>
  <br>
  <x-helpers.progress-bar />
  ```

* \- footers :
<br>
  ```html
  @section('title', __('Footer'))
  <div>
    <x-card>
    ...
          <x-helpers.cancel-save-btns :lk="route('menus.footers')" />
        </x-slot:actions>
      </x-form>
    </x-card>
    <x-helpers.progress-bar />
  </div>
  ```

* \- editfooter :
<br>
  ```html
  @section('title', __('Edit a footer'))
  <div>
    <x-card>
    ...
          <x-helpers.cancel-save-btns :lk="route('menus.footers')" />
        </x-slot:actions>
      </x-form>
    </x-card>
  </div>
  ```

##### admin.images <!-- markmap: fold -->

* \- index :
<br>
  ```html
  @section('title', __('Images'))
  <div>
    <x-card ...>
    ...
    </x-card>
    <x-helpers.progress-bar />
  ```

* \- edit :
<br>
  ```html
  @section('title', __('Manage an image'))
  <div ...
    <x-helpers.cancel-btn :lk="route('images.index')" />
        <x-button wire:click="keepVersion" class="mt-2 btn-sm">
        @lang('Finish and keep this version')</x-button><br>
    ...
    </script>
    <x-helpers.progress-bar />
  </div>
  ```

##### admin.settings <!-- markmap: fold -->

* \- index :
<br>
  ```html
  @section('title', __('Settings'))
  <div>  
    <x-card>
    ...
            <x-helpers.cancel-save-btns :lk="route('settings')" />
          </x-slot:actions>
        </x-form>
      </x-card>
    <x-helpers.progress-bar />
  </div>
  ```

##### various/**test.blade.php** <!-- markmap: fold -->

* &nbsp; <small>*Du coup, on peut aussi changer nos pages de test... :
   &nbsp; (Et n'oublions pas l'attribut de la classe et son 'use' à supprimer...)*</small>
  <br>

  ```html
  @section('title', __('Test page').' 1')
  <div>
    <p class...
  ```

#### Ajout d'un choix 'Autre' pour création & édition d'un submenu <!-- markmap: fold -->

* Traits ManageMenus (./app/):

  ```php
  public function with(): array {
    'subOptions' => [
    ...
      ['id' => 4, 'name' => __('Other')]
    ]
  ...
  private function resetSubProperties(): void {
    ...
    $this->subOption   = 4;
  ...
  ```

* admin.menu.editsub :

  ```php
  class ...
    public int $subOption = 4;
  ```

* ```json
  "Root menu": "Menu racine",
  "Other": "Autre"
  ```

#### De + beaux icônes pour notre liste d'users <!-- markmap: fold -->

##### Sourcer les icônes  <!-- markmap: fold -->

* Le choix est immense: Voir <a href="https://github.com/blade-ui-kit/blade-icons?tab=readme-ov-file" title="Aller sur le site de blade-ui-kit" target="_blank">Blade-UI-Kit</a> parmi tant d'autres...

* <a href="https://www.svgrepo.com" title="Aller sur le site de SVGrepo" target="_blank">SVGrepo</a> : Permet d'éditer l'icône choisi :-)

* → Créer resources/images/icons/**check.svg** :

  ```svg
  <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
  <svg version="1.1" id="Layer_1"
    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" enable-background="new 0 0 32 32" xml:space="preserve" width="28px" height="28px" fill="green">
    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
    <g id="SVGRepo_iconCarrier">
      <polyline fill="none" stroke="greenyellow" stroke-width="2" stroke-miterlimit="10" points="28,8 16,20 11,15 "/>
      <path d="M26.7,13.5c0.2,0.8,0.3,1.6,0.3,2.5c0,6.1-4.9,11-11,11S5,22.1,5,16S9.9,5,16,5c3,0,5.7,1.2,7.6,3.1l1.4-1.4 C22.7,4.4,19.5,3,16,3C8.8,3,3,8.8,3,16s5.8,13,13,13s13-5.8,13-13c0-1.4-0.2-2.8-0.7-4.1L26.7,13.5z"/>
    </g>
  </svg>
  ```

* → Créer resources/images/icons/**invalid.svg** :

  ```svg
  <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
  <svg fill="red" height="28px" width="28px" version="1.1" id="Capa_1"
    xmlns="http://www.w3.org/2000/svg"
    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 319.253 319.253" xml:space="preserve">
    <g>
      <path d="M317.361,282.335L172.735,22.335c-2.646-4.758-7.664-7.708-13.108-7.708c-5.444,0-10.462,2.95-13.108,7.708L1.891,282.335c-2.584,4.647-2.517,10.313,0.179,14.896c2.694,4.583,7.613,7.397,12.93,7.397h289.254c5.316,0,10.235-2.814,12.93-7.397C319.879,292.647,319.945,286.981,317.361,282.335z M40.508,274.627L159.627,60.483l119.118,214.143H40.508z" fill="#972023"/>
      <polygon points="132.405,164.598 116.849,180.155 144.07,207.377 116.849,234.598 132.405,250.155 159.627,222.933 186.849,250.155 202.405,234.598 175.183,207.377 202.405,180.155 186.849,164.598 159.627,191.82" />
    </g>
  </svg>
  ```

##### Installer les librairies

###### Ajout des librairies Blade-UI-Kit <!-- markmap: fold -->

* ```batch
  composer require blade-ui-kit/blade-ui-kit
  ```
  
* ```batch
  composer require blade-ui-kit/blade-icons
  ```

###### Configuration & publication de **Blade-UI-Kit** <!-- markmap: fold -->

* Créer config/**blade-icons.php** :

* ```php
  <?php
  // Src: https://github.com/blade-ui-kit/blade-icons (Beaucoup plus complet...)
  return [
    'sets' => [
      'default' => [
      'path'   => 'resources/images/icons',
      'prefix' => 'icon',
      ],
    ],
  ];
  
  ```
  
* ```batch
  php artisan vendor:publish --tag=blade-icons-config
  ```
  
* ```batch
  php artisan icons:clear
  ```

##### Les afficher dans notre vue  <!-- markmap: fold -->

* Modifier admin.users.index :

  ```html
    @scope('cell_valid', $user)
      @if ($user->valid)
        <x-icon-check />
      @else
        <x-icon-invalid />
      @endif
    @endscope
  ```

### Pour aller + loin <!-- markmap: fold -->

#### En premier chef, le <a href="https://github.com/bestmomo/sillo/blob/master/doc/installation.md" title="' Fork & Clone THE ' dépôt !" target="_blank">dépôt officiel</a>

* Dans ce site, vous y trouverez aussi ce qu'on appelle l'*Academy*...:
  → Ni +, ni -, un espace dans lequel vous pouvez y coder vos <a href="https://prnt.sc/AvfssfFpHuvN" title="' Fork & Clone THE ' dépôt !" target="_blank">essais des composant natifs</a>

#### Pour les codeurs sous Windows*, des *Starters*

##### Pour être opérationnel, en tapant JUSTE UN SEUL MOT en CLI, poser à la racine

##### \- ./**start.bat**, un script *batch* qui démarre tous les serveurs de base <!-- markmap: fold -->

* Auparavant, il nettoie quelques dossiers et fichiers, et surtout, vide divers fichiers de cache

* ```bat
  @REM Voir début fichier reset.bat pour infos dont l'encodage de fin de ligne...


  @echo off
  chcp 65001 > nul
  
  echo Nettoyage des fichiers log debugbar...
  if exist storage\debugbar (
      cd storage\debugbar
      for %%i in (*) do if not "%%i"==".gitignore" del /f /q "%%i"
      for /d %%i in (*) do rmdir /s /q "%%i"
      cd ..\..
      echo Fichiers log debugbar nettoyés.
  ) else (
      echo Le dossier storage\debugbar n'existe pas.
  )
  
  if exist storage\logs\laravel.log (
      del /f storage\logs\laravel.log
      echo storage\logs\laravel.log supprimé.
  ) else (
      echo storage\logs\laravel.log n'existe pas.
  )
  
  echo.
  echo Nettoyage des divers fichiers cache...
  call php artisan optimize
  call php artisan cache:clear
  call php artisan view:clear
  call php artisan config:clear
  
  echo.
  echo Démarrage des serveurs.
  
  start /b npm run dev
  start /b php artisan reverb:start
  start /b php artisan serve
  
  
  @REM Start serveur de Mail
  @REM → http://localhost:8025/#
  start /b config/MailHog_windows_amd64.exe
  
  REM Envoi de l'email de Test
  @REM powershell.exe -ExecutionPolicy Bypass -File "testMailServer.ps1"
  @REM php send_email.php
  
  echo.
  echo Les serveurs MonCMS sont démarrés.
  echo.
  
  pause

  ```

##### \- ./**reset.bat**, qui re-initialise tout votre projet, puis appelle **start.bat** <!-- markmap: fold -->

  ```bat
  @REM ATTENTION:  Windows & Sqlite UNIQUEMENT
  @REM (Et ne le lancer que tous serveurs arrêtés)
  
  @REM              UNIQUEMENT pour pur Développement !!!
  
  @REM ACTIONS :
  
  @REM 1 / Ce script re-initialise complètement le projet:
  @REM     - Efface les fichiers lock,
  @REM     - Efface la base de données,
  @REM     - Vide les dossiers des librairies PHP et des dépendances JS,
  @REM     - Supprime tous les fichiers cache (De vues, de config),
  @REM     - Et enfin, les fichiers log (De Laravel et de Debugbar).
  
  @REM 2 / Restaure ensuite librairies, dépendances et base de données (Avec seed).
  
  @REM 3 / Démarre les serveurs (PHP, ViteJS et Reverb [Si utilisé]).
  
  @REM Enfin, il doit être encodé UTF-8 et avoir CRLF comme fin de ligne.
  @REM Note: For that, in settings.json (parameters) in VSCode:
  @REM "[bat]": {
  @REM     "files.eol": "\r\n"
  @REM }
  @REM and and set \r\n in the end of each line in files.eos in parameters.
  @REM Pour vérifier, dans VSCode, vous pouvez faire CTRL + MAJ + P, et vérifier que le fichier est bien en CRLF en cherchant "seq" (Changer la SEQuence de fin, de ligne).
  
  @REM Pour l'heure, ne peut vous être utile que si vous êtes sous windows, et utilisez sqlite. (Cependant, aisé à adapter pour autres configurations)
  
  
  @echo off
  chcp 65001 > nul
  
  echo.
  echo Nettoyage des fichiers et dossiers...
  echo.
  
  if exist package-lock.json (
      del /f package-lock.json
      echo package-lock.json supprimé.
  ) else (
      echo package-lock.json n'existe pas.
  )
  
  if exist composer.lock (
      del /f composer.lock
      echo composer.lock supprimé.
  ) else (
      echo composer.lock n'existe pas.
  )
  
  if exist database\database.sqlite (
      del /f database\database.sqlite
      echo database\database.sqlite supprimé.
  ) else (
      echo database\database.sqlite n'existe pas.
  )
  
  if exist node_modules (
      rmdir /s /q node_modules
      echo Dossier node_modules supprimé.
  ) else (
      echo Le dossier node_modules n'existe pas.
  )
  
  if exist vendor (
      rmdir /s /q vendor
      echo Dossier vendor supprimé.
  ) else (
      echo Le dossier vendor n'existe pas.
  )
  
  if exist .php-cs-fixer.cache (
      del /f .php-cs-fixer.cache
      echo .php-cs-fixer.cache supprimé.
  ) else (
      echo .php-cs-fixer.cache n'existe pas.
  )
  
  echo Nettoyage des vues compilées...
  if exist storage\framework\views (
      cd storage\framework\views
      for %%i in (*) do if not "%%i"==".gitignore" del /f /q "%%i"
      for /d %%i in (*) do rmdir /s /q "%%i"
      cd ..\..\..
      echo Vues nettoyées.
  ) else (
      echo Le dossier storage\framework\views n'existe pas.
  )
  
  
  @REM exit 1
  
  
  echo.
  echo Restauration...
  
  echo.
  echo Installation des dépendances JS
  call npm install
  
  echo.
  echo Lancement de composer update...
  @REM set COMPOSER=config\reset\composer_dev.json
  call composer update
  @REM set COMPOSER=composer.json
  
  
  echo.
  echo Migration et seed de la base de données...
  if exist database\database.sqlite (
      call php artisan migrate:refresh --seed
  ) else (
      call php artisan migrate --force --seed
  )
  echo Tables restaurées avec données.
  
  call start.bat
  ```

##### \- ./**sillo.bat**, pour 'lancer' le site **Sillo** en local <!-- markmap: fold -->

* À l'issue, votre CLI est alors dans le dossier sillo/ de votre serveur local...
Les serveurs locaux y étant lancés, votre navigateur affichera le site...: **Sillo** :-) !
  → Et pas grave, pour 'revenir', il y a aussi un '**moncms.bat**' à sa racine qui relance
  &nbsp; &nbsp; &nbsp;pour vous, et vous ramène dans votre projet local **MonCMS** !

* ```bat
  @REM Start servers
  
  @echo off
  @REM call start.bat
  
  cd ../sillo/
  echo.
  echo Passe sur Sillo
  echo.
  
  call start.bat
  ```

##### \*: *Noter qu'il est aisé de les adapter pour les utilisateurs **Linux**...*

#### <a href="https://laravel.sillo.org/doc/ladoc" title="LaDoc" target="_blank">**LaDoc**</a>

* Cette présente MindMap est un premier jet...
Mais si vous en voyez l'intérêt, et surtout l'utilité,
nous pouvons élargir ensemble cette approche à d'autres thématiques...
* → Contribuez *ad libitum* !

## III &nbsp;/ &nbsp; **A I D E &nbsp; & &nbsp; C O N T A C T** <!-- markmap: fold -->

### **0 / Liens techniques clés**

* **<a href="http://127.0.0.1:8000" title="Ouvrir votre rendu" target="_blank">MonCMS</a>** (*Les serveurs doivent être démarrés...*)
* **<a href="http://127.0.0.1:8025" title="Ouvrir votre messagerie locale" target="_blank">MailHog</a>** (*Le service doit être démarré...*)

### 1 / **<a href="https://github.com/bestmomo/sillo" title="Voir le dépôt officiel du projet" target="_blank">Le TOP: Le dépôt GIT officiel</a>**

* En <a href="https://github.com/bestmomo/sillo/blob/master/doc/installation.md" title="' Fork & Clone THE ' dépôt !" target="_blank">récupérant le code complet du projet</a>
* Puis, en y faisant un Pull Request (Et là... : BRAVOs (*Mabrouk*) !!!)
* Ou au pire, en y levant une issue... Mais pas si gravissime (*Malich*) ;-)

### 2 / **<a href="https://laravel.sillo.org/login" title="Voir le site officiel" target="_blank">Le site officiel</a>**

* Message possible en bas de chaque article
(*Vous devez alors y être logué ou créer un compte...*)

### 3 / **<a href="https://discord.com/channels/1258750464800063640/1258750464800063646" title="Dial EN LIVE avec la communauté" target="_blank">Le canal officiel DISCORD</a>**

* Pour discuter en LIVE

### 4 / **<a href="https://laravel.sillo.org/contact" title="Communiquer plus discrètement..." target="_blank">Un message personnel</a>**
