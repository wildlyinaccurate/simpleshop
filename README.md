# Simple Shop

Simple Shop is a PyroCMS module that provides a simple way of managing an online store. It is currently in development.

## Requirements

Simple Shop was built on PyroCMS 2.0, and requires a minimum of PHP 5.3.0 to run. For greatly improved performance, you should use a caching system - APC is recommended.

## Installation

Installing Simple Shop should be as simple as putting the simpleshop folder into your PyroCMS modules folder.

## Caching

Simple Shop uses [Doctrine ORM](http://php.net/manual/en/memcached.construct.php). When dealing with large amounts of data, Doctrine can be quite resource hungry. A PHP bytecode cache will provide significant performance benefits, especially to sites that receive a high amount of traffic. Simple Shop will automatically detect if a caching system is installed on your server. Supported systems are APC, Memcache, Memcached, and XCache. Memcache requires some additional configuration (see below).

### Using Memcache with Simple Shop

If you use Memcache, you will need to configure Simple Shop's caching mechanism to work with your Memcache server. You will find the Memcache configuration around line 55 of `simpleshop/libraries/Doctrine.php`. Simply enter your Memcache server information the `$memcache->connect()` call.

