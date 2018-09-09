
## Setup project

Clone project using

```text
git clone git@github.com:aglavas/flaviarTask.git flaviar
```

Next, navigate to cloned repository and hit

```text
composer update
```

to install composer dependencies.


Database setup is needed, so rename .env.example to .env and populate database settings. 
Also database needs to be created. After all of these things are set up database tables needs to be set up:

```text
php artisan migrate
```

After table creation, dummy data is needed:

```text
php artisan db:seed
```

Default admin user will be created:
 
```text
email: admin@admin.com
pass: admin
```

One more thing before start, Laravel application needs encrypt key, so we can generate one with:

```text
php artisan key:generate
```

Application is now ready, enjoy.

