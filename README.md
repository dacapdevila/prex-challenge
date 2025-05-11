# Prex Challenge

A Laravel REST API integrating with GIPHY, featuring:

- OAuth2 authentication via Laravel Passport
- Search GIFs
- Retrieve GIF by ID
- Save favorite GIFs
- Request audit logging  

---

## Requirements

- Docker & Docker Compose
- PHP 8.3+
- Composer
- Node.js 16+ & npm (optional for local asset compilation)
- GIPHY API key (register at https://developers.giphy.com/)

---

## Installation

1. **Clone repository & enter folder**

    ```bash
    git clone git@github.com:dacapdevila/prex-challenge.git
    cd prex-challenge
    ```

2. **Copy env file & configure**

    ```bash
    cp .env.example .env
    # Edit .env: set GIPHY_KEY.
    ```

3. **Build & start containers**

   - Production mode (build assets once):
   
   ```bash
   docker compose up -d --build
   ```

    - Development mode (Vite in watch mode on port 5173):

   ```bash
   docker compose --profile dev up -d --build
   ```

4. **Run database migrations & Passport**

   ```bash
   docker compose exec app php artisan migrate
   docker compose exec app php artisan passport:install --force
   ```

---

## Testing

1. **Run all tests:**

   ```bash
   docker compose exec app php artisan test
   ```
   
2. **Generate code coverage report:**

   ```bash
   docker compose exec app vendor/bin/phpunit --coverage-html storage/coverage
   open storage/coverage/index.html
   ```
3. **You will see the current code coverage:**
![Code Coverage](docs/assets/code_coverage.png)

---

## Use Cases Diagrams

- **General**
  ![General](docs/assets/use_cases_diagrams.png)

---

## Sequence Diagrams

### Auth Service

- **Register**
  ![Register](docs/assets/sequence_diagram_register.png)

- **Login**
  ![Login](docs/assets/sequence_diagram_login.png)

- **Logout**
  ![Logout](docs/assets/sequence_diagram_logout.png)

### GIF Management

- **Search GIFs**
  ![Search GIFs](docs/assets/sequence_diagram_search_gifs.png)

- **Retrieve GIF by ID**
  ![Retrieve GIF](docs/assets/sequence_diagram_retrieve_gif.png)

### Favorite Management

- **Save GIF as Favorite**
  ![Add Favorite](docs/assets/sequence_diagram_add_gif_to_favorites.png)

- **List Favorite GIFs**
  ![List Favorite GIFs](docs/assets/sequence_diagram_list_favorites.png)

- **Delete Favorite GIF**
  ![Delete Favorite GIF](docs/assets/sequence_diagram_delete_favorite.png)

---

## Data Diagram - Entity Relationship Diagram

- ** Data Diagram **
  ![Data Diagram](docs/assets/ERD.png)

---

## API Documentation

- Docs: https://documenter.getpostman.com/view/11336555/2sB2jAaTL9
- Import Postman Collection with all the end points

[<img src="https://run.pstmn.io/button.svg" alt="Run In Postman" style="width: 128px; height: 32px;">](https://god.gw.postman.com/run-collection/:2sB2jAaTL9?action=collection%2Ffork&source=rip_markdown&:collection_url)

---

