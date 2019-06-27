# General Requirements

## Git
To check if git is already installed
```
git –version 
```
https://git-scm.com/downloads

## PHP
Install PHP 7.1 or greater
To check if PHP is already installed
```
php –version 
```
https://php.net/manual/en/install.php

## Composer
To check if Composer is already installed
```
composer
```
https://getcomposer.org/download

run:
```
mv composer.phar /usr/local/bin/composer
composer global require hirak/prestissimo
```

## Xcode
https://itunes.apple.com/us/app/xcode/id497799835?mt=12 

## Drush
To check if Drush is already installed
```
drush –version 
```
https://github.com/drush-ops/drush-launcher#installation---phar
Installation should consist of:
```
curl -OL https://github.com/drush-ops/drush-launcher/releases/download/0.6.0/drush.phar
chmod +x drush.phar
sudo mv drush.phar /usr/local/bin/drush
```

## Vagrant
To check if Vagrant is already installed
```
vagrant version  
```
https://www.vagrantup.com/downloads.html
Then run:
```
vagrant plugin install vagrant-cachier
vagrant plugin install vagrant-vbguest
vagrant plugin install vagrant-hostsupdater
```

## VirtualBox
To check if VirtualBox is already installed
```
vboxmanage –version   
```
https://www.virtualbox.org

You might encounter an error during installation on Mac OS Morave. Try:
- Boot into Recovery Mode via Command-R
- Open terminal
- Run: spctl kext-consent add VB5E2TV963
- Reboot back into the Normal OS environment
- Re-run the install

