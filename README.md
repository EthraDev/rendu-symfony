# Document technique de mesure de sécurité du site
Ce document vous fournit un guide de bonnes pratiques à mettre en place sur votre site web afin d'éviter les différentes menaces ci-dessous :
## Injections SQL
### Droits des utilisateurs
- Limiter les droits des utilisateur SQL.
- Utiliser des requêtes préparées et paramétrées pour toutes les opérations de base de données.
## Attaques XSS (Cross-Site Scripting)
### Validation des Données d'Entrée
- Utilisez les composants Symfony Validator et Form pour valider les données d'entrée côté serveur.
- Filtrez et échappez les données avant de les afficher pour prévenir les attaques XSS.
- Utilisez htmlspecialchars afin d'échapper les caractères sensibles au HTML (les balises HTML par exemple).
## Attaques CSRF (Cross-Site Request Forgery)
### Protection des Formulaires
- Utilisez le composant Symfony Form pour générer et valider les jetons CSRF pour chaque formulaire.
- Vérifiez automatiquement les jetons CSRF dans chaque formulaire soumis pour éviter les attaques CSRF.
- Utiliser l’attribut SameSite dans les cookies (instruction qui sécurise vos 
cookies, par défaut dans Symfony)
## Attaques DDoS (Distributed Denial of Service)
### Utilisation de Limiteurs de Trafic
- Mettez en place des limiteurs de trafic pour détecter et bloquer les tentatives d'attaque DDoS.
- Utilisez des services de protection contre les DDoS tiers si nécessaire pour filtrer le trafic malveillant.
- Mettez des files d'attente entre chaque refresh.