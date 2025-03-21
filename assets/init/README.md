# REPLACE_THEME_NAME

## Installation

Install the Docker desktop app and docker-compose.

```sh
$ git clone https://github.com/<username>/+++REPLACE_THEME_NAME+++.git
$ cd +++REPLACE_THEME_NAME+++
$ docker-compose up -d
```

It will take a little bit of time to pull the images at first but it only needs to be done once. The server is self-contained and consists of an Apache PHP server, a MariaDB server (because the dev team mostly work with ARM64 Macs), a PHPMyAdmin server, and a Compass SASS watcher.

The Wordpress site can be reached at `localhost:8888` and the PHPMyAdmin GUI `localhost:8080`.

### Starting

In your preferred terminal CD into your project directory and for the first time run: `docker-compose up --build`

All other times you will just need to run: `docker-compose up`

Stopping the stack is either via `command + c` or more gracefully via a terminal command in the root folder of `docker-compose down`.

Run `git init` and then push the new files and folders to your repository. *REMEMBER!* You *must* push the `.env` file to the repo despite it being in the `.gitignore` file. You can do this via `git add .env -f` to force it into the commit list.

We will be splitting this out into separate `.env` (`theme.env`, `development.env` ,`production.env` etc) files in future to remove any chance of sensitive information getting out whilst maintaining functionality.

### Styling

The site is built on top of TwentyTwentyFive theme as a child theme using Gutenberg Blocks. To start editing the CSS edit the files in the `compass/sass/` folder. The processed CSS will automatically be sent to the theme folder in `wp-content/themes/+++REPLACE_THEME_NAME+++-child/`. All stylesheets will be imported into the `style.scss`.

### Modules

This development scaffold has been built with a view to creating something similar to componentisation similar to Create React App or Vite.

To add a new module run: `bash ./add_module.sh` from the project root. Follow the on-screen instructions.

### Debugging

PHP debugging is provided via XDebug and requires a little bit of set-up.

### Troubleshooting

*REMEMBER!* Prune your dangling containers and orphan or stale images. They build up over time and not only use resources but overlap network assignations. Run `docker images prune` to remove dangling images.

If you start to get network issues then you can run `docker network ls` to see what networks are currently running and stop them.

## Donations

If you find this boilerplate useful consider buying me a coffee: https://www.paypal.com/donate/?hosted_button_id=FA5Z4XMVJ6KZC