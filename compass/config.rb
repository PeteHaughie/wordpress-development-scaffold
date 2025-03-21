# Open the .env file
file_path = '.env'
file_contents = File.read(file_path)

# Use regular expressions to find the desired string
pattern = /THEME_NAME=([\w-]+)/
match = file_contents.match(pattern)

# Extract the desired part from the match
theme_name = match[1] if match
# Require any additional compass plugins here.

#Folder settings
css_dir = "../wp-content/themes/" + theme_name          #where the CSS will saved
sass_dir = "sass"           #where our .scss files are
images_dir = "../assets/img"    #the folder with your images

# You can select your preferred output style here (can be overridden via the command line):
output_style = :expanded # After dev :compressed

# To disable debugging comments that display the original location of your selectors. Uncomment:
line_comments = true

# Obviously
preferred_syntax = :scss