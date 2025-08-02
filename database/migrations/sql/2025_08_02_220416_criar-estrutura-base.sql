CREATE EXTENSION IF NOT EXISTS pgcrypto
;
CREATE EXTENSION IF NOT EXISTS unaccent
;
CREATE EXTENSION IF NOT EXISTS hstore
;

create schema if not exists auditoria
;

create table auditoria.registro (
    registro_id bigserial constraint pk_registro primary key,
    usuario_criacao_id   bigint,
    usuario_alteracao_id bigint,
    usuario_exclusao_id  bigint,
    data_criacao         timestamp(0) DEFAULT now() NOT NULL,
    data_alteracao       timestamp(0) DEFAULT now() NOT NULL,
    data_exclusao        timestamp(0)
) with (autovacuum_enabled = true)
;
