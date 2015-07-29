alter table #prefix#organizations add column fax char(32) not null default '' after phone;
alter table #prefix#organizations_location add column fax char(32) not null default '' after phone;
