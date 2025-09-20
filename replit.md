# Replit.md - Educationali

## Overview

Educationali is a multilingual educational platform that connects teachers and students through live classes and test series. The platform features a public informational website, admin portal for management, teacher dashboard for conducting classes, and student dashboard for learning. Built with PHP and Supabase, it supports global operations with features like teacher verification, payment processing, live video classes, and comprehensive test management.

## User Preferences

Preferred communication style: Simple, everyday language.

## System Architecture

### Frontend Architecture
- **Technology**: PHP-based web application with responsive design
- **UI Framework**: Bootstrap CSS framework for responsive layouts
- **Client-side**: Vanilla JavaScript for interactivity and form validation
- **Design**: Custom CSS with CSS variables for theming and animations
- **Multilingual Support**: Language selector for international users

### Backend Architecture
- **Server Technology**: PHP for server-side logic and templating
- **Database**: Supabase (PostgreSQL-based) for data storage and real-time features
- **Authentication**: Multi-role authentication system (Admin, Teacher, Student)
- **Session Management**: PHP sessions for user state management
- **File Handling**: Document and video upload management for teacher profiles

### Application Structure
- **Public Website**: Informational pages and user entry points
- **Admin Portal**: Teacher/student management, approvals, and analytics
- **Teacher Dashboard**: Profile management, class scheduling, and test creation
- **Student Dashboard**: Class enrollment, test taking, and progress tracking
- **Multi-tenant Design**: Role-based access control with separate interfaces

### Data Architecture
- **User Management**: Separate authentication flows for different user types
- **Payment Integration**: Teacher registration fee processing ($455)
- **Content Management**: Video storage and streaming for demo videos and classes
- **Test System**: Question banks, test creation, and result tracking
- **Approval Workflow**: Admin approval system for teacher registrations

## External Dependencies

### Database Services
- **Supabase**: Primary database and backend services
  - PostgreSQL database hosting
  - Real-time subscriptions for live features
  - User authentication and authorization
  - File storage for documents and videos

### Payment Processing
- **Payment Gateway**: Integration required for teacher registration fees and student payments
- **Billing System**: Recurring payment management for subscriptions

### Communication Services
- **Email Service**: Password reset, notifications, and contact form submissions
- **Video Conferencing**: Live class delivery platform integration
- **SMS Service**: Optional for multi-factor authentication and notifications

### Frontend Libraries
- **Bootstrap**: CSS framework for responsive design
- **JavaScript**: Native browser APIs for form validation and UI interactions

### Development Tools
- **PHP**: Server-side scripting language
- **Web Server**: Apache/Nginx for hosting PHP application
- **SSL/TLS**: HTTPS encryption for secure data transmission