# 🛠️ ServiceHub - Backend Challenge

Este projeto é uma solução de gestão de tickets de suporte, desenvolvida com foco em **arquitetura robusta, testes automatizados e processamento assíncrono**. A prioridade foi garantir a integridade dos dados e a escalabilidade do motor de processamento, entregando uma base de código preparada para produção.

---

## 🎯 Foco Técnico e Diferenciais

* **Desenvolvimento Orientado a Testes (TDD):** A aplicação possui uma suíte de testes completa utilizando **Pest PHP**. Foram testados desde os relacionamentos de modelos e Enums até o comportamento complexo de *Jobs* e *Notifications*.
* **Processamento em Background (Queues):** A lógica de leitura e processamento de anexos foi isolada em **Jobs assíncronos**. Isso garante que o utilizador não sofra latência ao carregar ficheiros, delegando o trabalho pesado para o worker.
* **Integridade via Transações:** O processo de criação de tickets e detalhes é envolto em **DB Transactions**, garantindo que o sistema nunca fique em estado inconsistente (dados órfãos) em caso de falha no upload ou persistência.
* **Escopo Estratégico:** O foco foi a excelência no **Back-end**. Funcionalidades de CRUD básico (como editar ou eliminar) foram preteridas para priorizar a implementação técnica de Filas, Notificações e Testes de Integração.

---

## 🚀 Como Executar o Projeto

### Pré-requisitos
* **PHP 8.2+**
* **Composer** & **Node.js (NPM)**
* **MySQL**

### Instalação Manual

1.  **Clonar o repositório e instalar dependências:**
    ```bash
    git clone https://github.com/josafatngoma/ServiceHub-laravel-inertia-vue.git
    ```
    ```bash
    composer install
    npm install
    ```

2.  **Configuração de Ambiente:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    > **Nota:** Configure a sua base de dados no ficheiro `.env` antes de prosseguir.

3.  **Migrações e Dados Iniciais (Seeders):**
    O projeto inclui **Seeders** para que o ambiente esteja pronto para uso imediato, com usuário, empresa, projetos e tickets pré-configurados.
    ```bash
    php artisan migrate --seed
    ```

4.  **Execução:**
    ```bash
    php artisan serve
    npm run dev
    OU
    composer run dev
    ```

### Via Laravel Sail (Docker)
```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate --seed
```

## ⚙️ Processamento de Filas e Notificações

Para testar o fluxo completo de processamento de anexos e enriquecimento de dados:

1. **Certifique-se que o worker das filas está a correr:**
   ```bash
   php artisan queue:work

**Fluxo:** Ao submeter um ticket com um ficheiro `.json` ou `.txt`, o sistema processa os dados via **Job** e dispara uma **Notificação** (Email e Base de Dados) para o utilizador responsável.

---

## 🧪 Testes

Para validar a qualidade e segurança do código entregue:

```bash
php artisan test