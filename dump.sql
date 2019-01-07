insert into recurso(id,nome) values(1,'Perfil de acesso');
insert into recurso(id,nome) values(2,'Usuario');
insert into recurso(id,nome) values(3,'Mensagem');
insert into recurso(id,nome) values(4,'Configuração');

insert into role(id,descricao,excluido,root) values('1','Administrador',0,1);
insert into role(id,descricao,excluido,root) values('2','Recursos Humanos',0,0);

insert into permissao(id, nome, descricao, Recurso_id) values(1,'role.manager', 'Gerenciar perfis de acesso',1);
insert into permissao(id, nome, descricao, Recurso_id) values(2,'user.manager','Gerenciar contas de qualquer usuario',2);
insert into permissao(id, nome, descricao, Recurso_id) values(3,'user.own.manager','Editar sua propria conta de usuario',2);
insert into permissao(id, nome, descricao, Recurso_id) values(4,'msg.own.manager','Enviar/Receber mensagens',3);
insert into permissao(id, nome, descricao, Recurso_id) values(5,'config.manager','Gerenciar configuração do sistema',4);

insert into role_permissao(Role_id, Permissao_id) values(2,1);
insert into role_permissao(Role_id, Permissao_id) values(2,2);
insert into role_permissao(Role_id, Permissao_id) values(2,3);
insert into role_permissao(Role_id, Permissao_id) values(2,4);

insert into usuario(id,nome,login,senha,status,Role_id) values(1,'Admin','admin','123',1,1);