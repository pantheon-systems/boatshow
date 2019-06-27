# BLT General Requirements

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

## Python
To check if Python is already installed
```
python –version    
```
To install Python, run:
```
sudo easy_install pip    
```

## Ansible
To check if Ansible is already installed
```
ansible –version    
```
To install Ansible, run
```
sudo pip install ansible   
```
To update Ansible, run
```
sudo pip install ansible –upgrade   
```

## Drupal VM
Check installation video for mac OS at: http://docs.drupalvm.com/en/latest/getting-started/installation-macos/
Download Drupal VM at: https://www.drupalvm.com/
Additional instruction can be found at:
- http://docs.drupalvm.com/en/latest/
- https://github.com/geerlingguy/drupal-vm#quick-start-guide

## ssh-key
Instruction about ssh-key can be found at: https://docs.acquia.com/acquia-cloud/manage/ssh/generate/
To check if a public key already exists:
```
cd ~/.ssh ls -l 
```
To create an ssh-key: 
```
ssh-keygen -b 4096
hit enter until done
```
To copy your key to the clipboard: 
```
pbcopy < ~/.ssh/id_rsa.pub
```

Your ssh-key needs to be added to:
- Your Git profile
- Your profile in Acquia (https://cloud.acquia.com)

## Node.js & npm
Use either
```
brew install nvm
```
Download Noje.js at: https://nodejs.org/en/

or 

run:
```
nvm install 9.11.2
nvm use 9.11.2
```

  
    
---
## Ressources
Drupal VM Documentation  
http://docs.drupalvm.com/en/latest/

Acquia BLT Documentation  
https://docs.acquia.com/blt/

Acquia BLT Onboarding Documentation  
https://docs.acquia.com/blt/developer/onboarding/
