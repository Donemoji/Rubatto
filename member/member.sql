CREATE TABLE member(
	id char(20) not null,
	pass char(20) not null,
	name char(20) not null,
	nick char(20) not null,
	hp char(20) not null,
	email char(80),
	regist_day char(20),
	level int,
	primary key(id),
	UNIQUE(nick)
);