<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Markmap</title>
<style>
* {
  margin: 0;
  padding: 0;
}
#mindmap {
  display: block;
  width: 100vw;
  height: 100vh;
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/markmap-toolbar@0.17.0/dist/style.css">
</head>
<body>
<svg id="mindmap"></svg>
<script src="https://cdn.jsdelivr.net/npm/d3@7.8.5/dist/d3.min.js"></script><script src="https://cdn.jsdelivr.net/npm/markmap-view@0.17.0/dist/browser/index.js"></script><script src="https://cdn.jsdelivr.net/npm/markmap-toolbar@0.17.0/dist/index.js"></script><script>(r => {
                setTimeout(r);
              })(() => {
  const {
    markmap,
    mm
  } = window;
  const {
    el
  } = markmap.Toolbar.create(mm);
  el.setAttribute('style', 'position:absolute;bottom:20px;right:20px');
  document.body.append(el);
})</script><script>((getMarkmap, getOptions, root2, jsonOptions) => {
              const markmap = getMarkmap();
              window.mm = markmap.Markmap.create(
                "svg#mindmap",
                (getOptions || markmap.deriveOptions)(jsonOptions),
                root2
              );
            })(() => window.markmap,null,{"content":"Mon CMS","children":[{"content":"1 / Installation de la Base","children":[{"content":"<em>composer  create-project laravel/laravel moncms --prefer-dist</em>","children":[],"payload":{"lines":"6,7"}},{"content":"Paramètres .env file (APP_NAME, APP_URL &amp; DB_DATABASE)","children":[],"payload":{"lines":"7,8"}},{"content":"Ajout Fr : <em>composer require --dev laravel-lang/common<br>\nphp artisan lang:update</em>","children":[],"payload":{"lines":"8,11"}}],"payload":{"lines":"4,5","fold":1}},{"content":"2 / Gestion des Models et Tables","children":[{"content":"Tables:","children":[{"content":"Migration seule : <em>php artisan make:migration create_nnn_table</em>","children":[],"payload":{"lines":"14,15"}},{"content":"Factory : <em>php artisan make:factory MmmFactory</em>","children":[],"payload":{"lines":"15,16"}},{"content":"Seeders : <em>php artisan make:seeder MmmSeeder</em>","children":[],"payload":{"lines":"16,17"}},{"content":"Penser à appeler les seeders dans database/seeders/DataBaseSeeder.php:<br>\n<em>$this-&gt;call([<br>\nMmm1Seeder::class,<br>\nMmm2Seeder::class,<br>\netc...]);</em>","children":[],"payload":{"lines":"17,22"}},{"content":"Puis les exécuter : <em>php artisan db:seed</em>","children":[],"payload":{"lines":"22,23"}}],"payload":{"lines":"13,23","fold":1}},{"content":"Models + migration :","children":[{"content":"Migrations","children":[{"content":"<em>php artisan make:model Mmm --migration</em> ou<br>\n<em>php artisan make:model Mmm -m</em>","children":[],"payload":{"lines":"25,27"}},{"content":"<em>php artisan migrate</em> la 1ère fois","children":[],"payload":{"lines":"27,28"}},{"content":"<em>php artisan migrate:refresh --seed</em> ensuite","children":[],"payload":{"lines":"28,29"}}],"payload":{"lines":"24,29"}},{"content":"Model (Mmm) :","children":[{"content":"<em>protected $timestamps = false;</em>","children":[],"payload":{"lines":"30,31"}},{"content":"<em>protected $fillable = ['name', 'email', 'password', 'role', 'valid'];</em>","children":[],"payload":{"lines":"31,32"}}],"payload":{"lines":"29,32"}},{"content":"Relations :","children":[{"content":"1:n :","children":[{"content":"(1) : Dans MmmN","children":[{"content":"<em>use Illuminate\\Database\\Eloquent\\Relations\\BelongsTo;</em>","children":[],"payload":{"lines":"35,36"}},{"content":"<em>Illuminate\\Database\\Eloquent\\Relations\\BelongsTo;<br>\npublic function Mmm1(): BelongsTo {<br>\nreturn $this-&gt;belongsTo(Mmm1::class);}</em>","children":[],"payload":{"lines":"36,39"}}],"payload":{"lines":"34,39"}},{"content":"(n) : Dans Mmm1","children":[{"content":"<em>use Illuminate\\Database\\Eloquent\\Relations\\HasMany;</em>","children":[],"payload":{"lines":"40,41"}},{"content":"<em>Illuminate\\Database\\Eloquent\\Relations\\BelongsTo;<br>\npublic function MmmN(): HasMany {<br>\nreturn $this-&gt;HasMany(MmmN::class);}</em>","children":[],"payload":{"lines":"41,45"}}],"payload":{"lines":"39,45"}}],"payload":{"lines":"33,45"}}],"payload":{"lines":"32,45"}}],"payload":{"lines":"23,45","fold":1}}],"payload":{"lines":"11,12","fold":1}},{"content":"3 / Divers","children":[{"content":"\n<p data-lines=\"47,48\">helpers:</p>","children":[{"content":"app/helpers.php (Y écrire les fonctions appelées souvent un peu n'importe où)","children":[],"payload":{"lines":"49,50"}},{"content":"Dans composer.json :<br>\n<em>\"autoload\": {<br>\n\"files\": [<br>\n\"app/helpers.php\"<br>\n],...},</em>","children":[],"payload":{"lines":"50,55"}}],"payload":{"lines":"47,55"}},{"content":"\n<p data-lines=\"55,56\">composer dumpautoload</p>","children":[],"payload":{"lines":"55,57"}}],"payload":{"lines":"45,46","fold":1}},{"content":"Réf.: <strong><a href=\"https://laravel.sillo.org/posts/mon-cms-les-donnees\">https://laravel.sillo.org/posts/mon-cms-les-donnees</a></strong>","children":[],"payload":{"lines":"57,58"}}],"payload":{"lines":"0,1"}},{"duration":2000,"initialExpandLevel":-1})</script>
</body>
</html>
