# Real-time Earthquake Data Visualization tool

## Application Overview and Design

Proscovia Olango (p.olango@gu.ac.ug), Geoffrey Tabo (g.tabo@gu.ac.ug), Daniel Ogenrwot (danielogen@gmail.com), 

### Overview

The United States Geological Survey (USGS) provides enormous impartial information on a number of things including natural hazards like earthquakes which occur all over the world. Although USGS presents the daily information about earthquakes on a world map, earlier information is provided as RSS feeds which are difficult for people interested in information about earthquake to understand because it is large and abstract. In order to present the RSS feeds information that is easily understood, we developed a tool that presents real time information on the global map using Information Retrieval and Data Visualization techniques.

### Features

This tool was developed to be easily extendable. Features included are quiet limited as of the writing of this document but newer versions will surely constitute rich feature. Below are lists of features intergrated in this first version.

- Visual earthquake by places and dates
- Google maps markers customization
- Maps markers description
- Flexible legend
- Responsive design feature (Map is not yet responsive enough)

### Design
This visualization tool was entire developed on the LAMP environment. Because this tool was meant to be lightweight and faster, Google maps and JSON was heavily used. Support for small screens (e.g. mobile devices) was also highly consider.

### Core Technologies

As of the writing of this document, some of the core technologies that Tower DB uses include:

-   PHP 5.4.10
-   MySQL 5.5.29

### Other Technologies

Other dependencies that are bundled with the application include:

#### JavaScript Libraries

-   jQuery 1.9.1 – base jQuery JavaScript library
-   jQuery-ui-1.10.3 - JavaScript library for user interface
    interactions, effects, widgets, and themes
-   jQuery-ui-map-3.0 – A Google-developed JavaScript library for
    rendering maps

#### CSS

For UI support, this tool uses:

-   Twitter Bootstrap 2.3.2 – Provides the site’s base CSS

### Screen Shots

### Installation


-   Clone this Git repository (or download the ZIP and unpack the files) into your webroot.  I prefer to use a VirtualHost that points to the directory as the HTTP root.
-   Create a MySQL database and MySQL user.  I believe the MySQL user needs the following permissions:
```
ALTER, CREATE TEMPORARY TABLES, CREATE, DELETE, DROP, SELECT, INSERT, UPDATE, REFERENCES, INDEX, LOCK TABLES
```
-   Populate it using the schema (.sql) file located in db directory.
-   Change the DBSERVER NAME, DBUSER NAME and DBPASS PASSWORD located in the constant.php file
-   Restart your web server and point it at your URL. 

### Errata
