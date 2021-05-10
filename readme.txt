This manual covers the application install on a Debian-based Linux distribution.
For other distributions, you can use your OS package manager to install the necessary software.

To run this application, you have to install docker, as well as docker compose.
You can install it using this commands:
    apt-get install docker.io
    sudo curl -L "https://github.com/docker/compose/releases/download/1.29.1/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
    sudo chmod +x /usr/local/bin/docker-compose
    sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose

After this, you can go to the Docker directory, and run the command:
    docker-compose up

It will build the application container. Once the process is finished, you can access the
application using this URL:
    http://localhost:8000

Dev setup:
To install the application, after you download it, you have to run this command to install
its dependencies:
    apt-get install php7.4 php7.4-ds php7.4-xml composer npm

After this, you have to install the composer dependencies that the application uses.
For this, from inside the application directory, you have to run this command:
    composer install

The JS scripts are deployed using webpack. So, if you edit the JS files, you have to run webpack
to update the main library. For this, on the application directory, run this command:
    npx webpack -c webpack.JS

This directory is a Git repository. So, you can see all the application development process
using the git commands.