mv public/index.php index.php 2&>1 /dev/null || echo "ℹ Already moved!"
sed -i "s#__DIR__.'/../#__DIR__.'/#g" index.php
sed -i "s#env('ASSET_URL', null)#env('ASSET_URL', 'public/')#g"  config/app.php

php artisan 
echo "🚀 Now in deploy mode[shared hosting]"

