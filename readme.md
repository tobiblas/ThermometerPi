* First connect DS18S20 to 3.3V, GND and GPIO 4.

* then add

dtoverlay=w1-gpio

to /boot/config.txt

and reboot (sudo reboot)

* run:
sudo modprobe w1-gpio
sudo modprobe w1-therm
cd /sys/bus/w1/devices
ls
cd 28-xxxx (change this to match what serial number pops up)
cat w1_slave

#install pytz (timezone support)
sudo pip install pytz

#enable sqlite3 for php
sudo apt-get install php5-sqlite

#DATABASE STUFF
create the database temperature.db
make sure it is read and writeable PLUS that the folder it is in is readable/writable by php


There it is!

