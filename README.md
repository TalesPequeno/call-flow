# 🏢 Sistema de Chamados Internos (Help Desk)

Sistema web para gestão de suporte corporativo, desenvolvido com **Laravel + Blade**, focado em organização de atendimentos, controle de usuários e fluxo de suporte interno.

---

## 🚀 Objetivo

Centralizar e organizar solicitações internas da empresa, permitindo acompanhamento de atendimentos, definição de responsáveis e controle de prioridades.

---

## 🛠️ Tecnologias Utilizadas

- Laravel  
- Blade  
- MySQL  
- Bootstrap  
- Eloquent ORM  
- Laravel Breeze (Autenticação)

---

## 👥 Perfis de Usuário

- **Funcionário** — Abertura e acompanhamento de chamados  
- **Técnico** — Atendimento e atualização de status  
- **Admin** — Gestão completa do sistema e usuários  

Sistema com **controle de acesso baseado em papéis (RBAC)**.

---

## ✨ Funcionalidades

✔ Autenticação de usuários  
✔ Controle de permissões por perfil  
✔ Histórico de interações  
✔ Upload de anexos  
✔ Notificações por e-mail  
✔ Filtros e paginação  
✔ Logs de alterações  
✔ Soft delete  

---

## 🧠 Conceitos Aplicados

- Arquitetura MVC  
- Relacionamentos Eloquent  
- Policies / Gates  
- Form Requests  
- Notificações  
- Regras de negócio  
- Paginação e filtros  

---

## ⚙️ Instalação

```bash
git clone https://github.com/TalesPequeno/call-flow.git
cd call-flow

composer install
cp .env.example .env
php artisan key:generate

# Configurar o banco no .env
php artisan migrate

npm install
npm run dev

php artisan serve
