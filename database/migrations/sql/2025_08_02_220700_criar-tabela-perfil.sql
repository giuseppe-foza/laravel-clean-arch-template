create table usuario.perfil
(
    id bigserial not null
        constraint pk_perfil
            primary key,

    nome   varchar not null,
    chave  varchar not null constraint un_perfil unique,
    ativo  boolean default true not null
) inherits (auditoria.registro) with (autovacuum_enabled = true);

create index ix_perfil_ativo ON usuario.perfil (ativo)
;
