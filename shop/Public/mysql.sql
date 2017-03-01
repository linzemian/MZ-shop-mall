create database if not exists gz25;


create table shop_user(
    id int unsigned primary key auto_increment,
    username varchar(50) not null unique,
    pwd char(32) not null unique,
    role tinyint not null default '1' comment '1：普通用户 2：管理员',
    status tinyint not null default '1' comment '1：正常 2：冻结',
    sex tinyint not null default '2' comment '0:女 1：男 2：保密',
    phone char(11),
    pic varchar(255),
    time int not null default '0',
    qq varchar(15)
    )engine=innodb default charset=utf8;



create table shop_type(
	id int unsigned not null primary key auto_increment,
	name varchar(255) not null,
	pid int not null default '0',
	path varchar(255) not null default '0,'
	)engine=innodb default charset=utf8;

create table shop_goods(
	id int unsigned not null primary key auto_increment,
	name varchar(255) not null,
	price decimal unsigned not null,
	store int unsigned not null,
	status tinyint not null default '1' comment '1：在售中 2：已下架',
	tid int unsigned not null,
	des text,
	pic varchar(255) not null,
	time int not null default '0',
	clicknum int unsigned default '0',
	soldnum int unsigned default '0',
	index name(name)
	)engine=innodb default charset=utf8;

-- 创建地址表
create table shop_address(
	id int unsigned not null primary key auto_increment,
	uid int not null,
	address varchar(255) not null,
	phone char(11) not null,
	name varchar(20) not null,
	code char(6)
	)engine=innodb default charset=utf8;

-- 创建订单表
create table shop_order(
	id int unsigned not null primary key auto_increment,
	total decimal(10,2) not null,
	addtime int not null,
	uid int not null,
	status tinyint not null,
	aid int not null
	)engine=innodb default charset=utf8;

-- 创建订单详情表
create table shop_detail(
	id int unsigned not null primary key auto_increment,
	oid int not null,
	gid int not null,
	num int not null
	)engine=innodb default charset=utf8;

-- 拓展：创建友情链接表
create table shop_link(
	id int unsigned not null primary key auto_increment,
	name varchar(255) not null,
	lujing varchar(255) not null,
	pic varchar(255)
	)engine=innodb default charset=utf8;