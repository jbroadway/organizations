create sequence #prefix#organizations_id_seq;

create table #prefix#organizations (
	id integer not null default nextval('#prefix#organizations_id_seq') primary key, 
	name char(72) not null,
	phone char(32) not null,
	address char(48) not null, 
	address2 char(48) not null, 
	city char(48) not null, 
	state char(3) not null, 
	country char(3) not null, 
	zip char(16) not null, 
	website char(128) not null, 
	about text
);

create index #prefix#organizations_name on #prefix#organizations (name);

create sequence #prefix#organizations_location_id_seq;

create table #prefix#organizations_location (
	id integer not null default nextval('#prefix#organizations_location_id_seq') primary key, 
	organization int not null,
	name char(72) not null, 
	phone char(32) not null, 
	address char(48) not null, 
	address2 char(48) not null, 
	city char(48) not null, 
	state char(3) not null, 
	country char(3) not null, 
	zip char(16) not null
);

create index #prefix#organizations_location_org on #prefix#organizations_location (organization, name);

create sequence #prefix#organizations_member_id_seq;

create table #prefix#organizations_member (
	id integer default nextval('#prefix#organizations_member_id_seq') primary key,
	organization int not null,
	user int not null
);

create index #prefix#organizations_member_org on #prefix#organizations_member (organization);
create index #prefix#organizations_member_user on #prefix#organizations_member (user);
create unique index #prefix#organizations_member_unique on #prefix#organizations_member (organization, user);
