

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

Jeg valgte å lage dette prosjeketet i Laravel ettersom det er et back-end rammeverk jeg har en del erfaring med. Laravel bruker MVC struktur altså Model - View - Controller. I modellen definerer man logikken til databasen. I controller lager man de faktiske funksjonene slik at man ender opp med CRUD (Create, Read, Update, Delete). Viewet er front-enden altså det brukeren ser. Her bruker jeg blade.php filer ettersom det er hva standard Laravel følger, hvis man ikke velger en annen type starter pack som f.eks. React, Vue, Livewire. I tillegg bruker Eloquent ORM, ettersom det er en ORM jeg har god erfaring med å bruke fra tidligere prosjekter. Dette gjorde at jeg følte meg trygg på å lage denne nettsiden, og database oppsett. Oppsett i databasen finner du under /database/migrations/.


## Oppsett
.env filen må bli konfigurert med en MySQL database. Følg .env.example





