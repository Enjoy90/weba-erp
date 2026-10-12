@echo off
rem Menjalankan Aureus ERP (PHP 8.3) di http://127.0.0.1:8080/admin/login
set "PHPDIR=C:\laragon\bin\php\php-8.3.35-nts-Win32-vs16-x64"
if exist "D:\php83\php.exe" set "PHPDIR=D:\php83"
set "PATH=%PHPDIR%;%PATH%"
set PHP_CLI_SERVER_WORKERS=4
cd /d "%~dp0public"
set PORT=%1
if "%PORT%"=="" set PORT=8080
echo Membuka http://127.0.0.1:%PORT%/admin/login
rem OPcache harus dinyalakan untuk command line, kalau tidak setiap file PHP dikompilasi ulang di setiap permintaan (sekitar 3 kali lebih lambat).
php -d opcache.enable_cli=1 -d opcache.memory_consumption=256 -d opcache.interned_strings_buffer=32 -d opcache.max_accelerated_files=30000 -d opcache.validate_timestamps=1 -d opcache.revalidate_freq=2 -d realpath_cache_size=4096k -d realpath_cache_ttl=300 -S 127.0.0.1:%PORT% ..\vendor\laravel\framework\src\Illuminate\Foundation\resources\server.php
