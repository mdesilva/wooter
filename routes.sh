rm routes.html
GREEN='\033[0;32m'
NC='\033[0m'
printf "${GREEN}Created File:${NC} $PWD/routes.html;\n"
php artisan route:list --sort=uri >> routes.html
