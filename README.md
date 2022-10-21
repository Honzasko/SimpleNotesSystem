# <u>**SimpleNotesSystem**</u>
## About this project
This project is made to gain experience for programming in PHP. It is simple database free notes system,it can be easily deployed to any hosting that support PHP . The notes system work on files,there is root folder that contains folder and each folder represent subject,each subject has subfolder and these folders represents lessons . As I said this simple system for easy use . 

## How to use this notes system
There is root folder named **subjects** ,it contains folder,these folders represent subjects and file named **app_labels.txt**. Each subject has **name.txt** file that set the label for rendering by it content of that file . If name.txt does not exists the rendered label will be name of that folder. Each subject has folder,these folders are lessons . Each lesson has **index.html** what is content of lesson for page and **name.tx**t that represent like i said before in case of subjects label for rendering .
### Labels of of app_labels.txt
Currently it supports these labels:
- subject - set label for subjects
- lesson - set label for lessons
- title - set label for title of pages

### How to write in app_labels.txt
Each line has this form:
label_name=label_text

Make sure that all labels have their values,otherwise it will throw error and unsupported labels will be ignored.  One label can be set how many times you want in file but the displayed one will be the latest version

## Error files
- **error404.html** - html code for Error 404 page
- **error505.html** - html code for Error 500 page
- **error403.html** - html code for Error 403 page
