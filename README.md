# Laravel Vue Chat AI

## About the Project

Laravel Vue Chat AI is a real-time chat application powered by artificial intelligence. This project combines the robust backend capabilities of Laravel with the dynamic frontend features of Vue.js to deliver an interactive and intelligent chat experience. The application is designed to provide seamless communication with AI-driven responses, making it suitable for customer support, virtual assistants, and other conversational AI use cases.

## Features

- **Real-Time Messaging**: Instant communication between users with real-time updates.
- **AI-Powered Responses**: Leverages AI to provide intelligent and context-aware replies.
- **User Authentication**: Secure login and registration system using Laravel Jetstream.
- **Responsive Design**: Fully responsive UI for both desktop and mobile devices.
- **Sidebar Navigation**: Easy-to-use sidebar for quick access to chat rooms and settings.
- **Team Management**: Manage multiple teams and switch between them effortlessly.
- **Profile Management**: Update user profiles, including profile photos and personal details.

## Technology Stack

- **Backend**: Laravel (PHP Framework)
- **Frontend**: Vue.js (JavaScript Framework)
- **Real-Time Communication**: Laravel Echo and Pusher
- **AI Integration**: OpenAI API or similar AI service
- **Database**: MySQL
- **Authentication**: Laravel Jetstream with Inertia.js

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/laravel-vue-chat-ai.git
   cd laravel-vue-chat-ai

2. Install dependencies:
   ```bash
   composer install
   npm install
  
3. Set up the environment:
   ```bash
   Copy .env.example to .env:
    cp .env.example .env

    Update the .env file with your database and API credentials.

4. Run migrations:
   ```bash
   php artisan migrate

5. Start the development server:
   ```bash
   composer run dev

6. Access the application at:
   ```bash
   http://localhost:8000.


Usage:
1. Log in or register to access the chat interface.
2. Start a conversation with the AI or other users in real-time.
3. Manage your profile and settings from the sidebar.