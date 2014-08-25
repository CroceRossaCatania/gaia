#!/bin/bash
##
## (c)2014 Croce Rossa Italiana
##

echo " ===== CREAZIONE DELLE SCORCIATOIE ================"

echo " Cancellazione eventuali passate scorciatoie..."
sed -i '/gaia/d' ~/.bashrc
sed -i '/pma/d' ~/.bashrc

echo " Creazione della scorciatoia di Gaia..."
echo "alias gaia='cd ~/gaia; clear; echo \"APRI ===> http://localhost:8888/\"; php -S localhost:8888'" >> ~/.bashrc

echo " Scaricamento di phpMyAdmin..."
wget http://downloads.sourceforge.net/project/phpmyadmin/phpMyAdmin/4.2.7.1/phpMyAdmin-4.2.7.1-all-languages.zip
unzip phpMyAdmin-4.2.7.1-all-languages.zip
mv phpMyAdmin-4.2.7.1-all-languages/ pma

echo " Creazione scorciatoia PMA..."
echo "alias pma='cd ~/pma; clear; echo \"phpMyAdmin (user: gaia) ===> http://localhost:8887/\"; echo " "; php -S localhost:8887'" >> ~/.bashrc

echo " "
echo " [FATTO] "
echo " "
