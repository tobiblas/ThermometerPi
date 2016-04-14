import os
import subprocess
from tempfile import mkstemp
from shutil import move
from os import remove, close

################# APACHE2 ####################################

print "Checking for apache installation..."

apache2path = subprocess.Popen("which apache2", shell=True, stdout=subprocess.PIPE).stdout.read()

if "apache2" not in apache2path:
    print "installing apache web server (might take a while..)"
    print subprocess.Popen("sudo apt-get install apache2 -y", shell=True, stdout=subprocess.PIPE).stdout.read()
else:
    print "apache already installed. Skipping"
    print "-----------"

################# PHP ########################################

print "Checking for php installation..."

phpPath = subprocess.Popen("which php", shell=True, stdout=subprocess.PIPE).stdout.read()

if "php" not in phpPath:
    print "installing php  (might take a while..)"
    print subprocess.Popen("sudo apt-get install php5 libapache2-mod-php5 -y", shell=True, stdout=subprocess.PIPE).stdout.read()
else:
    print "php already installed. Skipping"

print "-----------"

################# SQLITE3 ########################################

print "Checking for sqlite3 installation..."

phpPath = subprocess.Popen("which sqlite3", shell=True, stdout=subprocess.PIPE).stdout.read()

if "sqlite3" not in phpPath:
    print "installing sqlite3  (might take a while..)"
    print subprocess.Popen("sudo apt-get install sqlite3 -y", shell=True, stdout=subprocess.PIPE).stdout.read()
else:
    print "sqlite3 already installed. Skipping"

print "-----------"

################# MOVE PHP PAGE TO RIGHT PLACE ###############

print "adding php admin page for thermometer."
print "installing php pages in /var/www/html/"

print subprocess.Popen("sudo mkdir -p /var/www/html/thermometer && sudo cp -R php/* /var/www/html/thermometer", shell=True, stdout=subprocess.PIPE).stdout.read()

print "-----------"

#################ALARM FILES, CONFIG ETC######################
thermoPath = "/home/pi/thermometer"

print "Installing thermometer files in " + thermoPath
print subprocess.Popen("mkdir -p " + thermoPath, shell=True, stdout=subprocess.PIPE).stdout.read()
if not thermoPath.endswith("/"):
	thermoPath += "/"
print subprocess.Popen("cp -R thermometer/* " + thermoPath, shell=True, stdout=subprocess.PIPE).stdout.read()

#if isServer:
#    print "Adding alarm home to admin.properties"
#    print subprocess.Popen('echo "alarm_home:' + alarmPath + '" | sudo tee /var/www/html/alarm/admin.properties', shell=True, stdout=subprocess.PIPE).stdout.read()
#    print "Making the alarm application available for the php server"
#    print subprocess.Popen('sudo chmod 777 ' + alarmPath + '/*', shell=True, stdout=subprocess.PIPE).stdout.read()
#    print subprocess.Popen('sudo chmod 777 /var/www/html/alarm/admin.properties', shell=True, stdout=subprocess.PIPE).stdout.read()


##############################################################

print
print "Congratulation! Now go to " + thermoPath + "settings.properties and fill in the necessary data."
