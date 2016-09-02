# Artisan GitTools

Laravel 5.* Artisan commands with helpful Git solutions. 

Note: Still in beta, use at your own risk.

## Install

In composer.json file add the following in the require array:

``` bash
  "require": {
        
        "ivanciric/artisan-git-tools": "0.0.1"
  },
```

In config/app.php providers array, add the following line:

```
Hamato\ArtisanGitTools\ArtisanGitToolsServiceProvider::class,
```

## Usage

```
php artisan gittools:{command}
```

### Available commands

```
timetravel
```
- resets the remote branch to a specific commit hash

```
oblivion
```
- removes folder/file from the repository but leaves it on the local fs