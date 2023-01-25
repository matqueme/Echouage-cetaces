                __  __   _          _     ___                 _         _                 
  ___   ___    |  \/  | (_)  _ _   (_)   | _ \  _ _   ___    (_)  ___  | |_     ___   ___ 
 |___| |___|   | |\/| | | | | ' \  | |   |  _/ | '_| / _ \   | | / -_) |  _|   |___| |___|
               |_|  |_| |_| |_||_| |_|   |_|   |_|   \___/  _/ | \___|  \__|              
                                                           |__/              
       \\\||||||////
        \\  ~ ~  //
         (  @ @  )
______ oOOo-(_)-oOOo___________
.......
....... Mathis QUEMENER - Clément YZIQUEL
....... 2021-2022 - Mini projet Framework
....... 
_____________Oooo._____________
   .oooO     (   )
    (   )     ) /
     \ (     (_/
      \_)

--------------BDD--------------

La base de données n'a pas été modifiée. Elle décrit toujours le même modèle que celui qui nous a été fournis

Bdd = echouage
User = prj_root
MdP = root

Modifier également le .env dans symfony pour les identifiants et les mots de passe

--------------API--------------

Le format d'accès à l'API se fait grâce à symfony qui retourne un tableau JSON qui est ensuite traité en REACT

JSON de tout les zones :
http://127.0.0.1:8000/api/zones

JSON de tout les dates :
http://127.0.0.1:8000/api/dates

JSON de tout les espèces :
http://127.0.0.1:8000/api/especes

JSON de l'espèce sélectionner en fonction des dates de début de fin :
http://127.0.0.1:8000/api/echouages/{date de début}/{date de fin}/{id de l'espèce}

Exemple de retour de l'api pour les échouages par dates et par espèce :
[
   {
      "date":1999,
      "zone":"Nord Atlantique - Manche Ouest",
      "zone_id":3,
      "nombre":"1"
   },
   {
      "date":2001,
      "zone":"Nord Atlantique - Manche Ouest",
      "zone_id":3,
      "nombre":"1"
   }
]

--------------Back-Office--------------

Page d'accueil :
http://127.0.0.1:8000/echouage/accueil

Affichage de tous les échouages :
http://127.0.0.1:8000/echouage/

Affichage de tous les zones :
http://127.0.0.1:8000/zone/

Affichage de tous les espèces :
http://127.0.0.1:8000/espece/

Recherche à partir de la page d'accueil :
http://127.0.0.1:8000/echouage/search?zone={id de la zone}&espece={id de l'espece}

--------------Front-Office--------------

Lien du site :
http://localhost:3000/

Ceci est présent sur le front : 
• un champ de sélection de l’année de début
• un champ de sélection de l’année de fin
• un champ de sélection de l’espèce
• un bouton de validation

--------------Points Bonus subsidiaires--------------

Mise en production

Auto-complétion en back office


