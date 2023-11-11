@echo off

set APP_URL=http://avr.local
set CLIENT_ID=1
set CLIENT_SECRET=mSxVdnCyW8A5mHCD3w8pynkRNrLD18o7WaMzrstB
set EMAIL=test@example.com
set PASSWORD=password

curl -X POST %APP_URL%/oauth/token -d "grant_type=password" -d "client_id=%CLIENT_ID%" -d "client_secret=%CLIENT_SECRET%" -d "username=%EMAIL%" -d "password=%PASSWORD%"
