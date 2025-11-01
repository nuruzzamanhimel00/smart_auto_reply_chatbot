# SMART AUTO REPLY CHATBOT


## Description

A Smart Auto Reply Chatbot designed to automate responses in real-time conversations. Built with Laravel and Vue.js, this project provides a robust foundation for developing intelligent chatbots that can understand user queries and deliver instant, context-aware replies. Ideal for customer support, FAQs, and interactive web applications.

This is a Laravel Vue.js project starter. It has some basic setup for your new projects startup. It's help full for every new project starter.

## Prerequisites

Before you begin, ensure you have met the following requirements:

-   [Node.js](https://nodejs.org/) installed v22 stable
-   [Composer](https://getcomposer.org/) installed v2.7.4
-   [PHP](https://www.php.net/) installed v^8.3
-   [Laravel](https://laravel.com/) v12
-   [NPM](https://www.npmjs.com/) or [Yarn](https://yarnpkg.com/) installed or br [Bun](https://bun.sh/docs/installation) Preferred to Bun

## Setup Instructions

To set up this project locally, follow these steps:

1. Clone the repository:

    ```bash
    git clone https://github.com/nuruzzamanhimel00/smart_auto_reply_chatbot.git
    ```

2. Navigate into the project directory:

    ```bash
    cd smart_auto_reply_chatbot

    ```

3. Install PHP dependencies using Composer:

    ```bash
    composer install
    ```

4. Install JavaScript dependencies using NPM or Yarn:

    ```bash
    bun install
    ```
   ### or
    ```bash
    npm install
    ```
   ### or

    ```bash
    yarn install
    ```

5. Copy the `.env.example` file and rename it to `.env`:

    ```bash
    cp .env.example .env
    ```

6. Generate an application key:

    ```bash
    php artisan key:generate
    ```

7. Configure your database settings in the `.env` file.

8. Run database migrations:

    ```bash
    php artisan migrate:fresh --seed
    ```


10. Compile front-end assets:

    ```bash
    npm run dev
    # or
    yarn dev
    ```

11. Start the development server:

    ```bash
    php artisan serve
    ```

12. Start the Queue Listen:

    ```bash
    php artisan queue:listen
    ```
12. Start the Reverb:

    ```bash
    php artisan reverb:start
    ```
12. Run the Scheduler:

    ```bash
    php artisan schedule:run
    ```

12. Visit `http://localhost:8000` in your browser to see the application.

## Usage

Provide instructions on how to use your application here. Include any necessary steps, commands, or configurations.

## Authors of this repo

### Regards  [Md Nuruzzaman](https://github.com/nuruzzamanhimel00)

## Contributors
[Md Nuruzzaman](https://github.com/nuruzzamanhimel00)
