### Getting started

First, build up and run docker containers:

```bash
cd docker/ && docker-compose up --build
```

Then install all dependencies with Composer from `src` directory:

```bash
cd ../src
composer install
```

To create the project schema, run migration:
```bash
php bin/console doctrine:mi:mi
```

To load fixtures data, run:
```bash
php bin/console doctrine:fi:lo
```

Now, at http://localhost:80/takequiz you can take the quiz and check results
 