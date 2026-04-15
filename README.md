# 📰 Portal Investidor10 (News Board)

Desafio técnico desenvolvido utilizando **Laravel 11**, **Vue.js 3** e **Tailwind CSS**. Este sistema atua como um portal profissional de notícias, contando com uma interface pública de leitura e um painel administrativo completo (SPA) para gerenciamento das publicações.

---

## 🚀 Tecnologias Utilizadas

- **Backend:** Laravel 11 (PHP 8.2+)
- **Frontend:** Vue.js 3 (Composition API) via CDN + Tailwind CSS
- **Banco de Dados:** MySQL 8.0
- **Ambiente de Desenvolvimento:** Docker (Laravel Sail)

---

## ⚙️ Pré-requisitos

Para rodar este projeto em sua máquina localmente, você não precisa ter PHP ou MySQL instalados. Tudo o que você precisa é:

- [Git](https://git-scm.com/)
- [Docker Desktop](https://www.docker.com/products/docker-desktop/) rodando em sua máquina
- (No Windows, recomenda-se a utilização do WSL2)

---

## 🛠️ Como instalar e rodar a aplicação

Siga o passo a passo abaixo no seu terminal para colocar o projeto no ar:

### 1. Clonar o repositório
```bash
git clone https://github.com/NelcinoJr/news-board.git
cd news-board
```

### 2. Configurar o arquivo de Ambiente (.env)
O projeto necessita do arquivo `.env` para conectar no banco de dados.
```bash
cp .env.example .env
```

Abra o arquivo `.env` recém-criado e verifique se as configurações de banco estão assim:
```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=news_board
DB_USERNAME=sail
DB_PASSWORD=password
```
*(Nota: Para evitar conflitos de porta com instalações locais como XAMPP, você pode definir `APP_PORT=8080` e `FORWARD_DB_PORT=3307` no `.env`).*

### 3. Subir os contêineres do Docker
Para baixar o PHP, MySQL e subir a aplicação, utilize o Laravel Sail:
```bash
./vendor/bin/sail up -d
```
*(Se for a primeira vez que executa este comando, ele pode demorar alguns minutos para baixar as imagens do Docker).*

### 4. Gerar a chave da Aplicação
```bash
./vendor/bin/sail artisan key:generate
```

### 5. Preparar o Banco de Dados e as Imagens
Execute as Migrations para criar as tabelas e crie o link simbólico das imagens:
```bash
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan storage:link
```

### 6. 🪄 A Mágica: Popular o Banco de Dados (Seed)
Eu criei um *Database Seeder* automatizado. Ao rodar o comando abaixo, o banco será **automaticamente preenchido com 5 Categorias e 50 Notícias financeiras reais**, todas vinculadas a imagens profissionais de alta qualidade:

```bash
./vendor/bin/sail artisan db:seed
```

---

## 💻 Acessando o Sistema

Pronto! Agora é só abrir o seu navegador e acessar:

👉 **Portal Público (Leitura):** [http://localhost](http://localhost) *(ou `http://localhost:8080` dependendo do seu `.env`)*  
👉 **Painel Admin (Gerenciamento):** [http://localhost/admin](http://localhost/admin) *(ou `http://localhost:8080/admin`)*

### O que você encontrará:
- **Painel Admin (SPA):** Permite Criar categorias, Criar, Editar e Excluir notícias. Suporta upload de imagens de capa reais. A interface é totalmente reativa e feita com Vue.js.
- **Portal Principal:** Sistema visual parecido com o G1/Investidor10. Possui um carrossel de manchetes e um filtro de categorias por abas totalmente sem recarregamento de página.

---

## 👨‍💻 Autor
Desafio Técnico desenvolvido por Nelcino Junior.
