create schema if not exists usuario
;
create table usuario.usuario (
     id bigserial not null
         constraint pk_usuario
             primary key,

     nome text not null,

     email text not null
         constraint un_usuario_email
             unique,

     senha text not null,
     ativo boolean not null default true,
     email_verificado boolean not null default false
) inherits (auditoria.registro) with (autovacuum_enabled = true)
;

create index ix_usuario_email on usuario.usuario (email)
;
