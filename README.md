## Development Environment Setup

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

## Docs

#### Reservations

**Status Types**

-   `billing` - The guest has selected dates, but has yet to enter billing details.
-   `pending` - The reservation is awaiting host approval
-   `failed` - The payment failed / waiting for guest to confirm
-   `active` - The reservation is approved, but not yet active _(guest hasn't arrived to the property yet)_
-   `completed` - The guest has **completed** their reseravtion
-   `cancelled` - The guest has **cancelled** their reservation and is awaiting refund
-   `rejected` - A host has rejected the reseravtion
-   `refunded` - The guest has cancelled their reservation and a refund has been issued
