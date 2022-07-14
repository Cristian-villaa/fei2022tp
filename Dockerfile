# develop stage
FROM node:17.8.0-alpine3.14 AS develop-stage
WORKDIR /app
COPY frontend/package*.json ./
RUN npm install
RUN npm install -g @vue/cli
COPY . .