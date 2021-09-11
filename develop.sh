mv index.php public/index.php
sed -i "s#__DIR__.'/#__DIR__.'/../#g" public/index.php
sed -i "s#env('ASSET_URL', 'public/')#env('ASSET_URL', null)#g"  config/app.php
echo "👨🏽‍💻 Now in develop mode"
