This manual covers the application install on a Debian-based Linux distribution.
For other distributions, you can use your OS package manager to install the necessary software.

Install:
To install the application, after you download it, you have to run this command to install
its dependencies:
    apt-get install php7.4 php7.4-ds composer

After this, you have to install the composer dependencies that the application uses.
For this, from inside the application directory, you have to run this command:
    composer install

After all the dependencies and composer libraries are installed, you can run the command 
to run the application:
    php -S localhost:8000 -t public/

And, then, you can access the application using your browser, accessing this URL:
    http://localhost:8000


Dev setup:
To dev environment, you also have to install npm, using this command:
    apt-get install npm

The JS scripts are deployed using webpack. So, if you edit the JS files, you have to run webpack
to update the main library. For this, on the application directory, run this command:
    npx webpack -c webpack.JS

This directory is a Git repository. So, you can see all the application development process
using the git commands.