@REM ATTENTION:  Windows & Sqlite UNIQUEMENT
@REM (Et ne le lancer que tous serveurs arrêtés)

@REM              UNIQUEMENT pour pur Developpement !!!

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


@REM exit 1


echo.
echo Restauration...

echo.
echo Installation des dependances JS
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


echo.
echo Nettoyage des divers fichiers cache...
call php artisan optimize
call php artisan cache:clear
call php artisan view:clear
call php artisan config:clear


echo.
echo Nettoyage et processus terminé.

start /b npm run dev
start /b php artisan reverb:start
start /b php artisan serve
