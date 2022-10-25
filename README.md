# Annuaire NWS

## The project

### About

This was initially a school project that I decided to upgrade.
It's a directory application meant to help schools register users
during events like open days.

### Features

-> Registering Students \
-> Creating Events \
-> User authentification \
-> Filtering / Sorting \
-> & More.


## Setup

### Installation

-> Download ZIP file

-> Open the terminal and run `cd frontend`

-> Install the dependencies by running `npm install` \
(NodeJS required : https://nodejs.org/en/)

-> Fill the `.env.exemple` in /frontend \
(Then rename it to `.env`)

-> Create the database using the SQL Script : `db.sql` in /scripts \
(Careful : If you already have a database named `annuaire_nws`, \
you may want to change it, as it will overwrite it.)

-> Fill the `settings.exemple.json` in /api/config \
(Then rename it to `settings.json`)

-> Default App logs in `/scripts/logs.txt`

### Running

-> Open the terminal

-> Make sure you're in the root directory

-> Type in `npm run start`

-> Run your local server \
(I personally used Wamp)

-> You're good to go !


## Techologies

## Front-end

-> HTML / CSS \
-> JavaScript \
-> React

## Back-end

-> PHP (v. 8.1.0) \
-> MySQL (v. 8.0.27) \
-> Wampserver (v. 3.2.6)


## Miscellaneous

### Copyrights

Code written by Sébastien Gervilla. \
License : MIT - Copyright Free.
