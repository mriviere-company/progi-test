# Vehicle auction fee calculator — technical test

*[Version française plus bas](#français)*

A technical test from autumn 2024: compute the total cost of a vehicle bought at auction,
fee by fee, from its price and its type. Built with **Symfony 6.1 / PHP 8.1** for the API
and a **Vue 3** component for the form.

## How it is built

Each fee is its own class implementing `FeeCalculatorInterface`:
`BasicFeeCalculator`, `SpecialFeeCalculator`, `AssociationFeeCalculator` and
`StorageFeeCalculator`. They are injected as a list (`config/services.yaml`) into
`BidCalculationService`, which adds them up. Five PHPUnit tests cover common, luxury and
edge-case prices.

## Run it

```bash
cp .env .env.local   # set API_KEY and DATABASE_URL
composer install
npm install && npm run dev
symfony server:start
php bin/phpunit
```

| Route | Purpose |
|---|---|
| `/bid-calculation` | Form: price and vehicle type, with the fee breakdown |
| `/api/calculate-fees` | API: the same calculation as JSON |

## Known limits (as delivered)

- The detail of each fee is filled by a `switch` on the calculator's class name, so a new
  fee still means editing the service. Next step: each calculator exposes its own key, and
  a new fee becomes a new class only (open/closed principle).
- Fee rules are in code: storing them in the database would let them change without a
  release.
- Requests are not stored.
- Minimal interface, no translations yet.
- The demo hosted at the time is no longer online.

---

<a id="français"></a>

# Calcul des frais d'enchère de véhicules — test technique

Test technique de l'automne 2024 : calculer le coût total d'un véhicule acheté aux
enchères, frais par frais, à partir de son prix et de son type. Réalisé en **Symfony 6.1 /
PHP 8.1** pour l'API, avec un composant **Vue 3** pour le formulaire.

## Conception

Chaque frais est une classe qui implémente `FeeCalculatorInterface` : frais de base,
frais spéciaux, frais d'association et frais de stockage. Ils sont injectés sous forme de
liste (`config/services.yaml`) dans `BidCalculationService`, qui les additionne. Cinq tests
PHPUnit couvrent des prix courants, des véhicules de luxe et des cas limites.

## Limites connues (à la livraison)

- Le détail de chaque frais est rempli par un `switch` sur le nom de la classe : ajouter un
  frais oblige encore à modifier le service. Étape suivante : chaque calculateur expose sa
  propre clé, et un nouveau frais devient une simple nouvelle classe (principe ouvert/fermé).
- Les règles de frais sont dans le code : les stocker en base permettrait de les changer
  sans mise en production.
- Les requêtes ne sont pas enregistrées.
- Interface minimale, pas encore de traductions.
- La démo hébergée à l'époque n'est plus en ligne.
