#  “Architecture d’application”

## Pour Commencer
- Required PHP 7.4

```bash
composer install
```
modifier la configuration de la base de données dans `.env`

```bash
php bin/console doctrine:migrations:migrate
```

```bash
symfony server:start
```

## API
### Entreprise

- Ajout Entreprise : `/entreprise/add/` METHOD `POST`
- Avoir Une Entreprise : `/entreprise/{id}` METHOD `GET`
- Avoir tous : `/entreprises/` METHOD `GET`
- Mise à jour : `/entreprise/update/{id}` METHOD `PUT`
- Supprimer : `/entreprise/delete/{id}` METHOD `DELETE`

### User

- Ajout Utilisateur : `/user/add/` METHOD `POST`
- Avoir Un Utilisateur : `/user/{id}` METHOD `GET`
- Avoir tous : `/users/` METHOD `GET`
- Mise à jour : `/user/update/{id}` METHOD `PUT`
- Supprimer : `/user/delete/{id}` METHOD `DELETE`