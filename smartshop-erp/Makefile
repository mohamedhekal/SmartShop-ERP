.PHONY: help install setup dev build test clean docker-up docker-down docker-build docker-logs

# Default target
help: ## عرض المساعدة
	@echo "SmartShop ERP System - Available Commands:"
	@echo ""
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

# Installation
install: ## تثبيت جميع dependencies
	@echo "Installing dependencies..."
	cd api && composer install
	cd frontend && npm install

setup: ## إعداد المشروع للمرة الأولى
	@echo "Setting up SmartShop ERP..."
	@make install
	@make setup-backend
	@make setup-frontend
	@echo "Setup completed! Run 'make dev' to start development servers."

setup-backend: ## إعداد Backend
	@echo "Setting up Laravel backend..."
	cd api && cp env.example .env
	cd api && php artisan key:generate
	cd api && php artisan migrate --seed
	cd api && php artisan storage:link

setup-frontend: ## إعداد Frontend
	@echo "Setting up Vue.js frontend..."
	cd frontend && cp .env.example .env 2>/dev/null || echo "Frontend .env file already exists"

# Development
dev: ## تشغيل خوادم التطوير
	@echo "Starting development servers..."
	@make dev-backend & make dev-frontend

dev-backend: ## تشغيل خادم Backend
	@echo "Starting Laravel development server..."
	cd api && php artisan serve

dev-frontend: ## تشغيل خادم Frontend
	@echo "Starting Vue.js development server..."
	cd frontend && npm run dev

# Building
build: ## بناء المشروع للإنتاج
	@echo "Building for production..."
	@make build-backend
	@make build-frontend

build-backend: ## بناء Backend
	@echo "Building Laravel backend..."
	cd api && composer install --no-dev --optimize-autoloader
	cd api && php artisan config:cache
	cd api && php artisan route:cache
	cd api && php artisan view:cache

build-frontend: ## بناء Frontend
	@echo "Building Vue.js frontend..."
	cd frontend && npm run build

# Testing
test: ## تشغيل جميع الاختبارات
	@echo "Running all tests..."
	@make test-backend
	@make test-frontend

test-backend: ## تشغيل اختبارات Backend
	@echo "Running Laravel tests..."
	cd api && php artisan test

test-frontend: ## تشغيل اختبارات Frontend
	@echo "Running Vue.js tests..."
	cd frontend && npm run test

# Docker
docker-up: ## تشغيل Docker containers
	@echo "Starting Docker containers..."
	docker-compose up -d

docker-down: ## إيقاف Docker containers
	@echo "Stopping Docker containers..."
	docker-compose down

docker-build: ## بناء Docker images
	@echo "Building Docker images..."
	docker-compose build

docker-logs: ## عرض logs للـ Docker containers
	@echo "Showing Docker logs..."
	docker-compose logs -f

docker-clean: ## تنظيف Docker containers والـ images
	@echo "Cleaning Docker containers and images..."
	docker-compose down -v
	docker system prune -f

# Database
db-migrate: ## تشغيل database migrations
	@echo "Running database migrations..."
	cd api && php artisan migrate

db-seed: ## تشغيل database seeders
	@echo "Running database seeders..."
	cd api && php artisan db:seed

db-reset: ## إعادة تعيين قاعدة البيانات
	@echo "Resetting database..."
	cd api && php artisan migrate:fresh --seed

# Cache
cache-clear: ## مسح جميع الـ caches
	@echo "Clearing all caches..."
	cd api && php artisan cache:clear
	cd api && php artisan config:clear
	cd api && php artisan route:clear
	cd api && php artisan view:clear

# Code Quality
lint: ## تشغيل linting
	@echo "Running linting..."
	@make lint-backend
	@make lint-frontend

lint-backend: ## تشغيل linting للـ Backend
	@echo "Running PHP linting..."
	cd api && composer exec phpcs -- --standard=PSR12 app/

lint-frontend: ## تشغيل linting للـ Frontend
	@echo "Running JavaScript linting..."
	cd frontend && npm run lint

format: ## تنسيق الكود
	@echo "Formatting code..."
	@make format-backend
	@make format-frontend

format-backend: ## تنسيق كود Backend
	@echo "Formatting PHP code..."
	cd api && composer exec php-cs-fixer fix

format-frontend: ## تنسيق كود Frontend
	@echo "Formatting JavaScript code..."
	cd frontend && npm run format

# Utilities
clean: ## تنظيف الملفات المؤقتة
	@echo "Cleaning temporary files..."
	@make clean-backend
	@make clean-frontend

clean-backend: ## تنظيف ملفات Backend
	@echo "Cleaning Laravel files..."
	cd api && rm -rf bootstrap/cache/*.php
	cd api && rm -rf storage/logs/*.log
	cd api && rm -rf storage/framework/cache/*
	cd api && rm -rf storage/framework/sessions/*
	cd api && rm -rf storage/framework/views/*

clean-frontend: ## تنظيف ملفات Frontend
	@echo "Cleaning Vue.js files..."
	cd frontend && rm -rf node_modules
	cd frontend && rm -rf dist
	cd frontend && rm -rf .cache

# Production
deploy: ## نشر المشروع للإنتاج
	@echo "Deploying to production..."
	@make build
	@echo "Deployment completed!"

# Monitoring
logs: ## عرض logs
	@echo "Showing application logs..."
	cd api && tail -f storage/logs/laravel.log

status: ## عرض حالة المشروع
	@echo "SmartShop ERP System Status:"
	@echo "=========================="
	@echo "Backend: $(shell cd api && php artisan --version 2>/dev/null || echo 'Not installed')"
	@echo "Frontend: $(shell cd frontend && npm --version 2>/dev/null && echo 'Installed' || echo 'Not installed')"
	@echo "Docker: $(shell docker --version 2>/dev/null || echo 'Not installed')"
	@echo "Database: $(shell cd api && php artisan migrate:status 2>/dev/null | grep -c '|' || echo 'Not connected')"

# Quick Commands
quick-start: ## بدء سريع للمشروع
	@echo "Quick start for SmartShop ERP..."
	@make install
	@make setup-backend
	@make dev

quick-docker: ## بدء سريع مع Docker
	@echo "Quick start with Docker..."
	@make docker-build
	@make docker-up
	@echo "Access the application at:"
	@echo "- Frontend: http://localhost:3000"
	@echo "- Backend API: http://localhost:8000"
	@echo "- phpMyAdmin: http://localhost:8080"
	@echo "- MailHog: http://localhost:8025" 