MAGIC SCRIPT README
======================

This guide will help you install and run `magic-script` locally and list its endpoints.

### Introduction 
Magic Script is an app that creates automatically scripts from Movie Quotes (powered by
Mashape API)
and send them to the VoiceBunny's API - when the recording is done, the last script its 
available in the index of the project.

Audio is only available in the index of the project when VoiceBunny's API pings the last
script.

Database is provided to store move than one script and to extend the project if it's necessary.

The project was build in PHP and Silex Microframework (With Symfony and Doctrine), the database
is SQLite (but the driver is easy to change if necessary).

### Important notes

This application was developed to reproduce an extensible structure. All the Abstract Classes
that you can find in */src/Bundler/Common* folder were made to keep new features easy to implement.
As an example, if we need to add a new "Audio" Entity, we just need to abstract it's Persists,
Retrieves and Normalizers classes and our CRUD is done.

This kind of application can easily be done with some framework like Django or Rails, but I really
wanted to show the power of a PHP microframework as Silex.

### App Map:

Application initalizes in: *web/index.php*

Silex application main structure is mounted in: *src/app.php*

Core files of the application, such as AbstractClasses, Routes, Controllers, Retrieves
can be find in *src/Bundle* folder

Classes injections and generators are localized in: *src/Bundle/Resources* folder

Entities can be find in: *src/Bundle/Entity* folder

**TO-DO**: 
* Improve the Mashape API, it has a bug that retrieves only a quote per request, so a 
loop is necessary to get more than one quote.
* Unit tests
* Add websocket to automaticaly updates index page when audio is done
* Improve UI


### Setup

Clone the repository in your projects folder.

Run `composer install`

Dump database with the following command:

`bin/doctrine orm:schema-tool:update --dump-sql -f`

Project should be working accordingly to your local webserver.

> This project is ready to work in Heroku, its main URL is: [https://magic-script.herokuapp.com](https://magic-script.herokuapp.com)

### Endpoints:

*POST* `/generate-script-and-audio`

*Body*:

```
{
  "voicebunnyUser": "YYY",
  "voicebunnyToken": "XXX",
  "test": 1,
  "numberOfQuotes": 10
}
```

This will generate a random script and send it to VoiceBunny's API
