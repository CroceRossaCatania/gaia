#!/bin/bash
##
## (c)2014 Croce Rossa Italiana
##

echo " ===== PRIMA QUALCHE INFORMAZIONE SU DI TE ================"
echo " - Inserisci email di GitHub (es.: mario.rossi@gmail.com)"
read email
echo " - Inserisci il tuo nome completo (es.: Mario Rossi)"
read nome
echo " "

clear
echo "Impostazione di GIT..."
git config --global user.email $email
git config --global user.name $nome

clear
echo " "
echo " ===== CONFIGURAZIONE DATABASE =================="
echo " - Inserisci la password di root di MySQL"
read pmysql 

clear
echo " "
echo " ===== INSTALLAZIONE DATABASE ==================="
echo " - Creazione database 'gaia'..."
echo "CREATE DATABASE gaia;" | mysql -u root --password=$pmysql
echo " - Creazione utente 'gaia'..."
echo "GRANT ALL ON gaia.* TO gaia@localhost IDENTIFIED BY '$pmysql';" | mysql -u root --password=$pmysql
echo "FLUSH PRIVILEGES;" | mysql -u root --password=$pmysql
echo " - Importazione database..."
cat upload/setup/gaia.sql | mysql -u gaia --password=$pmysql --database=gaia

echo " "
echo " ===== PREPARAZIONE CONFIGURAZIONE DI BASE ======"
cp -f core/conf/sample/* core/conf/
sed -i 's/DATABASE_NAME/gaia/g' core/conf/database.php
sed -i 's/DATABASE_USER/gaia/g' core/conf/database.php
sed -i "s/DATABASE_PASSWORD/$pmysql/g" core/conf/database.php
sed -i "s/DBNAME/gaia/g" core/conf/mongodb.php

clear
echo " "
echo " ===== CONFIGURAZIONE MANUALE ===================="
echo " E' ora necessario che modifichi alcuni file in:"
echo "   core/conf/*.php"
echo " Con i tuoi parametri di configurazione."
echo " "
echo " Premi un tasto quando hai finito."
read

clear
echo " "
echo " [FATTO]"
echo " La configurazione di base e' stata effettuata."
echo " "
echo " ===== IMPORTANTE ================================"
echo " Avviare Gaia usando il comando:"
echo "   gaia"
echo " E dirigersi all'indirizzo:"
echo "   http://localhost:8888/setup.php"
echo " Per completare l'installazione."
echo " "
echo " Premi un tasto per confermare."
read

echo " ... Non dimenticarlo!"
