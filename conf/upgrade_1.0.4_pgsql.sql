alter table #prefix#organizations add column public varchar(3) not null default 'no';
alter table #prefix#organizations add column category integer not null default 0;
create index #prefix#organizations_public on #prefix#organizations (public, category, name);

create table #prefix#organizations_category (
	id serial not null primary key,
	name character varying(72) not null
);

create index #prefix#organizations_category_name on #prefix#organizations_category (name);
