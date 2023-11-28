# Spotlister

A web application for playlist management, using [SpotDL](https://github.com/spotDL/spotify-downloader).
Currently only tested with GNU/Linux.

**Setup**

We don't use any package managers like composer. Only PHP and some of it's modules are necessary.

## *1. Clone the repository*

Use `git clone` or whatever method you prefer to clone the repository:

```
git clone https://github.com/archlich03/spotlister.git
``` 

## *2. Install PHP and dependencies*

Install PHP on your system. You can find guides on how to do so for your distribution online. On Ubuntu/Debian, it's:

```
sudo apt install --no-install-recommends php8.1
```

Don't forget to also install all the base packages:

```
sudo apt-get install -y php8.1-cli php8.1-common php8.1-mysql php8.1-zip php8.1-gd php8.1-mbstring php8.1-curl php8.1-xml php8.1-bcmath
```

## *3. Install MariaDB*

This project uses MariaDB. You can use another kind of database if you like.

On Ubuntu/Debian, do:

```
sudo apt install mariadb-server
```

And then start the service by:

```
sudo systemctl start mariadb.service
```

All that's left is to setup the DB user.

Note: **We're assuming you're using this for personal purposes. Make sure to modify your settings for security accordingly if you're making it public.**

Configure the installation using:

```
sudo mysql_secure_installation
```

When shown this, press enter to continue:
```
NOTE: RUNNING ALL PARTS OF THIS SCRIPT IS RECOMMENDED FOR ALL MariaDB
      SERVERS IN PRODUCTION USE!  PLEASE READ EACH STEP CAREFULLY!

In order to log into MariaDB to secure it, we'll need the current
password for the root user.  If you've just installed MariaDB, and
you haven't set the root password yet, the password will be blank,
so you should just press enter here.

Enter current password for root (enter for none): 
```

When given this prompt, select no:

```
OK, successfully used password, moving on...

Setting the root password ensures that nobody can log into the MariaDB
root user without the proper authorisation.

Set root password? [Y/n] N
```

After this, accept any default options you're given.

We then need to configure the DB user for the app. Enter mariadb using:

```
sudo mariadb
```

Replace `spotlister` with the DB username you want, and `password` with the password you wish to use.

```
GRANT ALL ON *.* TO 'spotlister'@'localhost' IDENTIFIED BY 'password' WITH GRANT OPTION;
```
Then use:

```
FLUSH PRIVILEGES;
```

Create the database for the application:

```
CREATE DATABASE spotlister;
```

After this, you can exit the configuration.

```
exit
```

## *4. Change the default settings*

Navigate to `conf.php` in your cloned repository folder. Change the following:

```
$settings['serverName'] = "localhost"; // name of the DB server
$settings['userName'] = "spotlister"; // name of the DB user
$settings['password'] = "test"; // password of the DB user
$settings['dbName'] = "spotlister"; // name of the DB
```

With the settings you defined in the mariaDB setup.

## *5. Getting SpotDL*

You can get SpotDL from [here](https://github.com/spotDL/spotify-downloader). You need the `spotdl-4.2.0-linux` file.

Once downloaded, place it in the `scripts/` folder.

**Note: If you've downloaded a later version of spotDL, make sure to change the spotDL executable's version in `readDB.py` so that it would match the new one.**

## *6. Launching the app*

Navigate to the folder where you cloned the repository, and type:

```
php -S localhost:8000
```

This starts the development server. You can navigate to it in your favorite web browser:

![image](https://github.com/archlich03/spotlister/assets/129758495/211c4cc1-8447-42e3-af4a-080ac11f0e68)

That's it!

