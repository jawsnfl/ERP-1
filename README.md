== Zarządzanie branchami: ==
1. Branch powstaje dla rozwiązania problemy, dodania elementu aplikacji lub plików.
2. Branch jest scalany gdy element osiąga swoją funkcjonalność.
3. Podstawowa linia kodu to linia master.
4. Robocza linia kodu to linia develop.
5. Do linii develop trafiają najpierw wszystkie request pulle.
6. Z linni develop trafią do mastera zgodnie z wersjonowaniem programu (0.1, 0.2 itd).


TODO I:
  - autentykacja i autoryzacja użytkownika: [===-------]
    - model + uzupełnienie struktury bazy danych [=---------]
    - kontroler + utrzymanie sesji [=====-----]
    - akcje dotyczące autentykacji i autoryzacji [=---------]
  - obsługa _GET ref oraz ret (do 2014-01-31) [=---------]
  - ~~przebudowanie Framework\Registry + zmiana zmiennych deklarowanych na rejestrowane (odłożone)~~ <= rejestracja działa, część ważnych zmiennych z bootstrapa jest już rejestrowana; przemyślę, czy to wszystkie
  - przebudowa Framework\Database [=---------]
  - przebudowa Framework\Exception [=---------]
  - ~~dodanie kolejnego kroku dla _GET url oraz jego obsługa w Framework\Controller~~

TODO II:
  - dodanie szablonów UI
    - dodanie pliku z podstawowym szablonem dla home/index
    - dodanie podstron
      - odział na podstrony
