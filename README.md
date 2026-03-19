# 💎 Diamond Talents Brasil — Sistema de Gerenciamento

Sistema web completo para gerenciamento de talentos, contratos, atendimentos e relatórios.
Réplica funcional do sistema original, desenvolvido com PHP + MySQL + Bootstrap 5.

---

## 📁 Estrutura de Arquivos

```
/
├── config/
│   └── database.php          # Configuração do banco de dados
├── includes/
│   ├── auth.php              # Autenticação e sessão
│   ├── header.php            # Cabeçalho + navbar
│   └── footer.php            # Rodapé
├── css/
│   └── custom.css            # Estilos customizados
├── js/
│   └── scripts.js            # Scripts jQuery/Bootstrap
├── uploads/
│   └── talentos/             # Fotos dos talentos
├── banco.sql                 # Estrutura + dados iniciais do banco
├── login.php                 # Tela de login
├── logout.php                # Encerrar sessão
├── index.php                 # Dashboard principal
├── talentos.php              # Listagem de talentos
├── cadastrar-talento.php     # Cadastro de novo talento
├── produtoras.php            # Gerenciar produtoras
├── scouters.php              # Gerenciar scouters
├── telemarketings.php        # Gerenciar telemarketing
├── agencias.php              # Gerenciar agências
├── fotografos.php            # Gerenciar fotógrafos
├── locais-para-fotos.php     # Locais de sessão fotográfica
├── contatos.php              # Primeiros contatos (leads)
├── contratos.php             # Gestão de contratos
├── lista-de-aprovados.php    # Aprovados por evento
├── excluir.php               # Handler de exclusões
├── relatorio-eventos.php     # Relatórios de eventos
├── relatorio-workshops.php   # Relatórios de workshops
├── relatorio-atendimentos.php# Relatórios de atendimentos
└── relatorio-administrativo.php # Relatórios administrativos
```

---

## 🚀 Como instalar

### Requisitos
- PHP 8.0+
- MySQL 5.7+ / MariaDB
- Servidor web: Apache ou Nginx
- (Recomendado) XAMPP, Laragon ou hospedagem cPanel

### Passo a passo

**1. Clone o repositório**
```bash
git clone https://github.com/thiagouglar16-dotcom/diamond-talents-sistema.git
```

**2. Crie o banco de dados**
```bash
mysql -u root -p < banco.sql
```
Ou importe o arquivo `banco.sql` pelo phpMyAdmin.

**3. Configure o banco**
Edite o arquivo `config/database.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'seu_usuario');
define('DB_PASS', 'sua_senha');
define('DB_NAME', 'diamond_talents');
```

**4. Configure as permissões da pasta de uploads**
```bash
chmod 755 uploads/
chmod 755 uploads/talentos/
```

**5. Acesse o sistema**
Abra no navegador: `http://localhost/diamond-talents-sistema/login.php`

---

## 🔑 Credenciais padrão

| Usuário | Senha     |
|---------|-----------|
| admin   | admin123  |
| brendon | admin123  |

> ⚠️ **Troque a senha após o primeiro acesso!**

---

## 🗂️ Módulos do sistema

| Módulo | Funcionalidade |
|--------|---------------|
| **Talentos** | Cadastro completo com fotos, medidas, características |
| **Produtoras** | Gestão de produtoras (RS/SC) |
| **Scouters** | Captadores de talentos |
| **Telemarketing** | Operadores de atendimento |
| **Agências** | Agências parceiras |
| **Primeiro contato** | Funil de leads com situações |
| **Contratos** | 3 tipos: Completo, Diamond+, Apenas Fotos |
| **Fotógrafos** | Cadastro e grade horária |
| **Locais para fotos** | Estúdios e locais de sessão |
| **Agendamentos** | Agendamento de sessões fotográficas |
| **Aprovados** | Lista de aprovados por evento |
| **Relatórios** | Eventos, Workshops, Atendimentos, Administrativo |

---

## 🛠️ Tecnologias

- **Backend:** PHP 8+ com PDO
- **Banco:** MySQL / MariaDB
- **Frontend:** Bootstrap 5.3 + jQuery 3.7
- **Ícones:** Bootstrap Icons
- **CEP:** ViaCEP API

---

## 📞 Suporte

Sistema desenvolvido como réplica do Diamond Talents Brasil.
Desenvolvido com ❤️ usando PHP + MySQL + Bootstrap 5.

© 2026 Diamond Talents Brasil
