create table #prefix#organizations (
	id integer primary key, 
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
	public char(3) not null default 'no',
	category integer not null default 0
);

create index #prefix#organizations_name on #prefix#organizations (name);
create index #prefix#organizations_public on #prefix#organizations (public, category, name);

create table #prefix#organizations_location (
	id integer primary key,
	organization int not null,
	name char(72) not null, 
	phone char(32) not null,  
	fax char(32) not null default '',
	address char(48) not null, 
	address2 char(48) not null, 
	city char(48) not null, 
	state char(3) not null, 
	country char(3) not null, 
	zip char(16) not null
);

create index #prefix#organizations_location_org on #prefix#organizations_location (organization, name);

create table #prefix#organizations_member (
	id integer primary key,
	organization int not null default 0,
	user int not null default 0,
	main int not null default 0
);

create index #prefix#organizations_member_org on #prefix#organizations_member (organization);
create index #prefix#organizations_member_user on #prefix#organizations_member (user);
create unique index #prefix#organizations_member_unique on #prefix#organizations_member (organization, user);

create table #prefix#organizations_category (
	id integer primary key,
	name char(72) not null
);

create index #prefix#organizations_category_name on #prefix#organizations_category (name);

create table #prefix#organizations_notes (
	id integer primary key,
	user_id int not null,
	ts datetime not null,
	made_by int not null,
	note text not null
);

create index #prefix#organizations_notes_user on #prefix#organizations_notes (user_id, ts);
create index #prefix#organizations_notes_made_by on #prefix#organizations_notes (made_by, ts);