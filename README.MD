# MediEMP

## Výzva
Poptávka po aplikaci byla identifikována na základě potřeb zaměstnavatelů, které plynou z absence přehledného systému zaměstnaneckých kompetencí a dosaženého vzdělávání.

Aplikace přinese komplexní možnost správy zaměstnaneckých databází, plánování budoucího vzdělávání a získávání nových kompetencí zaměstnanců. 
Poskytne tedy celistvý přehled o personálním vybavení zaměstnavatele a kvalifikaci či osobním rozvoji jeho zaměstnanců. 

## Řešení
* webová aplikace umožňující personální správu databáze zaměstnanců, jejich kvalifikací a kompetencí
* přehledné prostředí pro plánování vzdělávání zaměstnanců a rozvoj jejich profesních kompetencí a kvalifikací
* zaměstnancům i zaměstnavatelům poskytnout přehledný a souhrnný přehled odborných kurzů a seminářů pro kariérní rozvoj zdravotnických pracovníků 
* aplikace umožňuje registraci na jednotlivé akce, dle preferencí zaměstnance i zaměstnavatele

Naše řešení tak vytváří přehledné prostředí pro zaměstanavatele, kde mohou plánovat kurzy pro své zaměstnance. Zaměstnanci se pak mohou na tyto kurzy přihlásit. Poté se eviduje docházka a splnění závěrečného testu.

## Použité technologie
Naše aplikace běží na webovém serveru a je napsána v jazyce PHP ve verzi 8. Ke svému fungování potřebuje databázi MariaDB.





## Jak zprovoznit?

### Požadavky
* PHP >= 7.4, MariaDB => Doporučuji něco jako **[XAMPP](https://www.apachefriends.org/)**
* **[Composer](https://getcomposer.org/download/)**

### Instalace
1. Naklonujte si tento repozitář do složky `/xampp/htdocs`
2. V této složce spuťte příkaz `composer install` pro nainstalování závislostí
3. Vytvořte si pro projekt databázi, např. v phpmyadmin, zvolte kódování `utf8mb4_czech_ci`
4. V souboru `.env` v rootu projektu nastavte přístupové údaje do DB
    * Stačí upravit řádek s `DATABASE_URL` a dle potřeb nastavit přístupové parametry, v základu se db jmenuje `mediemp`
5. Pro ověření, že se vše dobře nainstalovalo spusťte příkaz `php bin/console --version`, což by vám mělo vypsat verzi Symfony
6. Je na čase migrovat DB - spusťte příkaz `php bin/console doctrine:migrations:migrate`
    * `php bin/console` slouží jako CLI pro Symfony, dají se s tim dělat čupr věci
7. Máme teď sice krásnou DB, ale je prázdná. Pomocí příkazu `php bin/console doctrine:fixtures:load` můžeme spustit tzv. seedování,
tedy vložení nějakých, v našem případě fake dat do DB. Toto seedování provádíme přes fixtures -> `src/DataFixtures`
   * Všechny hesla jsou `heslo123` a pro přihlášení můžete použít `test@test.cz`
8. Tohle už není tak úplně instalace, ale pokud chceme web vidět, můžeme spustit built-in webserver; `php -S localhost:8080 -t public/`
9. ???
10. Profit!

## Jak a co a jak funguje

Symfony funguje na návrhovém vzoru MVC - model, view, controller, kdy jednotlivé celky jsou od sebe odděleny. Kdyžtak google poradí.
Symfony zpracuje příchozí požadavek a dle URL adresy mu přiřadí nějakou routu; cestu. Tuto routu píšeme zpravidla jako anotaci nad kontroler. Můžeme určit parametry, název routy, pomocí které můžeme generovat URL adresu.
V kontroleru si provedeme nějakou potřebnou logiku a nakonci zavoláme vykreslení, kde můžeme do šablony poslat i nějaké proměnné.
```php
/**  
 * @Route("/employer/{id}",name="app_employee_get")  
 * @param int $id  
  */  
public function get(int $id, EmployerRepository $repository): Response {  
  $employer = $this->repository->find($id);
  if(!$employer){
        $this->createNotFoundException("Can't find employer with ID ".$id);
  } 
  
  return $this->render('/home/test.html.twig',[  
	  "employer"=>$employer  
  ]);  
}
```
Šablony se v Symfony píšou v Twigu, je to takový HTML na steroidech.

## Přístup k DB


Pro přístup k databázi používáme Doctrine - knihovnu pro mapování entit na objekty (ORM). Dokumentace [zde](https://symfony.com/doc/current/doctrine.html). Díky Doctrine můžeme vytvářet entity a mapovat je mezi sebou.

## Schéma databáze
![DB schéma](https://media.innogamescdn.com/com_DS_CZ/Kubina/forum/Mix/temp/obrazek_db.png)


## Struktura složek

* **bin**
    * **console** - soubor, který zpracovává CLI
* **config**
    * Konfigurace, zde prosím moc neupravujte, tedy pokud nevíte co děláte, obráceně tedy můžete
* **migrations**
    * Obsahuje soubory s migracemi; SQL příkazy, které verzovitě upravují DB
* **public**
    * Složka, která je vidět z venku = bude obsahovat např: assety - css, js atd.
* **src**
    * **Controller** - složka s kontrolery
    * **Entity** - "namapované entity z DB ve formě objektů
    * **Repository** - repositáře pro práci s DB
    * **Security** - obsahuje věci pro přihlášení; pro nás zajímavá jen Employee entita
* **templates**
    * Složka se šablonami
## Další
* V případě, že vás zarazí nějaká do očí bijící věc, tak vytvořte issue a popište problém


## Užitečné příkazy
1. `php bin/console debug:router`
   * seznam rout
2. `php bin/console debug:autowiring` <search>
   * services pro autowiring
   * možno vyhledat dle názvů -> `php bin/console debug:autowiring log`

TBA
