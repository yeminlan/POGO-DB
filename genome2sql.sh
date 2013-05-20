#!/bin/bash
cat genome_comparison_stats.csv |
sed '1d' |
sed "s/[^,]*/'&'/g" | 
sed "s/'NaN'/NULL/g" |
sed "s/'\([[:digit:].]\+\)'/\1/g" |
sed "s/^/INSERT INTO data VALUES\(NULL, /" |
sed "s/$/);/" > genome_comparison_stats.sql
