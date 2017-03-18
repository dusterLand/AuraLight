/*
 * This is the initial setup SQL file for the AuraLight World of Warcraft character manager
 *	website.
 *
 * THIS IS UNTESTED, FIRST DRAFT STATUS!
 *
 * @author Jason Dusterwald
 * @last_updated 2016-12-18
 */
CREATE EXTENSION IF NOT EXISTS pgcrypto; 
CREATE SCHEMA IF NOT EXISTS auralight;
-- Drop statements for all tables
drop table if exists al_race cascade;
drop table if exists al_faction cascade;
drop table if exists al_gender cascade;
drop table if exists al_class cascade;
drop table if exists al_specialization_role cascade;
drop table if exists al_specialization_type cascade;
drop table if exists al_specialization cascade;
drop table if exists al_profession_type cascade;
drop table if exists al_profession_tier cascade;
drop table if exists al_profession cascade;
drop table if exists al_player cascade;
drop table if exists al_character cascade;
drop table if exists al_race_faction cascade;
drop table if exists al_race_class cascade;
drop table if exists al_character_professions cascade;
drop table if exists al_objective_scope cascade;
drop table if exists al_objective_type cascade;
drop table if exists al_objective cascade;
/*
 * al_race - Races to which characters belong
 */
create table al_race(
	id SERIAL,
	race_name varchar(30) NOT NULL,
	race_reputation_name varchar(30) NOT NULL,
	primary key (id)
);
/*
 * al_faction - Factions
 */
create table al_faction(
	id SERIAL,
	faction_name varchar(24) NOT NULL,
	primary key (id)
);
/*
 *  al_gender - Gender
 */
create table al_gender(
	id SERIAL,
	gender_name varchar(16) NOT NULL,
	primary key (id)
);
/*
 * al_class - Character class
 */
create table al_class(
	id SERIAL,
	class_name varchar(24) NOT NULL,
	primary key (id)
);
/*
 * al_specialization_role - Damage, tank, healer
 */
create table al_specialization_role(
	id SERIAL,
	name varchar(24) NOT NULL,
	primary key (id)
);
/*
 * al_specialization_type - Melee, ranged
 */
create table al_specialization_type(
	id SERIAL,
	name varchar(24) NOT NULL,
	id_class int NOT NULL,
	primary key(id),
	foreign key (id_class) references al_class(id) on delete cascade
);
/*
 * al_specialization - Class specialization
 */
create table al_specialization (
	id SERIAL,
	specialization_name varchar(24) NOT NULL,
	parent_class int NOT NULL,
	id_specialization_role int NOT NULL,
	id_specialization_type int NOT NULL,
	primary key (id),
	foreign key (id_specialization_role) references al_specialization_role(id) on delete cascade
);
/*
 * al_profession_type - Gathering, production
 */
create table al_profession_type (
	id SERIAL,
	profession_type varchar(16) NOT NULL,
	primary key (id)
);
/*
 * al_profession_tier - Primary, secondary
 */
create table al_profession_tier (
	id SERIAL,
	profession_tier varchar(16) NOT NULL,
	primary key (id)
);
/*
 * al_profession - Character professions/tradeskills
 */
create table al_profession (
	id SERIAL,
	profession_name varchar(24) NOT NULL,
	id_profession_type int NOT NULL,
	id_profession_tier int NOT NULL,
	primary key (id),
	foreign key (id_profession_type) references al_profession_type(id) on delete cascade,
	foreign key (id_profession_tier) references al_profession_tier(id)
);
/*
 * al_player - Player/user
 */
create table al_player (
	id UUID DEFAULT gen_random_uuid(),
	player_username varchar(36) NOT NULL,
	player_email varchar(64) NOT NULL,
	player_name_first varchar(36),
	player_name_last varchar(36),
	player_name_middle varchar(36),
	primary key (id)
);

/*
 * al_character - Individual characters
 */
create table al_character(
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
	id_player_owner UUID NOT NULL,
	primary key (id),
	foreign key (id_character_class) references al_class(id) on delete cascade,
	foreign key (id_character_faction) references al_faction(id) on delete cascade,
	foreign key (id_character_gender) references al_gender(id) on delete cascade,
	foreign key (id_character_race) references al_race(id) on delete cascade,
	foreign key (id_player_owner) references al_player(id) on delete cascade
	
);

/*
 * al_race_faction - Valid race/faction combinations
 */
create table al_race_faction (
	id SERIAL,
	id_race int NOT NULL,
	id_faction int NOT NULL,
	primary key (id),
	foreign key (id_race) references al_race(id) on delete cascade,
	foreign key (id_faction) references al_faction(id) on delete cascade
);
/*
 * al_race_class - Valid race/class combinations
 */
create table al_race_class (
	id SERIAL,
	id_race int NOT NULL,
	id_class int NOT NULL,
	primary key (id),
	foreign key (id_race) references al_race(id) on delete cascade,
	foreign key (id_class) references al_class(id) on delete cascade
);
/*
 * al_character_professions - Professions used by specific characters
 */
create table al_character_professions (
	id UUID  DEFAULT gen_random_uuid(),
	id_character UUID NOT NULL,
	id_profession int NOT NULL,
	profession_skill_level int NOT NULL,
	foreign key (id_character) references al_character(id) on delete cascade,
	foreign key (id_profession) references al_profession(id) on delete cascade,
	primary key (id)
);

/*
 * al_objective_scope - Player or character - Is the player trying to get something done across
 *	multiple characters, or is a specific character trying to accomplish something?
 */
create table al_objective_scope (
	id SERIAL,
	objective_scope varchar(24) NOT NULL,
	primary key (id)
);
/*
 * al_objective_type - Profession, level, reputation
 */
create table al_objective_type (
	id SERIAL,
	objective_type varchar(24) NOT NULL,
	primary key (id)
);
/*
 * al_objective
 */
create table al_objective (
	id UUID DEFAULT gen_random_uuid(),
	id_objective_scope int NOT NULL,
	id_player_owner UUID NOT NULL,
	id_character UUID,
	id_objective_type int NOT NULL,
	objective_context varchar(64),
	objective_target_value int NOT NULL,
	primary key (id),
	foreign key (id_objective_scope) references al_objective_scope(id) on delete cascade,
	foreign key (id_objective_type) references al_objective_type(id) on delete cascade,
	foreign key (id_character) references al_character(id) on delete cascade,
	foreign key (id_player_owner) references al_player(id) on delete cascade
);


grant usage on schema auralight to auralight;
grant insert, update, delete, select on all tables in schema auralight to auralight;

