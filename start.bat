@REM Voir début fichier reset.bat pour infos dont l'encodage de fin de ligne...


@echo off
chcp 65001 > nul

echo.
echo Démarrage des serveurs.

start /b npm run dev
start /b php artisan reverb:start
start /b php artisan serve
