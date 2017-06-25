create table user(
  id int(10) unsigned not null auto_increment,
  username varchar(12) UNIQUE ,
  password VARCHAR(255)NOT  NULL ,
  PRIMARY key (id),
  UNIQUE key users_username_unique(username)
)engine=innodb;