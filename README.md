# Laravel Vue Chat AI

## About the Project

Laravel Vue Chat AI is a real-time chat application powered by artificial intelligence. This project combines the robust backend capabilities of Laravel with the dynamic frontend features of Vue.js to deliver an interactive and intelligent chat experience. The application is designed to provide seamless communication with AI-driven responses, making it suitable for customer support, virtual assistants, and other conversational AI use cases.

## Features

- **Real-Time Messaging**: Instant communication between users with real-time updates.
- **AI-Powered Responses**: Leverages AI to provide intelligent and context-aware replies.
- **User Authentication**: Secure login and registration system using Laravel Jetstream.
- **Responsive Design**: Fully responsive UI for both desktop and mobile devices.
- **Sidebar Navigation**: Easy-to-use sidebar for quick access to chat rooms.
<!-- - **Team Management**: Manage multiple teams and switch between them effortlessly. -->
- **Profile Management**: Update user profiles, including profile photos and personal details.
- **Multilingual Support**: Communicate in multiple languages with built-in support.
- **Privacy and Security**: Ensures secure and private conversations.

## Technology Stack

- **Backend**: Laravel (PHP Framework)
- **Frontend**: Vue.js (JavaScript Framework)
<!-- - **Real-Time Communication**: Laravel Echo and Pusher -->
- **AI Integration**: DEEPINFRA API or similar AI service
- **Database**: PostgreSQL
- **Authentication**: Laravel Jetstream with Inertia.js

## Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/your-username/laravel-vue-chat-ai.git
   cd laravel-vue-chat-ai
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Set up the environment**:
   - Copy `.env.example` to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Update the `.env` file with your database and API credentials.

4. **Run migrations**:
   ```bash
   php artisan migrate
   ```

5. **Start the development server**:
   ```bash
   composer run dev
   ```

6. **Access the application**:
   Open your browser and navigate to:
   ```
   http://localhost:8000
   ```

## Usage

1. **Log in or register**: Access the chat interface after authentication.
2. **Start a conversation**: Chat with the AI or other users in real-time.
3. **Manage your profile**: Update your profile and settings from the sidebar.

## API Integration

This project integrates with external APIs for AI responses and other features:
- **OpenAI API**: Used for generating AI-powered responses.
- **DeepInfra API**: Utilized for generating conversation titles.

Ensure you configure the required API keys in the `.env` file:
```env
OPENAI_API_KEY=your_openai_api_key // if you have access to openai credits
DEEPINFRA_API_KEY=your_deepinfra_api_key // alternative and uses the openai models
```

## Database Schema

The application uses the following database tables:
- **users**: Stores user information.
- **chat_messages**: Stores user prompts and AI replies.
- **personal_access_tokens**: Manages API tokens for authentication.
- **cache**: Handles caching for improved performance.
- **jobs**: Manages queued jobs for background processing.

Run `php artisan migrate` to create these tables.

## Contributing

Contributions are welcome! Please follow these steps:
1. Fork the repository.
2. Create a new branch for your feature or bug fix.
3. Commit your changes and push them to your fork.
4. Submit a pull request.

## License

This project is open-source and available under the [MIT License](LICENSE).

## Acknowledgments

- [Laravel](https://laravel.com/)
- [Vue.js](https://vuejs.org/)
- [OpenAI](https://openai.com/)
- [DeepInfra](https://deepinfra.com/)