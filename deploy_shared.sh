mv public/index.php index.php 2&>1 /dev/null || echo "ℹ Already moved!"
sed -i "s#__DIR__.'/../#__DIR__.'/#g" index.php
sed -i "s#env('ASSET_URL', null)#env('ASSET_URL', 'public/')#g"  config/app.php
sed -i "s#APP_DEBUG=true#APP_DEBUG=false#g"  .env
sed -i "s#APP_ENV=local#APP_ENV=production#g" .env

php artisan
echo "🚀 Now in deploy mode[shared hosting]"

