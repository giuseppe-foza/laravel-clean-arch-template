create table usuario.usuario_perfil
(
    perfil_id  bigint not null
        constraint perfil_id_usuario_perfil
            references usuario.perfil
            deferrable initially deferred,

    usuario_id bigint not null
        constraint usuario_id_usuario_perfil
            references usuario.usuario
            deferrable initially deferred,

    constraint pk_usuario_perfil
        primary key (perfil_id, usuario_id)
) inherits (auditoria.registro) with (autovacuum_enabled = true)
;

create index ix_usuario_perfil_usuario on usuario.usuario_perfil (usuario_id)
;
create index ix_usuario_perfil_perfil on usuario.usuario_perfil (perfil_id)
;
create index ix_usuario_perfil_usuario_perfil ON usuario.usuario_perfil (usuario_id, perfil_id)
;
