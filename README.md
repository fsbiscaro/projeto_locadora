# 🎮 Sistema de Empréstimos de Jogos em PHP

Este é um projeto de backend construído em **PHP**, utilizando **MySQL** como banco de dados, com autenticação via **JWT** e estrutura de **rotas REST**. Ele simula uma **locadora de jogos**, onde usuários podem se cadastrar, visualizar jogos disponíveis e realizar empréstimos.

---

## 🗂️ Estrutura do Banco de Dados

O sistema é composto por 5 tabelas principais:

| Tabela               | Descrição |
|----------------------|-----------|
| `usuario`            | Armazena os dados dos usuários (clientes). |
| `jogos`              | Contém os jogos disponíveis para empréstimo. |
| `categoria_jogo`     | Classificações (categorias) dos jogos, como Aventura, Ação, etc. |
| `emprestimo_usuario` | Representa cada empréstimo feito por um usuário. |
| `itens_emprestimo`   | Armazena os jogos individuais contidos em cada empréstimo. |

---

### 🔗 Relacionamentos:

- **Usuário (1:N) Empréstimos:** Um usuário pode ter vários empréstimos.
- **Jogo (1:N) Itens de Empréstimo:** Um jogo pode estar em vários empréstimos.
- **Empréstimo (1:N) Itens de Empréstimo:** Um empréstimo pode conter vários jogos.
- **Categoria (1:N) Jogos:** Uma categoria pode ter vários jogos.

---

## 🔐 Autenticação

O sistema utiliza **JWT (JSON Web Token)** para autenticação. Os endpoints protegidos exigem que o token seja enviado no header da requisição:

```
Authorization: Bearer <token>
```

---

## 📌 Funcionalidades

- [x] Cadastro e autenticação de usuários
- [x] CRUD de jogos
- [x] Classificação de jogos por categoria
- [x] Registro de empréstimos
- [x] Listagem dos jogos emprestados por usuário
- [x] Proteção de rotas com JWT

---

## 📁 Estrutura de Pastas

```
/controle            → Controladores (rotas)
/modelo              → Classes de modelo e conexão com o banco
README.md
```

---

## 📌 Requisitos

- PHP 7.4+
- MySQL 5.7+
- Extensão `openssl` habilitada (para JWT)

---

## 🧠 Autor

Desenvolvido por [Felipe Santos Biscaro](https://github.com/fsbiscaro) como projeto de prática em PHP e banco de dados.

---

## 📝 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.
