/*
 * This is the initial setup SQL file for the AuraLight World of Warcraft character manager
 *	website.
 *
 * @author Jason Dusterwald
 * @author Lisa Dusterwald
 * @last_updated 2017-05-28
 */
set session time zone 'UTC';
drop extension pgcrypto;
CREATE EXTENSION IF NOT EXISTS pgcrypto; 
CREATE SCHEMA IF NOT EXISTS auralight;
-- Drop statements for all tables
drop table if exists auralight.al_race cascade;
drop table if exists auralight.al_faction cascade;
drop table if exists auralight.al_gender cascade;
drop table if exists auralight.al_class cascade;
drop table if exists auralight.al_specialization_role cascade;
drop table if exists auralight.al_specialization_type cascade;
drop table if exists auralight.al_specialization cascade;
drop table if exists auralight.al_profession_type cascade;
drop table if exists auralight.al_profession_tier cascade;
drop table if exists auralight.al_profession cascade;
drop table if exists auralight.al_player cascade;
drop table if exists auralight.al_account cascade;
drop table if exists auralight.al_character cascade;
drop table if exists auralight.al_race_faction cascade;
drop table if exists auralight.al_race_class cascade;
drop table if exists auralight.al_character_professions cascade;
drop table if exists auralight.al_objective_scope cascade;
drop table if exists auralight.al_objective_type cascade;
drop table if exists auralight.al_objective cascade;
drop table if exists auralight.al_session cascade;
/*
 * Trigger to update mutation fields.
 */
create or replace function update_mutation()
returns trigger as $$
begin
	new.mutation = now();
	return new;
end;
$$ language 'plpgsql';
/*
 * auralight.al_race - Races to which characters belong
 */
create table auralight.al_race(
	id SERIAL,
	race_name varchar(30) NOT NULL,
	race_reputation_name varchar(30) NOT NULL,
	genesis timestamp with time zone default current_timestamp,
	mutation timestamp with time zone default current_timestamp,
	primary key (id)
);
create trigger update_al_race_mutation
before update on auralight.al_race
for each row
execute procedure update_mutation();
/*
 * auralight.al_faction - Factions
 */
create table auralight.al_faction(
	id SERIAL,
	faction_name varchar(24) NOT NULL,
	genesis timestamp with time zone default current_timestamp,
	mutation timestamp with time zone default current_timestamp,
	primary key (id)
);
create trigger update_al_faction_mutation
before update on auralight.al_faction
for each row
execute procedure update_mutation();
/*
 * auralight.al_gender - Gender
 */
create table auralight.al_gender(
	id SERIAL,
	gender_name varchar(16) NOT NULL,
	genesis timestamp with time zone default current_timestamp,
	mutation timestamp with time zone default current_timestamp,
	primary key (id)
);
create trigger update_al_gender_mutation
before update on auralight.al_gender
for each row
execute procedure update_mutation();
/*
 * auralight.al_class - Character class
 */
create table auralight.al_class(
	id SERIAL,
	class_name varchar(24) NOT NULL,
	genesis timestamp with time zone default current_timestamp,
	mutation timestamp with time zone default current_timestamp,
	primary key (id)
);
create trigger update_al_class_mutation
before update on auralight.al_class
for each row
execute procedure update_mutation();
/*
 * auralight.al_specialization_role - Damage, tank, healer
 */
create table auralight.al_specialization_role(
	id SERIAL,
	specialization_role_name varchar(24) NOT NULL,
	genesis timestamp with time zone default current_timestamp,
	mutation timestamp with time zone default current_timestamp,
	primary key (id)
);
create trigger update_al_specialization_role_mutation
before update on auralight.al_specialization_role
for each row
execute procedure update_mutation();
/*
 * auralight.al_specialization_type - Melee, ranged
 */
create table auralight.al_specialization_type(
	id SERIAL,
	specialization_type_name varchar(24) NOT NULL,
	genesis timestamp with time zone default current_timestamp,
	mutation timestamp with time zone default current_timestamp,
	primary key(id)
);
create trigger update_al_specialization_type_mutation
before update on auralight.al_specialization_type
for each row
execute procedure update_mutation();
/*
 * auralight.al_specialization - Class specialization
 */
create table auralight.al_specialization (
	id SERIAL,
	specialization_name varchar(24) NOT NULL,
	id_parent_class int NOT NULL,
	id_specialization_role int NOT NULL,
	id_specialization_type int NOT NULL,
	genesis timestamp with time zone default current_timestamp,
	mutation timestamp with time zone default current_timestamp,
	primary key (id),
	foreign key (id_specialization_role) references auralight.al_specialization_role(id) on delete cascade
);
create trigger update_al_specialization_mutation
before update on auralight.al_specialization
for each row
execute procedure update_mutation();
/*
 * auralight.al_profession_type - Gathering, production
 */
create table auralight.al_profession_type (
	id SERIAL,
	profession_type varchar(16) NOT NULL,
	genesis timestamp with time zone default current_timestamp,
	mutation timestamp with time zone default current_timestamp,
	primary key (id)
);
create trigger update_al_profession_type_mutation
before update on auralight.al_profession_type
for each row
execute procedure update_mutation();
/*
 * auralight.al_profession_tier - Primary, secondary
 */
create table auralight.al_profession_tier (
	id SERIAL,
	profession_tier varchar(16) NOT NULL,
	genesis timestamp with time zone default current_timestamp,
	mutation timestamp with time zone default current_timestamp,
	primary key (id)
);
create trigger update_al_profession_tier_mutation
before update on auralight.al_profession_tier
for each row
execute procedure update_mutation();
/*
 * auralight.al_profession - Character professions/tradeskills
 */
create table auralight.al_profession (
	id SERIAL,
	profession_name varchar(24) NOT NULL,
	id_profession_type int NOT NULL,
	id_profession_tier int NOT NULL,
	genesis timestamp with time zone default current_timestamp,
	mutation timestamp with time zone default current_timestamp,
	primary key (id),
	foreign key (id_profession_type) references auralight.al_profession_type(id) on delete cascade,
	foreign key (id_profession_tier) references auralight.al_profession_tier(id)
);
create trigger update_al_profession_mutation
before update on auralight.al_profession
for each row
execute procedure update_mutation();
/*
 * auralight.al_player - Player/user
 */
create table auralight.al_player (
	id UUID DEFAULT gen_random_uuid(),
	player_username varchar(36) NOT NULL,
	player_email varchar(64) NOT NULL,
	player_name_first varchar(36),
	player_name_last varchar(36),
	player_name_middle varchar(36),
	player_password varchar(32) not null,
	genesis timestamp with time zone default current_timestamp,
	mutation timestamp with time zone default current_timestamp,
	primary key (id)
);
create trigger update_al_player_mutation
before update on auralight.al_player
for each row
execute procedure update_mutation();
/*
 * auralight.al_account - Accounts associated with a player
 */
create table auralight.al_account (
	id SERIAL,
	account_name varchar(36) NOT NULL,
	id_player_owner UUID NOT NULL,
	genesis timestamp with time zone default current_timestamp,
	mutation timestamp with time zone default current_timestamp,
	primary key (id),
	foreign key (id_player_owner) references auralight.al_player(id) on delete cascade
);
create trigger update_al_account_mutation
before update on auralight.al_account
for each row
execute procedure update_mutation();
/*
 * auralight.al_character - Individual characters
 */
create table auralight.al_character(
	id UUID DEFAULT gen_random_uuid(),
	character_name_game varchar(24) NOT NULL,
	character_name_last varchar(30),
	character_name_first varchar(30),
	character_name_middle_first varchar(30),
	character_name_middle_second varchar(30),
	id_character_class int NOT NULL,
	id_character_faction int NOT NULL,
	id_character_gender int NOT NULL,
	character_level int NOT NULL,
	id_character_race int NOT NULL,
	id_account_owner int NOT NULL,
	genesis timestamp with time zone default current_timestamp,
	mutation timestamp with time zone default current_timestamp,
	primary key (id),
	foreign key (id_character_class) references auralight.al_class(id) on delete cascade,
	foreign key (id_character_faction) references auralight.al_faction(id) on delete cascade,
	foreign key (id_character_gender) references auralight.al_gender(id) on delete cascade,
	foreign key (id_character_race) references auralight.al_race(id) on delete cascade,
	foreign key (id_account_owner) references auralight.al_account(id) on delete cascade
);
create trigger update_al_character_mutation
before update on auralight.al_character
for each row
execute procedure update_mutation();
/*
 * auralight.al_race_faction - Valid race/faction combinations
 */
create table auralight.al_race_faction (
	id SERIAL,
	id_race int NOT NULL,
	id_faction int NOT NULL,
	genesis timestamp with time zone default current_timestamp,
	mutation timestamp with time zone default current_timestamp,
	primary key (id),
	foreign key (id_race) references auralight.al_race(id) on delete cascade,
	foreign key (id_faction) references auralight.al_faction(id) on delete cascade
);
create trigger update_al_race_faction_mutation
before update on auralight.al_race_faction
for each row
execute procedure update_mutation();
/*
 * auralight.al_race_class - Valid race/class combinations
 */
create table auralight.al_race_class (
	id SERIAL,
	id_race int NOT NULL,
	id_class int NOT NULL,
	genesis timestamp with time zone default current_timestamp,
	mutation timestamp with time zone default current_timestamp,
	primary key (id),
	foreign key (id_race) references auralight.al_race(id) on delete cascade,
	foreign key (id_class) references auralight.al_class(id) on delete cascade
);
create trigger update_al_race_class_mutation
before update on auralight.al_race_class
for each row
execute procedure update_mutation();
/*
 * auralight.al_character_professions - Professions used by specific characters
 */
create table auralight.al_character_professions (
	id UUID DEFAULT gen_random_uuid(),
	id_character UUID NOT NULL,
	id_profession int NOT NULL,
	profession_skill_level int NOT NULL,
	genesis timestamp with time zone default current_timestamp,
	mutation timestamp with time zone default current_timestamp,
	foreign key (id_character) references auralight.al_character(id) on delete cascade,
	foreign key (id_profession) references auralight.al_profession(id) on delete cascade,
	primary key (id)
);
create trigger update_al_character_professions_mutation
before update on auralight.al_character_professions
for each row
execute procedure update_mutation();
/*
 * auralight.al_objective_scope - Player or character - Is the player trying to get something done across
 *	multiple characters, or is a specific character trying to accomplish something?
 */
create table auralight.al_objective_scope (
	id SERIAL,
	objective_scope varchar(24) NOT NULL,
	genesis timestamp with time zone default current_timestamp,
	mutation timestamp with time zone default current_timestamp,
	primary key (id)
);
create trigger update_al_objective_scope_mutation
before update on auralight.al_objective_scope
for each row
execute procedure update_mutation();
/*
 * auralight.al_objective_type - Profession, level, reputation
 */
create table auralight.al_objective_type (
	id SERIAL,
	objective_type varchar(24) NOT NULL,
	genesis timestamp with time zone default current_timestamp,
	mutation timestamp with time zone default current_timestamp,
	primary key (id)
);
create trigger update_al_objective_type_mutation
before update on auralight.al_objective_type
for each row
execute procedure update_mutation();
/*
 * auralight.al_objective
 */
create table auralight.al_objective (
	id UUID DEFAULT gen_random_uuid(),
	id_objective_scope int NOT NULL,
	id_player_owner UUID NOT NULL,
	id_character UUID,
	id_objective_type int NOT NULL,
	objective_context varchar(64),
	objective_target_value int NOT NULL,
	genesis timestamp with time zone default current_timestamp,
	mutation timestamp with time zone default current_timestamp,
	primary key (id),
	foreign key (id_objective_scope) references auralight.al_objective_scope(id) on delete cascade,
	foreign key (id_objective_type) references auralight.al_objective_type(id) on delete cascade,
	foreign key (id_character) references auralight.al_character(id) on delete cascade,
	foreign key (id_player_owner) references auralight.al_player(id) on delete cascade
);
create trigger update_al_objective_mutation
before update on auralight.al_objective
for each row
execute procedure update_mutation();
/*
 * auralight.al_session
 */
create table auralight.al_session (
	id UUID DEFAULT gen_random_uuid(),
	id_player UUID NOT NULL,
	session_data JSON,
	genesis timestamp with time zone default current_timestamp,
	mutation timestamp with time zone default current_timestamp,
	primary key (id)
);
create trigger update_al_session_mutation
before update on auralight.al_session
for each row
execute procedure update_mutation();

grant usage on schema auralight to auralight;
grant insert, update, delete, select on all tables in schema auralight to auralight;
grant update, select, usage on all sequences in schema auralight to auralight;
