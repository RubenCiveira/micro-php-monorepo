--liquibase formatted sql

--changeset auto.generated:1825492372-1
ALTER TABLE service ADD enabled BIT(1) DEFAULT 0 NULL;

