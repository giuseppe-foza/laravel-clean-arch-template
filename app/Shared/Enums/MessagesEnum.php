<?php
declare(strict_types=1);

namespace App\Shared\Enums;

enum MessagesEnum
{
    const string ERRO_INTERNO = 'Erro interno de servidor.';
    const string USUARIO_NAO_ENCONTRADO = 'Usuário não encontrado.';
    const string USUARIO_EMAIL_JA_EXISTE = 'Já existe um usuário com o e-mail informado.';
    const string EMAIL_OU_SENHA_INCORRETOS = 'E-mail ou senha incorretos.';
    const string USUARIO_INATIVO = 'Usuário inativo. Entre em contato com o suporte para verificar seu acesso.';
    const string PERMISSAO_NEGADA = 'Você não tem permissão para acessar este recurso.';
    const string CONTEXTO_AUTENTICAO_NAO_INICIALIZADO = 'AuthContext acessado antes de ser inicializado.';
    const string CONTEXTO_AUTENTICAO_NAO_INJETADO = 'AuthContext não foi injetado corretamente.';
    const string TOKEN_INVALIDO = 'Token inválido.';
    const string NAO_AUTORIZADO = 'Não autorizado.';
    const string REGISTRO_NAO_ENCONTRADO = 'Registro não encontrado.';
    const string PERFIL_NAO_ENCONTRADO = 'Perfil não encontrado.';
}
