**SYSTEM REQUIREMENTS**  
PHP >= 7.1.3  
MySQL  
NodeJS  

**DEVELOPMENT MODE**  

_BUILD ADMIN THEME_  
cd resources/themes/metronic_v5.1.5/tools  
npm install  
gulp  

_COPY ADMIN THEME_  
npm install  
gulp copy:admin-theme  

_RUN WEB_  
composer install  
npm install  
npm run dev  
php artisan migrate  
php artisan db:seed (optional)  
php artisan  

**PRODUCTION BUILD**  

_BUILD ADMIN THEME_  
cd resources/themes/metronic_v5.1.5/tools  
npm install  
gulp --prod  

_COPY ADMIN THEME_  
npm install  
gulp copy:admin-theme  

_COPY DISTRIBUTION_  
composer install  
npm install  
npm run prod  
gulp  