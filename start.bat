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
echo Les serveurs sont démarrés.
echo.

pause
