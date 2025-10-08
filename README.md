1. Pada terminal run "git clone https://github.com/dharuuuuu/SKRIPSI_FINAL.git"
2. Pada terminal run "composer install"
3. Copy paste file ".env.example" dan rename jadi ".env"
4. Pada terminal run "php artisan key:generate"
5. Nyalakan XAMPP
6. Buat database baru pada phpmyadmin, namanya terserah
7. pada file ".env" pada bagian DB_DATABASE beri nilai sesuai nama database yang baru dibuat tadi
8. Pada terminal run "npm install"
9. Pada terminal run "npm run build"
10. Pada terminal run "php artisan migrate:fresh --seed"
10. Pada terminal run "php artisan storage:link"
11. Pada terminal run "php artisan serve"
12. Untuk akses akun nya bisa dilihat di "database->seeders->UserSeeder.php"
