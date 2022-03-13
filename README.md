### Development Environment Setup

1. Install and setup WSL2, Ubuntu, etc
2. Clone project
3. Run the following to install Composer dependencies: 
```
docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/var/www/html -w /var/www/html laravelsail/php81-composer:latest composer install --ignore-platform-reqs
```
4. Add the `sail` bash alias: `alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'`
5. Run `sail up`
6. Run `sail artisan storage:link` to add symbolic link

Done.