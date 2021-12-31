
## Installation

`php composer install`

`php artisan storage:link`

`php atrisan migrate`

`ln -s ././design`

## Start 

`php artisan serve`


## Parser Routes

`/parser` - route to parse designers list

`/parser/projects` - route to parse projects list

## Result Routes

`/designers` - you can find designers list on this route;


## Create and Edit Designers/Projects

`/designers/create` - route to create designers

`/designers/edit/{id}` - dynamic route to edit designer profile

`/projects` - route to create Projects

`/projects/edit/{id}` - dynamic route to edit project

## Проксирование через Apache .htaccess

RewriteRule ^designers/(.+)? http://IP:PORT/designers/$1 [P]

RewriteRule ^projects/(.+)? http://IP:PORT/projects/$1 [P]

RewriteRule ^storage/uploads/(.+) http://IP:PORT/storage/uploads/$1 [P]

RewriteRule ^design/(.+) http://IP:PORT/design/$1 [P]