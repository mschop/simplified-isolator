#!/usr/bin/env bash

set -e

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
DOCKER_DIR=$DIR

docker=`command -v docker`

if [ -z "$docker" ]; then
    printf "\nDocker is missing from your installation.\n"
    exit 1
fi

declare -a php_versions=("7.4" "8.0" "8.1")

for version in "${php_versions[@]}" # Later add further versions here
do
    printf "\n\n> Testing PHP-Version $version \n\n"
    docker build "$DOCKER_DIR" -t "simplified-isolator-php-$version" --build-arg "PHP_VERSION=$version"
    docker run -v "$DIR:/code" -w "/code" "simplified-isolator-php-$version" composer update --no-interaction --no-progress --no-scripts
    docker run -v "$DIR:/code" -w "/code" "simplified-isolator-php-$version" vendor/bin/phpunit
done
