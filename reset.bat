@echo off
chcp 65001 > nul
echo Nettoyage des fichiers et dossiers...

if exist package-lock.json (
    del /f package-lock.json
    echo package-lock.json supprime.
) else (
    echo package-lock.json n'existe pas.
)

if exist composer.lock (
    del /f composer.lock
    echo composer.lock supprime.
) else (
    echo composer.lock n'existe pas.
)

if exist composer_dev.lock (
    del /f composer_dev.lock
    echo composer_dev.lock supprime.
) else (
    echo composer_dev.lock n'existe pas.
)

if exist database\database.sqlite (
    del /f database\database.sqlite
    echo database\database.sqlite supprime.
) else (
    echo database\database.sqlite n'existe pas.
)

if exist node_modules (
    rmdir /s /q node_modules
    echo Dossier node_modules supprime.
) else (
    echo Le dossier node_modules n'existe pas.
)

if exist vendor (
    rmdir /s /q vendor
    echo Dossier vendor supprime.
) else (
    echo Le dossier vendor n'existe pas.
)

echo Nettoyage des vues compilees...
if exist storage\framework\views (
    cd storage\framework\views
    for %%i in (*) do if not "%%i"==".gitignore" del /f /q "%%i"
    for /d %%i in (*) do rmdir /s /q "%%i"
    cd ..\..\..
    echo Vues nettoyees.
) else (
    echo Le dossier storage\framework\views n'existe pas.
)

@REM exit 1

@REM call npm i

@REM echo Lancement de composer update...
@REM call composer install
@REM set COMPOSER=composer_dev.json
@REM call composer update
@REM set COMPOSER=composer.json
@REM call composer update

@REM echo Nettoyage et processus termine.

@REM start /b npm run dev
@REM php artisan serve
