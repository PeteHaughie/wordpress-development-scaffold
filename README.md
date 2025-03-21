# Development Scaffold

This is a starter stack for WordPress development. It is highly opinionated but a very very fast way to get up and running from nothing.

It was originally created by me for a company I worked for who no longer do web development and it was too useful to let rot.

## Installation

Install Docker and docker-compose.

Install VSCode.

Run the `init.sh` script. Enter your desired theme name using only characters and hyphens, eg: `my-new-theme`
Enter the client name or abbreviation for the DB prefix, eg `ph` or `acme`.

The script then reads the new .env file for the “THEME_NAME” variable and uses that to fill in areas of the project that can't utilise external files such as `.gitignore` and `docker-compose.yml`. These files are in the `/assets/init` folder which have placeholder strings which is then replaced with the correct value when the script runs.
