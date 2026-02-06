@echo off
cd /d C:\xampp\htdocs\myproject
echo 1. Key generate...
C:\xampp\php\php.exe artisan key:generate
echo 2. Storage link...
C:\xampp\php\php.exe artisan storage:link
echo 3. Server baslatiliyor...
echo Tarayicida: http://localhost:8000
C:\xampp\php\php.exe artisan serve
pause