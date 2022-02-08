<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://diagro.be/assets/img/diagro-logo.svg" width="400"></a></p>

<p align="center">
<img src="https://img.shields.io/badge/project-authentication/authorization-yellowgreen" alt="Diagro backend">
<a href="https://github.com/diagro-git/service_auth"><img src="https://img.shields.io/badge/type-service-informational" alt="Diagro service"></a>
<a href="https://php.net"><img src="https://img.shields.io/badge/php-8.0-blueviolet" alt="PHP"></a>
<a href="https://laravel.com/docs/8.x/"><img src="https://img.shields.io/badge/laravel-8.67-red" alt="Laravel framework"></a>
</p>

## Beschrijving

Deze service verleent diensten voor authenticatie en authorizatie. Het beheren van authentication en application authentication tokens.
En het valideren van de tokens.

## Dependencies

<p><a href="https://github.com/diagro-git/lib_laravel_token"><img src="https://img.shields.io/badge/lib-laravel_token-informational" alt="Diagro token library"></a></p>

## Development

Na het seeden zitten volgende entries in de database:

* company: **Diagro**
* role: **

## Production

* Link: <https://weegbrug-api.diagro.farm>
* Docker: `docker pull stijn1989/weegbrug-api:latest`
* Portainer: <https://portainer.diagro.farm>
* Docker server: `ssh diagro@159.223.1.58 -p 24045`
* Database server: `ssh diagro@165.22.200.34 -p 24045`

## Changelog

### V1.0.0

* **Feature**: inloggen met email/wachtwoord
* **Feature**: inloggen met AT token
* **Feature**: keuze uit meerdere bedrijven
* **Feature**: uitloggen
* **Feature**: validatie van frontend app id, AT token en AAT token
