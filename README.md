<p align="center">
  <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4b/Lambang_Kabupaten_Katingan.png/719px-Lambang_Kabupaten_Katingan.png" width="300" alt="Katingan Logo">
</p>

## Developer Note
- Laravel 10.10, PHP 8.2
- Login using Breeze. For [more](https://laravel.com/docs/10.x/starter-kits)
- Base temp user (RentUP)

### Getting Started

- How to start after clone:
-- 'composer install' <-- Laravel standard to retrieve vendor folder packages, also create autoload
-- 'npm install' <-- optional to Laravel, but necessary for this project, due to Breeze implementation
-- 'npm run build' <-- the 2nd necessary after npm install 
-- Storage Laravel method will uploads the file into /($ROOT_FOLDER)/storage/app/public
-- Meanwhile it could be uploaded, to access it is different story. Please do 'php artisan storage:link' (opt. rm -rf public/storage). For [more info](https://laracasts.com/discuss/channels/laravel/show-images-from-storage-folder). It will makes 'softlink' folder in /($ROOT_FOLDER)/public
-- Make sure the upload path (storeAs) same as you save into db

- Good to Know 
-- In DB please use collation "utf8mb4_unicode_ci", for any field that its value filled via WYSIWYG editor

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).