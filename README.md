# CRM Test Avid

Progetto Laravel + Inertia + Vue costruito come ambiente di prova per prendere confidenza con:

* CRUD completi
* form builder Avid
* tabelle Avid
* sidebar custom
* dashboard personalizzata
* notifiche database
* relazioni tra entità
* validazioni lato backend

## Stack usato

* Laravel
* Inertia.js
* Vue 3
* Avid (Ingenia)
* MySQL
* Tailwind CSS

## Moduli realizzati

### 1. Utenti

È stato realizzato il modulo `users` con:

* lista utenti
* creazione utente
* modifica utente
* eliminazione singola
* eliminazione multipla
* integrazione nella sidebar

File principali:

* `app/Http/Controllers/UserController.php`
* `app/Forms/UserForm.php`
* `app/Tables/UserTable.php`
* `app/Http/Requests/User/StoreUserRequest.php`
* `app/Http/Requests/User/UpdateUserRequest.php`
* `app/Http/Requests/User/BulkDestroyUserRequest.php`

## 2. Progetti

È stato realizzato il modulo `projects` con:

* lista progetti
* creazione progetto
* modifica progetto
* eliminazione singola
* eliminazione multipla
* gestione del campo descrizione
* integrazione nella sidebar
* notifiche alla creazione e cancellazione

File principali:

* `app/Http/Controllers/ProjectController.php`
* `app/Forms/ProjectForm.php`
* `app/Tables/ProjectTable.php`
* `app/Models/Project.php`
* `app/Http/Requests/Project/StoreProjectRequest.php`
* `app/Http/Requests/Project/UpdateProjectRequest.php`
* `app/Http/Requests/Project/BulkDestroyProjectRequest.php`

## 3. Task

È stato realizzato il modulo `tasks` con:

* lista task
* creazione task
* modifica task
* eliminazione singola
* eliminazione multipla
* collegamento della task a un progetto
* campi avanzati:

  * `status`
  * `priority`
  * `due_date`
* validazione obbligatoria di:

  * nome
  * descrizione
  * progetto associato
  * stato
  * priorità

File principali:

* `app/Http/Controllers/TaskController.php`
* `app/Forms/TaskForm.php`
* `app/Tables/TaskTable.php`
* `app/Models/Task.php`
* `app/Http/Requests/Task/StoreTaskRequest.php`
* `app/Http/Requests/Task/UpdateTaskRequest.php`
* `app/Http/Requests/Task/BulkDestroyTaskRequest.php`

## Relazione Task -> Project

Ogni task appartiene a un progetto.

Implementazione:

* colonna `project_id` nella tabella `tasks`
* relazione `belongsTo` nel model `Task`
* relazione `hasMany` nel model `Project`
* select nel form task per scegliere il progetto
* colonna progetto nella tabella task

## Dashboard personalizzata

La dashboard è stata personalizzata con:

* totale utenti
* totale progetti
* totale task
* ultimo utente aggiunto
* ultimo progetto aggiunto
* ultima task inserita
* ultimi utenti aggiunti
* ultimi progetti aggiunti
* ultime task inserite
* task in scadenza
* task scadute
* task completate

### Task in scadenza

Visualizzate ordinate per data di scadenza.

### Task scadute

Visualizzate separatamente con stile evidenziato.

### Task completate

Visualizzate separatamente con card dedicate.

### UX migliorata nella dashboard

Per le task sono stati introdotti:

* badge per stato
* badge per priorità
* colori diversi per scadenze
* card evidenziate per:

  * task in scadenza
  * task scadute
  * task completate

## Notifiche

È stato integrato il sistema di notifiche database.

Funzionalità implementate:

* notifica alla creazione di un progetto
* notifica alla cancellazione di un progetto
* notifica alla cancellazione multipla di progetti

Le notifiche includono informazioni utili come:

* nome del progetto
* nome dell’utente che ha effettuato l’azione
* stato della notifica

È stato anche gestito l’aggiornamento automatico delle notifiche nel layout principale con polling periodico.

## Sidebar personalizzata

La sidebar è stata estesa con:

* Dashboard
* Utenti
* Progetti
* Tasks
* Logout

Il logout è stato gestito con una route dedicata compatibile con il comportamento della sidebar.

## Routing

Sono state configurate le route per:

* utenti
* progetti
* task
* bulk destroy
* dashboard
* logout personalizzato

Le route bulk destroy sono state gestite in modo da evitare conflitti con le resource route.

## Validazioni implementate

### Utenti

* validazione dati base
* gestione request dedicate

### Progetti

* nome obbligatorio
* descrizione opzionale

### Task

* nome obbligatorio
* descrizione obbligatoria
* progetto obbligatorio
* stato obbligatorio
* priorità obbligatoria
* scadenza opzionale ma valida come data

## Migliorie tecniche affrontate

Durante lo sviluppo sono stati risolti diversi problemi pratici, tra cui:

* `403 Forbidden` dovuto a `authorize(): false`
* errori su route bulk destroy
* conflitti tra resource route e route personalizzate
* problemi di rendering nelle notifiche Avid
* struttura corretta dei payload notifiche
* configurazione corretta delle option nei campi `Select` Avid
* formattazione della data di scadenza nella tabella task
* polling notifiche senza rompere login e modal

## Struttura funzionale del progetto

Attualmente il progetto permette di:

* gestire utenti
* gestire progetti
* gestire task
* collegare task ai progetti
* monitorare task da dashboard
* ricevere notifiche sugli eventi principali

## Possibili sviluppi futuri

Evoluzioni naturali del progetto:

* assegnare task a un utente responsabile
* filtri avanzati nelle tabelle task
* pagina dettaglio progetto con task collegate
* soft delete
* storico modifiche
* commenti sulle task
* ruoli e permessi
* esportazione dati

## Comandi utili

### Avvio sviluppo

```bash
php artisan serve
npm run dev
```

### Migrazioni

```bash
php artisan migrate
```

### Pulizia cache

```bash
php artisan optimize:clear
```

## Stato attuale

Il progetto è una base gestionale funzionante costruita sopra Avid, utile per fare pratica con:

* Laravel
* Inertia
* Vue
* form e tabelle custom
* dashboard dinamiche
* notifiche
* relazioni tra entità

---

README creato come riepilogo tecnico e funzionale delle attività svolte sul progetto.

