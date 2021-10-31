## Chazos

Chazos is headless CMS built with Laravel. It is a simple CMS that allows you to create and manage your content, and you can consume this content using a REST API.

It should be used as a backend for websites, web apps and mobile apps.

Chazos is a greek work for stupid. Someone who is stupid is someone who is brainless or headless 😁. 


### How to install

0. Create your database first

1. Clone the project

    `git clone https://github.com/takumade/chazos.git`

2. Navigate to the project folder

    `cd chazos`

3. Modify .env file or create one. **Make sure your have composer and PHP >= 7.4 installed.**
    

4.  Run install

    `python woof.py install`

8. Serve it

    `php artisan serve`


### Deploy on shared hosting 🚀

1. Type the following

`python woof.py shared`

**Do this putting the file on server, since it also runs optimize commands**

### Update ⬆️

1. Type the following

`python woof.py update`

**Remember to save your data first**

### Make develop ready 👨🏽‍💻

1. Type the following

`python woof dev`

**If you want to make a pull request clean the project first**

`php artisan project:clean`


### Screenshots

**Dashbaord**
![Chazos Dashbaord](./readme_images/chazos_dashboard.png)

**Tables**
![Chazos Tables](./readme_images/chazos_tables.png)

**Table Builder**
![Chazos Table Builder](./readme_images/chazos_tablebuilder.png)

**Table Builder 2**
![Chazos Table Builder 2](./readme_images/chazos_tablebuilder2.png)

**Table Builder 1 Modal**
![Chazos Modal](./readme_images/chazos_modal.png)

**Settings**
![Chazos Settings](./readme_images/chazos_settings.png)


