# MediEMP


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
Šablony se v Symfony píšou v Twigu, no worries, je to takový HTML na steroidech.

## Přístup k DB

~~Jelikož tenhle projekt děláme do předmětu *Databázové systémy*, tak by nebylo moc košér, kdybychom pro manipulaci s daty používali ORM. Proto jsem zvolil, trochu křečovité, repozitáře. Zde si troufám říct, že kdybyste našli lepší způsob jak to napsat, tak mi klidně ve 3 ráno vyražte dveře (nebo hoďte issue, taky možnost).~~
Haha, my bad, takže pro přístup k databázi používáme Doctrine - knihovnu pro mapování entit na objekty (ORM). Dokumentace [zde](https://symfony.com/doc/current/doctrine.html). Díky Doctrine můžeme vytvářet entity a mapovat je mezi sebou.


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
* Už nevím, co psát, tak asi dobrou noc

## Užitečné příkazy
1. `php bin/console debug:router`
   * seznam rout
2. `php bin/console debug:autowiring` <search>
   * services pro autowiring
   * možno vyhledat dle názvů -> `php bin/console debug:autowiring log`

TBA