# Use the official PHP image as base
FROM php:latest

# Install PHP PostgreSQL extension
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql pgsql

# Set the working directory in the container
WORKDIR /var/www/html

# Copy all PHP files from the current directory to the container
COPY . /var/www/html/

# Expose port 80 to the outside world
EXPOSE 80

# Command to run the application
CMD ["php", "-S", "0.0.0.0:80"]
