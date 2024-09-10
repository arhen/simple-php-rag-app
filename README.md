# RAG Chat

<p align="center">
  <img src="/public/images/rag.webp" alt="RAG Chat Logo" width="200">
</p>

RAG Chat is a web application that demonstrates the power of Retrieval-Augmented Generation (RAG) for more accurate and informative conversations. This application is built using Laravel, Vue.js, and integrates with AI models to provide enhanced chat experiences.

## Features

- Retrieval-Augmented Generation for improved accuracy in responses
- Real-time chat interface
- Integration with external knowledge bases
- User-friendly and responsive design
- Social media authentication (Google)
- Admin authentication using Laravel Breeze

## Technologies

- PHP 8.1+
- Laravel 11+
- Inertia.js with Vue 3
- LLphant for RAG implementation
- Supabase for vector database
- Laravel Breeze for admin authentication
- Laravel Socialite for social media authentication (Google)

## Requirements

- PHP 8.1+
- Composer
- Node.js 14+ and npm
- PostgreSQL database
- OpenAI API key
- Supabase account and API key
- Google OAuth credentials

## Installation

1. Clone the repository:
   ```
   git clone https://github.com/your-username/rag-chat.git
   cd rag-chat
   ```

2. Install PHP dependencies:
   ```
   composer install
   ```

3. Install JavaScript dependencies:
   ```
   npm install
   ```

4. Copy the `.env.example` file to `.env` and configure your environment variables:
   ```
   cp .env.example .env
   ```

5. Generate an application key:
   ```
   php artisan key:generate
   ```

6. Set up your database in the `.env` file and run migrations:
   ```
   php artisan migrate
   ```

7. Configure your API keys and credentials in the `.env` file:
   ```
   OPENAI_API_KEY=your_openai_api_key
   SUPABASE_URL=your_supabase_url
   SUPABASE_KEY=your_supabase_key
   GOOGLE_CLIENT_ID=your_google_client_id
   GOOGLE_CLIENT_SECRET=your_google_client_secret
   # update .env database connection for supabase
   DB_CONNECTION=pgsql
   DB_HOST=your_supabase_host
   DB_PORT=your_supabase_port
   DB_DATABASE=your_supabase_database
   DB_USERNAME=your_supabase_username
   DB_PASSWORD=your_supabase_password
   ```

8. Build the frontend assets:
   ```
   npm run build
   ```

9. Start the development server:
   ```
   php artisan serve
   ```

10. Visit `http://localhost:8000` in your browser to use the application.

## Usage

1. Navigate to the welcome page to learn about RAG technology.
2. Sign in using your Google account or create an admin account.
3. Click on "Start Chatting" to begin a conversation.
4. Type your questions or prompts in the chat interface.
5. Receive AI-generated responses enhanced by RAG technology.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
