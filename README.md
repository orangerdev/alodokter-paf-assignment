# alodokter-paf-assignment
Develop AloDokter assignment with goals :

1. Enable Partner/3rd Party for using Our features
2. Each Partner/3rd Party can choose a specific feature or all features
3. Build a new service without having to changes the existing APIs


# Getting Started
The configuration files here are the base structure to start a WordPress development with Docker and run PHPUnit tests on plugins. Find more details about these files in: [Running PHPUnit tests in a WordPress plugin with Docker](https://carlosguzman.dev/running-phpunit-tests-in-a-wordpress-plugin-with-docker/).

# Prerequisites

- [Docker](https://docs.docker.com/get-docker/)

# Installation

1. Install the [prerequisites](#prerequisites) in your local system.
2. Clone this repository or download the file watch-and-do inside this repository to your local system.
3. Go to the folder and run docker compose: `docker-compose up -d --build`
4. Open phpmyadmin (http://localhost:8080), and then import SQL file from `dump/wordpress.sql`
5. Open http://localhost:8000/ to make sure everything works
6. Open http://localhost:8000/wp-admin, login with `admin:alodokteradmin!!!`

# PHPUnit

1. Go to the folder and run `docker ps`
2. Find wordpress container ID

![Container ID](/assets/docker-ps.png)

3. run `docker exec -u www-data -it [Container ID] bash`

![Docker Exec](/assets/docker-exec.png)

4. go to plugin folder alodokter-paf-assignment `cd wp-content/plugins/alodokter-paf-assignment`
5. we need to install wptests database for unit test, `bash bin/install-wp-tests.sh wptests wordpress password db:3306 latest`

![install-wp-tests.sh](/assets/bin-bash.png)

6. do `/tmp/phpunit`

![phpunit](/assets/phpunit.png)

# License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.
