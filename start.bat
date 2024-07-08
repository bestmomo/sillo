@REM Voir début fichier reset.bat pour infos dont l'encodage de fin de ligne...


@echo off
chcp 65001 > nul

echo.
echo Démarrage des serveurs.

start /b npm run dev
start /b php artisan reverb:start
start /b php artisan serve


@REM Start serveur de Mail
start /b config/MailHog_windows_amd64.exe

REM Envoi de l'email de Test
@REM powershell.exe -ExecutionPolicy Bypass -File "testMailServer.ps1"
@REM php send_email.php

echo.
echo Les serveurs sont démarrés.

pause
