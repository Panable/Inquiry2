#!/bin/bash

# MySQL service name as specified in docker-compose file
service_name='inquiry2-mysql-1'

# Database credentials
username='user'
password='kaibingoat'
database='kaibindb'

# SQL file
sql_file='init.sql'


# Execute SQL file
docker exec -i ${service_name} mysql -u${username} -p${password} ${database} < ${sql_file}
