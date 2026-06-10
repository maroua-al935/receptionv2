# Elyctis Card Middleware

Service local Windows pour lire les documents biométriques Elyctis et exposer une API HTTP locale consommée par Laravel.

## Choix technique

Les DLL fournies dans `x86/Release` sont des assemblies `x86` ciblant `.NET Framework 4.8`:

- `ElySCardDotNet.dll`
- `ElyMRTDdotNet.dll`

Pour cette raison, le service est volontairement compilé en `x86` / `.NET Framework 4.8`. C'est le choix stable pour charger les DLL Elyctis et leurs dépendances natives (`ElyMRTD.dll`, `FreeImage.dll`, `libeay32.dll`, etc.). Un host pur `.NET 8` ne doit pas référencer directement ces DLL en production.

## API locale

Base URL par défaut:

```text
http://127.0.0.1:8765/
```

Endpoints:

```text
GET /health
GET /read-card
GET /read-card?mrz=<MRZ_PASSWORD>
```

Sécurité locale:

- écoute uniquement sur `127.0.0.1`;
- CORS limité à `http://127.0.0.1:8000`;
- header obligatoire `X-Elyctis-Token`, configurable dans `appsettings.json`.

Exemple:

```powershell
Invoke-RestMethod http://127.0.0.1:8765/read-card -Headers @{ "X-Elyctis-Token" = "change-this-local-token" }
```

## Analyse des DLL

### ElySCardDotNet

Namespace principal: `ElySCardDotNet`.

Classes et méthodes utiles:

- `SCardManager`
  - `EstablishContext(SCOPE)`
  - `ReleaseContext()`
  - `ListReaders()`
  - `CreateConnection(string)`
  - `GetStatusChange(uint, SCARD_READERSTATE[])`
  - `Cancel()`
- `SCardConnection`
  - `Connect(SHARE, PROTOCOL)`
  - `Disconnect(DISCONNECT)`
  - `Reconnect(SHARE, PROTOCOL, DISCONNECT)`
  - `Transmit(byte[], uint)`
  - `TransmitEx(byte[], uint, uint)`
  - `BeginTransaction()`
  - `EndTransaction(DISCONNECT)`
- `ElyRDRControl`
  - `RDR_ListReaders()`
  - `RDR_OpenComm()`
  - `RDR_OpenComm(string)`
  - `RDR_CloseComm()`
  - `RDR_StartPolling()`
  - `RDR_StopPolling()`
  - `RDR_SetRF(bool)`
  - `RDR_GetSerialNumber()`
- `ElyRDRAntennaSelect`
  - `select(string, string)`

Enums utiles: `SHARE`, `PROTOCOL`, `STATE`, `DISCONNECT`, `SCOPE`, `SCARD_STATE`.

### ElyMRTDDotNet

Namespace principal: `ElyMRTDDotNet`.

Classe principale: `ElyMRTDDotNet.ElyMRTDDotNet`.

Connexion lecteur:

- `ListReaders()`
- `connect(string readerName)`
- `disconnect()`
- `transmit(byte[])`
- `getLastStatusWord()`

Accès NFC/MRTD:

- `establishBAC(string mrzPassword)`
- `establishPACE(string password, int passwordType)`
- `establishAccessControl(string password, int passwordType)`
- `readDG1()` à `readDG16()`
- `readDG32()` à `readDG34()`

Lecture données:

- `getName()`, `getSurname()`
- `getGivenNames()`, `getFamilyName()`
- `getFullName()`
- `getDocNum()`
- `getNationality()`
- `getBirthDate()`, `getFullBirthDate()`
- `getSex()`
- `getExpiryDate()`, `getValidityDate()`
- `getIssuingCountry()`, `getIssuingAuthority()`
- `getMRZString()`
- `getPhoto()`
- `getSignature()`

Parsing MRZ:

- `ElyMrzParser.Parse(string)`
- `GetMrzPwd()`
- `FirstName()`, `LastName()`, `DocumentNumber()`
- `NationalityIso()`, `DateOfBirth()`, `ExpiryDate()`
- validations de check digits.

## Structure

```text
elyctis-middleware/
  README.md
  src/ElyctisCardService/
    ElyctisCardService.csproj
    Program.cs
    WindowsServiceHost.cs
    appsettings.json
    Controllers/LocalHttpApi.cs
    Models/
    Services/
    Vendor/
```

## Build

Visual Studio:

1. Installer `.NET Framework 4.8 Developer Pack`.
2. Ouvrir `elyctis-middleware/src/ElyctisCardService/ElyctisCardService.csproj`.
3. Choisir `Release` et `x86`.
4. Build.

Ligne de commande:

```powershell
C:\Windows\Microsoft.NET\Framework\v4.0.30319\MSBuild.exe .\elyctis-middleware\src\ElyctisCardService\ElyctisCardService.csproj /p:Configuration=Release /p:Platform=x86
```

## Test console

```powershell
cd .\elyctis-middleware\src\ElyctisCardService\bin\x86\Release
.\ElyctisCardService.exe --console
```

Le service utilise un serveur local `TcpListener`, donc aucune réservation `netsh http urlacl` n'est nécessaire.

## Installation service Windows

Ouvrir PowerShell en administrateur:

```powershell
cd C:\Users\ANAM1429\receptionv2\elyctis-middleware\src\ElyctisCardService\bin\x86\Release
sc.exe create ElyctisCardMiddleware binPath= "\"%CD%\ElyctisCardService.exe\"" start= auto
sc.exe start ElyctisCardMiddleware
```

Désinstallation:

```powershell
sc.exe stop ElyctisCardMiddleware
sc.exe delete ElyctisCardMiddleware
```

## Intégration Laravel

La page `resources/views/Reception/add_index.blade.php` fait un polling toutes les 2.5 secondes vers:

```text
http://127.0.0.1:8765/read-card
```

Champs remplis:

- `fname` avec le nom;
- `lname` avec le prénom;
- `cin` avec le numéro document;
- `observations` avec nationalité et date de naissance.

Le token dans `appsettings.json` et dans le JavaScript Laravel doit être identique.

## Limite métier importante

Pour les passeports et certaines cartes, la lecture NFC exige BAC/PACE avec une clé dérivée de MRZ/CAN. Le service accepte `?mrz=...`, mais une lecture totalement automatique sans donnée d'accès dépend du type exact de carte et de la configuration Elyctis. Si `readDG1()` retourne vide, le service renvoie `READ_EMPTY` avec un message explicite.
