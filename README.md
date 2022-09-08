# laravel-docker
[![Maintainability](https://api.codeclimate.com/v1/badges/1433e161c6fc40dc15b7/maintainability)](https://codeclimate.com/github/vasilysmolin/user-parser/maintainability)

[![Test Coverage](https://api.codeclimate.com/v1/badges/1433e161c6fc40dc15b7/test_coverage)](https://codeclimate.com/github/vasilysmolin/user-parser/test_coverage)

# About Project
Парсер пользователей из VK

## Required

* PHP >= 8.0
* Composer >= 2
* make >= 4

## Install and start project
* `Необходимо добавить строчку в файле /etc/hosts 127.0.0.1 laravel-docker.ru`
* `Необходимо выполнить в корне проекта make setup`
* `Для парсинга пользователей необходимо получить access_token от вк и добавить его в переменную среды API_VK`


## Tests and lint

* `make lint - запуск codeSniffer`
* `make lint-fix - запуск исправления codeSniffer`
* `make test - запуск тестов`
* `test-coverage - запуск тестов с покрытием`

## Site
[project](https://user-parser.herokuapp.com/)

