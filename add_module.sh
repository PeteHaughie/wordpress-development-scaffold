#!/bin/bash

source .env

function validate_input() {
    read -p "Your module will be called “m_$1” is this correct? y/n: " confirm
    case $confirm in
        [Yy]* ) return 0;;
        [Nn]* ) return 1;;
        * ) echo "Please answer yes or no."; validate_input $1;;
    esac
}

function validate_js() {
    read -p "Does “m_$1” use javascript? y/n: " js
    case $js in
        [Yy]* ) return 0;;
        [Nn]* ) return 1;;
        * ) echo "Please answer yes or no."; validate_js $1;;
    esac
}

function add_module() {
    name=$1
    js=$2
    echo "Adding PHP"
    /usr/bin/awk -v n=$1 '/\/\/ Insert new modules here/{
        print "        // register the " n " module"
        print "        acf_register_block_type("
        print "            array("
        print "                '\''name'\'' => '\''" n "'\'',"
        print "                '\''title'\'' => __('\''Module " n "'\''),"
        print "                '\''description'\'' => __('\''My Module - " n "'\''),"
        print "                '\''render_template'\'' => '\''template-parts/modules/" n "/" n ".php'\'',"
        if(j == 0) print "                '\''enqueue_script'\'' => get_stylesheet_directory_uri() . '\''/template-parts/modules/" n "/" n ".js'\'',"
        print "                '\''render_callback'\'' => '\''my_acf_block_render_callback'\'',"
        print "                '\''category'\'' => '\''formatting'\'',"
        print "                '\''icon'\'' => '\''admin-home'\'',"
        print "                '\''keywords'\'' => array('\''" n "'\'', '\''quote'\''),"
        print "            )"
        print "        );"
        print "    "
    }1' "${PWD}/wp-content/themes/${THEME_NAME}/functions.php" > tmp && mv tmp "${PWD}/wp-content/themes/${THEME_NAME}/functions.php"
    # make the folder as it doesn't exist yet
    mkdir -p "${PWD}/wp-content/themes/${THEME_NAME}/template-parts/modules/${name}"
    cp "${PWD}/assets/module/module.php" "${PWD}/wp-content/themes/${THEME_NAME}/template-parts/modules/${name}/${name}.php"
    sed -i '' "s|+++MODULE+++|${name}|g" "${PWD}/wp-content/themes/${THEME_NAME}/template-parts/modules/${name}/${name}.php"
    sed -i '' "s|+++REPLACE_THEME_NAME+++|${THEME_NAME}|g" "${PWD}/wp-content/themes/${THEME_NAME}/template-parts/modules/${name}/${name}.php"
}

function add_js() {
    name=$1
    echo "Adding JS"
    cp "${PWD}/assets/module/module.js" "${PWD}/wp-content/themes/${THEME_NAME}/template-parts/modules/${name}/${name}.js"
    sed -i '' "s|+++MODULE+++|${name}|g" "${PWD}/wp-content/themes/${THEME_NAME}/template-parts/modules/${name}/${name}.js"
    sed -i '' "s|+++REPLACE_THEME_NAME+++|${THEME_NAME}|g" "${PWD}/wp-content/themes/${THEME_NAME}/template-parts/modules/${name}/${name}.js"
}

function add_scss() {
    name=$1
    echo "Adding SCSS"
    /usr/bin/awk -v n=$1 '/\/\/ Insert new modules here/{
        print "@import '\''./_modules/" n ".scss'\'';"
        print ""
        print $0
        next
    }1' "${PWD}/compass/sass/style.scss" > tmp && mv tmp "${PWD}/compass/sass/style.scss"
    cp "${PWD}/assets/module/module.scss" "${PWD}/compass/sass/_modules/${name}.scss"
    sed -i '' "s|+++MODULE+++|${name}|g" "${PWD}/compass/sass/_modules/${name}.scss"
}

function main() {
    while true; do
        read -p "Name of the module: " module

        if validate_input $module; then
            if validate_js $module; then
                # The module uses Javascript
                add_module "m_$module" 0
                add_scss "m_$module"
                add_js "m_$module"
            else
                # The module doesn't use Javascript
                add_module "m_$module" 1
                add_scss "m_$module"
            fi

            read -p "Do you want to generate any more modules? y/n: " more_modules
            case $more_modules in
                [Yy]* ) continue;;
                [Nn]* ) echo "Happy coding!"; exit 0;;
                * ) echo "Please answer yes or no.";;
            esac
        fi
    done
}

main
