# UPDATE V2: 07-2022

## First step: repository
1. Create a v2.0.0 sub-folder 
2. Clone the repository in this folder
3. Launch the commands:
```console
composer install --no-dev -o
yarn install
yarn build
```

4. Copy the `.env.local` file in the project dir.
5. Set the var `env=dev` into `.env.local`

## Second step: database

### Migrations
Launch database migrations.

### Data Fixtures
1. Copy `resource/material_sector_sign_items.csv` file in the production server
2. Load data fixtures
```console
symfony console doctrine:fixtures:load --append --group=v2
```

### Set prod env
1. Set the var `env=prod` into `.env.local`
2. Change subdomain directory.
