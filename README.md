# Set API_KEY in .env :
API_KEY=your-secure-api-key

# Config your database url :
DATABASE_URL=

# Migrate to feed your Database (can skip)
php bin/console doctrine:migrations:migrate

# Start the server backend :
symfony server:start

# Start the frontend dev :
npm run dev or npm run watch

# Start the frontend prod :
npm run build

# How to use :
- Frontend bid form and calculation -> /bid-calculation
- Backend API call -> /api/calculate-fees

# About the project, it needs :
- Better UI
- Add translation for later can be able to switch fr/en
- Store every fees in database so we can easily change them
- Store request for Vehicule and Bid in database

# To test in Prod :
https://progi.areauniverse.fr/bid-calculation
