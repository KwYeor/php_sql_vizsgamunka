# php_sql_vizsgamunka

Az oldal jelen állapotában alkalmas motoros túrák szervezésére, tagok felvételére és azok jelentkezéseinek rögzítésére. Az oldal jelszóval védett, a belépéshez előzetes regisztráció szükséges.

A jelentkezések módosíthatóak, de nem törölhetőek, mivel nemleges választ is lehet adni. Így követhető, hogy ki jelzett vissza és milyen választ adott.

Az események szervezése jelenleg mindenki számára engedélyezett. Külön fülön módosítható, de szintén nem törölhető, mert ha esemény eltűnne a sorból, nem biztos, hogy észrevehető a hiánya. Így esemény törlése esetén a módosításnál kell jelezni, hogy törölt esemény.

Tervben van későbbiek során egy admin oldal létrehozása, ahol lehetőséges lesz
a regisztrált felhasználók engedélyezésére (rejtett mezőböl "tinyint" megy majd az adatbázisba a regisztráció során, ahol '0' állapotnál nem lehetséges a home.php felé az átirányítás ) , valamint hasonló módszerrel az eseménykiírások is át fognak menni egy ellenőrzésen

Csatolva lesz az oldalhoz még pár, a működését nem befolyásoló funkció:
-beágyazás omline rock rádió lejátszójával,
-beágyazás időjárásjelző oldalakról
-beágyazás google térképről, mely tartalmazza a fontosabb célpontokat
-beágyazás google naptárról, ahova szintén be lesznek írva az ellenőrzött események,
így azokat naptáron is követni lehet, valamint onnan küldeni lehet a tagoknak emailben meghívót.
