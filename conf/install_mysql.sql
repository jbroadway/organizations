create table #prefix#organizations (
	id int not null auto_increment primary key, 
	name char(72) not null, 
	phone char(32) not null, 
	fax char(32) not null default '',
	address char(48) not null, 
	address2 char(48) not null, 
	city char(48) not null, 
	state char(3) not null, 
	country char(3) not null, 
	zip char(16) not null, 
	website char(128) not null, 
	about text,
	public enum('no','yes') not null default 'no',
	category int not null default 0,
	index (name),
	index (public, category, name)
);

create table #prefix#organizations_location (
	id int not null auto_increment primary key,
	organization int not null,
	name char(72) not null, 
	phone char(32) not null,  
	fax char(32) not null default '',
	address char(48) not null, 
	address2 char(48) not null, 
	city char(48) not null, 
	state char(3) not null, 
	country char(3) not null, 
	zip char(16) not null,
	index (organization, name)
);

create table #prefix#organizations_member (
	id int not null auto_increment primary key,
	organization int not null,
	user int not null,
	main int not null default 0,
	unique (organization, user),
	index (organization),
	index (user)
);

create table #prefix#organizations_category (
	id int not null auto_increment primary key,
	name char(72) not null,
	index (name)
);
