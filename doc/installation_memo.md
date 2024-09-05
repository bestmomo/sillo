# Mon CMS
<-- Réf.: https://laravel.sillo.org/posts/mon-cms-les-donnees -->
<-- VSCode: Utiliser extention markmap -->

## 1 / Installation de la Base

- *composer  create-project laravel/laravel moncms --prefer-dist*
- Paramètres .env file (APP_NAME, APP_URL & DB_DATABASE)
- Ajout Fr : *composer require --dev laravel-lang/common
  php artisan lang:update*

## 2 / Gestion des Models et Tables
  
- Tables:
  - Migration seule : *php artisan make:migration create_nnn_table*
  - Factory : *php artisan make:factory MmmFactory*
  - Seeders : *php artisan make:seeder MmmSeeder*
  - Penser à appeler les seeders dans database/seeders/DataBaseSeeder.php:
    *$this->call([
      Mmm1Seeder::class,
      Mmm2Seeder::class,
      etc...]);*
  - Puis les exécuter : *php artisan db:seed*
- Models + migration :
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
        - *Illuminate\Database\Eloquent\Relations\BelongsTo;
        public function Mmm1(): BelongsTo {
        return $this->belongsTo(Mmm1::class);}*
      - (n) : Dans Mmm1
        - *use Illuminate\Database\Eloquent\Relations\HasMany;*
        - *Illuminate\Database\Eloquent\Relations\BelongsTo;
        public function MmmN(): HasMany {
        return $this->HasMany(MmmN::class);}*

## 3 / Divers

- helpers:

  - app/helpers.php (Y écrire les fonctions appelées souvent un peu n'importe où)
  - Dans composer.json :
    *"autoload": {
    "files": [
    "app/helpers.php"
    ],...},*
- composer dumpautoload

## Réf.: <https://laravel.sillo.org/posts/mon-cms-les-donnees>
