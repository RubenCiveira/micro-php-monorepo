--liquibase formatted sql

--changeset auto.generated:1825492372-1
CREATE TABLE agent (uid INT NOT NULL, version INT NOT NULL, name VARCHAR(255) NOT NULL, CONSTRAINT PK_AGENT PRIMARY KEY (uid));

--changeset auto.generated:1825492372-2
CREATE TABLE agent_execution_group (uid INT NOT NULL, version INT NOT NULL, agent INT NOT NULL, `group` INT NOT NULL, CONSTRAINT PK_AGENT_EXECUTION_GROUP PRIMARY KEY (uid));

--changeset auto.generated:1825492372-3
CREATE TABLE execution_group (uid INT NOT NULL, version INT NOT NULL, name VARCHAR(255) NOT NULL, CONSTRAINT PK_EXECUTION_GROUP PRIMARY KEY (uid));

--changeset auto.generated:1825492372-4
CREATE INDEX FK_AGENT_EXECUTION_GROUP_GROUP ON agent_execution_group(`group`);

--changeset auto.generated:1825492372-5
CREATE INDEX FL_AGENT_EXECUTION_GROUP_AGENT ON agent_execution_group(agent);

--changeset auto.generated:1825492372-6
ALTER TABLE agent_execution_group ADD CONSTRAINT FK_AGENT_EXECUTION_GROUP_AGENT FOREIGN KEY (agent) REFERENCES agent (uid) ON UPDATE RESTRICT ON DELETE RESTRICT;

--changeset auto.generated:1825492372-7
ALTER TABLE agent_execution_group ADD CONSTRAINT FK_AGENT_EXECUTION_GROUP_GROUP FOREIGN KEY (`group`) REFERENCES execution_group (uid) ON UPDATE RESTRICT ON DELETE RESTRICT;
--liquibase formatted sql

--changeset auto.generated:250139598-1
CREATE UNIQUE INDEX UK_AGENT_NAME_UNIQUE ON agent(name);

--changeset auto.generated:250139598-2
CREATE UNIQUE INDEX UK_EXECUTION_GROUP_NAME_UNIQUE ON execution_group(name);
