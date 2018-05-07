MAGIC SCRIPT README
======================

This guide will help you install and run `magic-script` locally and list its endpoints.

### Introduction 
Magic Script is an app that creates automatically scripts from Movie Quotes (powered by
Mashape API)
and send them to the VoiceBunny's API - when the recording is done, the last script its 
available in the index of the project.
Database is provided to store move than one script and to extend the project if it's necessary.

The project was build in PHP and Silex Microframework (With Symfony and Doctrine), the database
is SQLite (but the driver is easy to change if necessary).

**TO-DO**: 
* Improve the Mashape API, it has a bug that retrieves only a quote per request, so a 
loop is necessary to get more than one quote. Unit tests
* Unit tests


### Setup

Clone the repository in your projects folder.

Run `composer install`

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
