alter table #prefix#organizations add column public char(3) not null default 'no';
alter table #prefix#organizations add column category char(48) not null default '';
create index #prefix#organizations_public on #prefix#organizations (public, category, name);

create table #prefix#organizations_category (
	id integer primary key,
	name char(72) not null
);

create index #prefix#organizations_category_name on #prefix#organizations_category (name);
