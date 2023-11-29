--liquibase formatted sql

--changeset auto.generated:1825492372-1
CREATE TABLE config (uid INT NOT NULL, version INT NOT NULL, property VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, service INT NOT NULL, CONSTRAINT PK_CONFIG PRIMARY KEY (uid));

--changeset auto.generated:1825492372-2
CREATE TABLE host (uid INT NOT NULL, version INT NOT NULL, name VARCHAR(255) NOT NULL, service INT NOT NULL, CONSTRAINT PK_HOST PRIMARY KEY (uid));

--changeset auto.generated:1825492372-3
CREATE TABLE service (uid INT NOT NULL, version INT NOT NULL, name VARCHAR(255) NOT NULL, CONSTRAINT PK_SERVICE PRIMARY KEY (uid));

--changeset auto.generated:1825492372-4
CREATE INDEX FL_CONFIG_SERVICE ON config(service);

--changeset auto.generated:1825492372-5
CREATE INDEX FL_HOST_SERVICE ON host(service);

--changeset auto.generated:1825492372-6
ALTER TABLE config ADD CONSTRAINT FK_CONFIG_SERVICE FOREIGN KEY (service) REFERENCES service (uid) ON UPDATE RESTRICT ON DELETE RESTRICT;

--changeset auto.generated:1825492372-7
ALTER TABLE host ADD CONSTRAINT FK_HOST_SERVICE FOREIGN KEY (service) REFERENCES service (uid) ON UPDATE RESTRICT ON DELETE RESTRICT;
--liquibase formatted sql

--changeset auto.generated:250139598-1
CREATE UNIQUE INDEX UK_HOST_NAME_UNIQUE ON host(name);

--changeset auto.generated:250139598-2
CREATE UNIQUE INDEX UK_SERVICE_NAME_UNIQUE ON service(name);
