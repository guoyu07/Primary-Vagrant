#!/bin/bash

USER="backup"
OUTPUT_DIR="/vagrant/user-data/database"

echo "Getting database list..."

databases=`mysql --user=$USER -e "SHOW DATABASES;" | tr -d "| " | grep -v Database`

echo "Database list retrieved."
echo ""
echo "Backing up databases..."

for db in $databases; do

    if [[ "$db" != "information_schema" ]] && [[ "$db" != "performance_schema" ]] && [[ "$db" != "sys" ]] && [[ "$db" != "mysql" ]] && [[ "$db" != "test" ]] && [[ "$db" != "Database" ]] && [[ "$db" != _* ]] ; then

        tableCount=`mysql --user=$USER -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='$db';" | tr -d "| " | grep -v COUNT`

		if [[ 0 < $tableCount ]] ; then

            echo "Dumping database: $db"

            mysqldump --force --opt --user=$USER --databases $db > $OUTPUT_DIR/$db.sql

            if [ -f $OUTPUT_DIR/$db.sql.gz ]; then
                rm "$OUTPUT_DIR/$db.sql.gz" > /dev/null 2>&1
            fi

            gzip -f $OUTPUT_DIR/$db.sql

        fi
    fi
done