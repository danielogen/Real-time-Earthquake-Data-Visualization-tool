# Real-time Earthquake Data Visualization tool

## Application Overview and Design

Proscovia Olango (p.olango@gu.ac.ug), Geoffrey Tabo (g.tabo@gu.ac.ug), Daniel Ogenrwot (d.ogenrwot@gu.ac.ug), 

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
This visualization tool was entirely developed on the LAMP environment. Because this tool was meant to be lightweight and faster, Google maps and JSON was heavily used. Support for small screens (e.g. mobile devices) was also highly consider.

### Core Technologies

As of the writing of this document, some of the core technologies that this tool uses include:

-   PHP 5.6.2
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

-   Twitter Bootstrap 3.0.1 – Provides the site’s base CSS

### Screen Shots

![result-3](https://cloud.githubusercontent.com/assets/15224992/17620676/9c4ad9e2-6096-11e6-9e13-eca2428cd708.PNG)
![result-2](https://cloud.githubusercontent.com/assets/15224992/17620677/9c514700-6096-11e6-9656-5c4c6d1c064e.PNG)
![result-1](https://cloud.githubusercontent.com/assets/15224992/17620678/9c52047e-6096-11e6-9b03-ee459885af5f.PNG)


### Installation


-   Clone this Git repository (or download the ZIP and unpack the files) into your webroot.  I prefer to use a VirtualHost that points to the directory as the HTTP root.
-   Create a MySQL database and MySQL user.  I believe the MySQL user needs the following permissions:
```
ALTER, CREATE TEMPORARY TABLES, CREATE, DELETE, DROP, SELECT, INSERT, UPDATE, REFERENCES, INDEX, LOCK TABLES
```
-   Populate it using the schema (.sql) file located in db directory.
-   Change the DBSERVER NAME, DBUSER NAME and DBPASS PASSWORD located in the **constant.php** file
-   Restart your web server and point it at your URL. 

### Errata

For any assistance or correction, please write an email to any of the author listed above.
