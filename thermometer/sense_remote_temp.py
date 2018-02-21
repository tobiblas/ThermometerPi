#!/usr/bin/env python
# -*- coding: utf-8 -*-
from __future__ import with_statement
from subprocess import call
import time
import sys
import urllib2
import threading
from urllib2 import URLError
import sqlite3
import json
import pytz
from datetime import datetime

if len(sys.argv) < 2:
    print "Usage: python sense_remote_temp.py temp_home <OPTIONAL:label>"
    sys.exit()
location = sys.argv[1]
label = None
if len(sys.argv) == 3:
    label = sys.argv[2]

if not location.endswith("/"):
    location += "/"

addTime = 0

def fetchFrom(url, attemptsLeft):
    print "Fetching from " + url + " attempts left " + str(attemptsLeft)
    try:
        response = urllib2.urlopen(url)
        if not response.code == 200:
            response.close()
            print "ERROR! Did not get 200 response"
            if (attemptsLeft > 0):
                print "Retrying..."
                return fetchFrom(url, attemptsLeft-1)
        else:
            body = response.read()
            print "Got response: " + body.rstrip()
            response.close()
            return body.rstrip()
    except URLError, e:
        if (attemptsLeft > 0):
            print "Retrying..."
            return fetchFrom(url, attemptsLeft-1)

def createTables(cursor):
    sql = "create table if not exists temperature (timestamp INTEGER PRIMARY KEY, location TEXT, temp REAL, label TEXT)"
    cursor.execute(sql)
    sql = "create index if not exists TEMP_IDX on temperature(timestamp)"
    cursor.execute(sql)


def saveTemp(temperature, device):
    global addTime
    dbName = "/home/pi/temperature.db"
    conn = sqlite3.connect(dbName)
    c = conn.cursor()
    createTables(c)
    tz = pytz.timezone('Europe/Berlin')
    tzOffsetInSeconds = tz.utcoffset(datetime.now()).total_seconds()
    epoch_time = int(time.time() + tzOffsetInSeconds) + addTime
    addTime = addTime + 1
    sql = ""
    if label is None:
        sql = "insert into temperature values("+ str(epoch_time) +", \""+ device +"\", " + str(temperature) + ",null)"
    else:
        sql = "insert into temperature values("+ str(epoch_time) +", \""+ device +"\", " + str(temperature) + ",\"" + label + "\")"
    print sql
    c.execute(sql)
    conn.commit()
    conn.close()

def fetchOutdoorTemp(myprops):

    apiKey = myprops['openweatherApiKey']
    location = myprops['outdoorLocation']
    unit = myprops['unit']

    requestStr = 'http://api.openweathermap.org/data/2.5/weather?q=' + location + '&appid=' + apiKey + '&units=metric'
    temp = fetchFrom(requestStr, 3)

    j = json.loads(temp)
    saveTemp(float(j['main']['temp']), location)

def remoteFetchTemp():
    print "Fetching remote temp"

    myprops = {}
    with open(location + 'admin.properties', 'r') as f:
        for line in f:
            line = line.rstrip() #removes trailing whitespace and '\n' chars

            if ":" not in line: continue #skips blanks and comments w/o =
            if line.startswith("#"): continue #skips comments which contain =

            k, v = line.split(":", 1)
            myprops[k] = v
    print myprops

    ips = myprops['deviceIPs']
    devices = myprops['devices']
    devicesSplit = devices.split(",")

    i = 0
    if label is None:
        for line in ips.split(","):
            url = "http://" + line.strip() + "/thermometer/current_temp.php"
            temperature = fetchFrom(url, 3)
            if temperature is None:
                print "Could not connect to " + url + ". trying one more time in 10 seconds"
                time.sleep(10)
                temperature = fetchFrom(url, 3)
            if temperature is None:
                print "Failed once more."
            else:
                print "got temp " + temperature + " in " + devicesSplit[i]
                saveTemp(float(temperature) - 273.15, devicesSplit[i])
            i = i + 1

    if 'openweatherApiKey' in myprops.keys() and myprops['openweatherApiKey'].strip() != "":
        fetchOutdoorTemp(myprops)


remoteFetchTemp()
