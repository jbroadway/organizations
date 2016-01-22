create table #prefix#organizations_notes (
	id int not null auto_increment primary key,
	user_id int not null,
	ts datetime not null,
	made_by int not null,
	note text not null,
	index (user_id, ts),
	index (made_by, ts)
);
