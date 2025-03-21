#! /bin/bash

YEAR=$(date +%Y)

# Prompt the user for input
read -p "Enter a client name (ie: acme): " CLIENT
read -p "Enter a db prefix (ie: tm): " PREFIX
read -p "Enter an author name (ie: Pete Haughie): " AUTHOR_NAME
read -p "Enter an author uri (ie: https://www.petehaughie.com/): " AUTHOR_URI

# Get a list of themes in wp-content/themes folder
THEMES=($(ls -d wp-content/themes/*/))

# Prompt the user to select a starting theme
echo "Select a starting theme:"
for i in "${!THEMES[@]}"; do
    printf "%s. %s\n" "$((i+1))" "${THEMES[i]%/}"
done

# Read the user's theme selection
read -p "Enter the number corresponding to the theme: " THEME_NUMBER

# Validate and set the selected theme
if [[ $THEME_NUMBER =~ ^[0-9]+$ ]] && (( THEME_NUMBER >= 1 )) && (( THEME_NUMBER <= ${#THEMES[@]} )); then
    THEME_SELECTED="${THEMES[THEME_NUMBER-1]%/}"
    SELECTED_THEME="${THEME_SELECTED##*/}"  # Extract the theme name from the full path
else
    echo "Invalid theme selection. Exiting."
    exit 1
fi

read -p "Enter a theme name (ie: acme or acme-${YEAR}): " THEME

REPLACE_CLIENT_STRING="+++REPLACE_CLIENT_NAME+++"
REPLACE_THEME_STRING="+++REPLACE_THEME_NAME+++"
REPLACE_THEME_SELECTED_STRING="+++REPLACE_THEME_SELECTED+++"
REPLACE_PREFIX_STRING="+++REPLACE_PREFIX+++"
REPLACE_RANGE_STRING="+++RANGE+++"
REPLACE_AUTHOR_NAME_STRING="+++REPLACE_AUTHOR_NAME+++"
REPLACE_AUTHOR_URI_STRING="+++REPLACE_AUTHOR_URI+++"
RANGE=$(( RANDOM % 256 ))

CURRDIR="${PWD}"

echo "${CURRDIR}"

cp "${PWD}/assets/init/.env" "${PWD}"
sed -i '' "s|${REPLACE_CLIENT_STRING}|\"${CLIENT}\"|g" "${PWD}/.env"
sed -i '' "s|${REPLACE_THEME_STRING}|${THEME}|g" "${PWD}/.env"
sed -i '' "s|${REPLACE_PREFIX_STRING}|${PREFIX}|g" "${PWD}/.env"
sed -i '' "s|${REPLACE_RANGE_STRING}|${RANGE}|g" "${PWD}/.env"
cp "${PWD}/assets/init/.gitignore" "${PWD}"
sed -i '' "s|${REPLACE_THEME_STRING}|${THEME}|g" "${PWD}/.gitignore"
cp "${PWD}/assets/init/docker-compose.yml" "${PWD}"
sed -i '' "s|${REPLACE_THEME_STRING}|${THEME}|g" "${PWD}/docker-compose.yml"
mv "${PWD}/README.md" "${PWD}/README.md.bak"
cp "${PWD}/assets/init/README.md" "${PWD}"
sed -i '' "s|${REPLACE_THEME_STRING}|${THEME}|g" "${PWD}/README.md"

echo "Generating new theme: ${THEME}"
cp -r "${PWD}/wp-content/themes/${SELECTED_THEME}" "${PWD}/wp-content/themes/${THEME}"
cat "${PWD}/assets/init/functions.php" > "${PWD}/wp-content/themes/${THEME}/functions.php"
sed -i '' "s|${REPLACE_THEME_STRING}|${THEME}|g" "${PWD}/wp-content/themes/${THEME}/functions.php"
sed -i '' "s|${REPLACE_THEME_SELECTED_STRING}|${SELECTED_THEME}|g" "${PWD}/wp-content/themes/${THEME}/functions.php"
sed -i '' "s|${REPLACE_CLIENT_STRING}|${CLIENT}|g" "${PWD}/wp-content/themes/${THEME}/functions.php"

echo "Copying scaffold to new folder"
cd ../
cp -r "${CURRDIR}" "${PWD}/${THEME}"
cd "${PWD}/${THEME}"
sed -i '' "s|${REPLACE_THEME_STRING}|${THEME}|g" "${PWD}/compass/sass/_partials/comments.scss"

rm -rf ".git" \
       "init.sh" \
       "README.md.bak" \
       "assets/init"
echo "Copied to ${PWD}"

echo "Cleaning up"
cd ../
cd "${CURRDIR}"
rm -rf "${CURRDIR}/wp-content/themes/${THEME}"
rm "${PWD}/.env"
rm "${PWD}/.gitignore"
rm "${PWD}/docker-compose.yml"
rm "${PWD}/README.md"
mv "${PWD}/README.md.bak" "${PWD}/README.md"
echo "Cleaned up"

echo "Done."
