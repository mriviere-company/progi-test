# Set API_KEY in .env :
API_KEY=your-secure-api-key

# Config your database url :
DATABASE_URL=

# Migrate to feed your Database
php bin/console doctrine:migrations:migrate

# Start the server backend :
symfony server:start

# Start the frontend dev :
npm run dev

# Start the frontend prod :
npm run build
npm start

# How to use :
- Frontend bid form and calculation -> /bid-calculation
- Backend API call -> /api/calculate-fees

# About the project, it needs :
- Better UI
- Add translation for later can be able to switch fr/en
- Store every fees in database so we can easily change them
- Deploy on prod
