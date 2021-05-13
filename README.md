# degreeauditspring
# About this project

This Degree Audit tool is a senior capstone project at UTD for UTD Design
The main objective was to make a tool which helps advisors navigate the course advising process. Streamlining it and making the experience as seamless as possible, tailored to a virtual


## Installation

Instruction for setting up project
```bash

sudo apt install -y apache2 apache2-utils
```
```bash
sudo apt install mysql-server
```

set mysql- password
```bash
mysql -u root -p
```

```bash
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '<choose your password>';
FLUSH PRIVILEGES;
```

Instructions for adding repository php 7 in ubuntu 16.04:
```bash
sudo add-apt-repository ppa:ondrej/php
```
```bash
sudo apt-get install software-properties-common
```
```bash
sudo apt-get install python-software-properties 0r software-properties-common
```


```bash
sudo apt install php7.3 libapache2-mod-php7.3 php7.3-mysql
```
```bash
sudo apt-get install phpmyadmin
```

```bash
sudo nano /etc/apache2/apache2.conf
```
paste this line at the end of file:
```bash
include /etc/phpmyadmin/apache.conf
```

In your ubuntu server go to your terminal type:

```bash
cd /var/www/html
```

```bash
git clone <https://github.com/eliseorobles/degreeauditspring>
```

```bash
apt install composer
```

```bash
composer install
```


in a web browser go to ipaddress/phpmyadmin
enter root as user name
enter password you put when creating mysqlserver

create a new database to keep track of the name of this DB for the following step

import the DB schema  with the following file Project_DB_Schema.sql

go to your project folder and open the .env file and find DB_DATABASE variable and set it to the name of the database you gave in

phpmyadmin like so DB_DATABASE=DB_NAME_YOU_GAVE  and set the password PASSWORD=<PASSWORD_YOUGAVE>

sudo service apache2 restart

now type ipaddress in browser

you should now be able to access our application anywhere with this IP address 


## Future Improvements
We sadly ran out of time during the semester for the project, we have attached the future features the advisors have requested in order to make this tool complete.
Please make sure to update tests as appropriate.

* Add other degree plans to application
* Implement Coursebook scraping web snippet
* Implement PreReq logic for other majors
* Dropdown of future courses to take based on prereq logic
* Implementation on UTD Servers
* Make Transfer student Credit Validation for equivalent courses at UTD


## License
[MIT](https://choosealicense.com/licenses/mit/)
