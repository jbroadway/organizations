create sequence #prefix#organizations_notes_seq;

create table #prefix#organizations_notes (
	id integer not null default nextval('#prefix#organizations_notes_seq') primary key,
	user_id int not null,
	ts timestamp not null,
	made_by int not null,
	note text not null
);

create index #prefix#organizations_notes_user on #prefix#organizations_notes (user_id, ts);
create index #prefix#organizations_notes_made_by on #prefix#organizations_notes (made_by, ts);
