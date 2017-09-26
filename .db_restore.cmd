"C:\PostgreSQL\pg96\bin\psql.exe" --host localhost --port 5432 --username postgres -c "drop database eye"
"C:\PostgreSQL\pg96\bin\psql.exe" --host localhost --port 5432 --username postgres -c "create database eye"
"C:\PostgreSQL\pg96\bin\psql.exe" -1 --host localhost --port 5432 --username postgres eye < C:\eye\eye.backup
