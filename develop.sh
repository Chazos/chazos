mv index.php public/index.php
sed -i "s#__DIR__.'/#__DIR__.'/../#g" public/index.php
sed -i "s#env('ASSET_URL', 'public/')#env('ASSET_URL', null)#g"  config/app.php
sed -i "s#APP_DEBUG=false#APP_DEBUG=true#g"  .env
sed -i "s#APP_ENV=production#APP_ENV=local#g" .env
echo "👨🏽‍💻 Now in develop mode"
