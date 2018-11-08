create table olog_logger_entry (id int not null auto_increment primary key, created_at_ts int not null default 0) engine InnoDB default charset utf8 /* rand7124 */;
alter table olog_logger_entry add column user_fullid varchar(255)    /* rand786743 */;
alter table olog_logger_entry add column object_fullid varchar(255)  not null    /* rand919975 */;
alter table olog_logger_entry add column serialized_object text    /* rand966747 */;
alter table olog_logger_entry add column user_ip varchar(255)    /* rand427721 */;
alter table olog_logger_entry add column comment text    /* rand116303 */;
insert into olog_auth_permission (title) values ("PERMISSION_PHPLOGGER_ACCESS") /* 83764587345 */;
create table loggerdemo_loggerdemomodel (id int not null auto_increment primary key, created_at_ts int not null default 0) engine InnoDB default charset utf8 /* rand4373 */;
alter table loggerdemo_loggerdemomodel add column title varchar(255)  not null   default "default title"  /* rand645806 */;

