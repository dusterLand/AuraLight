/*
 * This is the initial setup SQL file for the AuraLight World of Warcraft character manager
 *	website.
 *
 * @author Jason Dusterwald
 * @author Lisa Dusterwald
 * @last_updated 2017-03-19
 */
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
/*
 * auralight.al_race - Races to which characters belong
 */
create table auralight.al_race(
	id SERIAL,
	race_name varchar(30) NOT NULL,
	race_reputation_name varchar(30) NOT NULL,
	primary key (id)
);
/*
 * auralight.al_faction - Factions
 */
create table auralight.al_faction(
	id SERIAL,
	faction_name varchar(24) NOT NULL,
	primary key (id)
);
/*
 * auralight.al_gender - Gender
 */
create table auralight.al_gender(
	id SERIAL,
	gender_name varchar(16) NOT NULL,
	primary key (id)
);
/*
 * auralight.al_class - Character class
 */
create table auralight.al_class(
	id SERIAL,
	class_name varchar(24) NOT NULL,
	primary key (id)
);
/*
 * auralight.al_specialization_role - Damage, tank, healer
 */
create table auralight.al_specialization_role(
	id SERIAL,
	specialization_role_name varchar(24) NOT NULL,
	primary key (id)
);
/*
 * auralight.al_specialization_type - Melee, ranged
 */
create table auralight.al_specialization_type(
	id SERIAL,
	specialization_type_name varchar(24) NOT NULL,
	primary key(id)
);
/*
 * auralight.al_specialization - Class specialization
 */
create table auralight.al_specialization (
	id SERIAL,
	specialization_name varchar(24) NOT NULL,
	parent_class int NOT NULL,
	id_specialization_role int NOT NULL,
	id_specialization_type int NOT NULL,
	primary key (id),
	foreign key (id_specialization_role) references auralight.al_specialization_role(id) on delete cascade
);
/*
 * auralight.al_profession_type - Gathering, production
 */
create table auralight.al_profession_type (
	id SERIAL,
	profession_type varchar(16) NOT NULL,
	primary key (id)
);
/*
 * auralight.al_profession_tier - Primary, secondary
 */
create table auralight.al_profession_tier (
	id SERIAL,
	profession_tier varchar(16) NOT NULL,
	primary key (id)
);
/*
 * auralight.al_profession - Character professions/tradeskills
 */
create table auralight.al_profession (
	id SERIAL,
	profession_name varchar(24) NOT NULL,
	id_profession_type int NOT NULL,
	id_profession_tier int NOT NULL,
	primary key (id),
	foreign key (id_profession_type) references auralight.al_profession_type(id) on delete cascade,
	foreign key (id_profession_tier) references auralight.al_profession_tier(id)
);
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
	primary key (id)
);
/*
 * auralight.al_account - Accounts associated with a player
 */
create table auralight.al_account (
	id SERIAL,
	account_name varchar(36) NOT NULL,
	id_player_owner UUID NOT NULL,
	primary key (id),
	foreign key (id_player_owner) references auralight.al_player(id) on delete cascade
);
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
	primary key (id),
	foreign key (id_character_class) references auralight.al_class(id) on delete cascade,
	foreign key (id_character_faction) references auralight.al_faction(id) on delete cascade,
	foreign key (id_character_gender) references auralight.al_gender(id) on delete cascade,
	foreign key (id_character_race) references auralight.al_race(id) on delete cascade,
	foreign key (id_account_owner) references auralight.al_account(id) on delete cascade
	
);

/*
 * auralight.al_race_faction - Valid race/faction combinations
 */
create table auralight.al_race_faction (
	id SERIAL,
	id_race int NOT NULL,
	id_faction int NOT NULL,
	primary key (id),
	foreign key (id_race) references auralight.al_race(id) on delete cascade,
	foreign key (id_faction) references auralight.al_faction(id) on delete cascade
);
/*
 * auralight.al_race_class - Valid race/class combinations
 */
create table auralight.al_race_class (
	id SERIAL,
	id_race int NOT NULL,
	id_class int NOT NULL,
	primary key (id),
	foreign key (id_race) references auralight.al_race(id) on delete cascade,
	foreign key (id_class) references auralight.al_class(id) on delete cascade
);
/*
 * auralight.al_character_professions - Professions used by specific characters
 */
create table auralight.al_character_professions (
	id UUID DEFAULT gen_random_uuid(),
	id_character UUID NOT NULL,
	id_profession int NOT NULL,
	profession_skill_level int NOT NULL,
	foreign key (id_character) references auralight.al_character(id) on delete cascade,
	foreign key (id_profession) references auralight.al_profession(id) on delete cascade,
	primary key (id)
);

/*
 * auralight.al_objective_scope - Player or character - Is the player trying to get something done across
 *	multiple characters, or is a specific character trying to accomplish something?
 */
create table auralight.al_objective_scope (
	id SERIAL,
	objective_scope varchar(24) NOT NULL,
	primary key (id)
);
/*
 * auralight.al_objective_type - Profession, level, reputation
 */
create table auralight.al_objective_type (
	id SERIAL,
	objective_type varchar(24) NOT NULL,
	primary key (id)
);
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
	primary key (id),
	foreign key (id_objective_scope) references auralight.al_objective_scope(id) on delete cascade,
	foreign key (id_objective_type) references auralight.al_objective_type(id) on delete cascade,
	foreign key (id_character) references auralight.al_character(id) on delete cascade,
	foreign key (id_player_owner) references auralight.al_player(id) on delete cascade
);

grant usage on schema auralight to auralight;
grant insert, update, delete, select on all tables in schema auralight to auralight;
grant update, select, usage on all sequences in schema auralight to auralight;
