#!/bin/bash
cat taxonomy.csv | 
sed '1d' |
sed "s/[^,]*/'&'/g" | 
sed "s/'NA'/NULL/g" | 
sed "s/^/INSERT INTO taxonomy VALUES(NULL, /" |
sed "s/$/);/" > taxonomy.sql
