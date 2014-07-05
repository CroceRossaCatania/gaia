#!/bin/bash
##
## (c)2014 Croce Rossa Italiana
##

clear
echo "Questo programma installera' le dipendenze di Gaia sul tuo sistema Ubuntu"
echo " "
echo " ===== ATTENZIONE ========================================="
echo " | Se il sistema NON e' UBUNTU, questo programma fallira' |"
echo " | In tal caso, USCIRE ORA premendo CTRL + C              |"
echo " ----------------------------------------------------------"
echo " "
echo "Premere un tasto per continuare"
read

clear
echo "Aggiunta dei repository in corso..."
# Repository: ondrej's php5
sudo add-apt-repository --yes ppa:ondrej/php5
sudo add-apt-repository --yes ppa:ondrej/mysql-5.6
# Repository: mongodb
sudo apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 7F0CEB10
echo 'deb http://downloads-distro.mongodb.org/repo/ubuntu-upstart dist 10gen' | sudo tee /etc/apt/sources.list.d/mongodb.list

clear
echo "Aggiornamento delle sorgenti software..."
sudo apt-get update

# Installazione software
echo "Installazione del software necessario a Gaia..."
sudo apt-get install --yes wget sed unzip nano php5-cli php5-common php-pear php-mail mysql-server php5-dev php5-mysql redis-server mongodb-10gen

echo "Installazione della estensione Mongo..."
sudo pecl install mongo

# Aggiungi i moduli necessari al php.ini
if [ -f /etc/php5/cli/php.ini ];then
	echo "Impostazione di PHP CLI..."
	sudo sed -i '/mongo\.so/d' /etc/php5/cli/php.ini
	sudo -- bash -c "echo 'extension=mongo.so' >> /etc/php5/cli/php.ini"
	sudo killall php 2> /dev/null
fi
if [ -f /etc/php5/apache2/php.ini ];then
	echo "Impostazione del modulo PHP per Apache2..."
	sudo sed -i '/mongo\.so/d' /etc/php5/apache2/php.ini
	sudo -- bash -c "echo 'extension=mongo.so' >> /etc/php5/apache2/php.ini"
	sudo service apache2 restart
fi
if [ -f /etc/php5/fpm/php.ini ];then
	echo "Impostazione del modulo PHP5-FPM..."
	sudo sed -i '/mongo\.so/d' /etc/php5/fpm/php.ini
	sudo -- bash -c "echo 'extension=mongo.so' >> /etc/php5/fpm/php.ini"
	sudo service php5-fpm restart
fi

echo "Installazione della estensione Redis..."
sudo pecl install redis

if [ -f /etc/php5/cli/php.ini ];then
	echo "Impostazione di PHP CLI..."
	sudo sed -i '/redis\.so/d' /etc/php5/cli/php.ini
	sudo -- bash -c "echo 'extension=redis.so' >> /etc/php5/cli/php.ini"
	sudo killall php 2> /dev/null
fi
if [ -f /etc/php5/apache2/php.ini ];then
	echo "Impostazione del modulo PHP per Apache2..."
	sudo sed -i '/redis\.so/d' /etc/php5/apache2/php.ini
	sudo -- bash -c "echo 'extension=redis.so' >> /etc/php5/apache2/php.ini"
	sudo service apache2 restart
fi
if [ -f /etc/php5/fpm/php.ini ];then
	echo "Impostazione del modulo PHP5-FPM..."
	sudo sed -i '/redis\.so/d' /etc/php5/fpm/php.ini
	sudo -- bash -c "echo 'extension=redis.so' >> /etc/php5/fpm/php.ini"
	sudo service php5-fpm restart
fi

echo "Riavvio dei vari servizi..."
sudo service mongodb restart
sudo service apache2 restart

clear
echo " "
echo " [FATTO]"
echo " Tutte le dipendenze dovrebbero ora essere installate."
