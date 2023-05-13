SELECT * FROM `INNODB_SYS_TABLES` where name = "theatre/advertisers";
SELECT name FROM `INNODB_SYS_COLUMNS` where table_id = innodb_sys_tables.table_id; /* 86; */