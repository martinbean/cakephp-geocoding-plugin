# CakePHP Geocodable Behavior

This is a simple model behavior plugin that adds latitude and longitude values to your records. This is good for representing physical locations such as stores, venues etc.

## Preparation

Before you use the behavior, you need to add two columns to your database table: `latitude` and `longitude`. These should be of `DECIMAL(10,6)` data type.

## Installation

To install, either clone this repository or add it add a submodule to your project. Both are done in a command line client from the root of your project.

### Cloning the repository

The simplest way is to clone the respository. The command for this is:

    ~ git clone git@github.com:martinbean/cakephp-geocodable-behavior.git app/Plugin/GeocodableBehavior

### Adding as a submodule

Alternatively, you can add the behaviour as a submodule to your project if it’s already version-controlled with Git. To do this, run the following commands:

    ~ git submodule add git@github.com:martinbean/cakephp-geocodable-behavior.git app/Plugin/GeocodableBehavior
    ~ git submodule init

For more information on submodules in Git, read http://git-scm.com/book/en/Git-Tools-Submodules.