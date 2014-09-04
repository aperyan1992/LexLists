CREATE TABLE cities (id BIGINT AUTO_INCREMENT, name VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE clients (id BIGINT AUTO_INCREMENT, name VARCHAR(255) NOT NULL UNIQUE, is_enabled TINYINT(1) DEFAULT '1', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE countries (id BIGINT AUTO_INCREMENT, name VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE main_practice_areas (id BIGINT AUTO_INCREMENT, name VARCHAR(255), short_code VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE organizations (id BIGINT AUTO_INCREMENT, name VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE practice_areas (id BIGINT AUTO_INCREMENT, main_practice_area_id BIGINT, name TEXT, short_code TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX main_practice_area_id_idx (main_practice_area_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE regions (id BIGINT AUTO_INCREMENT, name VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE special_criterias (id BIGINT AUTO_INCREMENT, name VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE states (id BIGINT AUTO_INCREMENT, name VARCHAR(255), short_code VARCHAR(10), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE surveys (id BIGINT AUTO_INCREMENT, organization_id BIGINT, organization_url VARCHAR(255), survey_name VARCHAR(255), year BIGINT, survey_url VARCHAR(255), frequency BIGINT, submission_deadline DATE, survey_city_id BIGINT, survey_region_id BIGINT, survey_description TEXT, candidate_type BIGINT, eligibility_criteria TEXT, nomination TEXT, selection_methodology TEXT, self_nomination TINYINT(1), fees TINYINT(1), pay_for_play TINYINT(1), survey_contact_id BIGINT, survey_notes TEXT, staff_notes TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX survey_contact_id_idx (survey_contact_id), INDEX organization_id_idx (organization_id), INDEX survey_city_id_idx (survey_city_id), INDEX survey_region_id_idx (survey_region_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE survey_contacts (id BIGINT AUTO_INCREMENT, first_name VARCHAR(255), last_name VARCHAR(255), email_address VARCHAR(255), phone_number VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE survey_countries (survey_id BIGINT, country_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(survey_id, country_id)) ENGINE = INNODB;
CREATE TABLE survey_practice_areas (survey_id BIGINT, practice_area_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(survey_id, practice_area_id)) ENGINE = INNODB;
CREATE TABLE survey_special_criterias (survey_id BIGINT, special_criteria_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(survey_id, special_criteria_id)) ENGINE = INNODB;
CREATE TABLE survey_states (survey_id BIGINT, state_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(survey_id, state_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_forgot_password (id BIGINT AUTO_INCREMENT, user_id BIGINT NOT NULL, unique_key VARCHAR(255), expires_at DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_group (id BIGINT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_group_permission (group_id BIGINT, permission_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(group_id, permission_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_permission (id BIGINT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_remember_key (id BIGINT AUTO_INCREMENT, user_id BIGINT, remember_key VARCHAR(32), ip_address VARCHAR(50), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user (id BIGINT AUTO_INCREMENT, first_name VARCHAR(255), last_name VARCHAR(255), email_address VARCHAR(255) NOT NULL UNIQUE, username VARCHAR(128) NOT NULL, algorithm VARCHAR(128) DEFAULT 'sha1' NOT NULL, salt VARCHAR(128), password VARCHAR(128), is_active TINYINT(1) DEFAULT '1', is_super_admin TINYINT(1) DEFAULT '0', last_login DATETIME, phone_number VARCHAR(100), client_id BIGINT, is_client_admin TINYINT(1) DEFAULT '0', is_visible TINYINT(1) DEFAULT '1', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX is_active_idx_idx (is_active), INDEX client_id_idx (client_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_group (user_id BIGINT, group_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(user_id, group_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_permission (user_id BIGINT, permission_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(user_id, permission_id)) ENGINE = INNODB;
ALTER TABLE practice_areas ADD CONSTRAINT practice_areas_main_practice_area_id_main_practice_areas_id FOREIGN KEY (main_practice_area_id) REFERENCES main_practice_areas(id) ON DELETE CASCADE;
ALTER TABLE surveys ADD CONSTRAINT surveys_survey_region_id_regions_id FOREIGN KEY (survey_region_id) REFERENCES regions(id) ON DELETE CASCADE;
ALTER TABLE surveys ADD CONSTRAINT surveys_survey_contact_id_survey_contacts_id FOREIGN KEY (survey_contact_id) REFERENCES survey_contacts(id) ON DELETE CASCADE;
ALTER TABLE surveys ADD CONSTRAINT surveys_survey_city_id_cities_id FOREIGN KEY (survey_city_id) REFERENCES cities(id) ON DELETE CASCADE;
ALTER TABLE surveys ADD CONSTRAINT surveys_organization_id_organizations_id FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE;
ALTER TABLE survey_countries ADD CONSTRAINT survey_countries_survey_id_surveys_id FOREIGN KEY (survey_id) REFERENCES surveys(id) ON DELETE CASCADE;
ALTER TABLE survey_countries ADD CONSTRAINT survey_countries_country_id_countries_id FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE CASCADE;
ALTER TABLE survey_practice_areas ADD CONSTRAINT survey_practice_areas_survey_id_surveys_id FOREIGN KEY (survey_id) REFERENCES surveys(id) ON DELETE CASCADE;
ALTER TABLE survey_practice_areas ADD CONSTRAINT survey_practice_areas_practice_area_id_practice_areas_id FOREIGN KEY (practice_area_id) REFERENCES practice_areas(id) ON DELETE CASCADE;
ALTER TABLE survey_special_criterias ADD CONSTRAINT survey_special_criterias_survey_id_surveys_id FOREIGN KEY (survey_id) REFERENCES surveys(id) ON DELETE CASCADE;
ALTER TABLE survey_special_criterias ADD CONSTRAINT sssi FOREIGN KEY (special_criteria_id) REFERENCES special_criterias(id) ON DELETE CASCADE;
ALTER TABLE survey_states ADD CONSTRAINT survey_states_survey_id_surveys_id FOREIGN KEY (survey_id) REFERENCES surveys(id) ON DELETE CASCADE;
ALTER TABLE survey_states ADD CONSTRAINT survey_states_state_id_states_id FOREIGN KEY (state_id) REFERENCES states(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_forgot_password ADD CONSTRAINT sf_guard_forgot_password_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_remember_key ADD CONSTRAINT sf_guard_remember_key_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user ADD CONSTRAINT sf_guard_user_client_id_clients_id FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;
