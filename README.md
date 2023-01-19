# La Isla Normal

Härlig spansk ö för dem som vill ha det som det alltid ha varit.

# Det Vanliga Hotelet

Det Vanliga Hotelet för den vanliga människan.

# Instructions

The site GUI supports only mobile view.

# Code review

1. book.php: 69: Du skickar anropet till centralbanken/transferCode istället för deposit när du ska göra din transaktion 
2. calender.php: - Hade varit skönt med lite kommentarer för att förstå vad koden gör 
3. index.php: 37-38- Utkommenterad kod som inte behövs
4. index.php:47 - Kom ihåg att ha en alt på dina bilder
5. index.php: 3-4- Tror det är bättre att använda require för att om du använder include kan allt på sidan visas även fast den filen inte laddas in 
6. book.php  -  Även här hade det underlättat med kommentarer ovanför funktionerna för att snabbare och enklare förstå vad de gör
7. .images- Du har många bilder i din mapp som du inte använder, tänk på att rensa ut de
8. .env missing - Du har ingen env-fil
9. book.php 38 - $dateStayingAsString kanske inte ett så jättebra variabelnamn, svårt att läsa och svårt att förstå vad den gör
10. .license - Kom ihåg när du skapar din license att ange vilken typ av license du använder dig av
