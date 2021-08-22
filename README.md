## Chazos

Chazos is headless CMS built with Laravel. It is a simple CMS that allows you to create and manage your content, and you can consume this content using a REST API.

It should be used as a backend for websites, web apps and mobile apps.

Chazos is a greek work for stupid. Someone who is stupid is someone who is brainless or headless :).

### How to install

1. Clone the project

    `git clone https://github.com/takumade/chazos.git`

2. Navigate to the project folder

    `cd chazos`

3. Install dependencies

    `composure install`

4. Modify the .env file
    - Database

5. Run the server

    `php artisan config:cache && php artisan serve`


### Todo

- [ ] Allow admin to add, edit and delete content
- [ ] Add pagination in manage
- [ ] Remove stock styles from the frontend
- [ ] Allow admin to add, edit and delete collections/documents
- [ ] Add relationships between documents
- [ ] Add API for the frontend
- [ ] Add media library
- [ ] Add settings

