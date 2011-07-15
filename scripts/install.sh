#!/bin/bash

echo "###################################################"
echo "#                                                 #"
echo "#        Zend Framework Skeleton Installer        #"
echo "#                                                 #"
echo "###################################################"
echo -e "\n- Getting current folder path"

# Get current foldername
currentFolder=`basename \`pwd\``

# Check if we are executing the script inside scripts folder or in the root folder
if [ $currentFolder == "scripts" ] ; then
    prefix='../'
else
    prefix='./'
fi

# Create a few folders
echo "- Creating log folder"
mkdir "${prefix}logs"
mkdir "${prefix}logs/backoffice"
mkdir "${prefix}logs/backoffice/missing_translations"
mkdir "${prefix}logs/frontend"
mkdir "${prefix}logs/frontend/missing_translations"

echo "- Creating cache folder"
mkdir "${prefix}cache"

echo "- Creating temporary folder"
mkdir "${prefix}public/frontend/tmp"

# Copy the config files
echo "- Copying environment file"
cp -n "${prefix}application/configs/environment.example.php" "${prefix}application/configs/environment.php"

echo "- Copying config file"
cp -n "${prefix}application/configs/application.example.ini" "${prefix}application/configs/application.ini"

# Getting db parameters from the user
echo "- Customizing config file"
read -p "      Enter the database name: " dbName
read -p "      Enter the database username: " dbUsername
read -p "      Enter the database password: " dbPassword
read -p "      Enter the database host (ip or hostname): " dbHost

# Modifying config file
echo "- Modifying config file"
sed -i -e "9s/.*/resources.db.params.dbname = \"$dbName\"/" ${prefix}application/configs/application.ini
sed -i -e "10s/.*/resources.db.params.username = \"$dbUsername\"/" ${prefix}application/configs/application.ini
sed -i -e "11s/.*/resources.db.params.password = \"$dbPassword\"/" ${prefix}application/configs/application.ini
sed -i -e "12s/.*/resources.db.params.host = \"$dbHost\"/" ${prefix}application/configs/application.ini

# Create the log files
echo "- Creating log files"
touch "${prefix}logs/backoffice/flagflippers.log"
touch "${prefix}logs/backoffice/general.log"
touch "${prefix}logs/backoffice/mailer.log"
touch "${prefix}logs/frontend/flagflippers.log"
touch "${prefix}logs/frontend/general.log"
touch "${prefix}logs/frontend/mailer.log"
touch "${prefix}logs/frontend/gateway.log"

# Give read/write access to the logs and cache folders
echo "- Giving permissions to log and cache folders"
chmod -R 777 "${prefix}logs"
chmod -R 777 "${prefix}cache"

# Install the AkRabat migration tool
echo "- Installing AkRabat migration tool"
${prefix}bin/zf.sh --setup storage-directory
${prefix}bin/zf.sh --setup config-file
echo 'basicloader.classes.0 = "Akrabat_Tool_DatabaseSchemaProvider"' > ~/.zf.ini

# Run the migrations
echo "- Running the DB migrations"
${prefix}bin/zf.sh update database-schema

echo -e "\nInstallation finished"