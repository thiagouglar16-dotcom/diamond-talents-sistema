-- =============================================
-- SISTEMA DIAMOND TALENTS BRASIL
-- Banco de dados completo
-- =============================================

CREATE DATABASE IF NOT EXISTS diamond_talents CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE diamond_talents;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(50) NOT NULL UNIQUE,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100),
  senha VARCHAR(255) NOT NULL,
  empresa ENUM('RS','SC','RS E SC') DEFAULT 'RS E SC',
  ativo TINYINT(1) DEFAULT 1,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Senha padrão: admin123
INSERT INTO usuarios (usuario,nome,email,senha,empresa) VALUES
('admin','Administrador','admin@diamond.com.br','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','RS E SC'),
('brendon','Brendon Rodrigues','brendon@diamond.com.br','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','RS E SC');

CREATE TABLE produtoras (
  id INT AUTO_INCREMENT PRIMARY KEY,
  empresa ENUM('RS','SC','RS E SC') NOT NULL DEFAULT 'RS',
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100), telefone VARCHAR(30),
  situacao ENUM('ATIVO','INATIVO') DEFAULT 'ATIVO',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE scouters (
  id INT AUTO_INCREMENT PRIMARY KEY,
  empresa ENUM('RS','SC','RS E SC') NOT NULL DEFAULT 'RS E SC',
  nome VARCHAR(100) NOT NULL, codigo VARCHAR(20),
  email VARCHAR(100), telefone VARCHAR(30),
  situacao ENUM('ATIVO','INATIVO') DEFAULT 'ATIVO',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE telemarketings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  empresa ENUM('RS','SC','RS E SC') NOT NULL DEFAULT 'RS E SC',
  nome VARCHAR(100) NOT NULL, codigo VARCHAR(20),
  email VARCHAR(100), telefone VARCHAR(30),
  situacao ENUM('ATIVO','INATIVO') DEFAULT 'ATIVO',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE agencias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  empresa ENUM('RS','SC','RS E SC') NOT NULL DEFAULT 'RS E SC',
  nome VARCHAR(150) NOT NULL, email VARCHAR(100), site VARCHAR(150),
  telefone VARCHAR(30), contato VARCHAR(100), cidade VARCHAR(100), estado VARCHAR(2),
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE talentos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  empresa ENUM('RS','SC') NOT NULL DEFAULT 'RS',
  nome VARCHAR(150) NOT NULL, nome_artistico VARCHAR(100),
  sexo ENUM('MASCULINO','FEMININO') NOT NULL,
  data_nascimento DATE, rg VARCHAR(30), cpf VARCHAR(20), foto VARCHAR(255),
  resp_nome VARCHAR(150), resp_parentesco VARCHAR(50),
  resp_documento_tipo VARCHAR(10), resp_documento VARCHAR(30),
  resp_email VARCHAR(100), resp_telefone VARCHAR(30),
  pais VARCHAR(50) DEFAULT 'BRASIL', cep VARCHAR(10),
  estado VARCHAR(50) DEFAULT 'RIO GRANDE DO SUL',
  cidade VARCHAR(100) DEFAULT 'PORTO ALEGRE',
  bairro VARCHAR(100), logradouro VARCHAR(200), numero VARCHAR(20), complemento VARCHAR(100),
  email VARCHAR(100), telefone VARCHAR(30), telefone2 VARCHAR(30),
  cor_olhos VARCHAR(50), cor_cabelos VARCHAR(50), cor_pele VARCHAR(50),
  cicatriz TINYINT(1) DEFAULT 0, tatuagem TINYINT(1) DEFAULT 0,
  altura DECIMAL(5,2), confeccao VARCHAR(20), calcado VARCHAR(20),
  peso DECIMAL(5,2), torax_busto DECIMAL(5,2), quadril DECIMAL(5,2), cintura DECIMAL(5,2),
  obs_caracteristicas TEXT, trabalhou_antes TINYINT(1) DEFAULT 0,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE primeiro_contato (
  id INT AUTO_INCREMENT PRIMARY KEY,
  empresa ENUM('RS','SC') NOT NULL DEFAULT 'RS',
  talento_nome VARCHAR(150) NOT NULL, talento_idade INT,
  resp_nome VARCHAR(150), telefone VARCHAR(30), telefone2 VARCHAR(30),
  pais VARCHAR(50) DEFAULT 'BRASIL', estado VARCHAR(50), cidade VARCHAR(100),
  telemarketing_id INT, scouter_id INT,
  situacao VARCHAR(80) DEFAULT 'ABORDAGEM REALIZADA', situacao2 VARCHAR(80),
  observacoes TEXT, data_atendimento DATE,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (telemarketing_id) REFERENCES telemarketings(id) ON DELETE SET NULL,
  FOREIGN KEY (scouter_id) REFERENCES scouters(id) ON DELETE SET NULL
);

CREATE TABLE eventos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  empresa ENUM('RS','SC') NOT NULL DEFAULT 'RS',
  nome VARCHAR(150) NOT NULL, local_evento VARCHAR(200),
  data_evento DATE, hora_inicio TIME, hora_fim TIME,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE workshops (
  id INT AUTO_INCREMENT PRIMARY KEY,
  empresa ENUM('RS','SC') NOT NULL DEFAULT 'RS',
  nome VARCHAR(150) NOT NULL, data_aula DATE, horario VARCHAR(50),
  tipo VARCHAR(100), local_aula VARCHAR(200),
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE contratos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  numero VARCHAR(20) NOT NULL UNIQUE,
  tipo ENUM('COMPLETO','DIAMOND_MAIS','APENAS_FOTOS') DEFAULT 'COMPLETO',
  empresa ENUM('RS','SC') NOT NULL DEFAULT 'RS',
  talento_id INT NOT NULL, produtora_id INT, evento_id INT,
  data_contrato DATE NOT NULL, credencial VARCHAR(20), local_contrato VARCHAR(150),
  val_plataforma DECIMAL(10,2) DEFAULT 0, val_preparacao DECIMAL(10,2) DEFAULT 0,
  val_apresentacao DECIMAL(10,2) DEFAULT 0, val_fotos DECIMAL(10,2) DEFAULT 0,
  patrocinio_pct INT DEFAULT 0, total_contrato DECIMAL(10,2) DEFAULT 0,
  parcela_numero INT DEFAULT 1, parcela_valor DECIMAL(10,2) DEFAULT 0,
  parcela_vencimento DATE, parcela_tipo VARCHAR(30),
  situacao ENUM('ATIVO','CANCELADO','QUITADO') DEFAULT 'ATIVO',
  camiseta_recebeu TINYINT(1), aprovacoes TEXT, assinado TINYINT(1) DEFAULT 0,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (talento_id) REFERENCES talentos(id),
  FOREIGN KEY (produtora_id) REFERENCES produtoras(id) ON DELETE SET NULL,
  FOREIGN KEY (evento_id) REFERENCES eventos(id) ON DELETE SET NULL
);

CREATE TABLE contrato_parcelas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  contrato_id INT NOT NULL, numero_parcela INT NOT NULL,
  valor DECIMAL(10,2) NOT NULL, vencimento DATE,
  pago TINYINT(1) DEFAULT 0, data_pagamento DATE,
  tipo_pagamento VARCHAR(50), cartao_final VARCHAR(10),
  FOREIGN KEY (contrato_id) REFERENCES contratos(id) ON DELETE CASCADE
);

CREATE TABLE fotografos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  empresa ENUM('RS','SC','RS E SC') NOT NULL DEFAULT 'RS',
  nome VARCHAR(100) NOT NULL, email VARCHAR(100), telefone VARCHAR(30),
  situacao ENUM('ATIVO','INATIVO') DEFAULT 'ATIVO',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE locais_fotos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  empresa ENUM('RS','SC') NOT NULL DEFAULT 'RS',
  identificacao VARCHAR(200) NOT NULL,
  situacao ENUM('LIBERADO','BLOQUEADO') DEFAULT 'BLOQUEADO',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE agendamentos_fotos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  empresa ENUM('RS','SC') NOT NULL DEFAULT 'RS',
  contrato_id INT, talento_id INT, fotografo_id INT, local_id INT,
  data_agendamento DATE, horario TIME,
  situacao ENUM('AGENDADO','REALIZADO','CANCELADO') DEFAULT 'AGENDADO',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (contrato_id) REFERENCES contratos(id) ON DELETE SET NULL,
  FOREIGN KEY (talento_id) REFERENCES talentos(id) ON DELETE SET NULL,
  FOREIGN KEY (fotografo_id) REFERENCES fotografos(id) ON DELETE SET NULL,
  FOREIGN KEY (local_id) REFERENCES locais_fotos(id) ON DELETE SET NULL
);

CREATE TABLE grade_horaria (
  id INT AUTO_INCREMENT PRIMARY KEY,
  empresa ENUM('RS','SC') NOT NULL DEFAULT 'RS',
  fotografo_id INT, data_grade DATE NOT NULL,
  horario_inicio TIME, horario_fim TIME, disponivel TINYINT(1) DEFAULT 1,
  FOREIGN KEY (fotografo_id) REFERENCES fotografos(id) ON DELETE CASCADE
);
