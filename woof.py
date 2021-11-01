#-* encoding: utf-8 *-#

import os, shutil, argparse, subprocess


def replace_in_file(filepath, old_str, new_str):
    with open(filepath, 'r') as file :
        filedata = file.read()

        # Replace the target string
        filedata = filedata.replace(old_str, new_str)

        # Write the file out again
        with open(filepath, 'w') as file:
            file.write(filedata)





def development():
    filename = "index.php"
    if (os.path.exists(filename)):
        print("👨🏽‍💻 Switching to develop mode")

        shutil.move(filename, "public/index.php")
        replace_in_file("public/index.php", "__DIR__.'/", "__DIR__.'/../")
        replace_in_file("config/app.php", "env('ASSET_URL', 'public/')", "env('ASSET_URL', null)")
        replace_in_file(".env", "APP_DEBUG=false", "APP_DEBUG=true")
        replace_in_file(".env", "APP_ENV=production", "APP_ENV=local")
        print("👨🏽‍💻 Now in develop mode")
    else:
        print("👨🏽‍💻 Already in developer mode")


def shared_hosting():
    filename = "public/index.php"

    if (os.path.exists(filename)):
        shutil.move(filename, "index.php")
        replace_in_file("index.php", "__DIR__.'/../", "__DIR__.'/")
        replace_in_file("config/app.php", "env('ASSET_URL', null)", "env('ASSET_URL', 'public/')")
        replace_in_file(".env", "APP_DEBUG=true", "APP_DEBUG=false")
        replace_in_file(".env", "APP_ENV=local", "APP_ENV=production")
        # php artisan optimize
        print("🚀 Now in deploy mode[shared hosting]")
    else:
        print("Project might be already in deploy mode")


def update():
    print("🚀 Updating...")
    ecode = subprocess.run(["git", "pull", "origin", "main"], stdout=subprocess.DEVNULL)

    print("🚀 Installing dependencies")
    ecode = subprocess.run(["composer", "update"], stdout=subprocess.DEVNULL)

    print("⬆️ Running migrations")
    ecode = subprocess.run(["php", "artisan", "migrate"], stdout=subprocess.DEVNULL)

    print("🗃 Configuring caches")
    ecode = subprocess.run(["php", "artisan", "config:cache"], stdout=subprocess.DEVNULL)

    print("✅ Updated")



def install():

    print("🚀 Installing dependencies")
    ecode = subprocess.run(["composer", "update"], stdout=subprocess.DEVNULL)

    print("🧹 Cleaning project")
    ecode = subprocess.run(["php", "artisan", "project:clean"], stdout=subprocess.DEVNULL)

    print("🗃 Configuring caches")
    ecode = subprocess.run(["php", "artisan", "config:cache"], stdout=subprocess.DEVNULL)

    print("⬆️ Running migrations")
    ecode = subprocess.run(["php", "artisan", "migrate"], stdout=subprocess.DEVNULL)

    print("🌱 Seeding the database")
    ecode = subprocess.run(["php", "artisan", "db:seed"], stdout=subprocess.DEVNULL)

    print("〜 Linking storage")
    ecode = subprocess.run(["php", "artisan", "storage:link"], stdout=subprocess.DEVNULL)

    print("✅ Installed")



# Create the parser
parser = argparse.ArgumentParser()
# Add an argument
parser.add_argument('action', type=str)
# Parse the argument
args = parser.parse_args()


if args.action == "d" or args.action == "dev" or args.action == "development":
    development()
elif args.action == "s" or args.action == "shared" or args.action == "shared_hosting":
    shared_hosting()
elif args.action == "i" or args.action == "install":
    install()
elif args.action == "u" or args.action == "update":
    update()
else:
    print("🤷‍♂️ Invalid argument")


