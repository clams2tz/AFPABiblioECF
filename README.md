Note au load des fixtures : 

Couper/Coller les fichiers "LoansFixtures.php" et "ReservationsFixtures.php" hors du dossier "AFPABIBLIOECF"

Générer les fixtures avec : Symfony console d:f:l

Replacer les fichiers "LoansFixtures.php" et "ReservationsFixtures.php" dans le dossier "/src/Datafixtures/"

Générer ces deux fixtures avec 
"symfony console doctrine:fixtures:load --append --group=loans"
"symfony console doctrine:fixtures:load --append --group=reservations"

Arash ----> Rouge
Claudia ------> Violet
Clement Y -------> Vert
