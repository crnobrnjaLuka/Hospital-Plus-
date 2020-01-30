# psihijatrijska_bolnica

 *Rad sa prakse za grupu 2.1*

 # Veb aplikacija

 Zahtev je bio da se napravi veb aplikacija koja bi radnicima jedne bolnice omogućila lakši pristup informacijama vezanim za pacijente, kao i za praćnje stanja medikamenata. 
 Aplikacija je uradjena u framevorku za phpČ Larvel, a pojedini delovi sajta su uradjeni u JavaScript-u, i framevorku za JavaScript React-u. CSS je uradjen sa tehnologijama
 Flexbox i Grid. 

 # Korisnici

U aplikaciji su definisana tri tipa korisnika: admin, lekar i osoblje. 

# Svaki korisnik

Svaki korisnik ima pravo:
1. Da menja svoj username i email,
2. Da promeni svoju lozinku.

# Admin

Admin ima dve funkcionalnosti:

1. Da dodeljuje uloge registrovanim korisnicima.
2. Da briše korisnike iz baze koji nisu admin, ili koji nisu lekar sa dodeljenim pacijentom.

# Lekar

Lekar ima više funkcionalnosti:

1. Da ima pristup kartonima svojih pacijenata.
2. Da menja odredjene delove kartona koji se odnose na istoriju bolesti i alergije.
3. Da upisuje posetu pacijenta u karton.
4. Da ispravlja posete i poddelove poseta.
5. Ima pristup spisku oboljenja i spisku medikamenata. 

# Osoblje

Osoblje ima više funkcionalnosti:

1. Da dodaje novog pacijenta, i dodeljuje mu glavnog lekara.
2. Da modifikuje stvari iz tačke 1. 
3. Da ima pristup spiksu oboljenja, dodaje novo oboljenje i modifikuje postojeće. 
4. Da ima pristup spiksu lekova, dodaje novi lek, modifikuje postojeće, i da menja stanje (tj. količinu).

# Na izradu veb aplikacije su učestvovali:

1. Aleksandar Petrović
2. Luka Crnobrnja
3. Aleksandar Vilus
4. Luka Živanović





