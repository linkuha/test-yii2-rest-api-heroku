#!/usr/bin/env bash

if [ -n "$DYNO" ]
then
    php init --env=Heroku --overwrite=All
    ln -s /api/web api/web
    ln -s /frontend/web frontend/web
    ln -s /backend/web backend/web
    ln -s /vendor/bower-asset vendor/bower
fi