alter table #prefix#organizations add column public enum('no','yes') not null default 'no';
alter table #prefix#organizations add column category char(48) not null default '';
create index #prefix#organizations_public on #prefix#organizations (public, category, name);

create table #prefix#organizations_category (
	id int not null auto_increment primary key,
	name char(72) not null,
	index (name)
);
